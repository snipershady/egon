<?php

namespace Egon\Dto\RequestValidationV4;

class Address {

    /** @var int|null Egon code place */
    private ?int $egoncodePlace = null;

    /** @var int|null Egon code house number */
    private ?int $egoncodeHn = null;

    /** @var string|null Country description */
    private ?string $country = null;

    /** @var string|null State description */
    private ?string $state = null;

    /** @var string|null Region description */
    private ?string $region = null;

    /** @var string|null Province description */
    private ?string $province = null;

    /** @var string|null City description */
    private ?string $city = null;

    /** @var string|null District1 description */
    private ?string $district1 = null;

    /** @var string|null District2 description */
    private ?string $district2 = null;

    /** @var string|null District3 description */
    private ?string $district3 = null;

    /** @var string|null Zipcode description */
    private ?string $zipcode = null;

    /** @var string|null Town planning name (contains the type: Street, Square, Avenue, etc.) */
    private ?string $streetType = null;

    /** @var string|null Street description */
    private ?string $street = null;

    /** @var string|null Full address */
    private ?string $address = null;

    /** @var string|null House number */
    private ?string $hn = null;

    /** @var string|null Building */
    private ?string $building = null;

    /** @var string|null Sub Building */
    private ?string $subBuilding = null;

    /** @var string|null Organization */
    private ?string $organization = null;

    /** @var string|null Town planning name 2 (contains the type: Street, Square, Avenue, etc.) */
    private ?string $streetTypeStr2 = null;

    /** @var string|null Street 2 description */
    private ?string $street2 = null;

    /** @var string|null House number 2 */
    private ?string $hn2 = null;

    public function getEgoncodePlace(): ?int {
        return $this->egoncodePlace;
    }

    public function getEgoncodeHn(): ?int {
        return $this->egoncodeHn;
    }

    public function getCountry(): ?string {
        return $this->country;
    }

    public function getState(): ?string {
        return $this->state;
    }

    public function getRegion(): ?string {
        return $this->region;
    }

    public function getProvince(): ?string {
        return $this->province;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function getDistrict1(): ?string {
        return $this->district1;
    }

    public function getDistrict2(): ?string {
        return $this->district2;
    }

    public function getDistrict3(): ?string {
        return $this->district3;
    }

    public function getZipcode(): ?string {
        return $this->zipcode;
    }

    public function getStreetType(): ?string {
        return $this->streetType;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function getHn(): ?string {
        return $this->hn;
    }

    public function getBuilding(): ?string {
        return $this->building;
    }

    public function getSubBuilding(): ?string {
        return $this->subBuilding;
    }

    public function getOrganization(): ?string {
        return $this->organization;
    }

    public function getStreetTypeStr2(): ?string {
        return $this->streetTypeStr2;
    }

    public function getStreet2(): ?string {
        return $this->street2;
    }

    public function getHn2(): ?string {
        return $this->hn2;
    }

    public function setEgoncodePlace(?int $egoncodePlace): static {
        $this->egoncodePlace = $egoncodePlace;
        return $this;
    }

    public function setEgoncodeHn(?int $egoncodeHn): static {
        $this->egoncodeHn = $egoncodeHn;
        return $this;
    }

    public function setCountry(?string $country): static {
        $this->country = $country;
        return $this;
    }

    public function setState(?string $state): static {
        $this->state = $state;
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

    public function setCity(?string $city): static {
        $this->city = $city;
        return $this;
    }

    public function setDistrict1(?string $district1): static {
        $this->district1 = $district1;
        return $this;
    }

    public function setDistrict2(?string $district2): static {
        $this->district2 = $district2;
        return $this;
    }

    public function setDistrict3(?string $district3): static {
        $this->district3 = $district3;
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

    public function setStreet(?string $street): static {
        $this->street = $street;
        return $this;
    }

    public function setAddress(?string $address): static {
        $this->address = $address;
        return $this;
    }

    public function setHn(?string $hn): static {
        $this->hn = $hn;
        return $this;
    }

    public function setBuilding(?string $building): static {
        $this->building = $building;
        return $this;
    }

    public function setSubBuilding(?string $subBuilding): static {
        $this->subBuilding = $subBuilding;
        return $this;
    }

    public function setOrganization(?string $organization): static {
        $this->organization = $organization;
        return $this;
    }

    public function setStreetTypeStr2(?string $streetTypeStr2): static {
        $this->streetTypeStr2 = $streetTypeStr2;
        return $this;
    }

    public function setStreet2(?string $street2): static {
        $this->street2 = $street2;
        return $this;
    }

    public function setHn2(?string $hn2): static {
        $this->hn2 = $hn2;
        return $this;
    }

    /**
     *
     * @return RequestValidationV4Address
     */
    public static function fromArray(array $data): Address {
        $address = new Address();

        foreach ($data as $key => $value) {
            $camelKey = self::snakeToCamel($key);
            $setter = 'set' . ucfirst($camelKey);
            $address->$setter($value);
        }

        return $address;
    }

    public static function toArray(Address $address): array {
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
            'hn2'
        ];

        $result = [];
        foreach ($fields as $field) {
            $getter = 'get' . ucfirst($field);
            $snakeKey = self::camelToSnake($field);
            $result[$snakeKey] = $address->$getter();
        }

        return $result;
    }

    private static function snakeToCamel(string $string): string {
        $parts = explode('_', $string);
        return array_shift($parts) . implode('', array_map('ucfirst', $parts));
    }

    private static function camelToSnake(string $input): string {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
