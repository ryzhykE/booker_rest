<?php
namespace Models;
class Events extends Models
{
    public static $table = 'events';
    public $id;

    public static function allEvents($id,$start,$end)
    {
        $q = 'SELECT  e.id, e.id_user, u.login  as user_login,
            e.id_room, r.name as room_name, e.description, e.time_start,
            e.time_end, e.create_time, e.id_parent FROM events e
            LEFT JOIN users u
            ON e.id_user = u.id
            LEFT JOIN rooms r
            ON e.id_room = r.id
            WHERE e.id_room = :id
            AND e.time_start BETWEEN ' . "$start->format('Y-m-d H:i:s')" . ' AND ' ."$end->format('Y-m-d H:i:s')";
        var_dump($q);exit;
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT  e.id, e.id_user, u.login  as user_login,
            e.id_room, r.name as room_name, e.description, e.time_start,
            e.time_end, e.create_time, e.id_parent FROM events e
            LEFT JOIN users u
            ON e.id_user = u.id
            LEFT JOIN rooms r
            ON e.id_room = r.id
            WHERE e.id_room = :id
            AND e.time_start BETWEEN ' . "$start->format('Y-m-d H:i:s')" . ' AND ' ."$end->format('Y-m-d H:i:s')" ,
            [':id' => $id]
        );
        return $data;
    }

    }
