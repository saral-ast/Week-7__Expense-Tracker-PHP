<?php
namespace Core;
class Validator{
    public static function string($value,$min = 1,$max = INF){
         $value = trim($value);
        //  dd(strlen($value) >= $min && strlen($value) <= $max);
         return strlen($value) >= $min && strlen($value) <= $max;
    }
    
    public static function validateGroup($value){
        $value = trim($value);
        $db = App::resolve(Database::class);

        $group = $db->query('SELECT * FROM groups WHERE group_name = :name',[
                'name' => $value
            ])->find();
      
            
        return $group ?? false;
        
    }

}