<?php component::start(); ?>
<?php $confirm_message = component::get_props("confirm_message"); ?>
<div class="content">
    <!-- BEGIN LOGIN FORM --> 
    <p><?= $confirm_message ?></p>
    <!-- END LOGIN FORM -->
</div>
<?php component::end(); ?>
