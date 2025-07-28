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

class ValidationV4Postal {

    private ?string $row4 = null;
    private ?string $row5 = null;

    public function getRow4(): ?string {
        return $this->row4;
    }

    public function getRow5(): ?string {
        return $this->row5;
    }

    public function setRow4(?string $row4): static {
        $this->row4 = $row4;
        return $this;
    }

    public function setRow5(?string $row5): static {
        $this->row5 = $row5;
        return $this;
    }
}
