<?php
namespace Controllers;

class Admin extends \Validator
{
    protected $valid;
    public function __construct()
    {
        $this->valid = new \Validator();
        
    }

    public function getAdmin ($data = false,$type = false)
    {
        $result = \Models\User::deleteUser($data[0]);
        $result = \Response::typeData($result,$type);
        return \Response::ServerSuccess(200, $result);

    }

    public function putAdmin($data=false)
    {
        try {


            $putParams = json_decode(file_get_contents("php://input"), true);
            $id = $this->valid->clearData($putParams['id']);
            $login = $this->valid->clearData($putParams['login']);
            $email = $this->valid->clearData($putParams['email']);
            $pass = $this->valid->clearData($putParams['pass']);
            $result = \Models\User::updateUser($id,$login,$email,$pass);
            if($result)
            { 
            return \Response::ServerSuccess(200,'OK');
            }
        }
        catch(\Exception $exception)
        {
            return \Response::ServerSuccess(500, $exception->getMessage());
            
        }
    }
}

