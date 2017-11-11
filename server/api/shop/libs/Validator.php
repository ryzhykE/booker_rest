<?php

class Validator
{
    protected $data;
    public $value;

    /**
     * login validator
     * @param string $data
     * @return bool
     */
    protected function loginValid($data)
    {

        $pattern = '/^[a-zA-Z][a-zA-Z0-9-_\.]{7,10}$/';
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





    /*
    * Clear data from user
    *
    * @param data: number of string
    * @return: data
     */
    public function clearDataw($data)
    {
        if (is_array($data))
        {
            return $this->clearDataArr($data);
        }
        else
        {
            $data = trim(strip_tags($data));
            return $data;
        }
    }

    /*
    * Validate name field
    *
    * @param val: check string
    * @return: boolean
    */
    public function checkForm($val)
    {
        $this->value = '';
        $val = $this->clearData($val);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $val))
        {
            return false;
        }
        else
        {
            return true;
        }
    }


    /*
    * To positive number
    *
    * @param val: check string
    * @return: integer
    */
    public function numCheck($val)
    {
        return $this->value = abs((int)($val));
    }

    public function getValue()
    {
        return $this->value;
    }

    /*
    * Validate e-mail
    *
    * @param val: check string
    * @return: boolean
    */
    public function checkEmail($val)
    {
        $this->value = '';
        $val = $this->clearData($val);
        if (!filter_var($val, FILTER_VALIDATE_EMAIL))
        {
            return false;
        } else {
            return true;
        }
    }
}


