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

namespace Egon\Dto\RequestValidationV4;

use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputDescriptionEnum;
use Egon\Enum\OutputFormatEnum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Enum\OutputLanguageEnum;

final readonly class Parameter
{
    public function __construct(
        private CountryCodeAlpha3Enum $countryCodeAlpha3Enum,
        private OutputGeoCodingEnum $outputGeoCodingEnum = OutputGeoCodingEnum::GEOCODING_OFF,
        private ?OutputFormatEnum $outputFormatEnum = null,
        private ?OutputLanguageEnum $outputLanguageEnum = null,
        private ?OutputDescriptionEnum $outputDescriptionEnum = null,
    ) {}

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        $fields = [
            'iso3' => $this->countryCodeAlpha3Enum->value,
            'geo' => $this->outputGeoCodingEnum->value,
        ];
        if ($this->outputFormatEnum instanceof OutputFormatEnum) {
            $fields['fmtout'] = $this->outputFormatEnum->value;
        }

        if ($this->outputLanguageEnum instanceof OutputLanguageEnum) {
            $fields['lngout'] = $this->outputLanguageEnum->value;
        }

        if ($this->outputDescriptionEnum instanceof OutputDescriptionEnum) {
            $fields['tpxout'] = $this->outputDescriptionEnum->value;
        }

        return $fields;
    }
}
