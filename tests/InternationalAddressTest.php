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

use Egon\Dto\ResponseValidationV4\ValidationV4EgonCode;
use Egon\Dto\ResponseValidationV4\ValidationV4Geo;
use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Postal;
use Egon\Dto\ResponseValidationV4\ValidationV4QualityAddress;
use Egon\Dto\ResponseValidationV4\ValidationV4Smart;
use Egon\Dto\ResponseValidationV4\ValidationV4Standard;

/**
 * Regression coverage for how the response shape actually varies across
 * countries, captured from live API calls against several real addresses
 * (see tests/sample_response_*.json). Unlike tests/sample_response.json
 * (Italy), these fixtures exercise fields that only some countries return:
 * "state"/"state_code"/"locality" on the standard address, "locality" on
 * egon_code, and postal rows beyond row4/row5.
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 *
 * @example ./vendor/bin/phpunit tests/InternationalAddressTest.php
 *
 * @internal
 */
final class InternationalAddressTest extends AbstractTestCase
{
    public function testSpanishAddress(): void
    {
        $arrayContent = self::loadJsonFromFile(__DIR__.'/sample_response_es.json');
        $validationV4Response = ValidationV4Mapper::fromArray($arrayContent);

        $standard = $validationV4Response->getData()->getAddress()->getStandard();
        $quality = $validationV4Response->getQuality()->getAddress();
        self::assertInstanceOf(ValidationV4Standard::class, $standard);

        self::assertSame('ESP', $standard->getIso3());
        self::assertSame('España', $standard->getCountry());
        self::assertSame('Comunidad de Madrid', $standard->getRegion());
        self::assertSame('Madrid', $standard->getProvince());
        self::assertSame('M', $standard->getProvinceCode());
        self::assertSame('Madrid', $standard->getCity());
        self::assertSame('28014', $standard->getZipcode());
        self::assertSame('Calle', $standard->getStreetType());
        self::assertSame('de Alcalá', $standard->getStreetName());
        self::assertSame('Calle de Alcalá', $standard->getStreet());
        self::assertSame('Calle de Alcalá 1', $standard->getAddress());
        self::assertSame('1', $standard->getHn());
        self::assertSame('MADRID', $standard->getPostalTown1());

        // Spain reports a single administrative code, unlike Italy's twelve.
        $admCodes = $standard->getAdmCode();
        self::assertCount(1, $admCodes);
        self::assertSame('50137', $admCodes[0]->getType());
        self::assertSame('Madrid', $admCodes[0]->getValue());

        $egonCode = $standard->getEgonCode();
        self::assertInstanceOf(ValidationV4EgonCode::class, $egonCode);
        self::assertSame('72400004425', $egonCode->getCity());
        self::assertSame('72401061521', $egonCode->getStreet());
        // Spain's egon_code carries no house-number entry, same as Italy.
        self::assertSame('', $egonCode->getHn());

        $smart = $validationV4Response->getData()->getAddress()->getSmart();
        self::assertInstanceOf(ValidationV4Smart::class, $smart);
        self::assertSame('España', $smart->getCountry());
        self::assertSame('Madrid', $smart->getAdministrativeLevel());
        self::assertSame('Madrid', $smart->getCity());

        $postal = $validationV4Response->getData()->getPostal();
        self::assertInstanceOf(ValidationV4Postal::class, $postal);
        self::assertSame('CALLE DE ALCALÁ 1', $postal->getRow4());
        self::assertSame('28014', $postal->getRow5());
        self::assertInstanceOf(ValidationV4QualityAddress::class, $quality);

        self::assertSame('0', $quality->getLocality()->getFlag());
        self::assertSame('0', $quality->getStreet()->getFlag());

        self::assertSame('0', $validationV4Response->getSystem()->getRetCode());
    }

