# Egon
Egon API PHP Library

A lightweight and modern PHP library for seamless integration with the Egon API. Fully compatible with PHP 8.2 and above, it provides a clean and efficient interface to interact with Egon’s services, simplifying authentication, data retrieval, and request handling.

Egon website: https://www.egon.com/

## API implementation
 - v4/validation/address 

## LICENSE

This is an unofficial package provided with a GPL3 license for helping in the implementation of Egon service.


Copyright (C) 2022 Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
long with this program.  If not, see <http://www.gnu.org/licenses/>.


## Basic usage

```php

use Egon\Dto\RequestValidationV4\Address;
use Egon\Dto\RequestValidationV4\Parameter;
use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Service\ValidationV4;
use Exception;
use Throwable;

$address = new Address();
$address->setStreet("Via Pacinotti 4b")->setCity("Verona");
$parameter = new Parameter(CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

$token = "YOUR_API_TOKEN";
$v = new ValidationV4($token);
$arrayContent = $v->getValidAddress($address, $parameter);

// You can request a full mapped object as response
$response = ValidationV4Mapper::fromArray($arrayContent);
```

## Get Mapped Object with valid address

```php

use Egon\Dto\RequestValidationV4\Address;
use Egon\Dto\RequestValidationV4\Parameter;
use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use Egon\Enum\CountryCodeAlpha3Enum;
use Egon\Enum\OutputGeoCodingEnum;
use Egon\Service\ValidationV4;
use Exception;
use Throwable;

$address = new Address();
$address->setStreet("Via Pacinotti 4b")->setCity("Verona");
$parameter = new Parameter(CountryCodeAlpha3Enum::ITALY, OutputGeoCodingEnum::GEOCODING_ON);

$token = "YOUR_API_TOKEN";
$v = new ValidationV4($token);

// You can request a full mapped object as response
$validateResponse = $v->getValidAddressMapped($address, $parameter);

```

## Balance

```php

use Egon\Dto\ResponseValidationV4\ValidationV4Mapper;
use Egon\Dto\ResponseValidationV4\ValidationV4Response;
use RuntimeException;
use Throwable;


$token = "YOUR_API_TOKEN";
$b = new Balance($token);
$balanceValue = $b->getBalance(); //this method returns a float value with number of credits

```
