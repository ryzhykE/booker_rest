<?php

class RestServer
{
    protected $reqMethod;
    public  function run ()
    {
        list($s, $user, $REST, $server, $api, $class, $data) = explode("/", $_SERVER['REQUEST_URI'], 7);
        $className = 'Controllers\\'.ucfirst($class);
        $this->reqMethod = $_SERVER['REQUEST_METHOD'];

        if( class_exists($className) ) {
            $controller = new $className;
            $type = (preg_match('#(\.[a-z]+)#', $_SERVER['REQUEST_URI'], $match)) ? $match[0] : DEFAULT_TYPE;
            switch ($this->reqMethod)
            {
                case 'GET':
                    $this->setMethod($controller,'get'.ucfirst($class),explode('/', $this->cleanInputs($data)),$type);
                    break;
                case 'POST':
                    $this->setMethod($controller,'post'.ucfirst($class),explode('/', $this->cleanInputs($data)));
                    break;
                case 'PUT':
                    $this->setMethod($controller,'put'.ucfirst($class),explode('/', $this->cleanInputs($data)));
                    break;
                case 'DELETE':
                    $this->setMethod($controller,'delete'.ucfirst($class),explode('/', $this->cleanInputs($data)));
                    break;
                default:
                    return false;
            }
        }
        else
        {
            echo Response::clientError( 400, "Cannot find the class: " . $class );
        }

    }

    private function setMethod($class, $method,$param = false, $type = false)
    {
        if ( method_exists($class, $method) )
        {
            $class->$method($param,$type);
        }
        else
        {
            echo Response::ClientError(405, "The request cannot be fullfilled. The method is not allowed in this context.");
        }
    }

    private function cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }
}
