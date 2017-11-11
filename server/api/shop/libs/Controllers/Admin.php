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
            $res = new \Models\User();
            $res->id = $this->valid->clearData($putParams['id']);
            $res->login = $this->valid->clearData($putParams['login']);
            $res->pass = md5(md5(trim($this->valid->clearData($putParams['pass']))));
            $res->email = $this->valid->clearData($putParams['email']);
            $res->hash = 'null';
            $result = $res->update();
            return \Response::ServerSuccess(200, "Ok");
        }
        catch(\Exception $exception)
        {
            return \Response::ServerError(500, $exception->getMessage());
            
        }
    }
}


