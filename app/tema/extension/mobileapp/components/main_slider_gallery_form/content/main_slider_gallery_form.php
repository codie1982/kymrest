<?php component::start($props); ?>
<div class="modal fade bs-modal-lg" id="main_slider_gallery" tabindex="-1" role="basic" aria-hidden="true">
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
                            <span class="caption-subject font-dark sbold uppercase">Aplikasyon Slider</span>
                            <span class="help-inline"> Aplikasyonunuzda bulunan image slider için resimlr ekleyin.</span>
                        </div>
                    </div>
                    <div class="row margin-bottom-15">
                        <div class="col-md-12"><h4>Aplikasyon içindeki slider için resim yükleyin</h4></div>
                    </div>
                    <div class="row margin-bottom-15"><div class="col-md-12"><?= component::get_props("gallery_images"); ?></div></div>
                  
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
