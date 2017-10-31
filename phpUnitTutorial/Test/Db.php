<?php

class Db
{
    protected $pdo;
    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host='.HOST1.';dbname='.DB1, USER1, PASSWORD1);
        if(!$this->pdo)
        {
            return false;
        }
    }
    public function getPdo()
    {
        return $this->pdo;
    }
    public function execQuery($sql)
    {
        $count = $this->pdo->exec($sql);
        if ($count === false)
        {
            return false;
        }
        return $count;
    }
    protected function selectQuery($sql)
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute();
        if (false === $result)
        {
            return false;
        }
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        if (empty($data))
        {
            return ERR_SEARCH;
        }
        return $data;
    }
}