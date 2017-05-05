<?php

namespace AppBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * InvalidFileException.
 *
 * @author Łukasz Malicki
 */
class InvalidProductException extends HttpException
{
    /**
     * Constructor.
     *
     * @param string $message The internal exception message
     * @param \Exception $previous The previous exception
     * @param int $code The internal exception code
     */
    public function __construct($message = 'Product invalid.', \Exception $previous = null, $code = 0)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message, $previous, array(), $code);
    }
}
