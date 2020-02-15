<?php component::start($props); ?>
<?php $slider_data = component::get_props("slider_data"); ?>
<?php //dnd($slider_data);                                                                                           ?>
<?php if (!empty($slider_data)): ?>
    <ul class="list-group">
        <?php foreach ($slider_data as $data): ?>
            <?php $secret_number = rand(9999, 99999); ?>
            <li class="list-group-item" secret_number="<?= $secret_number ?>" style="padding: 5px;">

                <?php
                if (isset($data["primary_key"])) {
                    $prm = $data["primary_key"];
                    $primary_key = $data[$prm];
                    echo '<input type="hidden" name="@application_main_slider$primary_key:' . $secret_number . '" value="' . $primary_key . '" />';
                }
                ?>
                <input type="hidden" value="<?= $secret_number ?>" data-secretnumber="<?= $secret_number ?>" name="@application_main_slider$secret_number:<?= $secret_number ?>" />
                <input type="hidden" value="<?= $data["image_info"]->image_gallery_id ?>" name="@application_main_slider$image_gallery_id:<?= $secret_number ?>" />
                <input type="hidden" value="<?= modules::getModuleList("application_key") ?>" name="@application_main_slider$application_number:<?= $secret_number ?>" />
                <div class="row" style="margin: 0px;padding:0;">
                    <div class="col-sm-2">
                        <a data-fancybox="gallery" href="<?= get_image($data["image_info"]) //Orjinal Resim  ?>">
                            <img src="<?= get_image($data["image_info"], 100) ?>" alt="slider_images"/>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-radio-inline">
                            <label class="mt-radio">
                                <input class="check_search_type" type="radio" name="@application_main_slider$screen_type:<?= $secret_number ?>" secret_number="<?= $secret_number ?>" value="no" <?= $data["screen_type"] == "no" ? "checked" : $data["screen"] == "" ? "checked" : null ?>/> Yönlendirme Yok
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input class="check_search_type" type="radio" name="@application_main_slider$screen_type:<?= $secret_number ?>" secret_number="<?= $secret_number ?>" value="category" <?= $data["screen_type"] == "category" ? "checked" : null ?>/> Kategori Yönlendirmesi
                                <span></span>
                            </label>
                            <label class="mt-radio">
                                <input class="check_search_type" type="radio" name="@application_main_slider$screen_type:<?= $secret_number ?>" secret_number="<?= $secret_number ?>" value="product" <?= $data["screen_type"] == "product" ? "checked" : null ?>/> Ürün Yönlendirmesi
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="set_screen" >
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="search_category" data-search_type="category" secret_number="<?= $secret_number ?>" style="display: block;">
                                        <select class="form-control" data-searchbox="category" secret_number="<?= $secret_number ?>"></select>
                                    </div>
                                    <div class="search_product" data-search_type="product" secret_number="<?= $secret_number ?>" style="display: none;">
                                        <select class="form-control" data-searchbox="product" secret_number="<?= $secret_number ?>" ></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php
                                    if ($data["screen_type"] == "category") {
                                        $id = $data["screen"];
                                        $ncategory = new table_category();
                                        $ncategory->select();
                                        $ncategory->add_condition("category_id", $id);
                                        $category_data = $ncategory->get_alldata(true);
                                        $screen_name = $category_data->category_name;
                                    } elseif ($data["screen_type"] == "product") {
                                        $id = $data["screen"];
                                        $nproduct = new table_product();
                                        $nproduct->select();
                                        $nproduct->add_condition("product_id", $id);
                                        $product_data = $nproduct->get_alldata(true);
                                        $screen_name = $product_data->product_name;
                                    }
                                    ?>
                                    <div class="selected_screen"><p>Seçili Yönlendirme Ekranı : <strong><?= ucfirst($screen_name) ?></strong></p></div>
                                    <p>Yönlendirme ekranını yeniden yarlamak için arama çubuğundan yeni bir arama yapın.</p>
                                </div>
                            </div>
                        </div>
                        <div class="screen" secret_number="<?= $secret_number ?>">
                            <?php if ($data["screen"] != ""): ?>
                                <input type="hidden" name="@application_main_slider$screen_type:<?= $secret_number ?>" value="<?= $data["screen_type"] ?>" />
                                <input type="hidden" name="@application_main_slider$screen:<?= $secret_number ?>" value="<?= $data["screen"] ?>" />
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-1"><button class="btn btn-xs btn-circle btn-danger" secret_number="<?= $secret_number ?>"  <?= isset($data["primary_key"]) ? 'key="' . $primary_key . '"' : "" ?>  remove-listitem >Sil</button></div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>


<?php else: ?>
    <div class="row">
        <div class="col-sm-12">Slider için herhangi bir resim yüklenmemiş. Resim eklemek için resim ekle butonundan açılan pencereden 4 adet resim yükleyebilirsiniz.</div>
    </div>
<?php endif; ?>

<?php component::end(); ?>
