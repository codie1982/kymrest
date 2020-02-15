<?php component::start(); ?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?= PROOT ?>admin">Ana Sayfa</a>
            <i class="fa fa-circle"></i>
        </li>
        <?php
        if (isset($url)) {
            if ($url == "") {
                $site_title = "";
            } else {
                if (!empty($url)) {
                    switch ($url) {
                        case "settings":
                            $site_title = "Ayarlar";
                            break;
                        default :
                            $site_title = "";
                            break;
                    }
                }
            }
        } else {
            $site_title = "";
        }
        ?>
        <li><a href="javascript:void(0)"><?= $site_title ?></a></li>

    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Eylemler
                <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="<?= PROOT ?>home" target="_blank"><i class="icon-bell"></i> Siteye Git</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->
<?php component::end("breadcrumb") ?>
