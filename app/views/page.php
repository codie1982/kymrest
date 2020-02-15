<?php //(dnd(tema::get_tema()));        ?>



<html lang="tr">
    <head>
        <?php $this->make_meta_link(tema::get_tema("meta")); ?>
        <?php $this->make_font(tema::get_tema("font")); ?>
        <?php $this->make_css_link(tema::get_tema("css")); ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <?php ($this->screenOn(tema::get_tema("html"))); ?>
        <?php ($this->make_javascript_link(tema::get_tema("js"))); ?>
    </body>
</html> 