<?php component::start($props); ?>
<?php $transport_settings = component::get_props("transport_settings"); ?>
<?php $nproduct_constant = new product_constant(); ?>
<?php //dnd($transport_settings);                                                 ?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Gönderim  Ayarları</span>
                    <span class="help-inline"> Bu Ayarları Mümkün Olduğunca Değiştirmemeye Çalışın. </span>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="transport_settings_form" data-action="update_transport_settings">
                    <?php
                    if (isset($transport_settings->primary_key)) {
                        $prmk = $transport_settings->primary_key;
                        echo '<input type="hidden" name="@settings_transport_fields$primary_key" value="' . $transport_settings->$prmk . '">';
                    }
                    ?>
                    <div class="form-body">
                        <div class="portlet-title margin-bottom-15">
                            <div class="caption">
                                <i class="icon-envelope font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Gönderim Ayarlarınızı Yapılandırın</span>
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Gönderim Ücreti</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Miktar Girin" value="<?= $transport_settings->transport_price ?>"
                                           name="@settings_transport_fields$transport_price"/>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="@settings_transport_fields$transport_price_unit">
                                        <option value="<?= NODATA ?>" <?= $transport_settings->transport_price_unit == NODATA ? "selected" : null ?>>Birim Seçin </option>
                                        <option value="tl" <?= $transport_settings->transport_price_unit == "tl" ? "selected" : null ?>>TL</option>
                                        <option value="dl" <?= $transport_settings->transport_price_unit == "dl" ? "selected" : null ?>>DOLAR</option>
                                        <option value="eu" <?= $transport_settings->transport_price_unit == "eu" ? "selected" : null ?>>EURO</option>
                                    </select>
                                </div>
                                <p class="help-inline">Gönderim Ücretini Belirleyin. Gönderim Ücretini "0" olarak seçerseniz herhangi bir extra bedel de yansıtılmıyacaktır.</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check

                                                   data-transport_settings="transport_type" type="checkbox"
                                                   name="@settings_transport_fields$no_transport"
                                                   value="1"
                                                   <?= $transport_settings->no_transport == 1 ? "checked" : !empty($transport_settings) ? "checked" : null ?>/> Gönderim Yok
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="transport_type" type="checkbox" 
                                                   name="@settings_transport_fields$cargo" 
                                                   value="1" 
                                                   <?= $transport_settings->cargo == 1 ? "checked" : null ?> /> Kargo İle Gönderim
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <input data-check 
                                           type="text" data-transport_settings="cargo_price" class="form-control" placeholder="Miktar Girin" value="<?= $transport_settings->cargo_price ?>"
                                           name="@settings_transport_fields$cargo_price"/>
                                </div>
                                <div class="col-md-1">
                                    <select data-check  
                                            class="form-control" data-transport_settings="cargo_price_unit"
                                            name="@settings_transport_fields$cargo_price_unit">
                                        <option value="<?= NODATA ?>" <?= $transport_settings->cargo_price_unit == NODATA ? "selected" : null ?>>Birim Seçin </option>
                                        <option value="tl" <?= $transport_settings->cargo_price_unit == "tl" ? "selected" : null ?>>TL</option>
                                        <option value="dl" <?= $transport_settings->cargo_price_unit == "dl" ? "selected" : null ?>>DOLAR</option>
                                        <option value="eu" <?= $transport_settings->cargo_price_unit == "eu" ? "selected" : null ?>>EURO</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="cargo_in" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$cargo_in" value="1" <?= $transport_settings->cargo_in == "1" ? "checked" : null ?>/>Dahil
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="cargo_web" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$cargo_web" value="1" <?= $transport_settings->cargo_web == "1" ? "checked" : null ?>/>Web
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="cargo_application" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$cargo_application" value="1" <?= $transport_settings->cargo_application == "1" ? "checked" : null ?>/>App
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 

                                                   data-transport_settings="messenger" type="checkbox" 
                                                   name="@settings_transport_fields$messenger" 
                                                   value="1" 
                                                   <?= $transport_settings->messenger == 1 ? "checked" : null ?> /> Kurye İle Gönderim
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <input data-check 
                                           type="text" data-transport_settings="messenger_price" class="form-control" placeholder="Miktar Girin" value="<?= $transport_settings->messenger_price ?>"
                                           name="@settings_transport_fields$messenger_price"/>
                                </div>
                                <div class="col-md-1">
                                    <select data-check  
                                            class="form-control" data-transport_settings="messenger_price_unit"
                                            name="@settings_transport_fields$messenger_price_unit">
                                        <option value="<?= NODATA ?>" <?= $transport_settings->messenger_price_unit == NODATA ? "selected" : null ?>>Birim Seçin </option>
                                        <option value="tl" <?= $transport_settings->messenger_price_unit == "tl" ? "selected" : null ?>>TL</option>
                                        <option value="dl" <?= $transport_settings->messenger_price_unit == "dl" ? "selected" : null ?>>DOLAR</option>
                                        <option value="eu" <?= $transport_settings->messenger_price_unit == "eu" ? "selected" : null ?>>EURO</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="messenger_in" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$messenger_in" value="1" <?= $transport_settings->messenger_in == "1" ? "checked" : null ?>/>Dahil
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="messenger_web" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$messenger_web" value="1" <?= $transport_settings->messenger_web == "1" ? "checked" : null ?>/>Web
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="messenger_application" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$messenger_application" value="1" <?= $transport_settings->messenger_application == "1" ? "checked" : null ?>/>App
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 

                                                   data-transport_settings="transport_truck" type="checkbox" 
                                                   name="@settings_transport_fields$transport_truck" 
                                                   value="1" 
                                                   <?= $transport_settings->transport_truck == 1 ? "checked" : null ?> /> Nakliye ile Gönderim
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <input data-check 
                                           type="text" data-transport_settings="transport_truck_price" class="form-control" placeholder="Miktar Girin" value="<?= $transport_settings->transport_truck_price ?>"
                                           name="@settings_transport_fields$transport_truck_price"/>
                                </div>
                                <div class="col-md-1">
                                    <select data-check  
                                            class="form-control" data-transport_settings="transport_truck_price_unit"
                                            name="@settings_transport_fields$transport_truck_price_unit">
                                        <option value="<?= NODATA ?>" <?= $transport_settings->transport_truck_price_unit == NODATA ? "selected" : null ?>>Birim Seçin </option>
                                        <option value="tl" <?= $transport_settings->transport_truck_price_unit == "tl" ? "selected" : null ?>>TL</option>
                                        <option value="dl" <?= $transport_settings->transport_truck_price_unit == "dl" ? "selected" : null ?>>DOLAR</option>
                                        <option value="eu" <?= $transport_settings->transport_truck_price_unit == "eu" ? "selected" : null ?>>EURO</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="transport_truck_in" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$transport_truck_in" value="1" <?= $transport_settings->transport_truck_in == "1" ? "checked" : null ?>/>Dahil
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="transport_truck_web" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$transport_truck_web" value="1" <?= $transport_settings->transport_truck_web == "1" ? "checked" : null ?>/>Web
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="transport_truck_application" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$transport_truck_application" value="1" <?= $transport_settings->transport_truck_application == "1" ? "checked" : null ?>/>App
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Gönderim Ücretleri Şekli</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="@settings_transport_fields$transport_price_type">
                                        <option value="<?= NODATA ?>" <?= $transport_settings->transport_price_type == "---" ? "selected" : null ?>>Fonksiyon Seçin </option>
                                        <option value="<?= $nproduct_constant::basket ?>" <?= $transport_settings->transport_price_type == $nproduct_constant::basket ? "selected" : null ?>>Sepet Bazında</option>
                                        <option value="<?= $nproduct_constant::piece ?>" <?= $transport_settings->transport_price_type == $nproduct_constant::piece ? "selected" : null ?>>Adet Bazında</option>
                                        <option value="<?= $nproduct_constant::product ?>" <?= $transport_settings->transport_price_type == $nproduct_constant::product ? "selected" : null ?>>Ürün Bazında</option>
                                    </select> 
                                </div>

                            </div>
                            <div class="row"> 
                                <div class="col-sm-offset-3"> <p class="help-inline">Gönderim Ücreti Bedellerin Hangi şartlar altında etki edeceğini belirtin. Varsayılan olarak ürün bazında seçilidir.</p></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">Gönderim Ücreti Kırılım</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" placeholder="Miktar Girin" value="<?= $transport_settings->transport_anchor_threshold ?>"
                                           name="@settings_transport_fields$transport_anchor_threshold"/>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="@settings_transport_fields$transport_anchor_type">
                                        <option value="---">İndirim Tipi</option>
                                        <option  value="rate" <?= $transport_settings->transport_anchor_type == $nproduct_constant::rate ? "selected" : null ?>>Oran Olarak</option>
                                        <option  value="minute" <?= $transport_settings->transport_anchor_type == $nproduct_constant::minus ? "selected" : null ?>>Miktar Olarak</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="text" class="form-control" placeholder="Oran" value="<?= $transport_settings->transport_anchor_value ?>" name="@settings_transport_fields$transport_anchor_value"/>
                                </div>
                                <p class="help-inline">Kırılım miktarı ile yapılack indirim oranını belirleyin</p>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-offset-3"> <p class="help-inline">Gönderim Ücretleri için kırılım değeri belirleyebilirsiniz. Eşik değeri geçen bedeller için belirli indirimler sağlanabilir. Kampanya modelleri bu hesaplamada önceliklidir. <br />  Eğer Eşik değer sıfır "0" olarak belirlerseniz herhangi bir etki oluşturmaz. <br />  Ekstra bedel hesaplamaları ekstra ücretler fonksiyonuna bağlı çalışır.</p></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mt-checkbox-list">
                                        <label class="mt-checkbox">
                                            <input data-check 
                                                   data-transport_settings="transport_truck_application" type="checkbox" id="checkbox34" class="md-check"
                                                   name="@settings_transport_fields$transport_location_price" value="1" <?= $transport_settings->transport_location_price == "1" ? "checked" : null ?>/>Teslimat Adresine Fiyat Farklılıkları Oluştur
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= component::get_props("transport_adres_block") ?>
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
</div>
<?php component::end(); ?>
