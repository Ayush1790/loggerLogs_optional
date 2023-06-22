<?php

namespace logs\Error;

class ErrorLogger
{
    function errorMsg($type, $msg)
    {
        $this->logger->$type($msg);
    }
}
