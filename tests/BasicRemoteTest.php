<?php

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
use Exception;
use Throwable;

/**
 * Description of AbstractTestCase
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 * 
 * @example ./vendor/bin/phpunit tests/BasicRemoteTest.php 
 */
class BasicRemoteTest extends AbstractTestCase {

    public function testRemoteSampleResponse(): void {
        $address = new Address();
        $address->setStreet("Via Pacinotti 4b")->setCity("Verona");
        $parameter = new Parameter(CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

        try {
            $token = "b4fe924796db0794d0adf552b0986ab55b246364baa7d8187fe2ccbd700cd17a";
            $validationV4 = new ValidationV4($token);
            $arrayContent = $validationV4->getValidAddress($address, $parameter);
        } catch (Exception $exception) {
            $msg = "Exception: " . $exception->getMessage() . PHP_EOL;
            fwrite(STDERR, $msg);
            $this->fail("Exception thrown during validate call: " . $msg);
        }

        try {
            $response = ValidationV4Mapper::fromArray($arrayContent);
            $this->assertNotNull($response);
            $this->assertInstanceOf(ValidationV4Response::class, $response);
        } catch (Throwable $throwable) {
            fwrite(STDERR, "Exception caught: " . $throwable::class . "\n");
            fwrite(STDERR, $throwable->getMessage() . "\n");
            fwrite(STDERR, $throwable->getTraceAsString() . "\n");

            $this->fail("Exception thrown during fromArray(): " . $throwable->getMessage());
        }

        $data = $response->getData();
        $standard = $data->getAddress()->getStandard();
        $smart = $data->getAddress()->getSmart();
        $geo = $data->getGeo();
        $postal = $data->getPostal();
        $quality = $response->getQuality()->getAddress();
        $system = $response->getSystem();

        // Standard address assertions
        $this->assertEquals('ITA', $standard->getIso3());
        $this->assertEquals('Italia', $standard->getCountry());
        $this->assertEquals('Veneto', $standard->getRegion());
        $this->assertEquals('Verona', $standard->getProvince());
        $this->assertEquals('VR', $standard->getProvinceCode());
        $this->assertEquals('Verona', $standard->getCity());
        $this->assertEquals('37135', $standard->getZipcode());
        $this->assertEquals('Via', $standard->getStreetType());
        $this->assertEquals('Antonio Pacinotti', $standard->getStreetName());
        $this->assertEquals('Via Antonio Pacinotti', $standard->getStreet());
        $this->assertEquals('Via Antonio Pacinotti,4/B', $standard->getAddress());
        $this->assertEquals('Via Antonio Pacinotti,4/B, Verona, VR, Veneto, 37135, Italia', $standard->getFullAddress());
        $this->assertEquals('4/B', $standard->getHn());
        $this->assertEquals('VERONA', $standard->getPostalTown1());

        $admCodes = $standard->getAdmCode();
        $this->assertCount(12, $admCodes);

        $egonCode = $standard->getEgonCode();
        
        $this->assertEquals(38000004730, $egonCode->getCity());
        $this->assertEquals(38000073526, $egonCode->getStreet());
        $this->assertEquals("", $egonCode->getHn());

        // Smart address assertions
        $this->assertEquals('Italia', $smart->getCountry());
        $this->assertEquals('Verona', $smart->getAdministrativeLevel());
        $this->assertEquals('Verona', $smart->getCity());
        $this->assertEquals('Via Antonio Pacinotti,4/B', $smart->getAddress());
        $this->assertEquals('37135', $smart->getZipcode());

        // Geo
        $this->assertEquals('45.40616800, 10.97379600', $geo->getLatLong());
        $this->assertEquals('A41-111', $geo->getGeoLevel());
        //$this->assertEquals('0230910000922', $geo->getCensusCode());
        // Postal
        $this->assertEquals('VIA ANTONIO PACINOTTI 4/B', $postal->getRow4());
        $this->assertEquals('37135 VERONA VR', $postal->getRow5());

        // Quality
        $this->assertEquals('0', $quality->getLocality()->getFlag());
        $this->assertEquals(0, $quality->getLocality()->getCode());
        $this->assertEquals(strtolower('Ok'), strtolower($quality->getLocality()->getDescription()));

        // System
        $this->assertEquals(0, $system->getRetCode());
        $this->assertEquals(strtolower('Ok'), strtolower((string) $system->getDesRetCode()));

        $this->assertTrue(true);
    }
}
