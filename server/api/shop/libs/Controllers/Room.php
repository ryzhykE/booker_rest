<?php

namespace Controllers;


class Room
{
    public function getRoom($data = false,$type = false)
    {
        try
        {
            if($data[1] === null )
            {
                $result = \Models\Room::findAll();
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }
            else
            {
                $result = \Models\Room::findByid($data[0]);
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

    }

}
