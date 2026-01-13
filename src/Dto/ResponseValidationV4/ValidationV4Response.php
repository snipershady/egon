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

class ValidationV4Response
{
    private ?ValidationV4Data $validationV4Data = null;
    private ?ValidationV4Quality $validationV4Quality = null;
    private ?ValidationV4System $validationV4System = null;

    public function getData(): ?ValidationV4Data
    {
        return $this->validationV4Data;
    }

    public function getQuality(): ?ValidationV4Quality
    {
        return $this->validationV4Quality;
    }

    public function getSystem(): ?ValidationV4System
    {
        return $this->validationV4System;
    }

    public function setData(?ValidationV4Data $validationV4Data): static
    {
        $this->validationV4Data = $validationV4Data;

        return $this;
    }

    public function setQuality(?ValidationV4Quality $validationV4Quality): static
    {
        $this->validationV4Quality = $validationV4Quality;

        return $this;
    }

    public function setSystem(?ValidationV4System $validationV4System): static
    {
        $this->validationV4System = $validationV4System;

        return $this;
    }
}
