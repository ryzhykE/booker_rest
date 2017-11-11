<?php

namespace Models;

/**
 * Class Models
 * main class for db
 * @package Models
 */
class Models
{
    /**
     * get all info in db
     * @return mixed
     */
    public static function findAll()
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table,
            []
        );
        return $data;
    }

    /**
     * find one item by id
     * @param $id
     * @return mixed
     */
    public static function findByid($id)
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table . ' WHERE id=:id',
            [':id' => $id]
        );
        return $data[0];
		//?? false;
    }

    /**
     * insert data in DB, return last insert id
     * @return mixed
     */
    public function insert()
    {

        $columns = [];
        $binds = [];
        $data = [];
            foreach ($this as $column => $value) {
                if ('id' == $column) {
                    continue;
                }
                $columns[] = $column;
                $binds[] = ':' . $column;
                $data[':' . $column] = $value;
            }
            $sql = '
                INSERT INTO ' . static::$table . '
                (' . implode(', ', $columns). ')
                VALUES
                (' . implode(', ', $binds). ')
                ';
            $db = DB::getInstance();
            $db->execute($sql, $data);
            $res = $this->id = $db->lastInsertId();
            return $res;
    }


    /**
     * update date in DB
     * @return bool
     */
    public function update()
    {
        $columns = [];
        $data = [];
        foreach ($this as $item => $value) {
            if ('id' == $item) {
                continue;
            }
            $columns[] = $item . ' = ' . ':' . $item;
            $data[':' . $item] = $value;
        }
        $sql = '
               UPDATE ' . static::$table . '
               SET ' . implode(',', $columns) .
            ' WHERE id = :id';
        $data[':id'] = $this->id;
        $db = DB::getInstance();
        $result = $db->execute($sql, $data);
        return true;
    }



}