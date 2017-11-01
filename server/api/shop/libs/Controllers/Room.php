<?php

namespace Controllers;


class Room
{
    public function getRoom($data = false,$type = false)
    {
        try
        {
            $result = \Models\Room::findAll();
            $result = \Response::typeData($result,$type);
            return \Response::ServerSuccess(200, $result);
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

    }

}