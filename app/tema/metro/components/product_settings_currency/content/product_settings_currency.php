<?php component::start($props); ?>
<?php $product_settings = component::get_props("product_settings"); ?>
<?php $currency_data = component::get_props("currency_data"); ?>
<div class="portlet-title margin-bottom-15">
    <div class="caption">
        <i class="icon-envelope font-dark"></i>
        <span class="caption-subject font-dark sbold uppercase">Para Birimi Ayarlarınız</span>
    </div> 
</div>
<div class="form-group">
    <div class="row">
        <label class="col-md-3 control-label">Varsayılan Para Birimi</label>
        <div class="col-md-2">
            <select class="form-control" name="@settings_product_fields$product_default_currency">
                <option value="---" <?= $product_settings->product_default_currency == "---" ? "selected" : null ?>>Para Birimi </option>
                <?php foreach ($currency_data as $dt): ?>
                    <option value="<?= $dt->product_currency_type ?>" <?= $product_settings->product_default_currency == $dt->product_currency_type ? "selected" : null ?>><?= $dt->title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <p class="help-inline">Alışverişlerinizde kullanılan Para Birimi <br />Tüm hesaplamalar varsayılan para birimine dönüştürülerek hesaplanır</p>
    </div>
    <div class="row"> 
        <div class="col-sm-offset-3"> <p class="help-inline">Varsayılan para birimi. Ürün fiyatlandırmasında son fiyatının hangi döviz cinsi üzerinden hesaplanacağını belirlememizi sağlar.</p></div>
    </div>
</div>
<div data-settings="currency_section">
    <?php
    if (!empty($currency_data))
        foreach ($currency_data as $cr) {
            $prm = $cr->primary_key;
            if ($cr->product_currency_type != $product_settings->product_default_currency):
                $rnd = rand(9999, 99999);
                ?>

                <input type="hidden" name="@settings_general_currency_fields$secret_key:<?= $rnd ?>" value="<?= $rnd ?>" />
                <input type="hidden" name="@settings_general_currency_fields$primary_key:<?= $rnd ?>" value="<?= $cr->$prm ?>" />
                <div class="form-group" data-currency="<?= $cr->product_currency_type ?>">
                    <div class="row">
                        <label class="col-md-3 control-label"><?= $cr->title ?></label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Döviz Kuru Ekleyin" data-settings="number_mask"  name="@settings_general_currency_fields$<?= $cr->product_currency_type ?>:<?= $rnd ?>" value="<?= $cr->product_currency_price ?>"/>
                            <p class="help-inline"><?= $cr->title ?> için bir Döviz Kuru Belirleyin (.)</p>
                        </div>
                        <div class="col-sm-1"><?= strtoupper($product_settings->product_default_currency) ?></div>
                        <div class="col-sm-3"><button  class="btn btn-circle btn-info " disabled > Merkez Bankası ile Güncelle</button> </div>
                    </div>
                </div>
                <?php
            endif;
        }
    ?>

</div>
<?php component::end(); ?>
