<?php

class Response
{
    /**
     * response server success
     * @param $type
     * @param null $message
     */
    public static function ServerSuccess( $type, $message = null) {
        $responseHeader = self::ServerOKType();
        header($responseHeader[$type]);
        echo $message;
    }

    /**
     * response server error
     * @param $errorType
     * @param $message
     */
    public static function ServerError( $errorType, $message ) {
        $responseHeader = self::ServerErrorType();
        header($responseHeader[$errorType]);
        echo $message;
    }

    /**
     * response client error
     * @param $errorType
     * @param $message
     */
    public static function ClientError( $errorType, $message ) {
        $responseHeader = self::ClientErrorType();
        header($responseHeader[$errorType]);
        echo $message;
    }

    /**
     * list client error
     * @return array
     */
    private static function ClientErrorType() {
        return array(
            400 => "HTTP/1.0 400 Bad Request",
            401 => "HTTP/1.0 401 Unauthorized",
            403 => "HTTP/1.0 403 Forbidden",
            404 => "HTTP/1.0 404 Not Found",
            405 => "HTTP/1.0 405 Method Not Allowed",
            406 => "HTTP/1.0 406 Not Acceptable"
        );
    }

    /**
     * list server error
     * @return array
     */
    private static function ServerErrorType() {
        return array(
            500 => "HTTP/1.0 500 Internal Server Error",
            501 => "HTTP/1.0 501 Not Implemented",
            502 => "HTTP/1.0 502 Bad Gateway",
            503 => "HTTP/1.0 503 Service Unavailable",
            504 => "HTTP/1.0 504 Gateway Timeout",
            505 => "HTTP Version Not Supported"
        );
    }

    /**
     * list ok response server
     * @return array
     */
    private static function ServerOKType() {
        return array(
            200 => "HTTP/1.0 200 OK",
            201 => "HTTP/1.0 201 Created",
            202 => "HTTP/1.0 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.0 204 No Content",
            205 => "HTTP/1.0 205 Reset Content"
        );
    }

    /**
     * check type expansion
     * @param $data
     * @param $type
     * @return mixed|string|void
     */
    public static function typeData ($data, $type)
    {
        switch ($type)
        {
            case '.json':
                $data = self::convertJSON($data);
                break;
            case '.xml':
                $data = self::convertXML($data);
                break;
            case '.txt':
                $data = self::convertTXT($data);
                break;
            case '.html':
                $data = self::convertHTML($data);
                break;
        }
        return $data;
    }


    private function  convertJSON($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }

    private function  convertXML($data)
    {

        header("Content-type: text/xml");
        $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        self::toXml($data, $xml);
        return $xml->asXML();

    }


    private function toXml($data, $xml)
    {
        foreach($data as $key=>$val)
        {
            if(is_numeric($key))
            {
                $key = 'car'.$key ;

            }
            if(is_array($val))
            {
                $subnode = $xml->addChild($key);
                self::toXml($val, $subnode);
            }
            else
            {
                $xml->addChild("$key",htmlspecialchars("$val"));
            }
        }
    }

    private function convertTXT($data)
    {
        header('Content-Type: text/javascript; charset=utf-8');
        print_r($data);
    }


}