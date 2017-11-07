<?php
namespace Models;
class Events extends Models
{
    public static $table = 'events';
    public $id;

    public function deleteEvent($id)
    {
        $sql = 'DELETE FROM events WHERE id=:id AND time_start > NOW()';
        $data[':id'] = $id;
        $db = db::getinstance();
        $result = $db->execute($sql, $data);
        return  $result;
    }

    public static function allEvents($id,$start,$end,$parent=false)
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
        $st = $timeS->format(DATE_FORMAT);
        $en = $timeE->format(DATE_FORMAT);
        if(self::normalTime($id_room,$st,$en)) {
            $sql = "INSERT INTO  " . static::$table . " ( id_user, id_room, description, time_start, time_end)
                VALUES ($id_user, $id_room, '$description', '$st' , '$en' )";
            $db = DB::getInstance();
            $db->execute($sql);
            $result['id_parent'] = $db->lastInsertId();
            return $result;
        }
        return false;
    }


    public static function addRecurringEvent($id_user, $id_room, 
        $description, $timeS, $timeE,$period,$modify,$id)
    {
        $errors =0;
        for ($i=0; $i<$period; $i++)
        {
            $timeS->modify(self::getrecurring($modify));
            $timeE->modify(self::getrecurring($modify));
            $st = $timeS->format(DATE_FORMAT);
            $en = $timeE->format(DATE_FORMAT);

            if(!self::insertRecEvent($st,$en,$id_user,$id_room,$description,$id))
            {
                $errors++;
            }
        }
        if($errors == 0)
        {
            return ADD_OK;
        }
        else {
            return "ADD_NO  $errors";
        }


    } 

    private function insertRecEvent($st,$en,$id_user,$id_room,$description,$id){
        if(self::normalTime($id_room,$st,$en)) {
            $idlast = $id['id_parent'];
            $sql = "INSERT INTO  " . static::$table ." ( id_user, id_room, description, time_start, time_end,id_parent)
                VALUES ('$id_user', '$id_room', '$description', '$st', '$en', $idlast )";
            $db = DB::getInstance();
            $db->execute($sql);
            return true;

        }
        else {
            return false;
        }
    }
    private function normalTime($id_room,$start,$end)
    {
        $db = DB::getInstance();
        $data = $db->query(
            "SELECT time_start,time_end FROM events  WHERE id_room = :id
            AND time_start  BETWEEN '$start' AND  '$end' ",
            [':id' => $id_room]
        );
        if (!is_array($data))
        {
            return true;
        }
        foreach ($data as $val)
        {
            $valSt = new \DateTime($val['time_start']);
            $valE =  new \DateTime($val['time_end']);
            if ((($valSt < $start && $valE <= $start)
                || ($end <= $valSt && $end < $valE)))
            {
                return false;
            }
        }
        return true;
    }



    private function getRecurring($data)
    {
        $offset = '';
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

    public function getCountEv($id,$parent,$time_start)
    {
         $db = DB::getInstance();
        $data = $db->query(
            "SELECT count(*) FROM events WHERE (id = :id OR parent_id = $parent) AND time_start > NOW() "
            ,
            [':id' => $id]
        );
        return $data;
    }

 private function deleteRecEvents($id,$id_parent)
    {
        if ($id_parent == 'null')
        {
            $sql = 'DELETE FROM events WHERE id='.$id.' OR id_parent='.$id_parent;
            $db = db::getinstance();
            $result = $db->execute($sql, $data);
            return  $result;
        }
        else
        {
            $sql = 'DELETE FROM events WHERE (id='.$id.' OR id_parent='.$id_parent.') AND time_start >= NOW()';
            $db = db::getinstance();
            $result = $db->execute($sql, $data);
            return  $result;
        }
    }




}

