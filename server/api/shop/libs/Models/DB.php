<?php

namespace Models;


class DB
{
    use \TSingeton;
    private $dbh;

    protected function __construct()
    {

        if (!$this->dbh = new \PDO('mysql:host='.HOST.';dbname='.DB, USER, PASSWORD))
        {
            throw new \Exception(NO_CONNECT);
        }
    }

    public function query( $sql,$data = [])
	//public function query(string $sql, array $data = [])
    {

        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
        if (false === $result) {
            throw new \Exception(NO_CONNECT);
        }
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function execute($sql,$data = [])
    {
        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
        return $result;
    }


    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

}
