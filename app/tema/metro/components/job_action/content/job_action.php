<?php component::start($props); ?>
<div class="row margin-bottom-15">
    <div class="col-sm-12">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn green" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Yeni Sipariş Ekleyin
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a data-component_run="job_form" data-component_action="load" data-modal="#jobs"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Yeni Sipariş Ekle </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
