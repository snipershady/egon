<?php

declare(strict_types=1);

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

class ValidationV4Postal
{
    private ?string $row1 = null;
    private ?string $row2 = null;
    private ?string $row3 = null;
    private ?string $row4 = null;
    private ?string $row5 = null;
    private ?string $row6 = null;
    private ?string $row7 = null;

    public function getRow1(): ?string
    {
        return $this->row1;
    }

    public function getRow2(): ?string
    {
        return $this->row2;
    }

    public function getRow3(): ?string
    {
        return $this->row3;
    }

    public function getRow4(): ?string
    {
        return $this->row4;
    }

    public function getRow5(): ?string
    {
        return $this->row5;
    }

    public function getRow6(): ?string
    {
        return $this->row6;
    }

    public function getRow7(): ?string
    {
        return $this->row7;
    }

    public function setRow1(?string $row1): static
    {
        $this->row1 = $row1;

        return $this;
    }

    public function setRow2(?string $row2): static
    {
        $this->row2 = $row2;

        return $this;
    }

    public function setRow3(?string $row3): static
    {
        $this->row3 = $row3;

        return $this;
    }

    public function setRow4(?string $row4): static
    {
        $this->row4 = $row4;

        return $this;
    }

    public function setRow5(?string $row5): static
    {
        $this->row5 = $row5;

        return $this;
    }

    public function setRow6(?string $row6): static
    {
        $this->row6 = $row6;

        return $this;
    }

    public function setRow7(?string $row7): static
    {
        $this->row7 = $row7;

        return $this;
    }
}
