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

use Egon\Exception\CurlException;
use Egon\Exception\EgonException;

/**
 * Description of Balance
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
final readonly class Balance {

    /**
     * 
     * @param string $token
     * @param string $url
     */
    public function __construct(
            private string $token,
            private string $url = "https://api.egon.com/account/balance"
    ) {
        
    }

    /**
     * 
     * @param string $token
     * @return float
     * @throws CurlException
     * @throws EgonException
     */
    public function getBalance(): float {
        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true, // Per ottenere la risposta come stringa
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
            ],
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch) !== 0) {
            $msg = 'cURL Error: ' . curl_error($ch);
            curl_close($ch);
            throw new CurlException($msg);
        }
        
        curl_close($ch);

        $result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        if (empty($result["balance"])) {
            throw new EgonException("Balance call, failed");
        }

        return (float) $result["balance"];
    }
}
