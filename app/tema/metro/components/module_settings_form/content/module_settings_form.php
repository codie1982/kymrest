<?php component::start($props); ?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Modul  Ayarları</span>
                    <span class="help-inline"> Sisteminizdeki module.js dosyasının ve sitenizin genel ayarlarını burada görebilirsiniz. </span>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="module_settings_form" data-action="update_module_settings">
                    <div class="">



                        <?php
                        $module_list = modules::getModuleList();
                        // dnd($module_list);
                        $tabs = [];
                        $template = [];
                        $btntemplate = [];
                        $row = [];
                        $col = [];

//                        $col[] = [
//                            "content" =>
//                            [
//                                "type" => "div",
//                                "text" => "",
//                                "attributes" => ["class" => "col-sm-10"],
//                            ]
//                        ];  //   Label
//                        $col[] = [
//                            "content" =>
//                            [
//                                "type" => "div",
//                                "html" => html::addbutton(["class" => "btn btn-xs btn-danger", "data-module" => "addkey"], "Anahtar Ekle"),
//                                "attributes" => [
//                                    "class" => "col-sm-2",
//                                ],
//                            ]
//                        ]; // input
//                        $row[] = $col;

                        foreach ($module_list as $key => $value) {
                            if (is_object($value) || is_array($value)) {
                                if (is_object($value)) {
                                    $tabs[] = $key;
//                                    dnd($key);




                                    $objtemplate = [];

                                    $objrow = [];
                                    $objcol = [];

//                                    $objcol[] = ["content" => ["type" => "div", "html" => "", "attributes" => ["class" => "col-sm-9"]]];  //   Label
//                                    $objcol[] = ["content" => ["type" => "div", "html" => html::addbutton(["class" => "btn btn-xs btn-danger"], "Modul Ekle"), "attributes" => ["class" => "col-sm-3"]]];  //   Label
//                                    $objrow[] = $objcol;
//                                    $objcol = [];
                                    foreach ($value as $objkey => $obj) {
                                        if (!is_object($objkey)) {

                                            $objcol = [];
                                            $mdltt = [];
                                            $module_title = "";
                                            $mdltt[] = ["9,9,9,9" => ["html" => html::addinput(["value" => $objkey, 'name="' . $key . '[key][]"' => $objkey])]];
                                            $mdltt[] = ["3,3,3,3" => ["html" => html::addbutton(["class" => "btn btn-xs btn-danger"], "Modulu Kaldır")]];
                                            $module_title .= html::addrow($mdltt);

                                            $objcol[] = ["content" => ["type" => "div", "html" => $objkey, "attributes" => ["class" => "col-sm-2"]]];  // module router   Label
//                                            $objrow[] = $objcol;
//                                            $objcol = [];
                                            $module_content = "";
                                            foreach ($obj as $okey => $objparam) {
                                                $expk = [];
                                                if (!empty($objparam)) {
                                                    $ocol = [];
                                                    if (is_object($objparam)) {
                                                        $excoltit = [];
                                                        $excoltit[] = ["3,3,3,3" => ["html" => $okey, "attr" => ["style" => "border-bottom:1px solid"]]];
                                                        $extention_title = html::addrow($excoltit);
                                                        $extention_content = "";
                                                        foreach ($objparam as $exnm => $exvl) {
                                                            $excol = [];
                                                            $excol[] = ["3,3,3,3" => ["html" => $exnm]];
                                                            $excol[] = ["6,6,6,6" => ["html" => html::addinput(["disabled" => "disabled", "value" => $exvl, "class" => "form-control"], null, "text")]];
                                                            $extention_content .= html::addrow($excol);
                                                        }
                                                        $ocol[] = ["12,12,12,12" => ["html" => $extention_title . $extention_content]];
                                                    } else {
                                                        $ocol[] = ["3,3,3,3" => ["html" => html::addspan([""], "<strong>$okey</strong>")]];
                                                        $ocol[] = ["6,6,6,6" => ["html" => html::addinput(["disabled" => "disabled", "value" => $objparam, "class" => "form-control"], null, "text")]];
                                                    }
                                                    $module_content .= html::addrow($ocol);
                                                } else {
                                                    $module_content .= html::addrow([["12,12,12,12" => ["html" => "Modul Detayları Bulunmamakta"]]]);
                                                }
                                            }
                                            $objcol[] = ["content" => ["type" => "div", "html" => html::add_div(["style" => "margin:5px;padding:5px;"], $module_content), "attributes" => ["class" => "col-sm-9"]]]; // input
                                            $objrow[] = $objcol;
                                        }
                                    }
                                    $objtemplate [] = $objrow;
                                    echo '<input type="hidden" data-modules module_name="' . $key . '"  data-json="' . base64_encode(json_encode($objtemplate)) . '"/>';
                                }
                            } else {
                                $col = [];

                                $col[] = [
                                    "col" => ["3"],
                                    "content" =>
                                    [
                                        "type" => "label",
                                        "text" => $key,
                                        "attributes" => ["class" => "form-label"],
                                    ]
                                ];  //   Label
                                $col[] = [
                                    "content" =>
                                    [
                                        "type" => "div",
                                        "html" => html::addinput(["class" => "form-control", "value" => "$value", "disabled" => "disabled"]),
                                        "attributes" => [
                                            "class" => "col-sm-3",
                                        ],
                                    ]
                                ]; // input
                                $row[] = $col;
                            }
                        }
                        $template[] = $row;
                        echo '<input type="hidden" data-module_general_settings data-json="' . base64_encode(json_encode($template)) . '"/>';
                        ?>

                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-social-dribbble font-purple-soft"></i>
                                <span class="caption-subject font-purple-soft bold uppercase">Modul Ayarları</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#general" data-toggle="tab"> Genel Ayarlar </a>
                                </li>
                                <?php
                                foreach ($tabs as $tab)
                                    echo '<li><a href="#' . $tab . '" data-toggle="tab"> ' . $tab . ' </a></li>';
                                ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in " id="general">
                                    <div class="module_form_general_settings"></div>
                                </div>
                                <?php
                                foreach ($tabs as $tab) {
                                    echo '<div class="tab-pane fade" id="' . $tab . '"> <div class="' . $tab . '"></div></div>';
                                }
                                ?>
                            </div>
                            <div class="clearfix margin-bottom-20"> </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green" name="settings" value="1">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php component::end(); ?>
