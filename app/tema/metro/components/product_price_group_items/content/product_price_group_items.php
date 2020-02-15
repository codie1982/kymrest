<?php component::start($props); ?>
<?php $product_data = component::get_props("product_data"); ?>
<?php $product_price_option_data = component::get_props("product_price_option_data"); ?>
<?php
if (component::isset_probs("addul")) {
// dnd("UL Ekle");
//$addul = component::get_props("addul");
    $addul = false;
} else {
// dnd("UL Ekleme");
    $addul = true;
}
?>
<ul  class="price_group_list_item">
    <li>
        <div class="row">
            <div class="col-sm-2"><input type="text" class="form-control" placeholder="Başlık" name=""/></div>
            <div class="col-sm-2"><select name="" class="form-control" id=""><option value="">Arttırım</option><option value="">Azaltım</option></select></div>
            <div class="col-sm-2"><select name="" class="form-control" id=""><option value="">Miktar</option><option value="">Oran</option></select></div>
            <div class="col-sm-2"><input type="text" class="form-control" placeholder="Değer" value="0" name=""/></div>
            <div class="col-sm-2"><select name="" class="form-control" id=""><option value="">Seçili</option><option value="">Seçili Değil</option></select></div>
            <div class="col-sm-1"><button class="btn btn-danger" title="Alanı Kaldır"><span class="fa fa-trash"></span></button></div>
        </div>
    </li>
</ul>


<?php component::end(); ?>
