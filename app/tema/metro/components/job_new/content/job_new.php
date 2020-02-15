<?php component::start($props); ?>
<div id="selected_customer">
    <form  class="form-horizontal"  data-send="xhr" method="post" data-component_name="job_form" data-action="add_new_job">
        <div class="row">
            <div customer_id="<?= component::get_props("customer_id") ?>"></div>
            <input id="selected_customer_id" type="hidden" name="@job_fields$customer_id" value="<?= component::get_props("customer_id") ?>" />
            <div class="col-sm-6"><b><?= ucwords_tr(component::get_props("customer_name")) ?></b></div>
            <div class="col-sm-6"><button type="submit" class="btn btn-info green btn-block" >Yeni İş Oluştur</button></div>
        </div>
    </form>
</div>
<?php component::end(); ?>
