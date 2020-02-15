<?php component::start($props); ?>
<?php $category_info = component::get_props("category_info"); ?>
<?php $cd = $category_info["category"]; ?>
<?php $button_text = component::get_props("button_text"); ?>
<?php $action = component::get_props("action"); ?>


<div class="modal fade bs-modal-lg" id="category_modal" tabindex="-1" role="basic" aria-hidden="true">
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
                            <span class="caption-subject font-dark sbold uppercase">Yeni Bir Kategori Ekleyin</span>
                            <span class="help-inline"> Yeni Kategoriniz için Ayarlarınızı Girin. </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" data-send="xhr" method="post" data-component_name="category_form" data-action="<?= $action != "" ? $action : "add_new_category" ?>" role="form">
                            <?php
                            if (isset($cd->primary_key)) {
                                $prk = $cd->primary_key;
                                echo '<input type="hidden" name="@category_fields$primary_key" value="' . $cd->$prk . '"/>';
                            }
                            ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 control-label">Kategori Adı</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Başlık Girin" name="@category_fields$category_name" value="<?= $cd->category_name ?>"/>
                                            <span class="help-block"> Kategoriniz için bir başlık. </span>
                                        </div>
                                    </div>

                                </div>
                                <?= component::get_props("category_main_list"); ?> 
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 control-label">Kategori Açıklama</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3" name="@category_fields$category_description" ><?= base64_decode($cd->category_description) ?></textarea>
                                            <span class="help-block"> Kategoriniz ile ilgili bir açıklama oluşturun.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Kategori Anahtar kelimeleri</label>
                                        <div class="col-md-9">
                                            <input type="text" value="<?= $cd->category_keywords ?>" name="@category_fields$category_keywords"  data-role="tagsinput"/>
                                            <span class="help-block"> Kategoriniz için bir anahtar kelime listesi oluşturun.</span> 
                                        </div>
                                    </div>
                                </div>
                                <?= component::get_props("group_fields_list"); ?> 

                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green"><?= $button_text != "" ? $button_text : "Kaydet" ?></button>
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
