<?php 
namespace app\core\form;
use app\core\Model;


abstract class BaseField
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model,$attribute)
    {   
        $this->model=$model;
        $this->attribute=$attribute;
        
    }


    abstract public function renderInput():string;

    public function __toString()
{
    return sprintf('
        <div class="form-group">
            <label class="m-1">%s</label>
            %s
            <div class="invalid-feedback">
                %s
            </div>
        </div>',
        //$this->model->labels()[$this->attribute] ?? $this->attribute,//label
        $this->model->getLabel($this->attribute),//label
        $this->renderInput(),
        $this->model->getFirstErrror($this->attribute)//error
    );
}

}