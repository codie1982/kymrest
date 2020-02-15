<?php component::start($props); ?>
<?php $total_gallery_data = component::get_props("total_gallery_data") ?>
<?php $view = component::get_props("view") ?>
<?php $start = component::get_props("start") ?>
<?php $end = component::get_props("end") ?>
<?php $page_count = component::get_props("page_count") ?>
<?php $image_type = component::get_props("image_type") ?>
<?php $selected_date = component::get_props("selected_date") ?>
<div class="row">
    <div class="col-sm-12">
        <div class="library-header portlet">
            <div class="library-view-list">
                <ul class="">
                    <li <?= $view == "image" ? 'class="select"' : null ?> class="select" data-view_type="image"><span class="fa fa-list fa-2x"></span></li>
                    <li <?= $view == "table" ? 'class="select"' : null ?> data-view_type="table" ><span class="fa fa-table fa-2x"></span></li>
                </ul>
            </div>
            <div class="library-type-list">
                <ul class="">
                    <li <?= $image_type == "all" ? 'class="select"' : null ?>  data-media_type="all" ><span>Hepsi</span></li>
                    <li <?= $image_type == "all" ? 'class="select"' : $image_type == "image" ? 'class="select"' : null ?> data-media_type="image"><span>Resimler</span></li>
                    <li <?= $image_type == "all" ? 'class="select"' : $image_type == "image" ? 'class="select"' : null ?> data-media_type="video"><span>Videolar</span></li>
                    <li <?= $image_type == "all" ? 'class="select"' : $image_type == "image" ? 'class="select"' : null ?> data-media_type="audio"><span>Sesler</span></li>
                    <li <?= $image_type == "all" ? 'class="select"' : $image_type == "image" ? 'class="select"' : null ?> data-media_type="document"><span>Dökümanlar</span></li>
                </ul>
            </div>
            <div class="library-count-select">
                <input type="count" class="form-control" id="library-count" value="<?= $page_count ?>" />
            </div>
            <div class="library-date-select">
                <select name="" class="form-control" id="library-select">
                    <option value="all"     <?= $selected_date == "all" ? 'selected' : null ?>>Tüm Zamanlar</option>
                    <option value="today"   <?= $selected_date == "today" ? 'selected' : null ?>>Bugün</option>
                    <option value="yesterday" <?= $selected_date == "yesterday" ? 'selected' : null ?>>Dün</option>
                    <option value="last7"   <?= $selected_date == "last7" ? 'selected' : null ?>>Son 7 Gün</option>
                    <option value="last14"  <?= $selected_date == "last14" ? 'selected' : null ?>>Son 14 Gün</option>
                    <option value="last30"  <?= $selected_date == "last30" ? 'selected' : null ?>>Son 30 Gün</option>
                    <option value="last60"  <?= $selected_date == "last60" ? 'selected' : null ?>>Son 60 Gün</option>
                    <option value="last90"  <?= $selected_date == "last90" ? 'selected' : null ?>>Son 90 Gün</option>
                </select>
            </div>
            <div class="library-load-button">
                <button class="btn btn-block btn-info" data-media="reload">Yükle</button>
            </div>


        </div>
    </div>
</div>
<?php component::end(); ?>
