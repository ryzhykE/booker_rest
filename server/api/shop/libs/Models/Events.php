<?php
namespace Models;
class Events extends Models
{
    public static $table = 'events';
    public $id;

    public static function allEvents($id, $start, $end, $parent = false)
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





    private function normalTime($id_room, $start, $end,$id = null)
    {
        // if(!self::is_valid_time_ftom_to())
        // {
        // return false;
        // }
        $db = DB::getInstance();
        $data = $db->query(
            "SELECT time_start,time_end FROM events  WHERE id_room = :id
            AND time_start  BETWEEN '$start' AND  '$end' ",
            [':id' => $id_room]
        );
        if (!is_array($data)) {
            return true;
        }
        foreach ($data as $val) {
            $valSt = new \DateTime($val['time_start']);
            $valE = new \DateTime($val['time_end']);
            if ((($valSt < $start && $valE <= $start)
                || ($end <= $valSt && $end < $valE))
            ) {
                return false;
            }
        }
        return true;
    }


    public static function addEvents($id_user, $id_room, $description, $timeS, $timeE)
    {
        $st = $timeS->format(DATE_FORMAT);
        $en = $timeE->format(DATE_FORMAT);
        if (self::normalTime($id_room, $st, $en)) {
            $sql = "INSERT INTO  " . static::$table . " ( id_user, id_room, description, time_start, time_end)
                VALUES ($id_user, $id_room, '$description', '$st' , '$en' )";
            $db = DB::getInstance();
            $db->execute($sql);
            $result['id_parent'] = $db->lastInsertId();
            return $result;
        }
        return false;
    }

    private function insertRecEvent($st, $en, $id_user, $id_room, $description, $id)
    {
        //if (self::normalTime($id_room, $st, $en)) {
            $idlast = $id['id_parent'];
            $sql = "INSERT INTO  " . static::$table . " ( id_user, id_room, description, time_start, time_end,id_parent)
                VALUES ('$id_user', '$id_room', '$description', '$st', '$en', $idlast )";
            $db = DB::getInstance();
            $db->execute($sql);
            return true;

      //  } else {
         //   return false;
       // }
    }



    public static function addRecurringEvent($id_user, $id_room,
                                             $description, $timeS, $timeE, $period, $modify, $id)
    {
        $errors = 0;
        for ($i = 0; $i < $period; $i++) {
            $timeS->modify(self::getrecurring($modify));
            $timeE->modify(self::getrecurring($modify));
            $st = $timeS->format(DATE_FORMAT);
            $en = $timeE->format(DATE_FORMAT);

            if (!self::insertRecEvent($st, $en, $id_user, $id_room, $description, $id)) {
                $errors++;
            }
        }
        if ($errors == 0) {
            return ADD_OK;
        } else {
            return ADD_NO . ' ' . $errors . ' events';
        }


    }






