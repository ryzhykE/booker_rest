<?php

namespace Models;


class Room extends Models
{
    public static $table = 'rooms';
    public $id;
    public $name;
    /**
     * SELECT e.id, e.description as descr, e.id_employee as u_id, e.id_room
     * as room_id, emp.name as u_name, r.name as room_name, ed.start, ed.end
     * FROM events e left join employees emp on e.id_employee = emp.id
     * left join rooms r on e.id_room = r.id left join event_details ed on e.id = ed.id
     * WHERE ed.start between '2017-11-01 08-00-00' and '2017-11-30 20-00-00'and e.id_room = 3
     */

}