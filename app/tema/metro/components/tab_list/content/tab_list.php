<?php component::start(); ?>
<!-- Begin: life time stats -->
<?php $tab_section = component::get_props("tab_section"); ?>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-blue"></i>
            <span class="caption-subject font-blue bold uppercase">Genel İstatislikler</span>
            <span class="caption-helper">Genel Raporlar...</span>
        </div>

    </div>
    <div class="portlet-body">
        <div class="tabbable-line">
            <ul class="nav nav-tabs">
                <?php
                $i = 0;
                foreach ($tab_section as $section) {
                    $i++;
                    $active = $i == 1 ? "active" : null;
                    echo '<li class="' . $active . '"><a href="#tb' . $i . '" data-toggle="tab"> ' . $section["tab_name"] . ' </a></li>';
                }
                ?>
                <!--                <li class="active"><a href="#tab_complete_order" data-toggle="tab"> Tamamlanan Satışlar </a></li>
                                <li><a href="#tab_waiting_order" data-toggle="tab"> Sepette Bekleyenler </a></li>
                                <li><a href="#tab_returned_order" data-toggle="tab"> İade Alınanlar </a></li>
                                <li><a href="#tab_tranport_order" data-toggle="tab"> Kargo Sürecinde </a></li>-->
            </ul>
            <div class="tab-content">
                <?php
                $i = 0;
                foreach ($tab_section as $section) {
                    $i++;
                    $active = $i == 1 ? "active" : null;
                    echo '<div class="tab-pane ' . $active . '" id="tb' . $i . '" >' . $section["tab_content"] . ' </div>';
                }
                ?>

                <!--                <div class="tab-pane" id="tab_waiting_order"><div id="waiting_order"></div></div>
                                <div class="tab-pane" id="tab_returned_order"><div id="returned_order"></div></div>
                                <div class="tab-pane" id="tab_tranport_order"><div id="tranport_order"></div></div>-->
            </div>
        </div>
    </div>
</div>
<!-- End: life time stats -->
<?php component::end("tab_list") ?>
