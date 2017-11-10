<?php
namespace Controllers;
/**
 * update user from admin
 * Class Admin
 * @package Controllers
 */
class Admin extends \Validator
{
    protected $valid;
    public function __construct()
    {
        $this->valid = new \Validator();
    }

    /**
     * update user
     * @param bool $data
     */
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
            return \Response::ServerSuccess(201,'OK');
            }
        }
        catch(\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
            
        }
    }
}


