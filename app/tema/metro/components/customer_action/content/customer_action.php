<?php component::start($props); ?>
<div class="row margin-bottom-15">
    <div class="col-sm-12">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn green" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Yeni Müşteri Ekleyin
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a data-modal="#customers_personel" data-component_run="customer_personel_form" data-component_action="load" data-starter="form,component_run" ><i class="fa fa-pencil"></i> Kişisel Ekle </a></li>
                    <li><a data-modal="#customers_company" data-component_run="customer_company_form" data-component_action="load" data-starter="form,component_run" ><i class="fa fa-pencil"></i> Kurumsal Müşteri Ekle </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
