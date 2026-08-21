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

namespace Egon\Service;

use Egon\Dto\RequestValidationV4\Address;
use Egon\Dto\RequestValidationV4\Parameter;
use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use Egon\Exception\CurlException;
use Egon\Exception\EgonException;

/**
 * Description of ValidationV4.
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
final readonly class ValidationV4
{
    public function __construct(
        private string $token,
        private string $url = 'https://api.egon.com/v4/validation/address',
    ) {}

    /**
     * @return array<string, mixed>
     *
     * @throws CurlException
     * @throws EgonException
     */
    public function getValidAddress(
        Address $address,
        Parameter $parameter,
    ): array {
        return $this->validate($address, $parameter);
    }

    /**
     * @throws EgonException
     * @throws CurlException
     */
    public function getValidAddressMapped(
        Address $address,
        Parameter $parameter,
    ): ValidationV4Response {
        $arrayContent = $this->validate($address, $parameter);

        return ValidationV4Mapper::fromArray($arrayContent);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws CurlException
     * @throws EgonException
     */
    private function validate(
        Address $address,
        Parameter $parameter,
    ): array {
        // Payload JSON
        $payload = [
            'par' => $parameter->toArray(),
            'data' => [
                'address' => $address->toArray(),
            ],
        ];

        $encodedPayload = json_encode($payload);

        if (false === $encodedPayload) {
            throw new EgonException('Unable to encode request payload');
        }

        // init cURL Session
        $ch = curl_init($this->url);

        // URL options
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.$this->token,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => $encodedPayload,
        ]);

        // Curl request
        $response = curl_exec($ch);

        // Error handler
        if (0 !== curl_errno($ch)) {
            $msg = 'cURL Error: '.curl_error($ch);

            throw new CurlException($msg);
        }

        if (!\is_string($response)) {
            throw new CurlException('Empty or invalid response body');
        }

        $result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (!\is_array($result)) {
            throw new EgonException('Unexpected response format');
        }

        if (!empty($result['error']) && \is_array($result['error'])) {
            $message = $result['error']['message'] ?? '';
            $code = $result['error']['code'] ?? 0;

            throw new EgonException(
                \is_scalar($message) ? (string) $message : '',
                \is_scalar($code) ? (int) $code : 0,
            );
        }

        return $result;
    }
}
