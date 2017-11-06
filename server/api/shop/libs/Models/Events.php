<?php
namespace Models;
class Events extends Models
{
    public static $table = 'events';
    public $id;

    public static function allEvents($id,$start,$end)
    {
        $db = DB::getInstance();
        $data = $db->query(
            "SELECT  e.id, e.id_user, u.login  as user_login,
            e.id_room, r.name as room_name, e.description, e.time_start,
            e.time_end, e.create_time, e.id_parent FROM events e
            LEFT JOIN users u
            ON e.id_user = u.id
            LEFT JOIN rooms r
            ON e.id_room = r.id
            WHERE e.id_room = :id
            AND e.time_start  BETWEEN '$start' AND  '$end' "
            ,
            [':id' => $id]
        );
        return $data;
    }

    public static function addEvents($id_user, $id_room, $description, $timeS, $timeE)
    {
        $sql = "INSERT INTO  " . static::$table ." ( id_user, id_room, description, time_start, time_end)
                VALUES ('$id_user', '$id_room', '$description', '$timeS', '$timeE' )";
        $db = DB::getInstance();
        $db->execute($sql);
        $result['id_parent'] = $db->lastInsertId();
        return $result;
    }

    public static function addRecurringEvent($id_user, $id_room, $description, $timeS, $timeE,$period )//offset
    {
        $timeS = $timeS;

        $timeE = $timeE;
        //$offset = $this->getRecurring()
        for ($i=0; $i<$period; $i++)
        {
            $timeS->modify();// $offset
            $timeE->modify();//$offset
            $sql = "INSERT INTO  " . static::$table ." ( id_user, id_room, description, time_start, time_end,id_parent)
                VALUES ('$id_user', '$id_room', '$description', '$timeS', '$timeE', '1' )";
            $db = DB::getInstance();
            $result = $db->execute($sql);
            return $result;
        }
    }

    private function getRecurring($data)
    {
        switch ($data)
        {
            case 'weekly':
                $offset = '+1 week';
                break;
            case 'bi-weekly':
                $offset = '+2 weeks';
                break;
            case 'monthly':
                $offset = '+1 month';
                break;
        }
        return $offset;
    }

}
