<?php

namespace Egon\Dto\ResponseValidationV4;

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

final class ValidationV4Address {

    private ?ValidationV4Standard $standard = null;
    private ?ValidationV4Smart $smart = null;

    public function getStandard(): ?ValidationV4Standard {
        return $this->standard;
    }

    public function getSmart(): ?ValidationV4Smart {
        return $this->smart;
    }

    public function setStandard(?ValidationV4Standard $standard): static {
        $this->standard = $standard;
        return $this;
    }

    public function setSmart(?ValidationV4Smart $smart): static {
        $this->smart = $smart;
        return $this;
    }
}
