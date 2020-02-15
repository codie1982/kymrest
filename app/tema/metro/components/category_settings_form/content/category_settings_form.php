<?php component::start($props); ?>
<?php $settings = component::get_props("settings"); ?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Kategori Ayarları</span>
                    <span class="help-inline"> Bu Ayarları Mümkün Olduğunca Değiştirmemeye Çalışın. </span>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="category_settings_form" data-action="update_category_settings">

                    <div class="form-body">
                        <div class="portlet-title margin-bottom-15">
                            <div class="caption">
                                <i class="icon-envelope font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Kategori Ayarlarınızı Yapılandırın</span>
                            </div> 
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green" name="settings" value="1">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php component::end(); ?>
