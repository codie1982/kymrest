<?php component::start($props); ?>
<div class="row margin-bottom-15">
    <div class="col-sm-12">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn green" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Yeni Kategori Ekleyin
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Yeni Kategori Ekle </a></li>
                    <li><a data-component_run="group_fields_modal" data-component_action="load" data-modal="#group_fields_modal" data-starter="form,component_run"  ><i class="fa fa-pencil"></i> Gruplama Alanlarını Ekle </a></li>
                    <li><a data-component_run="group_fields_edit_form" data-component_action="load" data-modal="#group_fields_edit_modal" data-starter="form,component_run"  ><i class="fa fa-pencil"></i> Gruplama Alanlarını Düzenle </a></li>
                    <li><a data-component_run="category_tree_list" data-component_action="load" data-starter="form,component_run"><i class="fa fa-pencil"></i> Listeyi Yenile </a></li>
                    <li><a data-component_run="category_table" data-component_action="load" data-starter="form,component_run"><i class="fa fa-pencil"></i> Tabloyu Yenile </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
