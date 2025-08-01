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

namespace Egon\Tests;

use Egon\Service\Balance;

/**
 * Description of BasicBalanceTest
 *
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 * 
 * @example ./vendor/bin/phpunit tests/BasicBalanceTest.php 
 */
class BasicBalanceTest extends AbstractTestCase {

    public function testWalletBalance(): void {
        $token = "";
        $b = new Balance($token);
        $res = $b->getBalance();

        $this->assertIsFloat($res);
    }
}
