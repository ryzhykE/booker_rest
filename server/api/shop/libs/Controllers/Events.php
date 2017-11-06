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
            $result = \Models\Events::allEvents($data[0],$arr,$end);
            $result = \Response::typeData($result,$type);
            return \Response::ServerSuccess(200, $result);

        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }
    }

    public function postEvents($data = false,$type = false)
    {
        try {

            if($_POST['recur_period'] === null)
            {
                $id_user = $_POST['id_user'];
                $id_room = $_POST['id_room'];
                $description = $_POST['description'];
                $dateStart = new \DateTime();
                $startT = $dateStart->setTimestamp($_POST['time_start']/1000);
                $timeS = $startT->format(DATE_FORMAT);
                $endT = $dateStart->setTimestamp($_POST['time_end']/1000);
                $timeE = $endT->format(DATE_FORMAT);
                $result = \Models\Events::addEvents($id_user, $id_room, $description, $timeS, $timeE);
            }
            else
            {
                $id_user = $_POST['id_user'];
                $id_room = $_POST['id_room'];
                $description = $_POST['description'];
                $period = $_POST['duration'];
                $modify = $_POST['recur_period'];

                $timeS = new \DateTime();
               // $timeS->modify(self::getRecurring($modify));
                $startT = $timeS->setTimestamp($timeS/1000);
                $timeS = $startT->format(DATE_FORMAT);

                $timeE = new \DateTime();
              //  $timeE->modify(self::getRecurring($modify));
                $endT = $timeE->setTimestamp($timeE/1000);
                $timeE = $endT->format(DATE_FORMAT);

                $result = \Models\Events::addRecurringEvent($id_user, $id_room, $description, $timeS, $timeE,$period);
            }

        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

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


}