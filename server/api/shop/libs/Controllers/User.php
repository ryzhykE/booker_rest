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
            if($data[1] === null )
            {
                $result = \Models\User::findAll();
                $result = \Response::typeData($result,$type);
                return \Response::ServerSuccess(200, $result);
            }
            else
            {
                $result = \Models\User::checkUsers($data[0]);
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
        try {
            $login = $this->valid->clearData($_POST['login']);
            $pass = $this->valid->clearData($_POST['pass']);
            $email = $this->valid->clearData($_POST['email']);
            if($login !== false && $pass !== false && $email !== false)
            {
                $result = \Models\User::authUser($login,$pass,$email);
            }
            else {

                return "не корр логин";

            }
            if (false === $result) {
                return \Response::ClientError(401, "User with such login already exists ");
            } else {
                return \Response::ServerSuccess(200, "Register success");
            }
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

    public static function updateUser($id,$login,$email,$pass)
    {
            $pass = md5(md5(trim($pass)));
            $sql = "UPDATE  " . static::$table ." SET login='$login', email='$email',
                pass = '$pass'  WHERE id='$id' ";
            $db = DB::getInstance();
            $result = $db->execute($sql);
            return $result;

            
    }

}
