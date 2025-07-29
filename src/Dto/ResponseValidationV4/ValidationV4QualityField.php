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

class ValidationV4QualityField {

    private ?string $flag = null;
    private ?string $code = null;
    private ?string $description = null;

    public function getFlag(): string {
        return $this->flag;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setFlag(string $flag): static {
        $this->flag = $flag;
        return $this;
    }

    public function setCode(string $code): static {
        $this->code = $code;
        return $this;
    }

    public function setDescription(string $description): static {
        $this->description = $description;
        return $this;
    }
}
