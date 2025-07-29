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

final class ValidationV4System {

    private ?string $retCode = null;
    private ?string $desRetCode = null;

    public function getRetCode(): ?string {
        return $this->retCode;
    }

    public function getDesRetCode(): ?string {
        return $this->desRetCode;
    }

    public function setRetCode(?string $retCode): static {
        $this->retCode = $retCode;
        return $this;
    }

    public function setDesRetCode(?string $desRetCode): static {
        $this->desRetCode = $desRetCode;
        return $this;
    }
}
