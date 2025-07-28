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

    public function testOne(): void {
        try {
            $arrayContent = $this->loadJsonFromFile(__DIR__ . '/sample_response.json');
        } catch (RuntimeException $e) {
            echo "Errore: " . $e->getMessage();
        }

        try {
            $map = ValidationV4Mapper::fromArray($arrayContent);
            // Puoi fare asserzioni qui, ad esempio:
            $this->assertNotNull($map);
            $this->assertInstanceOf(ValidationV4Response::class, $map);
        } catch (Throwable $e) {
            fwrite(STDERR, "Exception caught: " . $e::class . "\n");
            fwrite(STDERR, $e->getMessage() . "\n");
            fwrite(STDERR, $e->getTraceAsString() . "\n");

            $this->fail("Exception thrown during fromArray(): " . $e->getMessage());
        }

        var_dump($map);

        $this->assertTrue(true);
    }
}
