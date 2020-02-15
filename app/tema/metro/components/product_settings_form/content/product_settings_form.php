<?php component::start($props); ?>
<?php $product_settings = component::get_props("product_settings"); ?>
<?php $nproduct_constant = new product_constant(); ?>
<?php //dnd($product_settings);         ?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Ürün Ayarları</span>
                    <span class="help-inline"> Bu Ayarları Mümkün Olduğunca Değiştirmemeye Çalışın. </span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="product_settings_form" data-action="update_product_settings">
                    <?php if (!empty($product_settings)): ?>
                        <?php $prm = $product_settings->primary_key ?>
                        <input type="hidden" name="@settings_product_fields$primary_key" value="<?= $product_settings->$prm ?>" />
                    <?php endif; ?>

                    <div class="form-body">
                        <div class="portlet-title margin-bottom-15">
                            <div class="caption">
                                <i class="icon-envelope font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Ürün Ayarlarınızı Yapılandırın</span>
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Ürün Alt Başlık</label>
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list" style="margin-top: 8px;">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" id="checkbox29" class="md-check" value="1" name="@settings_product_fields$product_sub_title" <?= $product_settings->product_sub_title == 1 ? "checked" : null ?>/>Ürün Alt Başlık Ekle
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-offset-3"> <p class="help-inline">Ürün Alt Başlıkları Opsiyoneldir. <br />Ürünlerinizin alt başlıları MetaTag lar arasında ürün açıklama alanında gözterilir.</p></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Ürün Kodu</label>
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list" style="margin-top: 8px;">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" id="checkbox29" class="md-check" value="1" <?= $product_settings->product_code == 1 ? "checked" : null ?> name="@settings_product_fields$product_code"/>Ürün Kodu Ekleyin
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-offset-3"> <p class="help-inline">Ürün Kodu Opsiyoneldir.Ürün Kodu Ürünleriniz için eşsiz olmasına dikat etmelisiniz.<br /> Eğer ürün kodu eklenmiyorsa ürünler için gizli bir ürün kodu otomatik olarak oluşturulur.</p></div>
                            </div>
                        </div>
                        <input type="hidden" value="1"  name="@settings_product_fields$product_cost_price"/>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Ücretlendirme Şekli</label>
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list" style="margin-top: 8px;">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" id="checkbox29" class="md-check" value="1" <?= $product_settings->product_flat_price == 1 ? "checked" : null ?>  name="@settings_product_fields$product_flat_price"/>Sabit Fiyat
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list" style="margin-top: 8px;">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" id="checkbox29" class="md-check" value="1" <?= $product_settings->product_options_price == 1 ? "checked" : null ?>  name="@settings_product_fields$product_options_price"/>Seçenekli Fiyat
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-offset-3"> <p class="help-inline">Ürün Fiyatları Çeşitlendirilbilir.<br /> Eğer ürün fiyatları için herhangi bir seçenek girilmez ise varsayılan olarak sabit fiyat ilişkilendirilir.</p></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Ürün Satış Hesaplama Noktası</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="@settings_product_fields$product_sales_anchor">
                                        <option value="---">Bir Nokta Seçin</option>
                                        <option value="<?= $nproduct_constant::sales_anchor_product ?>" <?= $product_settings->product_sales_anchor == $nproduct_constant::sales_anchor_product ? "selected" : null ?>>Ürün Fiyatı Üzerinden</option>
                                        <option value="<?= $nproduct_constant::sales_anchor_pieces ?>" <?= $product_settings->product_sales_anchor == $nproduct_constant::sales_anchor_pieces ? "selected" : null ?>>Adet Fiyatı Üzerinden</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Ürün Satış Kırılım</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" value="<?= $product_settings->product_sales_threshold ?>" placeholder="Miktar Girin" name="@settings_product_fields$product_sales_threshold"/>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="@settings_product_fields$product_sales_threshold_type">
                                        <option value="<?= NODATA ?>">İndirim Tipi</option>
                                        <option value="rate" <?= $product_settings->product_sales_threshold_type == "rate" ? "selected" : null ?>>Oran Olarak</option>
                                        <option value="minus" <?= $product_settings->product_sales_threshold_type == "minus" ? "selected" : null ?>>Değer Olarak</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" 
                                           placeholder="Değer" 
                                           value="<?= $product_settings->product_sales_threshold_amount ?>" 
                                           name="@settings_product_fields$product_sales_threshold_amount"/>
                                </div>
                                <p class="help-inline">Kırılım miktarı ile yapılack indirim oranını belirleyin</p>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-offset-3"> <p class="help-inline">Ürün kırılım miktarları O ürünlerde belirli bir miktar üzerinde 2.eyemlerin olmasını sağlar. <br />Eşik değeri aşan ürün fiyatları için belirli indirimler oluşturabilirsiniz.Kırılım değerinin sıfır "0" girilmesi kırılım miktarını önemsiz kılar.</p></div>
                            </div>
                        </div>
                        <hr />
                        <?= component::get_props("product_settings_currency_component"); ?> 
                        <hr />

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-3">Ürün Birimleri</label>
                                <div class="col-md-6">
                                    <input type="text" value="<?= $product_settings->product_unit_list == "---" ? null : $product_settings->product_unit_list ?>" name="@settings_product_fields$product_unit_list" data-role="tagsinput" /> 
                                </div>
                                <div class="row">
                                    <div class="col-sm-offset-3"> <p class="help-inline">Ürünlerde kullanılabilen birimleri eklememizi sağlar.(Adet,m,tane,kilo).
                                            <br />birimlerinizi aralarına virgül koyarak eklemelisiniz.</p></div>
                                </div>
                            </div>
                        </div>
                        
                        <?php // component::get_props("product_settings_extra_price_component"); ?> 
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green" name="settings" value="1">Ürün Ayarlarını Güncelle</button>
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
