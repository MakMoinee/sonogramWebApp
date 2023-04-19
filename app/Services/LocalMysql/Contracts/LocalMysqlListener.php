<?php

namespace App\Services\LocalMysql\Contracts;

use Exception;

interface LocalMysqlListener
{
    /**
     * @return - plain success
     */
    public function onSuccess(): void;
    public function onError(Exception $e): void;
    
}
