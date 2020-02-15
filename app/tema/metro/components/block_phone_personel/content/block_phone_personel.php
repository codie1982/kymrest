<?php component::start(); ?>
<?php $customer_phone_data = component::get_props("customer_phone_data"); ?>
<?php //dnd($customer_phone_data);                                          ?>
<div data-section="phone">
    <div class="form-group">
        <div class="row margin-bottom-10">
            <div class="col-sm-3">
                <button type="none" class="btn btn-circle red btn-outline" data-max="10" data-phone="add">Telefon Numarası Ekle</button>
            </div>
        </div>
        <div class="phone_content">
            <?php
            if (!empty($customer_phone_data)) {
                 $template = [];
                foreach ($customer_phone_data as $data) {
                    $prk = $data->primary_key;
                    $col = [];
                    $row = [];
                   
                     if (component::isset_probs("customer_id")) {
                        $col[] = [
                            "col" => ["12"],
                            "content" =>
                            [
                                "type" => "input",
                                "control_class" => "customer_phone_fields",
                                "action" => "customer_id",
                                "attributes" => [
                                    "type" => "hidden",
                                    "value" => component::get_props("customer_id"),
                                ],
                            ]
                        ]; // kullanıcı Tipi 
                    }
                    $col[] = [
                        "content" => [
                            "type" => "primary_key",
                            "control_class" => "customer_adres_fields",
                            "primary_id" => $data->$prk,
                        ]
                    ];
                    $col[] = [
                        "content" => [
                            "type" => "secret_number",
                            "control_class" => "customer_adres_fields",
                        ]
                    ];  //secret_number
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Telefon Numarası",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // Telefon Numarası - label

                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "select",
                            "control_class" => "customer_phone_fields",
                            "action" => "phone_type",
                            "datatype" => "phone_type",
                            "options" => [
                                [
                                    "text" => "Telefon Cinsi",
                                    "attributes" => ["value" => NODATA, "!" => $data->phone_type == NODATA ? "selected" : null]
                                ],
                                [
                                    "text" => "Cep Telefonu",
                                    "attributes" => ["value" => "cell", "!" => $data->phone_type == "cell" ? "selected" : null]
                                ],
                                [
                                    "text" => "Sabit Telefon",
                                    "attributes" => ["value" => "land", "!" => $data->phone_type == "land" ? "selected" : null]
                                ],
                                [
                                    "text" => "Fax",
                                    "attributes" => ["value" => "fax", "!" => $data->phone_type == "fax" ? "selected" : null]
                                ]
                            ],
                            "attributes" => [
                                "class" => "form-control",
                            ]
                        ]
                    ]; // Telefon Cinsi 
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "phone_block",
                            "control_class" => "customer_phone_fields",
                            "action" => "area_code",
                            "selected_value" => $data->area_code,
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "block_phone_personel",
                                "data-type" => "area_code",
                            ]
                        ]
                    ]; // Alan Kodu 
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_phone_fields",
                            "action" => "phone_number",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_phone_personel",
                                "value" => $data->phone_number,
                                "placeholder" => "telefon numarası",
                                "data-type" => "phone_number",
                            ],
                        ]
                    ]; // Telefon Numarası 

                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "checkbox",
                            "control_class" => "customer_phone_fields",
                            "action" => "confirm",
                            "check" => [
                                "text" => "Onayla",
                                "attributes" => [
                                    "class" => "md-check",
                                    "value" => "1",
                                    "data-type" => "confirm",
                                    "!" => $data->confirm == "1" ? "checked" : null
                                ]
                            ],
                            "attributes" => [
                                "class" => "mt-checkbox-list",
                            ],
                        ]
                    ]; // Telefon Onayı
                    $col[] = [
                        "col" => ["1"],
                        "content" => [
                            "type" => "removeButton",
                            "key" => $data->$prk,
                        ]
                    ];

                    $row[] = $col;

                    $template[] = $row;

                    echo '<input type="hidden" data-block_phone_personel data-json="' . base64_encode(json_encode($template)) . '"/>';
                }
            }


            $col = [];
            $row = [];
            $resettemplate = [];
             if (component::isset_probs("customer_id")) {
                        $col[] = [
                            "col" => ["12"],
                            "content" =>
                            [
                                "type" => "input",
                                "control_class" => "customer_phone_fields",
                                "action" => "customer_id",
                                "attributes" => [
                                    "type" => "hidden",
                                    "value" => component::get_props("customer_id"),
                                ],
                            ]
                        ]; // kullanıcı Tipi 
                    }
            $col[] = [
                "content" => [
                    "type" => "secret_number",
                    "control_class" => "customer_phone_fields",
                ]
            ];  //secret_number
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Telefon Numarası",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // Telefon Numarası - label

            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "select",
                    "control_class" => "customer_phone_fields",
                    "action" => "phone_type",
                    "datatype" => "phone_type",
                    "options" => [
                        [
                            "text" => "Telefon Cinsi",
                            "attributes" => ["value" => "---"]
                        ],
                        [
                            "text" => "Cep Telefonu",
                            "attributes" => ["value" => "cell"]
                        ],
                        [
                            "text" => "Sabit Telefon",
                            "attributes" => ["value" => "land"]
                        ],
                        [
                            "text" => "Fax",
                            "attributes" => ["value" => "fax"]
                        ]
                    ],
                    "attributes" => [
                        "class" => "form-control",
                    ]
                ]
            ]; // Telefon Cinsi 
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "phone_block",
                    "control_class" => "customer_phone_fields",
                    "action" => "area_code",
                    "selected_value" => "",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "block_phone_personel",
                        "data-type" => "area_code",
                    ]
                ]
            ]; // Alan Kodu 
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_phone_fields",
                    "action" => "phone_number",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_phone_personel",
                        "value" => "",
                        "placeholder" => "telefon numarası",
                        "data-type" => "phone_number",
                    ],
                ]
            ]; // Telefon Onayı 

            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "checkbox",
                    "control_class" => "customer_phone_fields",
                    "action" => "confirm",
                    "check" => [
                        "text" => "Onayla",
                        "attributes" => [
                            "class" => "md-check",
                            "value" => "1",
                            "data-type" => "confirm",
                        ]
                    ],
                    "attributes" => [
                        "class" => "mt-checkbox-list",
                    ],
                ]
            ]; // checkbox
            $col[] = [
                "col" => ["1"],
                "content" => [
                    "type" => "removeButton",
                ]
            ];

            $row[] = $col;

            $resettemplate[] = $row;

            echo '<input type="hidden" reset-block_phone_personel data-json="' . base64_encode(json_encode($resettemplate)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
