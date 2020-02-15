<?php component::start($props); ?>
<?php $data = component::get_props("customer_settings_data"); ?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Kullanıcı Ayarları</span>
                    <span class="help-inline"> Bu Ayarları Mümkün Olduğunca Değiştirmemeye Çalışın. </span>
                </div>
            </div>

            <div class="portlet-body form">
                <form class="form-horizontal" data-send="xhr" method="post" data-component_name="user_settings_form" data-action="update_user_settings">

                    <div class="form-body">
                        <div class="portlet-title margin-bottom-15">
                            <div class="caption">
                                <i class="icon-envelope font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">Kullanıcı Ayarlarınızı Yapılandırın</span>
                            </div> 
                        </div>


                        <div class="settings_customer_form">

                            <?php
                            $template = [];
                            $row = [];
                            $col = [];

                            if (!empty($data)) {
                                $prk = $data->primary_key;
                                $col[] = [
                                    "content" => [
                                        "type" => "primary_key",
                                        "control_class" => "settings_customer_fields",
                                        "primary_id" => $data->$prk,
                                    ]
                                ];
                            }

                            $col[] = [
                                "col" => ["3"],
                                "content" =>
                                [
                                    "type" => "label",
                                    "text" => "Kullanıcı Etiketleri",
                                    "attributes" => ["class" => "form-label"],
                                ]
                            ];  //   Label

                            $col[] = [
                                "col" => ["9"],
                                "content" =>
                                [
                                    "type" => "input",
                                    "control_class" => "settings_customer_fields",
                                    "action" => "customer_tag",
                                    "attributes" => [
                                        "id" => "customer",
                                        "class" => "form-control",
                                        "type" => "text",
                                        "data-component_name" => "user_settings_form",
                                        "value" => $data->customer_tag == null ? "" : $data->customer_tag,
                                    ],
                                ]
                            ]; // input
                            $row[] = $col;
                            $col = [];
                            if (in_array("supermen", data::get_user_permission())) {
                                $col[] = [
                                    "col" => ["3"],
                                    "content" =>
                                    [
                                        "type" => "label",
                                        "text" => "Supermen Etiketleri",
                                        "attributes" => ["class" => "form-label"],
                                    ]
                                ];  //   Label
                                $col[] = [
                                    "col" => ["9"],
                                    "content" =>
                                    [
                                        "type" => "input",
                                        "control_class" => "settings_customer_fields",
                                        "action" => "supermen_tag",
                                        "attributes" => [
                                            "id" => "supermen",
                                            "class" => "form-control",
                                            "data-component_name" => "user_settings_form",
                                            "type" => "text",
                                            "value" => $data->supermen_tag == null ? "" : $data->supermen_tag,
                                        ],
                                    ]
                                ]; // input
                                $row[] = $col;
                                $col = [];
                            }

                            $template[] = $row;
                            echo '<input type="hidden" data-user_settings_form data-json="' . base64_encode(json_encode($template)) . '"/>';
                            ?>


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