    private function getRecurring($data)
    {
        $offset = '';
        switch ($data) {
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

    public function getCountEv($id, $parent = null)
    {
        if(!$parent)
        {
            $db = DB::getInstance();
            $data = $db->query(
                "SELECT count(id) FROM events WHERE (id = :id OR id_parent = :id) AND time_start > NOW() "
                ,
                [':id' => $id]
            );
            return $data[0]["count(id)"];
        }
        $db = DB::getInstance();
        $data = $db->query(
            "SELECT count(id) FROM events WHERE (id = :parent OR id_parent = :parent) AND time_start > NOW() "
            ,
            [':parent' => $parent]
        );
        return $data[0]["count(id)"];

    }

    public static function deleteRecEvents($id, $id_parent,$start_point)
    {
        if ($id_parent == 'null') {
            $sql = "DELETE FROM events WHERE (id='$id' OR id_parent='$id') AND time_start >= '{$start_point->format(DATE_FORMAT)}'";
            $data[':id'] = $id;
            $db = DB::getinstance();
            $result = $db->execute($sql, $data);
            //var_dump($result);
            return $result;
        } else {
            $sql = "DELETE FROM events WHERE (id='$id' OR id_parent='$id_parent ') AND time_start >= '{$start_point->format(DATE_FORMAT)}'";
            $data[':id'] = $id;
            $db = DB::getinstance();
            $result = $db->execute($sql, $data);
           // var_dump($result);exit;
            return $result;
        }
    }

    public static function deleteEvent($id)
    {
        $sql = 'DELETE FROM events WHERE id=:id AND time_start > NOW()';
        $data[':id'] = $id;
        $db = DB::getinstance();
        $result = $db->execute($sql,$data);
        if($result == null)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function editEvents($id, $id_user, $id_room, $description, $timeS, $timeE, $start_point = null, $id_parent = null)
    {
        $st = $timeS->format(DATE_FORMAT);
        $en = $timeE->format(DATE_FORMAT);
        if(!$start_point)
        {
            return self::editOneEvent($id_user, $id_room, $description, $st,  $en, $id);
        }
        $start_point = $start_point->format(DATE_FORMAT);
        $result = self::editRecur($id, $id_user, $id_room, $description, $st, $en, $start_point, $id_parent);
        return $result;
    }

    private function editOneEvent($id_user, $id_room, $description, $st,  $en, $id)
    {
     if(self::normalTime($id_room, $st, $en))
     {
            $sql = "UPDATE  events  SET id_user='$id_user', id_room='$id_room',
                   description = '$description' , time_start = '$st', time_end = '$en' WHERE id='$id' ";
            $db = DB::getInstance();
            $result = $db->execute($sql);
         if($result)
         {
             return true;
         }
         else
         {
             return false;
         }

       }
        return ERR_UPDATE;

    }


    private function editRecur($id, $id_user, $id_room, $description, $timeS, $timeE,$start_point, $id_parent = null)
    {
        if($events = self::getUsersRecurEvents($id, $id_user, $start_point, $id_parent))
        {

            $err= [];
            foreach($events as $ev)
            {
                $start = new \DateTime($timeS);
                $end = new \DateTime($timeE);
                $id = $ev['id'];
                $id_user = $id_user;
                $id_room = $id_room;
                $description = $description;
                $newStart = new \DateTime($ev['time_start']);
                $newStart->setTime($start->format('H'),$start->format('i'),0);
                $newEnd = new \DateTime($ev['time_end']);
                $newEnd->setTime($end->format('H'),$end->format('i'),0);
                if(!self::editOneEvent($id_user, $id_room, $description, $newStart->format(DATE_FORMAT), $newEnd->format(DATE_FORMAT), $id))
                {
                    $err[] = NO_UPDATE;
                }
            }
            if(count($err) !=0)
            {
                return $err;
            }
            return true;
        }
        return false;

    }

    private function getUsersRecurEvents($id, $id_user, $start_point, $id_parent = null)
    {
        $db = DB::getInstance();
        if(!$id_parent)
        {
            $data = $db->query(
                $sql = "SELECT  id, id_parent, id_user, description, time_start, time_end from events where (time_start >= '{$start_point}')
                  and (id = {$id} or id_parent = {$id}) and (id_user = {$id_user})"
                ,
                []
            );
        }
        else
        {
            $data = $db->query(
                $sql = "SELECT  id, id_parent, id_user, description, time_start, time_end from events where (time_start >= '{$start_point}')
                  and (id = {$id} or id_parent = {$id_parent}) and (id_user = {$id_user})"
                ,
                []
            );
        }

        return $data;


    }



      function is_valid_time_ftom_to($start_ev,$nd_ev)
     {
       return true;

    }





















    /**
     * take parent events
     * @param $id
     * @param $id_ev
     * @param $id_par
     * @return mixed
     */
    public static function eventPar($id,$id_ev,$id_par)
    {
        $db = DB::getInstance();
        $data = $db->query(
            "SELECT  e.id, e.id_user, u.login  as user_login,
    e.id_room, r.name as room_name, e.description, e.time_start,
    e.time_end, e.create_time, e.id_parent FROM events e
    LEFT JOIN users u
    ON e.id_user = u.id
    LEFT JOIN rooms r
    ON e.id_room = :id WHERE (e.id = '$id_ev' OR e.id_parent = '$id_par' ) AND e.time_start > NOW()"
            ,
            [':id' => $id]
        );
        return $data;
    }

}