    public function testGermanAddressExposesStateAndLocalityFields(): void
    {
        $arrayContent = self::loadJsonFromFile(__DIR__.'/sample_response_de.json');
        $validationV4Response = ValidationV4Mapper::fromArray($arrayContent);

        $standard = $validationV4Response->getData()->getAddress()->getStandard();
        self::assertInstanceOf(ValidationV4Standard::class, $standard);

        self::assertSame('DEU', $standard->getIso3());
        self::assertSame('Deutschland', $standard->getCountry());
        // Germany's response has no "region" key at all, only state/province.
        self::assertNull($standard->getRegion());
        self::assertSame('Berlin', $standard->getState());
        self::assertSame('BE', $standard->getStateCode());
        self::assertSame('Berlin', $standard->getProvince());
        self::assertSame('Berlin', $standard->getCity());
        self::assertSame('Mitte', $standard->getLocality());
        self::assertSame('10117', $standard->getZipcode());

        $egonCode = $standard->getEgonCode();
        self::assertInstanceOf(ValidationV4EgonCode::class, $egonCode);
        self::assertSame('27600008912', $egonCode->getCity());
        self::assertSame('27600073750', $egonCode->getLocality());
        self::assertSame('27600296069', $egonCode->getStreet());

        $postal = $validationV4Response->getData()->getPostal();
        self::assertInstanceOf(ValidationV4Postal::class, $postal);
        self::assertSame('MITTE', $postal->getRow3());
        self::assertSame('PARISER PLATZ 1', $postal->getRow4());
        self::assertSame('10117', $postal->getRow5());

        // Unlike the Spanish/Italian samples, this address is only a
        // fuzzy match: both quality flags report a "candidate found",
        // not an exact "OK".
        $quality = $validationV4Response->getQuality()->getAddress();
        self::assertInstanceOf(ValidationV4QualityAddress::class, $quality);
        self::assertSame('1', $quality->getLocality()->getFlag());
        self::assertSame('701', $quality->getLocality()->getCode());
        self::assertSame('1', $quality->getStreet()->getFlag());
        self::assertSame('801', $quality->getStreet()->getCode());
    }

    public function testFrenchAddressExposesExtraPostalRows(): void
    {
        $arrayContent = self::loadJsonFromFile(__DIR__.'/sample_response_fr.json');
        $validationV4Response = ValidationV4Mapper::fromArray($arrayContent);

        $standard = $validationV4Response->getData()->getAddress()->getStandard();
        self::assertInstanceOf(ValidationV4Standard::class, $standard);
        self::assertSame('FRA', $standard->getIso3());
        self::assertSame('France', $standard->getCountry());
        self::assertSame('Paris', $standard->getCity());

        $admCodes = $standard->getAdmCode();
        self::assertCount(7, $admCodes);

        $postal = $validationV4Response->getData()->getPostal();
        self::assertInstanceOf(ValidationV4Postal::class, $postal);
        self::assertSame('5 AVENUE ANATOLE FRANCE', $postal->getRow4());
        // France skips row5 and uses row6/row7 instead.
        self::assertNull($postal->getRow5());
        self::assertSame('75007 PARIS', $postal->getRow6());
        self::assertSame('FRANCE', $postal->getRow7());
    }

    public function testAddressNotFoundStillMapsWithoutErrors(): void
    {
        $arrayContent = self::loadJsonFromFile(__DIR__.'/sample_response_not_found.json');
        $validationV4Response = ValidationV4Mapper::fromArray($arrayContent);

        $quality = $validationV4Response->getQuality()->getAddress();
        self::assertInstanceOf(ValidationV4QualityAddress::class, $quality);
        self::assertSame('3', $quality->getLocality()->getFlag());
        self::assertSame('212', $quality->getLocality()->getCode());
        self::assertSame('2', $quality->getStreet()->getFlag());
        self::assertSame('302', $quality->getStreet()->getCode());

        // egon_code and geo come back as an empty JSON array ("[]") rather
        // than an object when nothing was matched; the mapper must still
        // produce well-formed, non-null value objects with empty fields
        // instead of erroring out.
        $egonCode = $validationV4Response->getData()->getAddress()->getStandard()->getEgonCode();
        self::assertInstanceOf(ValidationV4EgonCode::class, $egonCode);
        self::assertSame('', $egonCode->getCity());
        self::assertSame('', $egonCode->getStreet());

        $geo = $validationV4Response->getData()->getGeo();
        self::assertInstanceOf(ValidationV4Geo::class, $geo);
        self::assertNull($geo->getLatLong());

        self::assertSame('0', $validationV4Response->getSystem()->getRetCode());
    }
}
