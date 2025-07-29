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

namespace Egon\Dto\ResponseValidationV4;

class ValidationV4EgonCode {

    private ?string $city = null;
    private ?string $street = null;
    private ?string $hn = null;

    public function getCity(): ?string {
        return $this->city;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function getHn(): ?string {
        return $this->hn;
    }

    public function setCity(?string $city): static {
        $this->city = $city;
        return $this;
    }

    public function setStreet(?string $street): static {
        $this->street = $street;
        return $this;
    }

    public function setHn(?string $hn): static {
        $this->hn = $hn;
        return $this;
    }
}
