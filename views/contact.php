<?php
use app\core\form\Form;
use app\core\form\TextareaField;


$this->title = 'Contact';
?>

<div class="contact ">
    <div class="container">

<div class="text-center mt-5">
    <h1>Contact Us</h1>
</div>

<?php
    $form = Form::begin('',"post");
?>

    <?php 
    echo $form->field($model,'subject');
    echo $form->field($model,'email');
    echo  new TextareaField($model,'body');
    ?>
<button type="submit" class="btn btn-primary m-1">Sunmit</button>


<?php echo Form::end() ?>
</div>
</div>