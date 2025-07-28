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

class ValidationV4Geo {

    private ?string $latLong = null;
    private ?string $geoLevel = null;
    private ?string $censusCode = null;

    public function getLatLong(): ?string {
        return $this->latLong;
    }

    public function getGeoLevel(): ?string {
        return $this->geoLevel;
    }

    public function getCensusCode(): ?string {
        return $this->censusCode;
    }

    public function setLatLong(?string $latLong): static {
        $this->latLong = $latLong;
        return $this;
    }

    public function setGeoLevel(?string $geoLevel): static {
        $this->geoLevel = $geoLevel;
        return $this;
    }

    public function setCensusCode(?string $censusCode): static {
        $this->censusCode = $censusCode;
        return $this;
    }
}
