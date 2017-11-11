<?php

namespace Controllers;
/**
 * work
 * Class User
 * @package Controllers
 */
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
            if($data[1] === null )
            {
                $result = \Models\User::findAll();
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }
            else
            {
                $result = \Models\User::findByid($data[0]);
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

    }

    public function postUser($data=false)
    {
        try{
            $res = new \Models\User();
            $res->login = $this->valid->clearData($_POST['login']);
            $res->pass = md5(md5(trim($this->valid->clearData($_POST['pass']))));
            $res->email = $this->valid->clearData($_POST['email']);
            $res->hash = 'null';
            $result = $res->insert();
            if($result)
            {
                return \Response::ServerSuccess(200, "Register success");
            }
            return false;
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }
    }

    public function putUser($data=false)
    {
        try{
            $putParams = json_decode(file_get_contents("php://input"), true);

            $results = $this->valid->clearData($putParams['login']);
            $result = \Models\User::loginUser($results);
            if($result)
            {
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
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }

    }

    public function deleteUser($data)
    {
        try
        {
            $param = $this->valid->clearData($data[0]);
            $result = \Models\User::deleteUser($param);
            return \Response::ServerSuccess(200, $result);
        }
        catch (\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
        }
    }

}
