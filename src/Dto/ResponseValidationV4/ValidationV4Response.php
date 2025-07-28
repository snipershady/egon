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

class ValidationV4Response {

    private ?ValidationV4Data $data = null;
    private ?ValidationV4Quality $quality = null;
    private ?ValidationV4System $system = null;

    public function getData(): ?ValidationV4Data {
        return $this->data;
    }

    public function getQuality(): ?ValidationV4Quality {
        return $this->quality;
    }

    public function getSystem(): ?ValidationV4System {
        return $this->system;
    }

    public function setData(?ValidationV4Data $data): static {
        $this->data = $data;
        return $this;
    }

    public function setQuality(?ValidationV4Quality $quality): static {
        $this->quality = $quality;
        return $this;
    }

    public function setSystem(?ValidationV4System $system): static {
        $this->system = $system;
        return $this;
    }
}
