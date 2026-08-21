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

namespace Egon\Dto\RequestValidationV4;

final class Address
{
    /** @var null|int Egon code place */
    private ?int $egoncodePlace = null;

    /** @var null|int Egon code house number */
    private ?int $egoncodeHn = null;

    /** @var null|string Country description */
    private ?string $country = null;

    /** @var null|string State description */
    private ?string $state = null;

    /** @var null|string Region description */
    private ?string $region = null;

    /** @var null|string Province description */
    private ?string $province = null;

    /** @var null|string City description */
    private ?string $city = null;

    /** @var null|string District1 description */
    private ?string $district1 = null;

    /** @var null|string District2 description */
    private ?string $district2 = null;

    /** @var null|string District3 description */
    private ?string $district3 = null;

    /** @var null|string Zipcode description */
    private ?string $zipcode = null;

    /** @var null|string Town planning name (contains the type: Street, Square, Avenue, etc.) */
    private ?string $streetType = null;

    /** @var null|string Street description */
    private ?string $street = null;

    /** @var null|string Full address */
    private ?string $address = null;

    /** @var null|string House number */
    private ?string $hn = null;

    /** @var null|string Building */
    private ?string $building = null;

    /** @var null|string Sub Building */
    private ?string $subBuilding = null;

    /** @var null|string Organization */
    private ?string $organization = null;

    /** @var null|string Town planning name 2 (contains the type: Street, Square, Avenue, etc.) */
    private ?string $streetTypeStr2 = null;

    /** @var null|string Street 2 description */
    private ?string $street2 = null;

    /** @var null|string House number 2 */
    private ?string $hn2 = null;

    public function getEgoncodePlace(): ?int
    {
        return $this->egoncodePlace;
    }

    public function getEgoncodeHn(): ?int
    {
        return $this->egoncodeHn;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getDistrict1(): ?string
    {
        return $this->district1;
    }

    public function getDistrict2(): ?string
    {
        return $this->district2;
    }

    public function getDistrict3(): ?string
    {
        return $this->district3;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function getStreetType(): ?string
    {
        return $this->streetType;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getHn(): ?string
    {
        return $this->hn;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function getSubBuilding(): ?string
    {
        return $this->subBuilding;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function getStreetTypeStr2(): ?string
    {
        return $this->streetTypeStr2;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function getHn2(): ?string
    {
        return $this->hn2;
    }

    public function setEgoncodePlace(?int $egoncodePlace): static
    {
        $this->egoncodePlace = $egoncodePlace;

        return $this;
    }

    public function setEgoncodeHn(?int $egoncodeHn): static
    {
        $this->egoncodeHn = $egoncodeHn;

        return $this;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function setProvince(?string $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function setDistrict1(?string $district1): static
    {
        $this->district1 = $district1;

        return $this;
    }

    public function setDistrict2(?string $district2): static
    {
        $this->district2 = $district2;

        return $this;
    }

    public function setDistrict3(?string $district3): static
    {
        $this->district3 = $district3;

        return $this;
    }

    public function setZipcode(?string $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function setStreetType(?string $streetType): static
    {
        $this->streetType = $streetType;

        return $this;
    }

    public function setStreet(?string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function setHn(?string $hn): static
    {
        $this->hn = $hn;

        return $this;
    }

    public function setBuilding(?string $building): static
    {
        $this->building = $building;

        return $this;
    }

    public function setSubBuilding(?string $subBuilding): static
    {
        $this->subBuilding = $subBuilding;

        return $this;
    }

    public function setOrganization(?string $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function setStreetTypeStr2(?string $streetTypeStr2): static
    {
        $this->streetTypeStr2 = $streetTypeStr2;

        return $this;
    }

    public function setStreet2(?string $street2): static
    {
        $this->street2 = $street2;

        return $this;
    }

    public function setHn2(?string $hn2): static
    {
        $this->hn2 = $hn2;

        return $this;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $address = new self();

        foreach ($data as $key => $value) {
            $camelKey = self::snakeToCamel($key);
            $setter = 'set'.ucfirst($camelKey);
            $address->{$setter}($value);
        }

        return $address;
    }

    /**
     * @return array<string, null|int|string>
     */
    public function toArray(): array
    {
        $fields = [
            'egoncodePlace',
            'egoncodeHn',
            'country',
            'state',
            'region',
            'province',
            'city',
            'district1',
            'district2',
            'district3',
            'zipcode',
            'streetType',
            'street',
            'address',
            'hn',
            'building',
            'subBuilding',
            'organization',
            'streetTypeStr2',
            'street2',
            'hn2',
        ];

        $result = [];
        foreach ($fields as $field) {
            $getter = 'get'.ucfirst($field);
            $snakeKey = $this->camelToSnake($field);
            $result[$snakeKey] = $this->{$getter}();
        }

        return $result;
    }

    private static function snakeToCamel(string $string): string
    {
        $parts = explode('_', $string);

        return array_shift($parts).implode('', array_map(ucfirst(...), $parts));
    }

    private function camelToSnake(string $input): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
