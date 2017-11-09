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
            if($data[0] === 'parent')
            {
                $id = $data[1];
                $id_ev = $data[2];
                $id_par = $data[3];
                $result = \Models\Events::eventPar($id,$id_ev,$id_par);
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }
            if($data[0] === 'count')
            {
                $id = (int)$data[1];
                $parent = (int)$data[2];
                $result = \Models\Events::getCountEv($id,$parent);
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }

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


            if($_POST['recur_period'] != null)
            {
                $period = $_POST['duration'];
                $modify = $_POST['recur_period'];
                $id = \Models\Events::addEvents($id_user, $id_room, $description, $timeS, $timeE);
                $result = \Models\Events::addRecurringEvent($id_user, $id_room,
                $description, $timeS, $timeE,$period,$modify,$id);
                return \Response::ServerSuccess(200, $result);
            }
            else {
                $result = \Models\Events::addEvents($id_user, $id_room, $description, $timeS, $timeE);
                if(!$result)
                {
                    return \Response::ServerError(200, SELECT_DAY);
                }
                else {
                    return \Response::ServerSuccess(200, ADD_ONE_OK);
                }
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
            $start_point =  null;
            $id_parent =  null;
            $id = $putParams['id'];
            $id_user = $putParams['id_user'];
            $id_room = $putParams['id_room'];
            $description = $putParams['description'];
            $id_parent = $putParams['id_parent'];
            $dateStart = new \DateTime();
            $dateEnd = new \DateTime();
            $timeS = $dateStart->setTimestamp($putParams['time_start'] / 1000);
            $timeE = $dateEnd->setTimestamp($putParams['time_end'] / 1000);
            if(isset($putParams['start_point']))
            {
                $start_point = new \DateTime();
                $start_point= $start_point->setTimestamp($putParams['start_point'] / 1000);
               //$result = \Models\Events::editEvent($id, $id_user, $id_room, $description, $timeS, $timeE,  $start_point);
            }
            $result = \Models\Events::editEvents($id, $id_user, $id_room, $description, $timeS, $timeE,  $start_point, $id_parent);

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
            $time_start = trim($data[3]);
            //var_dump($time_start);
            //exit;
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
