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
//            if($data[0] === 'count')
//            {
//                $id = (int)$data[1];
//                $parent = (int)$data[2];
//                $result = \Models\Events::getCountEv($id,$parent);
//                $result = \Response::typeData($result,$type);
//                return \Response::ServerSuccess(200, $result);
//            }

            $year = (int)$data[1];
            $month = (int)$data[2];
            $start = new \DateTime();
            $start->setDate($year,$month,1);
            $arr = $start->format('Y-m-d 08:00:00');
            $end = $start->format('Y-m-t 20:00:00');
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

    public function putEvents()
    {
        try {
            $putParams = json_decode(file_get_contents("php://input"), true);
            $id = $putParams['id'];
            $id_user = $putParams['id_user'];
            $id_room = $putParams['id_room'];
            $description = $putParams['description'];
            $dateStart = new \DateTime();
            $dateEnd = new \DateTime();
            $timeS = $dateStart->setTimestamp($putParams['time_start'] / 1000);
            $timeE = $dateEnd->setTimestamp($putParams['time_end'] / 1000);
            $result = \Models\Events::editEvent($id, $id_user, $id_room, $description, $timeS, $timeE);
            if($result)
            {
                return \Response::ServerSuccess(200, true);
            }
            else
            {
                false;
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
            $id = $data[0];
            $id_parent = $data[1];
            if($data[2])
            {
                $result = \Models\Events::deleteRecEvents($id, $id_parent);
            }
            else
            {
                $result = \Models\Events::deleteEvent($id);
            }

            return \Response::ServerSuccess(200, $result);

        }
        catch (\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
        }
    }


}
