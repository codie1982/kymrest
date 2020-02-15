<?php component::start($props); ?>
<?php $product_payment_method_data = component::get_props("product_payment_method_data"); ?>
<?php if (empty($product_payment_method_data)): ?>
    <?php $selected_value = component::get_props("selected_value"); ?>
    <?php
    switch ($selected_value) {
        case"credicart":
            $helper_text = "Kredi Kartı ödeme siparişlerinizde ekleyebileceğiniz extra bedelli belirtebilirsiniz";
            $label = "Kredi Kartı Ödemesi";
            break;
        case"atthedoor":
            $helper_text = "Kapıda Ödeme siparişlerinizde ekleyebieceğiniz extra bedelleri belirtebilirsiniz";
            $label = "Kapıda Ödeme";
            break;
        case"inplace":
            $helper_text = "Yerinde Ödeme siparişlerinizde ekleyebieceğiniz extra bedelleri belirtebilirsiniz";
            $label = "Yerinde Ödeme";
            break;
        case"bank":
            $helper_text = "Banka Havalesi siparişlerinizde ekleyebieceğiniz extra bedelleri belirtebilirsiniz";
            $label = "Banka Havalesi";

            break;
        default :
            $helper_text = "Kredi Kartı ödeme siparişlerinizde ekleyebileceğiniz extra bedelli belirtebilirsiniz";
            $label = "Kredi Kartı Ödemesi";
            break;
    }
    ?>
    <div class="row payment_method_section" data-section_name="<?= $selected_value ?>" style="background: #eee;margin-top:5px;padding-top: 15px;border-top:1px solid #b5b5b5;border-bottom:1px solid #b5b5b5 ">
        <label class="col-md-3 control-label"><strong><?= $label ?></strong></label>
        <?php $rnd = rand(999, 9999); ?>
        <input type="hidden" name="'@product_payment_method_fields$secret_number:<?= $rnd ?>" value="<?= $rnd ?>" />
        <input type="hidden" name="@product_payment_method_fields$payment_method:<?= $rnd ?>" value="<?= $selected_value ?>" />
        <div class="col-md-3">
            <input type="text" class="form-control product_extra_price" placeholder="Miktar Girin" name="@product_payment_method_fields$payment_method_extra_price:<?= $rnd ?>" value="0" />
        </div>
        <div class="col-md-3">
            <select class="form-control product_extra_price_unit" name="@product_payment_method_fields$extra_price_unit:<?= $rnd ?>">
                <option value="---">Birim Seçin </option>
                <option value="tl">TL</option>
                <option value="dl">DOLAR</option>
                <option value="eu">EURO</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-xs btn-danger" data-product_form="remove_payment_method"><span class="fa fa-remove"></span></button>
        </div>
        <div class="col-sm-offset-3 col-sm-9"> <span class="help-block"><?= $helper_text ?></span></div>
    </div>

<?php else : ?>
    <?php foreach ($product_payment_method_data as $data): ?>
        <?php
        switch ($data->payment_method) {
            case"credicart":
                $helper_text = "Kredi Kartı ödeme siparişlerinizde ekleyebileceğiniz extra bedelli belirtebilirsiniz";
                $label = "Kredi Kartı Ödemesi";
                break;
            case"atthedoor":
                $helper_text = "Kapıda Ödeme siparişlerinizde ekleyebieceğiniz extra bedelleri belirtebilirsiniz";
                $label = "Kapıda Ödeme";
                break;
            case"inplace":
                $helper_text = "Yerinde Ödeme siparişlerinizde ekleyebieceğiniz extra bedelleri belirtebilirsiniz";
                $label = "Yerinde Ödeme";
                break;
            case"bank":
                $helper_text = "Banka Havalesi siparişlerinizde ekleyebieceğiniz extra bedelleri belirtebilirsiniz";
                $label = "Banka Havalesi";
                break;
        }
        ?>
        <div class="row payment_method_section" data-section_name="<?= $data->payment_method ?>" style="background: #eee;margin-top:5px;padding-top: 15px;border-top:1px solid #b5b5b5;border-bottom:1px solid #b5b5b5 ">
            <label class="col-md-3 control-label"><strong><?= $label ?></strong></label>
            <?php $rnd = rand(999, 9999); ?>
            <?php $prm = $data->primary_key; ?>
            <?php $key = $data->$prm; ?>
            <input type="hidden" name="'@product_payment_method_fields$secret_number:<?= $rnd ?>" value="<?= $rnd ?>" />
            <?php if (!component::get_props("copy")): ?>
            <input type="hidden" name="'@product_payment_method_fields$primary_key:<?= $rnd ?>" value="<?= $key ?>" />
            <?php endif; ?>
            <input type="hidden" name="@product_payment_method_fields$payment_method:<?= $rnd ?>" value="<?= $selected_value ?>" />
            <div class="col-md-3">
                <input type="text" class="form-control product_extra_price" placeholder="Miktar Girin" name="@product_payment_method_fields$payment_method_extra_price:<?= $rnd ?>" value="<?= $data->payment_method_extra_price ?>" />
            </div>
            <div class="col-md-3">
                <select class="form-control product_extra_price_unit" name="@product_payment_method_fields$extra_price_unit:<?= $rnd ?>">
                    <option value="---" <?= $data->extra_price_unit == NODATA ? "selected" : null ?>>Birim Seçin </option>
                    <option value="tl" <?= $data->extra_price_unit == NODATA ? "tl" : null ?>>TL</option>
                    <option value="dl" <?= $data->extra_price_unit == NODATA ? "dl" : null ?> >DOLAR</option>
                    <option value="eu" <?= $data->extra_price_unit == NODATA ? "eu" : null ?> >EURO</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-xs btn-danger" data-product_form="remove_payment_method" data-key="<?= $key ?>" ><span class="fa fa-remove"></span></button>
            </div>
            <div class="col-sm-offset-3 col-sm-9"> <span class="help-block"><?= $helper_text ?></span></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?php component::end(); ?>
