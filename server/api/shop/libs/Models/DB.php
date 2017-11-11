<?php

namespace Models;

/**
 * Compound with DB
 * Class DB
 * @package Models
 */

class DB
{
    use \TSingeton;
    private $dbh;

    /**
     * DB constructor
     */
    protected function __construct()
    {
        if (!$this->dbh = new \PDO('mysql:host='.HOST.';dbname='.DB, USER, PASSWORD))
        {
            throw new \Exception(NO_CONNECT);
        }
    }

    /**
     * @param $sql
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function query( $sql,$data = [])
    {
        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
        if (false === $result) {
            throw new \Exception(NO_QUERY);
        }
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array $data
     * @return array
     * @throws \Exception
     */
	public function execute($sql,$data = [])
    {
        $sth = $this->dbh->prepare($sql);
        $result = $sth->execute($data);
       if (false === $result) {
            throw new \Exception(NO_QUERY);
        }
    }

    /**
     * return last insert id in DB
     * @return int
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

}
