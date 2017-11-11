<?php

namespace Models;

/**
 * User Model
 * Works with controller Users.
 * Receives data from the controller,
 * @package Models
 */
class User extends Models
{
    public static $table = 'users';
    public $id;
    public $login;
    public $pass;
    public $email;
    public $hash;

    /**
     * return access to the main page
     * @param $login
     * @return mixed
     */
    public static function loginUser($login)
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table . ' WHERE login=:login',
            [':login' => $login]
        );
        return $data[0];
    }

    /**
     * take hash for user
     * @param $id
     * @return string
     */
    public static function setHash($id)
    {
        $hash = md5(self::generateCode(10));
        $db = DB::getInstance();

        $data = $db->query(
            'SELECT id_role FROM ' . static::$table . ' WHERE id=:id',
            [':id' => $id]
        );
        $id_role = $data[0]['id_role'];
        $sql = "UPDATE " . static::$table . " SET hash = '$hash' WHERE id = '$id' ";
        $result = $db->execute($sql);
        $arr = ['id'=>$id, 'hash'=>$hash , 'id_role'=> $id_role];
        return json_encode($arr);
    }

    /**
     * get role user
     * @param $id
     * @return bool
     */
    public static function getRoleUser($id)
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT roles.name FROM users u LEFT JOIN roles  ON u.id_role=roles.id WHERE u.id=:id',
            [':id' => $id]
        );
        if (!empty ($data))
        {
            return $data[0]['name'];
        }
        return false;
    }

    /**
     * delete user from admin
     * @param $id
     * @return bool|string
     */
    public function deleteUser($id)
    {
        if (self::getRoleUser($id) == 'user')
        {
            $sql = 'DELETE FROM events WHERE id_user=:id AND time_start > NOW()';
            $data[':id'] = $id;
            $db = DB::getInstance();
            $db->execute($sql, $data);
            $sql = 'DELETE FROM users  WHERE id=:id';
            $data[':id'] = $id;
            $db = DB::getInstance();
            $db->execute($sql, $data);
            return true;
        }
        else
        {
            $db = DB::getInstance();
            $data = $db->query(
                'SELECT count(id_role) as sum FROM users WHERE id_role=1',
                []
            );
            if ($data[0]['sum'] > 1)
            {
                $db = DB::getInstance();
                $data = $db->query(
                    'DELETE FROM users  WHERE id=:id',
                    [':id' => $id]
                );
                if (!empty ($data))
                {
                    return true;
                }
                return false;
            }
            else
            {
                return ERROR_ADDMDEL;
            }

        }
        return ERROR_DELL;

    }

    /**
     * generate code for  hash
     * @param int $length
     * @return string
     */
    function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length)
        {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

}
