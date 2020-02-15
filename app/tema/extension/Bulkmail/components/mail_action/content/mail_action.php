<?php component::start($props); ?>
<div class="row margin-bottom-15">
    <div class="col-sm-12">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn green" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Toplu Mail Gönderin
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a data-modal="#bulk_mail_form" data-component_run="bulk_mail_form" data-component_action="load" data-starter="form,component_run" ><i class="fa fa-pencil"></i> Toplu Mail Gönderin</a></li>
                    <li><a data-modal="#test_mail_form" data-component_run="test_mail_form" data-component_action="load" data-starter="form,component_run" ><i class="fa fa-pencil"></i> Test Mail Gönder</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
