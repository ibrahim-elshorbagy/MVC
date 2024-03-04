<?php
namespace app\core;

class Session
{
/* ------------------- FLASH_MESSAGES ------------------- */

    protected const FLASH_MESSAGES = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages =$_SESSION[self::FLASH_MESSAGES] ?? [];

        foreach($flashMessages as $key => &$flashMessage)
        {
            //mark them to remove at the end of request
            $flashMessage['remove']=true;
        }

        $_SESSION[self::FLASH_MESSAGES] =$flashMessages;

    }
    
    public function setFlash($key,$message)
    {
        $_SESSION[self::FLASH_MESSAGES][$key] = [
            'remove'=>false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_MESSAGES][$key]['value'] ?? false;
    }

/* ------------------- get  set remove ------------------- */

    public function set($key,$value)
    {
        $_SESSION[$key]=$value;
    }
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

/* ------------------- destruct ------------------- */

    public function __destruct()
    {
        $flashMessages =$_SESSION[self::FLASH_MESSAGES] ?? [];

        foreach($flashMessages as $key => $flashMessage)
        {
            if($flashMessage['remove'])
            {
                unset($_SESSION[self::FLASH_MESSAGES][$key]);
            }
        }
    }





}