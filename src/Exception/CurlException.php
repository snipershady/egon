<?php

namespace Egon\Exception;

use Exception;
use Throwable;

/**
 * 
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
class CurlException extends Exception {

    public function __construct(string $message = "CurlException", int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
