<?php

declare(strict_types=1);

/*
 * Copyright (C) 2022 Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Egon\Tests;

use Egon\Dto\RequestValidationV4\Address;
use Egon\Dto\RequestValidationV4\Parameter;
use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Service\ValidationV4;

/**
 * Description of AbstractTestCase.
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * @example ./vendor/bin/phpunit tests/BasicRemoteTest.php
 *
 * @internal
 */
final class BasicRemoteTest extends AbstractTestCase
{
    public function testRemoteSampleResponse(): void
    {
        $token = self::getApiToken();

        $address = new Address();
        $address->setStreet('Via Pacinotti 4b')->setCity('Verona');
        $parameter = new Parameter(CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

        try {
            $validationV4 = new ValidationV4($token);
            $arrayContent = $validationV4->getValidAddress($address, $parameter);
        } catch (\Exception $exception) {
            $msg = 'Exception: '.$exception->getMessage().PHP_EOL;
            fwrite(STDERR, $msg);
            self::fail('Exception thrown during validate call: '.$msg);
        }

        try {
            $response = ValidationV4Mapper::fromArray($arrayContent);
            self::assertNotNull($response);
            self::assertInstanceOf(ValidationV4Response::class, $response);
        } catch (\Throwable $throwable) {
            fwrite(STDERR, 'Exception caught: '.$throwable::class."\n");
            fwrite(STDERR, $throwable->getMessage()."\n");
            fwrite(STDERR, $throwable->getTraceAsString()."\n");

            self::fail('Exception thrown during fromArray(): '.$throwable->getMessage());
        }

        $data = $response->getData();
        $standard = $data->getAddress()->getStandard();
        $smart = $data->getAddress()->getSmart();
        $geo = $data->getGeo();
        $postal = $data->getPostal();
        $quality = $response->getQuality()->getAddress();
        $system = $response->getSystem();

        // Standard address assertions
        self::assertSame('ITA', $standard->getIso3());
        self::assertSame('Italia', $standard->getCountry());
        self::assertSame('Veneto', $standard->getRegion());
        self::assertSame('Verona', $standard->getProvince());
        self::assertSame('VR', $standard->getProvinceCode());
        self::assertSame('Verona', $standard->getCity());
        self::assertEquals('37135', $standard->getZipcode());
        self::assertSame('Via', $standard->getStreetType());
        self::assertSame('Antonio Pacinotti', $standard->getStreetName());
        self::assertSame('Via Antonio Pacinotti', $standard->getStreet());
        self::assertSame('Via Antonio Pacinotti,4/B', $standard->getAddress());
        self::assertSame('Via Antonio Pacinotti,4/B, Verona, VR, Veneto, 37135, Italia', $standard->getFullAddress());
        self::assertSame('4/B', $standard->getHn());
        self::assertSame('VERONA', $standard->getPostalTown1());

        $admCodes = $standard->getAdmCode();
        self::assertCount(12, $admCodes);

        $egonCode = $standard->getEgonCode();

        self::assertEquals(38000004730, $egonCode->getCity());
        self::assertEquals(38000073526, $egonCode->getStreet());
        self::assertSame('', $egonCode->getHn());

        // Smart address assertions
        self::assertSame('Italia', $smart->getCountry());
        self::assertSame('Verona', $smart->getAdministrativeLevel());
        self::assertSame('Verona', $smart->getCity());
        self::assertSame('Via Antonio Pacinotti,4/B', $smart->getAddress());
        self::assertEquals('37135', $smart->getZipcode());

        // Geo
        self::assertSame('45.40616800, 10.97379600', $geo->getLatLong());
        self::assertSame('A41-111', $geo->getGeoLevel());
        // $this->assertEquals('0230910000922', $geo->getCensusCode());
        // Postal
        self::assertSame('VIA ANTONIO PACINOTTI 4/B', $postal->getRow4());
        self::assertSame('37135 VERONA VR', $postal->getRow5());

        // Quality
        self::assertEquals('0', $quality->getLocality()->getFlag());
        self::assertEquals(0, $quality->getLocality()->getCode());
        self::assertSame(strtolower('Ok'), strtolower($quality->getLocality()->getDescription()));

        // System
        self::assertEquals(0, $system->getRetCode());
        self::assertSame(strtolower('Ok'), strtolower((string) $system->getDesRetCode()));

        self::assertTrue(true);
    }
}
