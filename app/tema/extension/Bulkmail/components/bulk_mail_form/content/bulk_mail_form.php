<?php component::start($props); ?>
<div class="modal fade bs-modal-lg " id="bulk_mail_form" tabindex="-1" role="basic" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="interval_value">Gönderim Aralığı</label>
                            <input type="email" class="form-control" id="interval_value" value="40" placeholder="gönderim aralığını sn olarak girin"/>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-top:25px;">
                        <div class="form-group">
                            <label for="auto_subject">Otomatik Konu Oluştur</label>
                            <input type="checkbox" id="auto_subject" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mail_subject">Gönderim Aralığı</label>
                            <input type="email" class="form-control" id="mail_subject" value="" placeholder="Mail Konusu"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="switch">
                            <input type="checkbox" id="bulkmail_switch" />
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
