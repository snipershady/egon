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

use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;

/**
 * Description of AbstractTestCase.
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * @example ./vendor/bin/phpunit tests/BasicTest.php
 *
 * @internal
 */
final class BasicTest extends AbstractTestCase
{
    public function testPersistedSampleResponse(): void
    {
        $arrayContent = self::loadJsonFromFile(__DIR__.'/sample_response.json');

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
        self::assertEquals('50137', $admCodes[0]->getType());
        self::assertEquals('VR', $admCodes[0]->getValue());

        self::assertEquals('30030', $admCodes[1]->getType());
        self::assertEquals('11700', $admCodes[1]->getValue());

        self::assertEquals('30000', $admCodes[2]->getType());
        self::assertEquals('L781', $admCodes[2]->getValue());

        self::assertEquals('30021', $admCodes[3]->getType());
        self::assertEquals('023091', $admCodes[3]->getValue());

        self::assertEquals('30060', $admCodes[4]->getType());
        self::assertEquals('086', $admCodes[4]->getValue());

        self::assertEquals('30061', $admCodes[5]->getType());
        self::assertEquals('660999', $admCodes[5]->getValue());

        self::assertEquals('30050', $admCodes[6]->getType());
        self::assertEquals('0777000', $admCodes[6]->getValue());

        self::assertEquals('30071', $admCodes[7]->getType());
        self::assertEquals('IT', $admCodes[7]->getValue());

        self::assertEquals('30070', $admCodes[8]->getType());
        self::assertEquals('ITA', $admCodes[8]->getValue());

        self::assertEquals('30072', $admCodes[9]->getType());
        self::assertEquals('380', $admCodes[9]->getValue());

        self::assertEquals('30114', $admCodes[10]->getType());
        self::assertEquals('ITALIA', $admCodes[10]->getValue());

        self::assertEquals('30022', $admCodes[11]->getType());
        self::assertEquals('005', $admCodes[11]->getValue());

        $egonCode = $standard->getEgonCode();
        self::assertEquals(38000004730, $egonCode->getCity());
        self::assertEquals(38000073526, $egonCode->getStreet());
        self::assertEquals(380100008326045, $egonCode->getHn());

        // Smart address assertions
        self::assertSame('Italia', $smart->getCountry());
        self::assertSame('Verona', $smart->getAdministrativeLevel());
        self::assertSame('Verona', $smart->getCity());
        self::assertSame('Via Antonio Pacinotti,4/B', $smart->getAddress());
        self::assertEquals('37135', $smart->getZipcode());

        // Geo
        self::assertSame('45.40616800, 10.97379600', $geo->getLatLong());
        self::assertSame('A41-111', $geo->getGeoLevel());
        self::assertEquals('0230910000922', $geo->getCensusCode());

        // Postal
        self::assertSame('VIA ANTONIO PACINOTTI 4/B', $postal->getRow4());
        self::assertSame('37135 VERONA VR', $postal->getRow5());

        // Quality
        self::assertEquals('0', $quality->getLocality()->getFlag());
        self::assertEquals(0, $quality->getLocality()->getCode());
        self::assertSame('Ok', $quality->getLocality()->getDescription());

        self::assertEquals('1', $quality->getStreet()->getFlag());
        self::assertEquals(801, $quality->getStreet()->getCode());
        self::assertSame('Candidato strada con parole in meno', $quality->getStreet()->getDescription());

        self::assertEquals('0', $quality->getHn()->getFlag());
        self::assertEquals(0, $quality->getHn()->getCode());
        self::assertSame('Ok', $quality->getHn()->getDescription());

        // System
        self::assertEquals(0, $system->getRetCode());
        self::assertSame('Ok', $system->getDesRetCode());

        self::assertTrue(true);
    }
}
