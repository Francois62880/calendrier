<?php

namespace App;

class Validator{

    private $data;
    protected $errors= [];

     /**
     * @param array $date
     * @return array/bool
     */
    public function validates(array $data)
    {
        $this->errors = [];
        $this->data = $data;
    }
    public function validate(string $field, string $method, ...$parameters)
    {
        if(!isset($this->data[$field]))
        {
            $this->errors[$field] = "Le champs $field n'est pas rempli";
        }else{
        call_user_func([$this, $method],$field, ...$parameters);
        }
    }

    public function minLength(string $field,int $length): bool
    {
        if(mb_strlen($field)<$length)
        {
            $this->errors[$field]= "Le champs doit avoir plus de $length caratères";
            return false;
        }
        return true;
    }
    public function date(string $field): bool
    {
       if(\DateTime:: createFromFormat('Y-m-d', $this->data[$field]===false))
        {
            $this->errors[$field] = 'La date ne semble pas valide';
            return false;
        }
        return true;
    }
    public function time(string $field): bool
    {
       if(\DateTime:: createFromFormat('H:i', $this->data[$field]===false))
        {
            $this->errors[$field] = 'Le temps ne semble pas valide';
            return false;
        }
        return true;
    }
    public function beforTime(string $startfield, string $endfield)
    {
        if($this->time($startfield) && $this->time($endfield))
        {
            $start = \DateTime:: createFromFormat('H:i', $this->data[$startfield]);
            $end = \DateTime:: createFromFormat('H:i', $this->data[$endfield]);
            if($start->getTimestamp() > $end->getTimestamp())
            {
                $this->errors[$startfield] = 'Le temps doit être inférieur au temps de fin';
                return false;
            }
            return true;
        }
        return false;
    }
}