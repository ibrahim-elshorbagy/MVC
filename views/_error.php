<?php
$this->title = 'Error';
?>


<div class="contact ">
    <div class="container">

<div class="text-center mt-5">
    <h1>
    <?php 
echo $exception->getCode()
?> - <?php echo $exception->getMessage();?></h1>
</div>

</div>
</div>