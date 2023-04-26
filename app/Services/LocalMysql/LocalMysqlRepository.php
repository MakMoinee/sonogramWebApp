<?php

namespace App\Services\LocalMysql;

use App\Services\LocalMysql\Contracts\LocalMysql;
use App\Services\LocalMysql\Contracts\LocalMysqlListener;
use Exception;
use Illuminate\Support\Facades\DB;

class LocalMysqlRepository implements LocalMysql
{
    public function create(string $tableName, array $data, LocalMysqlListener $listener): void
    {
    }

    public function findAll(string $tableName, LocalMysqlListener $listener): void
    {
        try {
            $result = DB::table($tableName)->get();
            $data = json_decode($result, true);
            $listener->onSuccessUsers($data);
        } catch (Exception $e) {
            $listener->onError($e);
        }
    }

    public function findAllWithWhere(string $tableName, string $whereColumn, string $whereOperator, string $whereValue, LocalMysqlListener $listener)
    {
        try {
            $result = DB::table($tableName)->where($whereColumn, $whereOperator, $whereValue)->get();
            $data = json_decode($result, true);
            return $listener->onSuccessUsers($data);
        } catch (Exception $e) {
            $listener->onError($e);
        }
    }
}
