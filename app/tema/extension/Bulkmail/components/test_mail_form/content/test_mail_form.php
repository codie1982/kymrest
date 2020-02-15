<?php component::start(); ?>
<?php $mail_list = component::get_props("mail_components") ?>
<div class="modal fade bs-modal-lg " id="test_mail_form" tabindex="-1" role="basic" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Mail Adresi</label>
                            <input type="email" class="form-control" id="test_mail_adres" value="engin_erol@hotmail.com" placeholder="test mail göndermek istediğiniz mail adresini yazınız"/>
                        </div>
                    </div>
                    <div class="col-sm-3 m-t-10">
                        <div class="form-group">
                            <label for="bulk_mail_type">Mail İçeriği</label>
                            <select class="form-control" id="test_mail_subjet">
                                <option value="<?= NODATA ?>">Mail İçeriği seçin</option>
                                <?php if (!empty($mail_list))  ?>
                                <?php foreach ($mail_list as $mail): ?>
                                    <option value="<?= $mail["type"] ?>"><?= $mail["title"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 m-t-10" style="margin-top:25px;">
                        <button class="btn btn-info btn-block" id="send_test_mail">Gönder</button>
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
