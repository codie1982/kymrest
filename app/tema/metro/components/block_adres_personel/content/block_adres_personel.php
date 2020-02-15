<?php component::start(); ?>
<?php $customer_adres_data = component::get_props("customer_adres_data"); ?>
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
            if (!empty($customer_adres_data)) {
                foreach ($customer_adres_data as $data) {
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
                    $col = [];
                    $row = [];
                    
                    if (component::isset_probs("customer_id")) {
                        $col[] = [
                            "col" => ["12"],
                            "content" =>
                            [
                                "type" => "input",
                                "control_class" => "customer_adres_fields",
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
                    ];
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Adres Başlığı",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // Adres Başılığı Label
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_adres_fields",
                            "action" => "adres_title",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_adres_personel",
                                "value" => $data->adres_title,
                                "placeholder" => "Adres Başlığınızı yazın Ör.Ev Adresi",
                                "data-type" => "adres_title",
                            ],
                        ]
                    ]; // Adres Başılığı - adres_title
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "checkbox",
                            "control_class" => "customer_adres_fields",
                            "action" => "delivery_adres",
                            "check" => [
                                "text" => "Teslimat Adresi",
                                "attributes" => [
                                    "class" => "md-check",
                                    "value" => "1",
                                    "data-type" => "delivery_adres",
                                    "!" => $data->delivery_adres == 1 ? "checked" : null,
                                ],
                            ],
                            "attributes" => [
                                "class" => "mt-checkbox-list",
                            ],
                        ]
                    ]; // Teslimat Adresi - delivery_adres
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "checkbox",
                            "control_class" => "customer_adres_fields",
                            "action" => "shipping_adres",
                            "check" => [
                                "text" => "Fatura Adresi",
                                "attributes" => [
                                    "id" => "checkbox34",
                                    "class" => "md-check",
                                    "value" => "1",
                                    "data-type" => "shipping_adres",
                                    "!" => $data->shipping_adres == 1 ? "checked" : null,
                                ],
                            ],
                            "attributes" => [
                                "class" => "mt-checkbox-list",
                            ],
                        ]
                    ]; // Fatura Adresi- shipping_adres
                    $col[] = [
                        "col" => ["1"],
                        "content" => [
                            "type" => "removeButton",
                            "key" => $data->$prk
                        ]
                    ];  // Kaldır Butonu
                    $row[] = $col;
                    $col = [];
                    /* Birinci Satır * ********************************************************************************* */


                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "İl/ilçe/mah.",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // İl İlçe Mahalle Label
                    $row[] = $col;
                    /* İkinci Satır * ********************************************************************************* */
                    $col = [];
                    $col[] = ["col" => ["1"], "content" => ["type" => "offset"]];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "province",
                            "control_class" => "customer_adres_fields",
                            "action" => "province",
                            "selected_value" => $data->province,
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "block_adres_personel",
                                "data-type" => "province",
                            ]
                        ]
                    ];  // İl
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "district",
                            "control_class" => "customer_adres_fields",
                            "action" => "district",
                            "selected_value" => $data->district,
                            "district_list" => base64_encode($jdslist),
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "block_adres_personel",
                                "data-type" => "district",
                            ]
                        ]
                    ];  // İlçe
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "neighborhood",
                            "control_class" => "customer_adres_fields",
                            "action" => "neighborhood",
                            "selected_value" => $data->neighborhood,
                            "neighborhood_list" => base64_encode($jnblist),
                            "neighborhood_semtlist" => base64_encode($jnbsmlist),
                            "attributes" => [
                                "class" => "form-control",
                                "data-component_name" => "block_adres_personel",
                                "data-type" => "neighborhood",
                            ]
                        ]
                    ];  // Mahalle
                    $col[] = [
                        "col" => ["1"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "PK/SK",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];   // PK/SK Label
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_adres_fields",
                            "action" => "mail_code",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_adres_personel",
                                "value" => $data->mail_code,
                                "placeholder" => "Posta Kodu",
                                "data-type" => "mail_code",
                            ],
                        ]
                    ];  // Posta Kodu
                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_adres_fields",
                            "action" => "street",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_adres_personel",
                                "value" => $data->street,
                                "placeholder" => "Sokak Numarası",
                                "data-type" => "street",
                            ],
                        ]
                    ];  // Sokak Numarası
                    $row[] = $col;
                    $col = [];
                    /* Ücüncü Satır * ********************************************************************************* */
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Adres Tarifi",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ]; // Adres Tarifi Label
                    $col[] = [
                        "col" => ["8"],
                        "content" =>
                        [
                            "type" => "textarea",
                            "control_class" => "customer_adres_fields",
                            "action" => "description",
                            "text" => $data->description,
                            "attributes" => [
                                "class" => "form-control",
                                "rows" => "3", "cols" => "50",
                                "data-component_name" => "block_adres_personel",
                                "data-type" => "description",
                            ],
                        ]
                    ]; // Adres Tarifi
                    $row[] = $col;
                    $template[] = $row;
                    echo '<input type="hidden" data-block_adres_personel data-json="' . base64_encode(json_encode($template)) . '"/>';
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
                                "control_class" => "customer_adres_fields",
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
                    "control_class" => "customer_adres_fields",
                ]
            ];
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Adres Başlığı",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // Adres Başılığı Label
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_adres_fields",
                    "action" => "adres_title",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_adres_personel",
                        "value" => "",
                        "placeholder" => "Adres Başlığınızı yazın Ör.Ev Adresi",
                        "data-type" => "adres_title",
                    ],
                ]
            ]; // Adres Başılığı - adres_title
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "checkbox",
                    "control_class" => "customer_adres_fields",
                    "action" => "delivery_adres",
                    "check" => [
                        "text" => "Teslimat Adresi",
                        "attributes" => [
                            "class" => "md-check",
                            "value" => "1",
                            "data-type" => "delivery_adres",
                        ],
                    ],
                    "attributes" => [
                        "class" => "mt-checkbox-list",
                    ],
                ]
            ]; // Teslimat Adresi - delivery_adres
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "checkbox",
                    "control_class" => "customer_adres_fields",
                    "action" => "tax_number",
                    "check" => [
                        "text" => "Fatura Adresi",
                        "attributes" => [
                            "id" => "checkbox34",
                            "class" => "md-check",
                            "value" => "1",
                            "data-type" => "tax_number",
                        ],
                    ],
                    "attributes" => [
                        "class" => "mt-checkbox-list",
                    ],
                ]
            ]; // Fatura Adresi- shipping_adres
            $col[] = [
                "col" => ["1"],
                "content" => [
                    "type" => "removeButton",
                ]
            ];  // Kaldır Butonu
            $row[] = $col;
            $col = [];
            /* Birinci Satır * ********************************************************************************* */


            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "İl/ilçe/mah.",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // İl İlçe Mahalle Label
            $row[] = $col;
            /* İkinci Satır * ********************************************************************************* */
            $col = [];
            $col[] = ["col" => ["1"], "content" => ["type" => "offset"]];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "province",
                    "control_class" => "customer_adres_fields",
                    "action" => "province",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "block_adres_personel",
                        "data-type" => "province",
                    ]
                ]
            ];  // İl
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "district",
                    "control_class" => "customer_adres_fields",
                    "action" => "district",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "block_adres_personel",
                        "data-type" => "district",
                    ]
                ]
            ];  // İlçe
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "neighborhood",
                    "control_class" => "customer_adres_fields",
                    "action" => "neighborhood",
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "block_adres_personel",
                        "data-type" => "neighborhood",
                    ]
                ]
            ];  // Mahalle
            $col[] = [
                "col" => ["1"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "PK/SK",
                    "attributes" => ["class" => "form-label"],
                ]
            ];   // PK/SK Label
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_adres_fields",
                    "action" => "mail_code",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_adres_personel",
                        "value" => "",
                        "placeholder" => "Posta Kodu",
                        "data-type" => "mail_code",
                    ],
                ]
            ];  // Posta Kodu
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_adres_fields",
                    "action" => "street",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_adres_personel",
                        "value" => "",
                        "placeholder" => "Sokak Numarası",
                        "data-type" => "street",
                    ],
                ]
            ];  // Sokak Numarası
            $row[] = $col;
            $col = [];
            /* Ücüncü Satır * ********************************************************************************* */
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Adres Tarifi",
                    "attributes" => ["class" => "form-label"],
                ]
            ]; // Adres Tarifi Label
            $col[] = [
                "col" => ["8"],
                "content" =>
                [
                    "type" => "textarea",
                    "control_class" => "customer_adres_fields",
                    "action" => "description",
                    "text" => "Adres Tarifi",
                    "attributes" => [
                        "class" => "form-control",
                        "rows" => "3", "cols" => "50",
                        "data-component_name" => "block_adres_personel",
                        "data-type" => "description",
                    ],
                ]
            ]; // Adres Tarifi
            $row[] = $col;
            $resettemplate[] = $row;

            echo '<input type="hidden" reset-block_adres_personel data-json="' . base64_encode(json_encode($resettemplate)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
