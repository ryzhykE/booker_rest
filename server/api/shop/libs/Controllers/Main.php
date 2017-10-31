<?php

namespace Controllers;


class Main extends \Validator
{
    protected $valid;

    public function __construct()
    {
        $this->valid = new \Validator();
    }

    public function getMain ($data = false,$type = false)
    {
        $result = 'Main Controller';
        return \Response::ServerSuccess(200, $result);

    }

    public function postMain ($data = false)
    {
       
    }
    public function putBooks($data = false)
    {
        try{
        //$putParams = json_decode(file_get_contents("php://input"), true);
      
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }
    }

    public function deleteBooks($data = false)
    {
        return false;
    }

}