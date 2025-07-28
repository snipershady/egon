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

final class ValidationV4Standard {

    private ?string $iso3 = null;
    private ?string $country = null;
    private ?string $region = null;
    private ?string $province = null;
    private ?string $provinceCode = null;
    private ?string $city = null;
    private ?string $zipcode = null;
    private ?string $streetType = null;
    private ?string $streetName = null;
    private ?string $street = null;
    private ?string $address = null;
    private ?string $fullAddress = null;
    private ?string $hn = null;
    private ?string $postalTown1 = null;

    /**
     * <p>array of ValidationV4AdmCode</p>
     * @var array<ValidationV4AdmCode>
     */
    private array $admCode = [];
    private ?ValidationV4EgonCode $egonCode = null;

    public function getIso3(): ?string {
        return $this->iso3;
    }

    public function getCountry(): ?string {
        return $this->country;
    }

    public function getRegion(): ?string {
        return $this->region;
    }

    public function getProvince(): ?string {
        return $this->province;
    }

    public function getProvinceCode(): ?string {
        return $this->provinceCode;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function getZipcode(): ?string {
        return $this->zipcode;
    }

    public function getStreetType(): ?string {
        return $this->streetType;
    }

    public function getStreetName(): ?string {
        return $this->streetName;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function getFullAddress(): ?string {
        return $this->fullAddress;
    }

    public function getHn(): ?string {
        return $this->hn;
    }

    public function getPostalTown1(): ?string {
        return $this->postalTown1;
    }

    public function getAdmCode(): array {
        return $this->admCode;
    }

    public function getEgonCode(): ?ValidationV4EgonCode {
        return $this->egonCode;
    }

    public function setIso3(?string $iso3): static {
        $this->iso3 = $iso3;
        return $this;
    }

    public function setCountry(?string $country): static {
        $this->country = $country;
        return $this;
    }

    public function setRegion(?string $region): static {
        $this->region = $region;
        return $this;
    }

    public function setProvince(?string $province): static {
        $this->province = $province;
        return $this;
    }

    public function setProvinceCode(?string $provinceCode): static {
        $this->provinceCode = $provinceCode;
        return $this;
    }

    public function setCity(?string $city): static {
        $this->city = $city;
        return $this;
    }

    public function setZipcode(?string $zipcode): static {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function setStreetType(?string $streetType): static {
        $this->streetType = $streetType;
        return $this;
    }

    public function setStreetName(?string $streetName): static {
        $this->streetName = $streetName;
        return $this;
    }

    public function setStreet(?string $street): static {
        $this->street = $street;
        return $this;
    }

    public function setAddress(?string $address): static {
        $this->address = $address;
        return $this;
    }

    public function setFullAddress(?string $fullAddress): static {
        $this->fullAddress = $fullAddress;
        return $this;
    }

    public function setHn(?string $hn): static {
        $this->hn = $hn;
        return $this;
    }

    public function setPostalTown1(?string $postalTown1): static {
        $this->postalTown1 = $postalTown1;
        return $this;
    }

    public function setAdmCode(array $admCode): static {
        $this->admCode = $admCode;
        return $this;
    }

    public function setEgonCode(?ValidationV4EgonCode $egonCode): static {
        $this->egonCode = $egonCode;
        return $this;
    }
}
