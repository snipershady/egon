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

class ValidationV4AdmCode {

    private string $iso3;
    private string $type;
    private string $value;

    public function getIso3(): string {
        return $this->iso3;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function setIso3(string $iso3): static {
        $this->iso3 = $iso3;
        return $this;
    }

    public function setType(string $type): static {
        $this->type = $type;
        return $this;
    }

    public function setValue(string $value): static {
        $this->value = $value;
        return $this;
    }
}
