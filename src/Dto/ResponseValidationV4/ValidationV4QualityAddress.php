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

final class ValidationV4QualityAddress {

    private ?ValidationV4QualityField $locality = null;
    private ?ValidationV4QualityField $street = null;
    private ?ValidationV4QualityField $hn = null;

    public function getLocality(): ?ValidationV4QualityField {
        return $this->locality;
    }

    public function getStreet(): ?ValidationV4QualityField {
        return $this->street;
    }

    public function getHn(): ?ValidationV4QualityField {
        return $this->hn;
    }

    public function setLocality(?ValidationV4QualityField $locality): static {
        $this->locality = $locality;
        return $this;
    }

    public function setStreet(?ValidationV4QualityField $street): static {
        $this->street = $street;
        return $this;
    }

    public function setHn(?ValidationV4QualityField $hn): static {
        $this->hn = $hn;
        return $this;
    }
}
