<?php component::start(); ?>
<?php $customer_email_data = component::get_props("customer_mail_data"); ?>
<div data-section="email">
    <div class="form-group">
        <div class="row margin-bottom-10">
            <div class="col-sm-3">
                <button type="none" class="btn btn-circle red btn-outline" data-email="add">Email Ekle</button>
            </div>
        </div>
        <div class="email_content">
            <?php
            $template = [];
            if (!empty($customer_email_data)) {
                foreach ($customer_email_data as $data) {
                    $prk = $data->primary_key;
                    $col = [];
                    $row = [];
                   
                    if (component::isset_probs("customer_id")) {
                        $col[] = [
                            "col" => ["12"],
                            "content" =>
                            [
                                "type" => "input",
                                "control_class" => "customer_mail_fields",
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
                            "control_class" => "customer_mail_fields",
                            "primary_id" => $data->$prk,
                        ]
                    ];
                    $col[] = [
                        "content" => [
                            "type" => "secret_number",
                            "control_class" => "customer_mail_fields",
                        ]
                    ];
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Email Adresleri",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // email Adresleri Label
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_mail_fields",
                            "action" => "customer_mail",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_email_personel",
                                "value" => $data->customer_mail,
                                "placeholder" => "Kullandığınız email adresi",
                                "data-type" => "customer_mail",
                            ],
                        ]
                    ]; // email Adresleri - adres_title

                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "checkbox",
                            "control_class" => "customer_mail_fields",
                            "action" => "confirm",
                            "check" => [
                                "text" => "Mail Onayı",
                                "attributes" => [
                                    "class" => "md-check",
                                    "value" => "1",
                                    "data-type" => "confirm",
                                    "!" => $data->confirm == 1 ? "checked" : null,
                                ]
                            ],
                            "attributes" => [
                                "class" => "mt-checkbox-list",
                            ],
                        ]
                    ]; // checkbox


                    /* Birinci Satır * ********************************************************************************* */
                    $col[] = [
                        "col" => ["1"],
                        "content" => [
                            "type" => "removeButton",
                            "key" => $data->$prk,
                        ]
                    ];  // Kaldır Butonu



                    $row[] = $col;
                    $template[] = $row;
                    echo '<input type="hidden" data-block_email_personel data-json="' . base64_encode(json_encode($template)) . '"/>';
                }
            }
            $rtemplate = [];

            $col = [];
            $row = [];
            if (component::isset_probs("customer_id")) {
                $col[] = [
                    "col" => ["12"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "customer_mail_fields",
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
                    "control_class" => "customer_mail_fields",
                ]
            ];
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Email Adresleri",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // email Adresleri Label
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_mail_fields",
                    "action" => "customer_mail",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_email_personel",
                        "value" => "",
                        "placeholder" => "Kullandığınız email adresi",
                        "data-type" => "customer_mail",
                    ],
                ]
            ]; // email Adresleri - adres_title

            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "checkbox",
                    "control_class" => "customer_mail_fields",
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
            ];  // Kaldır Butonu

            /* Birinci Satır * ********************************************************************************* */



            $row[] = $col;
            $rtemplate[] = $row;
            echo '<input type="hidden" reset-block_email_personel data-json="' . base64_encode(json_encode($rtemplate)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
