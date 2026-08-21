# Egon

A lightweight, modern PHP library for the [Egon API](https://www.egon.com/) — address validation, geocoding and account balance, with a clean, typed interface.

## Requirements

- PHP 8.2 or higher

## Installation

```bash
composer require snipershady/egon
```

## API coverage

- `v4/validation/address` — address validation, correction and geocoding
- `balance` — remaining account credits

## Usage

### Validate an address

```php
use Egon\Dto\RequestValidationV4\Address;
use Egon\Dto\RequestValidationV4\Parameter;
use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Service\ValidationV4;

$address = new Address();
$address->setStreet('Via Pacinotti 4b')->setCity('Verona');
$parameter = new Parameter(CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

$validationV4 = new ValidationV4('YOUR_API_TOKEN');

// Raw array response
$arrayContent = $validationV4->getValidAddress($address, $parameter);

// Or a fully typed response object
$response = $validationV4->getValidAddressMapped($address, $parameter);

$standard = $response->getData()->getAddress()->getStandard();
echo $standard->getFullAddress();
```

`getValidAddress()` and `getValidAddressMapped()` throw `Egon\Exception\CurlException` on transport errors and `Egon\Exception\EgonException` when the API itself reports an error.

> **Note:** the fields returned under `standard`, `egon_code` and `postal` vary by country — for example only some countries return `state`/`locality`, and postal lines can use `row3`, `row6` or `row7` instead of the more common `row4`/`row5`. All of these are exposed as nullable getters on the response DTOs.

### Check account balance

```php
use Egon\Service\Balance;

$balance = new Balance('YOUR_API_TOKEN');
$credits = $balance->getBalance(); // float
```

## Development

Clone the repository and install dependencies:

```bash
composer install
```

Some tests call the live API and need a valid token. Copy `.env.example` to `.env` and fill in `EGON_API_TOKEN`; without it, those tests are skipped automatically.

```bash
composer test            # run the test suite
composer quality         # apply Rector + PHP-CS-Fixer
composer quality-check   # check Rector, PHP-CS-Fixer and PHPStan without changing files
```

## License

GPL-3.0-or-later. See [LICENSE](LICENSE) for the full text.

This is an unofficial package, not affiliated with Egon, provided to help with integrating their service.

Copyright (C) 2022 Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
