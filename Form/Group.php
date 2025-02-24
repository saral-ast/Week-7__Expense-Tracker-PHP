<?php

namespace Form;
use Core\ValidationException;
use Core\Validator;

class Group{
    protected $errors = [];
    protected $attributes = [];
    public function __construct($attributes){
       
        $this->attributes = $attributes;
    
     }
    public function throw(){
        ValidationException::throw($this->getErrors(),$this->attributes);

    }

    public function validate(){
        if(Validator::validateGroup($this->attributes['groupName'])){
            return $this;
        }
        return false;
    }

    public function failed(){
        return count($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }

    public function setErrors($field,$message){
        $this->errors[ $field ] = $message;
        return $this;
    }

}