<?php component::start($props); ?>
<div class="form-group product_payment_group">
    <div class="row">
        <label class="col-md-3 control-label">Ürün Ödeme Yöntemi</label>
        <div class="col-md-3">
            <select class="form-control product_payment_select" >
                <option value="<?= NODATA ?>">Ödeme Yöntemi Seçin</option>
                <option value="credicart" >Kredi Kartı</option>
                <option value="atthedoor">Kapıda Ödeme</option>
                <option value="inplace">Yerinde Ödeme</option>
                <option value="bank">Banka Havalesi</option>
            </select>
        </div>
    </div>
    <div class="parent_payment_method">
        <?= $product_payment_group_section = component::get_props("product_payment_group_section_component"); ?>
    </div>

</div>
<?php component::end(); ?>
