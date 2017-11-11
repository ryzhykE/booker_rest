<?php
namespace Models;
class Events extends Models
{
    public static $table = 'events';
    public $id;
    public $id_user;
    public $id_room;
    public $description;
    public $time_start;
    public $time_end;
    //public $id_parent;

    /**
     * get all events
     * @param $id
     * @param $start
     * @param $end
     * @param bool $parent
     * @return mixed
     */
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
        if(!$data)
        {
            return false;
        }
        return $data;
    }

    /**
     * add new event/events
     * @param $id_user
     * @param $id_room
     * @param $description
     * @param $timeS
     * @param $timeE
     * @return bool
     */
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

    /**
     * insert recursion events
     * @param $st
     * @param $en
     * @param $id_user
     * @param $id_room
     * @param $description
     * @param $id
     * @return bool
     */
    private function insertRecEvent($st, $en, $id_user, $id_room, $description, $id)
    {
        if(self::normalTime($id_room, $st, $en)) {
            $idlast = $id['id_parent'];
            $sql = "INSERT INTO  " . static::$table . " ( id_user, id_room, description, time_start, time_end,id_parent)
                VALUES ('$id_user', '$id_room', '$description', '$st', '$en', $idlast )";
            $db = DB::getInstance();
            $db->execute($sql);
            return true;

        } else {
            return false;
        }
    }


    /**
     * add recursion events
     * @param $id_user
     * @param $id_room
     * @param $description
     * @param $timeS
     * @param $timeE
     * @param $period
     * @param $modify
     * @param $id
     * @return string
     */
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

    /**
     * get on of recursion period
     * @param string $data
     * @return string
     */
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

    /**
     * delete events recursion
     * @param $id
     * @param $id_parent
     * @param $start_point
     * @return bool
     */
    public static function deleteRecEvents($id, $id_parent,$start_point)
    {
        if ($id_parent == 'null') {
            $sql = "DELETE FROM events WHERE (id='$id' OR id_parent='$id') AND time_start >= '{$start_point->format(DATE_FORMAT)}'";
            $data[':id'] = $id;
            $db = DB::getinstance();
            $result = $db->execute($sql, $data);
            return true;
        } else {
            $sql = "DELETE FROM events WHERE (id='$id' OR id_parent='$id_parent ') AND time_start >= '{$start_point->format(DATE_FORMAT)}'";
            $data[':id'] = $id;
            $db = DB::getinstance();
            $result = $db->execute($sql, $data);
            var_dump($result);exit;
        }
    }

    /**
     * delete one event
     * @param $id
     * @return bool
     */
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

    /**
     * edit all events
     * @param $id
     * @param $id_user
     * @param $id_room
     * @param $description
     * @param $timeS
     * @param $timeE
     * @param null $start_point
     * @param null $id_parent
     * @return array|bool|string
     */
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

    /**
     * edit one event
     * @param $id_user
     * @param $id_room
     * @param $description
     * @param $st
     * @param $en
     * @param $id
     * @return bool|string
     */
    private function editOneEvent($id_user, $id_room, $description, $st,  $en, $id)
    {
        if(self::normalTime($id_room, $st, $en))
       {
            $sql = "UPDATE  events  SET id_user='$id_user', id_room='$id_room',
                description = '$description' , time_start = '$st', time_end = '$en' WHERE id='$id' ";
            $db = DB::getInstance();
            $result = $db->execute($sql);
            //var_dump($sql);exit;
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

    /**
     * recursion edit events
     * @param $id
     * @param $id_user
     * @param $id_room
     * @param $description
     * @param $timeS
     * @param $timeE
     * @param $start_point
     * @param null $id_parent
     * @return array|bool
     */
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
                    $err++ ;
                }
            }
            if ($err == 0) {
                return ADD_OK;
            } else {
                return NO_UPDATE . ' ' . $err . ' events';
            }
        }
        return false;

    }

    /**
     *
     * @param $id
     * @param $id_user
     * @param $start_point
     * @param null $id_parent
     * @return mixed
     */
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

    /**
     * get count event
     * @param $id
     * @param null $parent
     * @return mixed
     */
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

    /**
     * check time from 8-00 to 20-00
     * @param $start_ev
     * @param $end_ev
     * @return bool
     */
    function timeFrame($start_ev, $end_ev)
    {
        $start_t = date("G", $start_ev/1000);
        $end_t = date("G", $end_ev/1000);
        if ($start_t >= FROM_T && $start_t < TO_T)
        {
            if ($end_t >= FROM_T && $end_t <= TO_T)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * check time frame
     * @param int $id_room
     * @param sting $start
     * @param string $end
     * @param null $id
     * @return bool
     */
   public static function normalTime($id_room, $start, $end,$id = null)
    {
        if(!self::timeFrame($start,$end))
        {
            return false;
        }
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
}


