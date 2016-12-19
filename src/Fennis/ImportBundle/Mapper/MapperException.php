<?php

declare(strict_types=1);

namespace Fennis\ImportBundle\Mapper;

use Exception;

/**
 * Class MapperException.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
class MapperException extends \Exception
{
    public function __construct($data, Exception $previous)
    {
        $message = 'Could not map data because of an ' . get_class($previous) . '';

        if ($previous instanceof Exception) {
            $message .= ' with message: ' . $previous->getMessage();
        }

        $message .= ' offending data: ' . print_r($data, true);

        parent::__construct($message, 0, $previous);
    }
}
