<?php component::start(); ?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="false" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->

            <?php
            //TODO :: PERFORMANS PROBLEMM!!!
            // $menu_items = modules::getModuleList("menu_item");
            $nsidebar = new table_sidebar_menu();
            $sidebarInfo = $nsidebar->select();
            if ($menu_items = $nsidebar->get_alldata()) {
                // dnd($menu_items);
//            $ncustomer_permission = new table_customer_tag();
//            $ncustomer_permission->select("tag");
//            $ncustomer_permission->add_condition("customer_id", session::get(CURRENT_USER_SESSION_NAME));
//            $customer_permission = $ncustomer_permission->get_alldata();
                foreach ($menu_items as $menu_item) {
                    ?>
                    <?php
                    if (isset($menu_item->link)):
                        $controller = $menu_item->link;
                        $menuurl = explode("/", $menu_item->link);
                        $module_list = router::get_module_info();
                        $module = router::get_module_controller($module_list, $menuurl);

//                    dnd($module_list);
                        //dnd($module_controller);
//                    dnd($controller);
//                    dnd("SIDE BAR");
//                    if (class_exists($controller)) { }
                        $user_permission = data::get_user_permission();
                        if (modules::modulesAuthorizations($module["permission"], $user_permission)) {
                            ?>
                            <li class="nav-item start ">
                                <?php $menu_link = isset($menu_item->sub_item) ? 'javascript:;' : ltrim(rtrim($menu_item->link, "/"), "/") ?>
                                <?php $toggle_class = isset($menu_item->sub_item) ? 'nav-toggle' : null ?> 
                                <a href="<?= PROOT ?><?= $menu_link ?>" <?= $menu_item->disabled ? "disabled" : null ?> class="nav-link <?= $toggle_class ?>">
                                    <i class="<?= $menu_item->icon ?>"></i>
                                    <span class="title"><?= $menu_item->menu_title ?></span>
                                    <?php if (isset($menu_item->sub_item)): ?>
                                        <?= '<span class="arrow"></span>' ?>
                                    </a>
                                    <ul class="sub-menu">
                                        <?php foreach ($menu_item->sub_item as $item): ?>
                                            <?php
                                            $menuurl = explode("/", $item->link);

                                            $module_list = router::get_module_info();
                                            $module_controller = router::get_module_controller($module_list, $menuurl);
                                            $controller = $module_controller["controller"];
                                            $cls = new $controller($controller, null);
                                            if ($cls->controller_authorizations()):
                                                ?>
                                                <li class="nav-item">
                                                    <a href="<?= PROOT ?><?= ltrim(rtrim($item->link, "/"), "/") ?>" class="nav-link ">
                                                        <span class="title"><?= $item->menu_title ?></span> 
                                                    </a>
                                                </li>
                                                <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if (!isset($menu_item->sub_item)): ?>
                                    </a>
                                <?php endif; ?>

                            </li>
                            <?php
                        } else {
                            if (isset($menu_item->sub_item)) {
                                ?>
                                <li class="nav-item start ">
                                    <?php $menu_link = isset($menu_item->sub_item) ? 'javascript:;' : ltrim(rtrim($menu_item->link, "/"), "/") ?>
                                    <?php $toggle_class = isset($menu_item->sub_item) ? 'nav-toggle' : null ?> 
                                    <a href="<?= PROOT ?><?= $menu_link ?>" <?= $menu_item->disabled ? "disabled" : null ?> class="nav-link <?= $toggle_class ?>">
                                        <i class="<?= $menu_item->icon ?>"></i>
                                        <span class="title"><?= $menu_item->menu_title ?></span>
                                        <?php if (isset($menu_item->sub_item)): ?>
                                            <?= '<span class="arrow"></span>' ?>
                                        </a>
                                        <ul class="sub-menu">
                                            <?php foreach ($menu_item->sub_item as $item): ?>
                                                <?php
                                                $menuurl = explode("/", $item->link);

                                                $module_list = router::get_module_info();
                                                $module_controller = router::get_module_controller($module_list, $menuurl);
                                                $controller = $module_controller["controller"];
                                                $cls = new $controller(null, null);
                                                //dnd($controller);
                                                $cls->set_controller($controller);
                                                if ($cls->controller_user_authorizations($customer_permission)):
                                                    ?>
                                                    <li class="nav-item">
                                                        <a href="<?= PROOT ?><?= ltrim(rtrim($item->link, "/"), "/") ?>" class="nav-link ">
                                                            <span class="title"><?= $item->menu_title ?></span> 
                                                        </a>
                                                    </li>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!isset($menu_item->sub_item)): ?>
                                        </a>
                                    <?php endif; ?>

                                </li>
                                <?php
                            }
                        }
                        ?>
                    <?php elseif (isset($menu_item->head)): ?>
                        <li class="heading">
                            <h3 class="uppercase"><?= $menu_item->head ?></h3>
                        </li>
                        <?php
                    endif;
                    ?>
                    <?php
                }
            }
            ?>


            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->

        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
<?php component::end() ?>
