<?php component::start($props); ?>
<div class="modal fade bs-modal-lg" id="group_fields_modal" tabindex="-1" role="basic" aria-hidden="true">
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
                            <span class="caption-subject font-dark sbold uppercase">Yeni Bir Gruplama Alanı Ekleyin</span>
                            <span class="help-inline"> Gruplama alanlarınız ayarlarınızı girin. </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?= component::get_props("group_fields_form") ?>
                    </div>
                </div>
                <div class="note note-info margin-bottom-15">
                    <div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i></div><p>Gruplama Özellikleri Ürünlerinizi belirli alanlar altında gruplamanıza Olanak Sağlar.Ör. olarak (MARKA,RENK,BOYUT vb.) alanlarda ürünlerinizi gruplayabilri kullanıcı aramalarını kolaylaştırabilirsiniz.  </p>
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
