<?php
use app\core\form\Form; 
$this->title = 'Login';
?>
<div class="login ">
        <div class="container">


        <div class="text-center mt-5">
            <h1>Login</h1>
        </div>
        <?php
        $form = Form::begin('',"post");
        ?>

        <?php 
        echo $form->field($model,'email');
        echo $form->field($model,'password')->passwordFiled();
        ?>
        <button type="submit" class="btn btn-primary m-1">Login</button>

        <?php echo Form::end() ?>
    </div>
</div>