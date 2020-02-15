<?php component::start($props); ?>
<?php $category_name = component::get_props("category_name"); ?>

<?php $category_id = component::get_props("category_id"); ?>
<div class="modal fade bs-modal-lg" id="category_gallery" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase">Kategori Galerisi</span>
                            <span class="help-inline"> Kategoriniz için bir galleri oluşturun.</span>
                        </div>
                    </div>
                    <div class="row margin-bottom-15">
                        <div class="col-md-12"><h4><strong><?= $category_name ?></strong> kategorisi için bir galeri oluşturun</h4></div>
                    </div>
                    <div class="row margin-bottom-15"><div class="col-md-12"><?= component::get_props("category_gallery_images_component"); ?></div></div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" data-send="xhr" method="post" data-component_name="category_gallery_form" data-action="update_gallery_form" role="form">
                            <?= component::get_props("category_images_list_component"); ?>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Galleriyi Düzenle</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="note note-info margin-bottom-15">
                    <div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i></div>Kategori Galerileri Kategorilerinize galleri oluşturmanızı sağlar
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
<?php component::end(); ?>
