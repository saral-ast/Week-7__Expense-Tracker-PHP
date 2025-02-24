<?php

namespace Core;
class Session{
         
       public static function put($key, $value){
            $_SESSION[$key] = $value;
       }
       public static function get($key,$default=null){
            return $_SESSION[$key] ?? $default;
       }

       public static function flush(){
              $_SESSION = [];
        }

     
}