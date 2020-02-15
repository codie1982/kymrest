<?php component::start($props); ?>
<?php $site_info = component::get_props("site_info"); ?>
<?php $site_logo_info = component::get_props("site_logo_info"); ?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Tema Genel Ayarlarınız</span>
                    <span class="help-inline"> Bu Ayarlar temanız için varsayılan ve genel ayarlardır. </span>
                </div>
            </div>
            <div class="row margin-bottom-15">
                <div class="col-md-12">
                    <?= $sitelogo = component::get_props("site_logo"); ?>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="grnt_settings_form" data-action="update_tema_settings">
                    <?php $prm = $site_info->primary_key ?>
                    <input type="hidden" name="@settings_grnt_fields$primary_key" value="<?= $site_info->$prm ?>" />
                    <div class="form-group">
                        <div class="row">
                            <label for="exampleInputFile" class="col-md-3 control-label">Site Logonuz</label>
                            <div class="col-md-9">
                                <div id="site_logo_output">
                                    <!--images_info[i].image_gallery_id-->
                                    <?php if ($site_info->image_gallery_id == "" || $site_info->image_gallery_id == 0): ?>
                                        <p>Siteniz için bir logo yükleyin</p>
                                    <?php else: ?>
                                        <!--//images_info[i].image_relative_path + images_info[i].first_image_name + "_ORJ." + images_info[i].extention-->
                                        <?php $imgsource = $site_logo_info->image_relative_path . $site_logo_info->first_image_name . "_100" . DOT . $site_logo_info->extention ?>
                                        <input class="image_gallery_id" type="hidden" name="@settings_grnt_fields$image_gallery_id" value="<?= $site_logo_info->image_gallery_id ?>" />
                                        <img class="img-responsive img-thumbnail" width="150"src="<?= PROOT ?><?= $imgsource ?>" alt="product_gallery_image"/>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Site Başlık</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="<?= $site_info->site_title ?>" name="@settings_grnt_fields$site_title" placeholder="Başlık Girin" maxlength="225" id="site_title"/> 
                                    <span class="help-block"> Sitenizin Başlığı. </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Site Açıklama</label>
                                <div class="col-md-9">
                                    <textarea id="summernote" class="form-control"  name="@settings_grnt_fields$site_description" rows="3"  maxlength="455" id="site_description"><?= base64_decode(html_entity_decode($site_info->site_description)) ?></textarea>
                                    <span class="help-block"> Siteniz ile ilgili meta açıklama olarak 70-455 karakterlik bir açıklama giriniz. </span> 
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Site Adresini Giriniz.</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="@settings_grnt_fields$site_url_protocol" >
                                        <option value="<?= NODATA ?>">Protokol </option>
                                        <option <?= $site_info->site_url_protocol == "http" ? "selected" : null ?> value="http">http://</option>
                                        <option  <?= $site_info->site_url_protocol == "https" ? "selected" : null ?> value="https">https://</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-inline input-medium">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-link"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="URL" name="@settings_grnt_fields$site_url" maxlength="255" value="<?= $site_info->site_url ?>" id="site_url"/> </div>
                                    </div>
                                    <span class="help-inline"> www.siteadresiniz.com </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-3">Site Anahtar Kelimeler</label>
                                <div class="col-md-9">
                                    <input type="text" value="<?= $site_info->site_keywords ?>" name="@settings_grnt_fields$site_keywords" data-role="tagsinput"/> 
                                </div>
                            </div>
                        </div>
                        <div class="portlet-title margin-bottom-15">
                            <div class="caption">
                                <i class="icon-envelope font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Site İletişim Bilgileriniz</span>
                                <span class="help-inline"> Sitenize Ait İletişim Bilgileri. </span>
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Site iletişim mail adresi</label>
                                <div class="col-md-7">
                                    <div class="input-inline input-medium">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope-o"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Mail Adresiniz" value="<?= $site_info->site_mail ?>" name="@settings_grnt_fields$site_mail" maxlength="45" id="site_email"/> </div>
                                    </div>
                                    <span class="help-inline"> info@siteadresi.com </span>
                                </div>
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
    <!-- END SAMPLE FORM PORTLET-->
</div>
<?php component::end(); ?>
