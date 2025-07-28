<?php

namespace Egon\Service;

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
            private readonly string $url = "https://api.egon.com/v4/validation/address",
            private readonly string $token = "b4fe924796db0794d0adf552b0986ab55b246364baa7d8187fe2ccbd700cd17a"
    ) {
        
    }

    public function validate(): array {
        // Payload JSON
        $payload = [
            'par' => [
                'iso3' => 'ITA',
                'geo' => 'S',
            ],
            'data' => [
                'address' => [
                    'city' => 'Verona',
                    'street' => 'Via Pacinotti 4b',
                ],
            ],
        ];

        // Inizializza la sessione cURL
        $ch = curl_init($this->url);

        // Imposta le opzioni cURL
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

        // Esegui la richiesta
        $response = curl_exec($ch);

        // Gestisci eventuali errori
        if (curl_errno($ch) !== 0) {
            echo 'Errore cURL: ' . curl_error($ch);
        } else {
            // Decodifica la risposta JSON
            $result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        }

        // Chiudi la sessione cURL
        curl_close($ch);

        return $result;
    }
}
