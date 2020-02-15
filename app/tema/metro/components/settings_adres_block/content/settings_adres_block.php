<?php component::start(); ?>
<?php $adres_info = component::get_props("adres_info"); ?>
<div data-section="adres">
    <div class="form-group">
        <div class="row margin-bottom-10">
            <div class="col-sm-3">
                <button type="none" class="btn btn-circle red btn-outline" data-adres="add">Adres Ekle</button>
            </div>
        </div>
        <div class="adres_content">
            <?php
            $template = [];
            if (!empty($adres_info)) {
                foreach ($adres_info as $data) {
                    $col = [];
                    $row = [];
                    $prk = $data->primary_key;
                    $nadres = new table_adres();
                    $dslist = $nadres->getdistrictlist($data->province);
                    $jdslist = json_encode($dslist);
                    $nblist = $nadres->getneighborhoodlist($data->province, $data->district);
                    $nbsmlist = $nadres->getneighborhoodSmtlist($data->province, $data->district);
                    $jnblist = json_encode($nblist);
                    $jnbsmlist = json_encode($nbsmlist);


                    $col[] = [
                        "content" => [
                            "type" => "primary_key",
                            "control_class" => "settings_general_adres_fields",
                            "primary_id" => $data->$prk,
                        ]
                    ];
                    $col[] = [
                        "content" => [
                            "type" => "secret_number",
                            "control_class" => "settings_general_adres_fields",
                        ]
                    ];

                    $col[] = [
                        "col" => ["1"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "İl",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "province",
                            "control_class" => "settings_general_adres_fields",
                            "action" => "province",
                            "selected_value" => $data->province,
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "settings_adres_block",
                                "data-type" => "province",
                            ]
                        ]
                    ];
                    $col[] = [
                        "col" => ["1"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "İlçe",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "district",
                            "control_class" => "settings_general_adres_fields",
                            "action" => "district",
                            "selected_value" => $data->district,
                            "district_list" => base64_encode($jdslist),
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "settings_adres_block",
                                "data-type" => "district",
                            ]
                        ]
                    ];
                    $col[] = [
                        "col" => ["1"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Mahalle",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "neighborhood",
                            "control_class" => "settings_general_adres_fields",
                            "action" => "neighborhood",
                            "selected_value" => $data->neighborhood,
                            "neighborhood_list" => base64_encode($jnblist),
                            "neighborhood_semtlist" => base64_encode($jnbsmlist),
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "settings_adres_block",
                                "data-type" => "neighborhood",
                            ]
                        ]
                    ];
                    $col[] = [
                        "col" => ["1"],
                        "content" => [
                            "type" => "removeButton",
                            "key" => $data->$prk,
                        ]
                    ];
                    $row[] = $col;
                    $template[] = $row;
                }
                echo '<input type="hidden" data-settings_adres_block data-json="' . base64_encode(json_encode($template)) . '"/>';
            }
            $template = [];
            $col = [];
            $row = [];
            $col[] = [
                "col" => ["1"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "İl",
                    "attributes" => ["class" => "form-label"],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "province",
                    "control_class" => "settings_general_adres_fields",
                    "action" => "province",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "settings_adres_block",
                        "data-type" => "province",
                    ]
                ]
            ];
            $col[] = [
                "col" => ["1"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "İlçe",
                    "attributes" => ["class" => "form-label"],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "district",
                    "control_class" => "settings_general_adres_fields",
                    "action" => "district",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "settings_adres_block",
                        "data-type" => "district",
                    ]
                ]
            ];
            $col[] = [
                "col" => ["1"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Mahalle",
                    "attributes" => ["class" => "form-label"],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "neighborhood",
                    "control_class" => "settings_general_adres_fields",
                    "action" => "neighborhood",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "settings_adres_block",
                        "data-type" => "neighborhood",
                    ]
                ]
            ];
            $col[] = [
                "col" => ["1"],
                "content" => [
                    "type" => "removeButton",
                    "key" => $data->$prk,
                ]
            ];
            $row[] = $col;
            $resettemplate[] = $row;
            echo '<input type="hidden" reset-settings_adres_block data-json="' . base64_encode(json_encode($resettemplate)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
