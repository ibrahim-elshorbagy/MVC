<?php
namespace app\core;


class Request
{

    /* ------------------- path + method ------------------- */

    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        
        $postion = strpos($path,'?');

        if($postion === false)
        {
            return $path;
        }
    
        return substr($path,0,$postion);
    }



    public function method(){

        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /* ------------------- post or get  --------------------- */

    public function isGet()
    {
        return $this->method() === 'get';
    }

    public function isPost()
    {
        return $this->method()  === 'post';
    }

    /* ------------------- Body security ------------------- */

    public function getBody()
    {
        $body =[];

    if($this->isGet())
    {
        foreach($_GET as $key=>$value)
        {
            $body[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
        }

    }

    if($this->isPost())
    {
        foreach($_POST as $key=>$value)
        {
            $body[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
        }

    }

        return $body;
    }

    /* ------------------------------------------------------ */
    
}