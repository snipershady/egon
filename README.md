# egon
Egon API PHP Library

A lightweight and modern PHP library for seamless integration with the Egon API. Fully compatible with PHP 8.2 and above, it provides a clean and efficient interface to interact with Egon’s services, simplifying authentication, data retrieval, and request handling.


## Basic usage

```php

$address = new Address();
$address->setStreet("Via Pacinotti 4b")->setCity("Verona");

$token = "YOUR_API_TOKEN";
$v = new ValidationV4($token);
$arrayContent = $v->getValidAddress($address, CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

// You can request a full mapped object as response
$response = ValidationV4Mapper::fromArray($arrayContent);
```

## Get Mapped Object with valid address

```php

$address = new Address();
$address->setStreet("Via Pacinotti 4b")->setCity("Verona");

$token = "YOUR_API_TOKEN";
$v = new ValidationV4($token);
$arrayContent = $v->getValidAddress($address, CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

// You can request a full mapped object as response
$validateResponse = $v->getValidAddressMapped($address, CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

```