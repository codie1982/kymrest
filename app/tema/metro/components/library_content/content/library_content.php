<?php component::start($props); ?>
<?php $gallery_data = component::get_props("gallery_data") ?>
<?php $total_gallery_data = component::get_props("total_gallery_data") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="actions">
                    <div class="clearfix">  
                        <div class="btn-group">
                            <label class="btn btn-default library_filter">
                                <input type="checkbox" data-media="all_media" style="opacity: 0"/> Tümünü Seç ( <?= count($gallery_data) ?> ) </label>
                            <label class="btn btn-default library_filter">
                                <input type="checkbox" data-media="break_all_media" style="opacity: 0"/> Tümünü Bırak </label>
                            <label class="btn btn-default library_filter">
                                <input type="checkbox" data-media="no_media" style="opacity: 0"/> Ulaşılamayanları Seç </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="library">
            <div class="library-list">
                <?php if (!empty($gallery_data)): ?>
                    <ul class="">
                        <?php foreach ($gallery_data as $data): ?>
                            <?php
                            if ($media_path = get_image($data)) {
                                ?>  
                                <?php $rand = rand(0, 3) ?>
                                <?php $media = ["image", "video", "audio", "document"] ?>
                                <li data-media_type="<?= $data->media_type ?>" data-image_gallery_id="<?= $data->image_gallery_id ?>">
                                    <a data-fancybox="gallery" href="<?= get_image($data) //Orjinal Resim          ?>">
                                        <?php
                                        $thb = get_closest_image($data, 250);
                                        if (!$thb) {
                                            $thb = noimage();
                                        }
                                        ?>
                                        <img src="<?= $thb //Thumbnail Resim           ?>"/>
                                    </a>
                                    <span class="select-box" ><i class="fa fa-check" aria-hidden="true"></i></span>
                                </li>
                                <?php
                            } else {
                                ?>
                                <?php $rand = rand(0, 3) ?>
                                <?php $media = ["image", "video", "audio", "document"] ?>
                                <li data-media_type="<?= $data->media_type ?>" data-filter="no_media" data-image_gallery_id="<?= $data->image_gallery_id ?>">
                                    <a>
                                        <img src="<?= noimage() ?>"/>
                                    </a>
                                    <span class="select-box" ><i class="fa fa-check" aria-hidden="true"></i></span>
                                </li>
                                <?php
                            }
                            ?>
                        <?php endforeach; ?>
                        <?php //exit();  ?>

                    </ul>
                <?php else: ?>
                    <div class="row"><div class="col-sm-12">Kütüphanenizde Hiç Medya Dosyası Bulunmamaktadır.</div></div>
                <?php endif; ?>
            </div>
            <div class="library-description-section">
                <div class="desription">
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-block btn-xs btn-danger" data-media="remove_selected">Seçili Olanları Sil</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (component::get_props("page_count") != "all" && component::get_props("page_count") != 0): ?>
            <div class="row">
                <div class="col-sm-10">
                    <div class="btn-toolbar margin-top-10 margin-bottom-10" library-pagination >
                        <?php
                        $total_gallery_data = component::get_props("total_gallery_data");
                        $start = component::get_props("start");
                        $end = component::get_props("end");
                        $page_count = component::get_props("page_count");
                        $page_number = component::get_props("page_number");

                        $pagination = ceil($total_gallery_data / $page_count);
                        ?>
                        <?php for ($i = 0; $i < $pagination; $i++): ?>
                            <?php ($i + 1 == $page_number) ? $select = "select" : $select = ""; ?>
                            <?php if ($total_gallery_data / $page_count > 12): ?>
                                <?php if ($i < 6 || $i > (($total_gallery_data / $page_count) - 6)): ?>
                                    <div class="btn-group"><button type="button" class="btn btn-default library-pagination-page-button <?= $select ?>" library-page_number="<?= $i ?>"   library-start="<?= $i * $page_count ?>" library-end="<?= ($i + 1) * $page_count ?>"><?= $i + 1 ?></button></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="btn-group"><button type="button" class="btn btn-default library-pagination-page-button <?= $select ?>" library-page_number="<?= $i ?>"   library-start="<?= $i * $page_count ?>" library-end="<?= ($i + 1) * $page_count ?>"><?= $i + 1 ?></button></div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php if ($total_gallery_data >= 6): ?>
                    <div class="col-sm-1">
                        <select name="" class="form-control" id="">
                            <option value="<?= NODATA ?>"><?= "Sayfa No" ?></option>
                            <?php for ($i = 0; $i < $pagination; $i++): ?>
                                <option value="<?= $i + 1 ?>"><?= $i + 1 ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php component::end(); ?>
