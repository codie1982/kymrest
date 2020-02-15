<?php component::start(); ?>
<?php $sidebar_info = component::get_props("sidebar_info"); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Menu  Ayarları</span>
                    <span class="help-inline"> Siteminizdeki yan menuyu bu kısımdan ayarlayabilirsiniz. </span>
                </div>
            </div>

            <div class="portlet-body form">
                <div class="row">
                    <div class="col-sm-6">   
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <ul class="nav nav-tabs tabs-left">
                                        <li class="active">
                                            <a href="#tab_6_1" data-toggle="tab"> Back Module </a>
                                        </li>


                                    </ul>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <h3 class=""><a href="javascript:void(0)">Modul Listeleri</a></h3>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_6_1">
                                            <div class="mt-element-list">
                                                <div class="mt-list-container list-simple">
                                                    <?php $backmodules = modules::getModuleList("router"); ?>
                                                    <ul class="connectedSortable" id="backmodule_list">
                                                        <?php foreach ($backmodules as $router => $module): ?>
                                                            <li class="mt-list-item"
                                                                module-router="<?= $router ?>"
                                                                module-page_title="<?= $module->page_title ?>"
                                                                module-controller="<?= $module->controller ?>"
                                                                module-icon="<?= $module->icon ?>"
                                                                >
                                                                <div class="list-item-content">
                                                                    <h3 class=""><a href="javascript:void(0)"><?= $router ?></a></h3>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <h3 class=""><a href="javascript:void(0)">Menu Listesi</a></h3>
                        <form class="form-horizontal" data-send="xhr" method="post" data-component_name="sidebar_settings_form" data-action="update_sidebar" >

                            <div class="mt-element-list ">
                                <div class="mt-list-container list-simple">
                                    <ul class="connectedSortable" id="menu_list">
                                        <?php if (!empty($sidebar_info)): ?>
                                            <?php $row_number = 0; ?>
                                            <?php foreach ($sidebar_info as $sidebar): ?>
                                                <?php $row_number++; ?>
                                                <?php $rand = rand(9999, 99999); ?>
                                                <?php $prk = $sidebar->primary_key ?>
                                                <?php $primary_id = $sidebar->$prk ?>
                                                <li class="mt-list-item"
                                                    module-key="<?= $sidebar->$prk ?>"
                                                    module-router="<?= $sidebar->link ?>"
                                                    module-page_title="<?= $sidebar->menu_title ?>"
                                                    module-icon="<?= $sidebar->icon ?>"
                                                    >
                                                    <div class="list-item-content">
                                                        <h3 class="">
                                                            <a href="javascript:void(0)"><?= $sidebar->menu_title ?> 
                                                              
                                                                <input type="hidden"  value="<?= $rand ?>" name="@sidebar_menu_fields$secret_number:<?= $rand ?>" /> 
                                                                <input type="hidden"  value="<?= $sidebar->menu_title ?>" name="@sidebar_menu_fields$menu_title:<?= $rand ?>" /> 
                                                                <input type="hidden"  value="<?= $sidebar->link ?>" name="@sidebar_menu_fields$link:<?= $rand ?>" /> 
                                                                <input type="hidden" class="sidebar_row_number" value="<?= $row_number ?>" name="@sidebar_menu_fields$row_number:<?= $rand ?>" /> 
                                                                <span style="position: absolute;right: 65px;width: 40%;margin-top: -10px;">
                                                                    <input type="input" class="form-control" value="<?= $sidebar->icon ?>" placeholder="Menu için bir ikon belirleyin" name="@sidebar_menu_fields$icon:<?= $rand ?>" />
                                                                </span> 
                                                            </a>
                                                        </h3>
                                                    </div>
                                                </li>

                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="mt-list-item">
                                                <div class="list-item-content">
                                                    <h3 class=""><a href="javascript:;">Modul Ekleyin</a></h3>
                                                </div>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green" name="settings" value="1">Menuyu Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
