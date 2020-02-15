<?php component::start($props); ?>

<div class="modal fade bs-modal-lg" id="category_move" tabindex="-1" role="basic" aria-hidden="true">
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
                            <span class="caption-subject font-dark sbold uppercase">Kategorinizi Taşıyın</span>
                            <span class="help-inline"> Kategoriniz için yeni bir üst kategori seçin. </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" data-send="xhr" method="post" data-component_name="category_move_form" data-action="move_category" role="form">
                            <?= component::get_props("category_move_list") ?>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Kategoriyi Taşı</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="note note-info margin-bottom-15">
                    <p><div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i> </div>Kategori Sistemi ürün ve listelemede son derece önemlidir. Seo Çalışmalarında kullanılan yöntemler için Doğru bir kategori hayati öneme sahiptir. </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- END MODAL -->

<?php component::end(); ?>
