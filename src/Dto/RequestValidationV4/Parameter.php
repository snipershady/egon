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

namespace Egon\Dto\RequestValidationV4;

use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputDescriptionEnum;
use Egon\Enum\OutputFormatEnum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Enum\OutputLanguageEnum;

final readonly class Parameter {

    /**
     * 
     * @param CountryCodeAlpha3Enum $countryCode
     * @param OutputGeoCodingEnum $outputGeoCoding
     * @param OutputFormatEnum|null $outputFormat
     * @param OutputLanguageEnum|null $outputLanguage
     * @param OutputDescriptionEnum|null $outputDescription
     */
    public function __construct(
            private CountryCodeAlpha3Enum $countryCode,
            private OutputGeoCodingEnum $outputGeoCoding = OutputGeoCodingEnum::GEOCODING_OFF,
            private ?OutputFormatEnum $outputFormat = null,
            private ?OutputLanguageEnum $outputLanguage = null,
            private ?OutputDescriptionEnum $outputDescription = null
    ) {
        
    }

    public function toArray(): array {
        $fields = [
            "iso3" => $this->countryCode->value,
            "geo" => $this->outputGeoCoding->value
        ];
        if ($this->outputFormat !== null) {
            $fields["fmtout"] = $this->outputFormat->value;
        }
        if ($this->outputLanguage !== null) {
            $fields["lngout"] = $this->outputLanguage->value;
        }
        if ($this->outputDescription !== null) {
            $fields["tpxout"] = $this->outputDescription->value;
        }
        return $fields;
    }
}
