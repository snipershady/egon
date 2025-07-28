<?php

namespace Egon\Tests;

use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use RuntimeException;
use Throwable;

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

/**
 * Description of AbstractTestCase
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 * 
 * @example ./vendor/bin/phpunit --display-output tests/BasicTest.php 
 */
class BasicTest extends AbstractTestCase {

    private function loadJsonFromFile(string $filePath): ?array {
        if (!file_exists($filePath)) {
            throw new RuntimeException("File not found: $filePath");
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new RuntimeException("Unable to read file: $filePath");
        }
        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    public function testPersistedSampleResponse(): void {
        try {
            $arrayContent = $this->loadJsonFromFile(__DIR__ . '/sample_response.json');
        } catch (RuntimeException $e) {
            echo "Errore: " . $e->getMessage();
        }

        try {
            $response = ValidationV4Mapper::fromArray($arrayContent);
            // Puoi fare asserzioni qui, ad esempio:
            $this->assertNotNull($response);
            $this->assertInstanceOf(ValidationV4Response::class, $response);
        } catch (Throwable $e) {
            fwrite(STDERR, "Exception caught: " . $e::class . "\n");
            fwrite(STDERR, $e->getMessage() . "\n");
            fwrite(STDERR, $e->getTraceAsString() . "\n");

            $this->fail("Exception thrown during fromArray(): " . $e->getMessage());
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
        $this->assertEquals('50137', $admCodes[0]->getType());
        $this->assertEquals('VR', $admCodes[0]->getValue());

        $this->assertEquals('30030', $admCodes[1]->getType());
        $this->assertEquals('11700', $admCodes[1]->getValue());

        $this->assertEquals('30000', $admCodes[2]->getType());
        $this->assertEquals('L781', $admCodes[2]->getValue());

        $this->assertEquals('30021', $admCodes[3]->getType());
        $this->assertEquals('023091', $admCodes[3]->getValue());

        $this->assertEquals('30060', $admCodes[4]->getType());
        $this->assertEquals('086', $admCodes[4]->getValue());

        $this->assertEquals('30061', $admCodes[5]->getType());
        $this->assertEquals('660999', $admCodes[5]->getValue());

        $this->assertEquals('30050', $admCodes[6]->getType());
        $this->assertEquals('0777000', $admCodes[6]->getValue());

        $this->assertEquals('30071', $admCodes[7]->getType());
        $this->assertEquals('IT', $admCodes[7]->getValue());

        $this->assertEquals('30070', $admCodes[8]->getType());
        $this->assertEquals('ITA', $admCodes[8]->getValue());

        $this->assertEquals('30072', $admCodes[9]->getType());
        $this->assertEquals('380', $admCodes[9]->getValue());

        $this->assertEquals('30114', $admCodes[10]->getType());
        $this->assertEquals('ITALIA', $admCodes[10]->getValue());

        $this->assertEquals('30022', $admCodes[11]->getType());
        $this->assertEquals('005', $admCodes[11]->getValue());

        $egonCode = $standard->getEgonCode();
        $this->assertEquals(38000004730, $egonCode->getCity());
        $this->assertEquals(38000073526, $egonCode->getStreet());
        $this->assertEquals(380100008326045, $egonCode->getHn());

        // Smart address assertions
        $this->assertEquals('Italia', $smart->getCountry());
        $this->assertEquals('Verona', $smart->getAdministrativeLevel());
        $this->assertEquals('Verona', $smart->getCity());
        $this->assertEquals('Via Antonio Pacinotti,4/B', $smart->getAddress());
        $this->assertEquals('37135', $smart->getZipcode());

        // Geo
        $this->assertEquals('45.40616800, 10.97379600', $geo->getLatLong());
        $this->assertEquals('A41-111', $geo->getGeoLevel());
        $this->assertEquals('0230910000922', $geo->getCensusCode());

        // Postal
        $this->assertEquals('VIA ANTONIO PACINOTTI 4/B', $postal->getRow4());
        $this->assertEquals('37135 VERONA VR', $postal->getRow5());

        // Quality
        $this->assertEquals('0', $quality->getLocality()->getFlag());
        $this->assertEquals(0, $quality->getLocality()->getCode());
        $this->assertEquals('Ok', $quality->getLocality()->getDescription());

        $this->assertEquals('1', $quality->getStreet()->getFlag());
        $this->assertEquals(801, $quality->getStreet()->getCode());
        $this->assertEquals('Candidato strada con parole in meno', $quality->getStreet()->getDescription());

        $this->assertEquals('0', $quality->getHn()->getFlag());
        $this->assertEquals(0, $quality->getHn()->getCode());
        $this->assertEquals('Ok', $quality->getHn()->getDescription());

        // System
        $this->assertEquals(0, $system->getRetCode());
        $this->assertEquals('Ok', $system->getDesRetCode());

        $this->assertTrue(true);
    }

    public function testRemoteSampleResponse(): void {
        try {
            $v = new \Egon\Service\ValidationV4();
            $arrayContent = $v->validate();
        } catch (RuntimeException $e) {
            echo "Errore: " . $e->getMessage();
        }

        try {
            $response = ValidationV4Mapper::fromArray($arrayContent);
            // Puoi fare asserzioni qui, ad esempio:
            $this->assertNotNull($response);
            $this->assertInstanceOf(ValidationV4Response::class, $response);
        } catch (Throwable $e) {
            fwrite(STDERR, "Exception caught: " . $e::class . "\n");
            fwrite(STDERR, $e->getMessage() . "\n");
            fwrite(STDERR, $e->getTraceAsString() . "\n");

            $this->fail("Exception thrown during fromArray(): " . $e->getMessage());
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
        $this->assertEquals(380100008326045, $egonCode->getHn());

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

        $this->assertEquals('0', $quality->getHn()->getFlag());
        $this->assertEquals(0, $quality->getHn()->getCode());
        $this->assertEquals(strtolower('Ok'), strtolower($quality->getHn()->getDescription()));

        // System
        $this->assertEquals(0, $system->getRetCode());
        $this->assertEquals(strtolower('Ok'), strtolower((string) $system->getDesRetCode()));

        $this->assertTrue(true);
    }
}
