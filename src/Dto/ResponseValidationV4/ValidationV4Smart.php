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

final class ValidationV4Smart {

    private ?string $country = null;
    private ?string $administrativeLevel = null;
    private ?string $city = null;
    private ?string $address = null;
    private ?string $zipcode = null;

    public function getCountry(): ?string {
        return $this->country;
    }

    public function getAdministrativeLevel(): ?string {
        return $this->administrativeLevel;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function getZipcode(): ?string {
        return $this->zipcode;
    }

    public function setCountry(?string $country): static {
        $this->country = $country;
        return $this;
    }

    public function setAdministrativeLevel(?string $administrativeLevel): static {
        $this->administrativeLevel = $administrativeLevel;
        return $this;
    }

    public function setCity(?string $city): static {
        $this->city = $city;
        return $this;
    }

    public function setAddress(?string $address): static {
        $this->address = $address;
        return $this;
    }

    public function setZipcode(?string $zipcode): static {
        $this->zipcode = $zipcode;
        return $this;
    }
}
