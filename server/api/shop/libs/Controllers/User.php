<?php

namespace Controllers;

class User extends \Validator
{
    protected $valid;

    public function __construct()
    {
        $this->valid = new \Validator();
    }

    public function getUser($data = false,$type = false)
    {
        try
        {
            $result = \Models\Client::findAll();
            $result = \Response::typeData($result,$type);
            return \Response::ServerSuccess(200, $result);
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

    }

    public function postUser($data=false)
    {
    }

    public function putUser($data=false)
    {
        try{
            $putParams = json_decode(file_get_contents("php://input"), true);
            $result = $this->valid->clearData($putParams['login']);
            if($result)
            {
                var_dump($result["pass"]);
                if(md5(md5($putParams['pass'])) === $result["pass"] )
                {
                    $result = \Models\User::setHash($result["id"]);
                    return \Response::ServerSuccess(200, $result);
                }
                else
                {
                    return \Response::ClientError(401, "Wrong password");
                }
            }
            //var_dump($putParams);
            //$id = $this->valid->clearData($putParams['id']);
            //$first_name = $this->valid->clearData($putParams['first_name']);
           // $last_name = $this->valid->clearData($putParams['last_name']);
            //$login = $this->valid->clearData($putParams['login']);
            //$pass = $this->valid->clearData($putParams['pass']);
            //$discount = $this->valid->clearData($putParams['discount']);
            //$role = $this->valid->clearData($putParams['role']);
            //$active = $this->valid->clearData($putParams['active']);
            //$result = \Models\Client::updateUserAdm($id,$first_name,$last_name,$login,$pass,$discount,$role,$active);
            //return \Response::ServerSuccess(200,'OK');
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

    }

}