<?php
use app\core\form\Form; 
$this->title = 'Register';
?>

<div class="register">
    <div class="container">

    <div class="text-center mt-5">
        <h1>Register</h1>
    </div>

    <?php
    $form = Form::begin('',"post");
    ?>

<div class="row ">
    <div class="col"><?php echo $form->field($model,'firstname'); ?></div>
    <div class="col"><?php echo $form->field($model,'lastname'); ?></div>
</div>

<?php 
echo $form->field($model,'email');
echo $form->field($model,'password')->passwordFiled();
echo $form->field($model,'confirmPassword')->passwordFiled();
?>
<button type="submit" class="btn btn-primary m-1">Submit</button>

<?php echo Form::end() ?>
</div>
</div>
