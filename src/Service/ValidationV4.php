<?php

namespace Egon\Service;

use Egon\Dto\RequestValidationV4\Address;
use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Exception\CurlException;

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
 * Description of ValidationV4
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
class ValidationV4 {

    public function __construct(
            private readonly string $token,
            private readonly string $url = "https://api.egon.com/v4/validation/address"
    ) {
        
    }

    public function validate(
            Address $address,
            CountryCodeAlpha3Enum $countrycode,
            OutputGeoCodingEnum $geocoding = OutputGeoCodingEnum::GEOCODING_OFF
    ): array {
        // Payload JSON
        $payload = [
            'par' => [
                'iso3' => $countrycode->value,
                'geo' => $geocoding->value,
            ],
            'data' => [
                'address' => $address->toArray(),
            ]
        ];

        // init cURL Session
        $ch = curl_init($this->url);

        // URL options
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        // Curl request
        $response = curl_exec($ch);

        // Error handler
        if (curl_errno($ch) !== 0) {
            $msg = 'Errore cURL: ' . curl_error($ch);
            throw new CurlException($msg);
        } else {
            $result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        }

        // Close curl session
        curl_close($ch);

        return $result;
    }
}
