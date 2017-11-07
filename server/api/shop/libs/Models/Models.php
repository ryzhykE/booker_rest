<?php

namespace Models;

class Models
{

    public static function findAll()
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table,
            []
        );
        return $data;
    }

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
	
	public function save ()
    {
        if (empty($this->id)) {
            $this->insert();
        } else {
            $this->update();
        }
    }
    /**
     * insert into db
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
            $this->id = $db->lastInsertId();
    }
    /**
     * update obj
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
            $db->execute($sql, $data);
    }

}