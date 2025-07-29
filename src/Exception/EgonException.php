<?php

namespace Egon\Exception;

use Exception;
use Throwable;

/**
 * 
 * @author Stefano Perrini <perrini.stefano@gmail.com> aka La Matrigna
 */
class EgonException extends Exception {

    /**
     * 
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "EgonException", int $code = 0, ?Throwable $previous = null) {
        parent::__construct("EgonException " . $message, $code, $previous);
    }
}
