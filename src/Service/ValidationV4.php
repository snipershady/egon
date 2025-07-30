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

namespace Egon\Service;

use Egon\Dto\RequestValidationV4\Address;
use Egon\Dto\RequestValidationV4\Parameter;
use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use Egon\Exception\CurlException;
use Egon\Exception\EgonException;

/**
 * Description of ValidationV4
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
final readonly class ValidationV4 {

    public function __construct(
            private string $token,
            private string $url = "https://api.egon.com/v4/validation/address"
    ) {
        
    }

    /**
     * 
     * @param Address $address
     * @param Parameter $parameter
     * @throws CurlException
     * @throws EgonException
     * @return array
     */
    public function getValidAddress(
            Address $address,
            Parameter $parameter
    ): array {
        $arrayContent = $this->validate($address, $parameter);

        if (empty($arrayContent)) {
            return [];
        }
        return $arrayContent;
    }

    /**
     * 
     * @param Address $address
     * @param Parameter $parameter
     * @return ValidationV4Response
     * @throws EgonException
     * @throws CurlException
     */
    public function getValidAddressMapped(
            Address $address,
            Parameter $parameter
    ): ValidationV4Response {
        $arrayContent = $this->validate($address, $parameter);

        return ValidationV4Mapper::fromArray($arrayContent);
    }

    /**
     * 
     * @param Address $address
     * @param Parameter $parameter
     * @return array
     * @throws CurlException
     * @throws EgonException
     */
    private function validate(
            Address $address,
            Parameter $parameter
    ): array {
        // Payload JSON
        $payload = [
            'par' => $parameter->toArray(),
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
            $msg = 'cURL Error: ' . curl_error($ch);
            curl_close($ch);
            throw new CurlException($msg);
        }

        // Close curl session
        curl_close($ch);

        $result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (!empty($result["error"])) {
            throw new EgonException($result["error"]["message"], (int) $result["error"]["code"]);
        }

        return $result;
    }
}
