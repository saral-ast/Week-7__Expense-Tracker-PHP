<?php

namespace Core;

class ValidationException extends \Exception{

    protected array $errors;
    protected array $old;
        public static function throw($errors,$old){
            $instance = new static;
            $instance->errors = $errors;
            $instance->old = $old;
            throw $instance;
        }
        
        public function getOld(){
            return $this->old;
        }
        public function getErrors(){
            return $this->errors;
        }
}