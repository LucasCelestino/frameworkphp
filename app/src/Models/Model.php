<?php

namespace App\Models;

use App\Helpers\Connection;
use PDO;

abstract class Model extends Connection
{
    protected $data;
    protected $fail;
    protected $message;

    public function __set($name, $value)
    {
        if(empty($this->data))
        {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    public function __get($name)
    {
        if(!empty($this->data->$name))
        {
            return $this->data->$name;
        }
        
        return null;
    }

    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    protected function fail()
    {
        return $this->fail;
    }

    protected function data()
    {
        return $this->data;
    }

    protected function setMessage(String $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    protected function create(String $entity, Array $data): ?int
    {
        try
        {
            $columns = implode(",", array_keys($data));
            $values = ":".implode(", :", array_keys($data));
            
            $stmt = Connection::getConnection()->prepare("INSERT INTO ".$entity." ({$columns}) VALUES ({$values})");

            $stmt->execute($this->filter($data));

            return Connection::getConnection()->lastInsertId();
        }
        catch(\PDOException $ex)
        {
            $this->fail = $ex;
            return null;
        }
    }

    protected function read($sql, $params = null)
    {
        try
        {
            $stmt = Connection::getConnection()->prepare($sql);

            if($params)
            {
                parse_str($params, $params);

                foreach ($params as $key => $value) 
                {
                    $type = (is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
                    $stmt->bindValue(":{$key}", $value, $type);
                }
            }

            $stmt->execute();
            return $stmt;
        }
        catch (\PDOException $th)
        {
            $this->fail = $th;
            return null;
        }
    }

    protected function update(String $entity, Array $data, String $terms, String $params): ?int
    {
        try
        {
            $dateSet = [];

            foreach ($data as $key => $value) 
            {
                $dateSet[] = "{$key} = :{$key}";
            }

            $dateSet = implode(",", $dateSet);

            $stmt = Connection::getConnection()->prepare("UPDATE {$entity} SET {$dateSet} WHERE {$terms}");

            parse_str($params, $params);

            $stmt->execute($this->filter(array_merge($data, $params)));

            return $stmt->rowCount();
        }
        catch (\PDOException $ex)
        {
            $this->fail = $ex;
            return null;
        }
    }

    protected function delete(String $entity, String $terms, Array $params): ?int
    {
        try
        {
            $stmt = Connection::getConnection()->prepare("DELETE FROM {$entity} WHERE {$terms}");

            $stmt->execute($this->filter($params));

            return $stmt->rowCount();
        }
        catch (\PDOException $ex)
        {
            $this->fail = $ex;
            return null;
        }
    }

    protected function safe(): array
    {
        $safe = (array) $this->data;

        foreach (static::$safe as $unset)
        {
            unset($safe[$unset]);
        }

        return $safe;
    }

    protected function filter(array $data)
    {
        $filter = [];

        foreach ($data as $key => $value)
        {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }

        return $filter;
    }
}