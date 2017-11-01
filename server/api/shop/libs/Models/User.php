<?php

namespace Models;


class User extends Models
{
    public static $table = 'users';
    public $id;
    public $login;
    public $pass;
    public $hash;
    public $id_role;
/**
    public static function authUser($first_name,$last_name,$login,$pass)
    {
        $pass = md5(md5(trim($pass)));
        $sql = "INSERT INTO  " . static::$table ." ( first_name,last_name,login, pass)
                VALUES ('$first_name', '$last_name', '$login', '$pass' )";
        $db = DB::getInstance();
        $result = $db->execute($sql);
        return $result;
    }
 */
    public static function loginUser($login)
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table . ' WHERE login=:login',
            [':login' => $login]
        );
        return $data[0];
        //?? false;
    }
    public function checkUsers($id)
    {
        $db = DB::getInstance();
        $data = $db->query(
            'SELECT * FROM ' . static::$table . ' WHERE id=:id',
            [':id' => $id]
        );
        //return = ['discount'=>$data[0]['hash'], 'hash'=>$data[0]['hash'] , 'role'=> $role];
        return $data[0];
        //?? false;
    }

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
