<?php component::start(); ?>
<?php $phone_info = component::get_props("phone_info"); ?>
<div data-section="phone">
    <div class="form-group">
        <div class="row margin-bottom-10">
            <div class="col-sm-3">
                <button type="none" class="btn btn-circle red btn-outline" data-phone="add">Telefon Numarası Ekle</button>
            </div>
        </div>
        <div class="phone_content">
            <?php
            
            if (!empty($phone_info)) {
                foreach ($phone_info as $data) {
                    $prk = $data->primary_key;
                    $col[] = [
                        "content" => [
                            "type" => "primary_key",
                            "control_class" => "settings_general_phone_fields",
                            "primary_id" => $data->$prk,
                        ]
                    ];
                    $col[] = [
                        "content" => [
                            "type" => "secret_number",
                            "control_class" => "settings_general_phone_fields",
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Telefon Numarası",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "select",
                            "control_class" => "settings_general_phone_fields",
                            "action" => "phone_type",
                            "datatype" => "phone_type",
                            "options" => [
                                [
                                    "text" => "Telefon Tipini Seçiniz",
                                    "attributes" => [
                                        "value" => "---",
                                    ]
                                ],
                                [
                                    "text" => "Cep Telefonu",
                                    "attributes" => [
                                        "value" => "cell",
                                        "!" => $data->phone_type == "cell" ? "selected" : "",
                                    ]
                                ],
                                [
                                    "text" => "Sabit Telefon",
                                    "attributes" => [
                                        "value" => "land",
                                        "!" => $data->phone_type == "land" ? "selected" : "",
                                    ]
                                ],
                                [
                                    "text" => "Fax Telefon",
                                    "attributes" => [
                                        "value" => "fax",
                                        "!" => $data->phone_type == "fax" ? "selected" : "",
                                    ]
                                ]
                            ],
                            "attributes" => [
                                "class" => "form-control",
                            ]
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "phone_block",
                            "control_class" => "settings_general_phone_fields",
                            "action" => "area_code",
                            "selected_value" => $data->area_code,
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "settings_phone_block",
                                "data-type" => "area_code",
                            ]
                        ]
                    ];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "input",
                            "control_class" => "settings_general_phone_fields",
                            "action" => "phone_number",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "value" => $data->phone_number,
                                "placeholder" => "Telefon Numaranızı Giriniz",
                                "data-type" => "phone_number",
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


                echo '<input type="hidden" data-settings_phone_block data-json="' . base64_encode(json_encode($template)) . '"/>';
            }
            $col = [];
            $row = [];
            $template = [];

            $col[] = [
                "content" => [
                    "type" => "secret_number",
                    "control_class" => "settings_general_phone_fields",
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Telefon Numarası",
                    "attributes" => ["class" => "form-label"],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "select",
                    "control_class" => "settings_general_phone_fields",
                    "action" => "phone_type",
                    "datatype" => "phone_type",
                    "options" => [
                        [
                            "text" => "Telefon Tipini Seçiniz",
                            "attributes" => [
                                "value" => "---",
                            ]
                        ],
                        [
                            "text" => "Cep Telefonu",
                            "attributes" => [
                                "value" => "cell",
                            ]
                        ],
                        [
                            "text" => "Sabit Telefon",
                            "attributes" => [
                                "value" => "land",
                            ]
                        ],
                        [
                            "text" => "Fax Telefon",
                            "attributes" => [
                                "value" => "fax",
                            ]
                        ]
                    ],
                    "attributes" => [
                        "class" => "form-control",
                    ]
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "phone_block",
                    "control_class" => "settings_general_phone_fields",
                    "action" => "area_code",
                    "selected_value" => $data->area_code,
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "settings_phone_block",
                        "data-type" => "area_code",
                    ]
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "input",
                    "control_class" => "settings_general_phone_fields",
                    "action" => "phone_number",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "value" => 0,
                        "placeholder" => "Telefon Numaranızı Giriniz",
                        "data-type" => "phone_number",
                    ]
                ]
            ];
            $col[] = [
                "col" => ["1"],
                "content" => [
                    "type" => "removeButton",
                ]
            ];
            $row[] = $col;
            $template[] = $row;

            echo '<input type="hidden" reset-settings_phone_block data-json="' . base64_encode(json_encode($template)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
