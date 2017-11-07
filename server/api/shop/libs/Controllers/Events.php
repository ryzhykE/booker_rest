<?php

namespace Controllers;


class Events
{
    /**
     * @param bool $data
     * @param bool $type
     */
    public function getEvents ($data = false,$type = false)
    {
        try{
            $year = (int)$data[1];
            $month = (int)$data[2];
            $start = new \DateTime();
            $start->setDate($year,$month,1);
            $arr = $start->format('Y-m-d 08:00:00');
            $end = $start->format('Y-m-t 20:00:00');
            // if($data['count'])
            // {
            //  $result = \Models\Events::allEventsCount($data[0],$arr,$end);

            // }
            $result = \Models\Events::allEvents($data[0],$arr,$end);
            $result = \Response::typeData($result,$type);
            return \Response::ServerSuccess(200, $result);

        }
        catch(\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
        }
    }

    public function postEvents($data = false,$type = false)
    {
        try{
            $id_user = $_POST['id_user'];
            $id_room = $_POST['id_room'];
            $description = $_POST['description'];
            $dateStart = new \DateTime();
            $dateEnd = new \DateTime();
            $timeS = $dateStart->setTimestamp($_POST['time_start']/1000);
            $timeE = $dateEnd->setTimestamp($_POST['time_end']/1000);
            $id = \Models\Events::addEvents($id_user, $id_room, $description, $timeS, $timeE);

            if($_POST['recur_period'] != null)
            {
                $period = $_POST['duration'];
                $modify = $_POST['recur_period'];
                $result = \Models\Events::addRecurringEvent($id_user, $id_room,
                $description, $timeS, $timeE,$period,$modify,$id);
                return \Response::ServerSuccess(200, $result);
            }

        }
        catch(\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
        }
    }

    public function deleteEvents($data)
    {
        try
        {
            $result = \Models\Events::deleteEvent($data[0]);
            return \Response::ServerSuccess(200, $result);
            

        }
        catch (\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
        }
    }

public function deleteEventsG($data)
    {
        try
        {
            $result = \Models\Events::deleteRecEvents($data[0]);
            return \Response::ServerSuccess(200, $result);
            

        }
        catch (\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
        }
    }


}
