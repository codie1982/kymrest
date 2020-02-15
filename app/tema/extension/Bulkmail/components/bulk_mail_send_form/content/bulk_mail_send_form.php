<?php component::start($props); ?>
<?php $mail_list = component::get_props("mail_components"); ?>

<div class="modal fade bs-modal-lg " id="bulk_mail_send_form" tabindex="-1" role="basic" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="bulk_mail_list">
                            <div class="row">
                                <div class="col-sm-6"><p>Tableda Seçili Kullanıcıar için toplu mail listesi oluşturun</p></div>
                                <div class="col-sm-3 m-t-10">
                                    <select class="form-control" name="" id="bulk_mail_type">
                                        <option value="<?= NODATA ?>">Mail İçeriği seçin</option>
                                        <?php if (!empty($mail_list))  ?>
                                        <?php foreach ($mail_list as $mail): ?>
                                            <option value="<?= $mail["type"] ?>"><?= $mail["title"] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <div class="col-sm-2 m-t-10"><button class="btn btn-info" id="send_bulk_mail"> Gönder</button></div>
                            </div>

                        </div>
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
