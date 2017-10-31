<?php

class Validator
{
    protected $data;
    public $value;
    protected function loginValid($data)
    {
        $pattern = '/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/';
        if(preg_match($pattern, $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function passwordValid($data)
    {
        $pattern = '/^([0-9a-z]{8,10})$/i';
        if(preg_match($pattern, $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function clearData($data)
    {
        $this->value = trim($data);
        $this->value = stripslashes($data);
        $this->value = strip_tags($data);
        $this->value = htmlspecialchars($data);
        return $this->value;
    }

    function isIntNumber($value){
        if (!is_int($value) && !is_string($value)) return ERROR_INT;
        if (!preg_match("/^-?/(([1-9][0-9]*|0/))$/", $value)) return ERROR_INT;
        return true;
    }

}