<?php

namespace app\core;


abstract class Model
{



//valitdation rules we need to have
public const RULE_REQUIRED  = 'required';
public const RULE_EMAIL     = 'email';
public const RULE_MIN       = 'min';
public const RULE_MAX       = 'max';
public const RULE_MATCH     = 'match';
public const RULE_UNIQUE    = 'unique';

    /* ------------------- loadData  --------------------- */

/*
loadData
make sure models objects conatin variable with the same key name of the sended data
then put the data value into the object variables

*/

    public function loadData($data)
    {

        foreach($data as $key =>$value)
        {
            if(property_exists($this,$key))
            {
                $this->{$key} =$value;
            }
        }

    }


    /* ------------------- Rules + validate  --------------------- */


    abstract public function rules():array;

    public function labels() :array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }
    public array $errors =[];


    public function validate()
    {
        foreach($this->rules() as $attribute=>$rules) //$attribute is the object variable
        {
            $value =$this->{$attribute}; //like $this->firstname get the value for this variable on the object after saving it on loadData

            foreach($rules as $rule)
            {
                $ruleName = $rule;

                if(is_array($ruleName))
                {
                    $ruleName =$rule[0];
                }

                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrorForRule($attribute,self::RULE_REQUIRED);
                }
                
                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorForRule($attribute,self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) 
                {
                    $this->addErrorForRule($attribute,self::RULE_MIN ,$rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                {
                    $this->addErrorForRule($attribute,self::RULE_MAX ,$rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})//$this->{$rule['match']} => $this->{password};
                {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute,self::RULE_MATCH ,$rule);
                    
                }

                if($ruleName === self::RULE_UNIQUE )
                {
                    $className =$rule['class'];
                    $uniqueAttribute =$rule['attribute'] ?? $attribute;
                    $tableName =$className::tableName(); 
                    $statment = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribute= :attr");
                    $statment->bindValue(":attr",$value);
                    $statment->execute();
                    $record = $statment->fetchObject();

                    if($record)
                    {
                        $this->addErrorForRule($attribute,self::RULE_UNIQUE,['field'=>$this->getLabel($attribute)]);
                    }
                }
            }
        }


        return empty($this->errors);
    }


    private function addErrorForRule(string $attribute,string $rule ,$params=[] ){
        $message=$this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value)
        {
            $message =str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][]= $message;
    }

    public function addError(string $attribute,string $message  ){

        $this->errors[$attribute][]= $message;
    }

    public function errorMessages(){

        return [

        self::RULE_REQUIRED  => 'This filed is required',
        self::RULE_EMAIL     => 'This filed Must be a Valid email address',
        self::RULE_MIN       => 'Min length of this filed must be {min}',
        self::RULE_MAX       => 'Max length of this filed must be {max}',
        self::RULE_MATCH     => 'This filed Must be the same as {match}',
        self::RULE_UNIQUE    => 'Record with this {field} already exists',

        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstErrror($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
    /* ------------------- Rules + validate  --------------------- */

}