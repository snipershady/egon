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

class ValidationV4Data
{
    private ?ValidationV4Address $validationV4Address = null;
    private ?ValidationV4Geo $validationV4Geo = null;
    private ?ValidationV4Postal $validationV4Postal = null;

    public function getAddress(): ?ValidationV4Address
    {
        return $this->validationV4Address;
    }

    public function getGeo(): ?ValidationV4Geo
    {
        return $this->validationV4Geo;
    }

    public function getPostal(): ?ValidationV4Postal
    {
        return $this->validationV4Postal;
    }

    public function setAddress(?ValidationV4Address $validationV4Address): static
    {
        $this->validationV4Address = $validationV4Address;

        return $this;
    }

    public function setGeo(?ValidationV4Geo $validationV4Geo): static
    {
        $this->validationV4Geo = $validationV4Geo;

        return $this;
    }

    public function setPostal(?ValidationV4Postal $validationV4Postal): static
    {
        $this->validationV4Postal = $validationV4Postal;

        return $this;
    }
}
