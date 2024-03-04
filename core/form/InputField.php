<?php 
namespace app\core\form;
use app\core\Model;


class InputField extends BaseField
{
    public const TYPE_TEXT ='text';
    public const TYPE_PASSWORD ='password';
    public const TYPE_NUMBER ='number';
    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct($model,$attribute)
    {   
        $this->type =self::TYPE_TEXT;
        parent::__construct($model,$attribute);
        
    }




public function passwordFiled()
{
    $this->type =self::TYPE_PASSWORD;
    return $this;
}

public function renderInput():string
{

return sprintf('<input type="%s" name="%s" value="%s" class="form-control m-1 %s" >',
        $this->type,//type
        $this->attribute,//name
        $this->model->{$this->attribute},//value
        $this->model->hasError($this->attribute) ? 'is-invalid' : '',//class
    );
}

}