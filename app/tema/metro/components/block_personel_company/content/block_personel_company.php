<?php component::start(); ?>
<?php $customer_personel_data = component::get_props("customer_personel_data"); ?>
<?php $customer_constant = new customer_constant(); ?>

<div data-section="personel">
    <div class="row margin-bottom-10">
        <div class="col-sm-3">
            <button type="none" class="btn btn-circle red btn-outline" data-personel="add">Personel Ekle</button>
        </div>
    </div>
    <div class="personel_content">

        <?php
        $template = [];

        if (!empty($customer_personel_data)) {
            foreach ($customer_personel_data as $data) {
                $col = [];
                $row = [];
                $prk = $data->primary_key;
                 if (component::isset_probs("customer_id")) {
                        $col[] = [
                            "col" => ["12"],
                            "content" =>
                            [
                                "type" => "input",
                                "control_class" => "customer_personals_fields",
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
                        "control_class" => "customer_personals_fields",
                        "primary_id" => $data->$prk,
                    ]
                ];
                $col[] = [
                    "content" => [
                        "type" => "secret_number",
                        "control_class" => "customer_personals_fields",
                    ]
                ];
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Adı",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Adı Label
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "customer_personals_fields",
                        "action" => "name",
                        "attributes" => [
                            "class" => "form-control",
                            "type" => "text",
                            "data-component_name" => "customer_personel_form",
                            "value" => $data->name == null ? "" : $data->name,
                            "placeholder" => "Adını Yazınız",
                            "data-type" => "name",
                        ],
                    ]
                ]; // Adı - adres_title
                $col[] = [
                    "col" => ["1"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "SoyAdı",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Soy Adı  Label
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "customer_personals_fields",
                        "action" => "lastname",
                        "attributes" => [
                            "class" => "form-control",
                            "type" => "text",
                            "data-component_name" => "customer_personel_form",
                            "value" => $data->lastname == null ? "" : $data->lastname,
                            "placeholder" => "Soyadını Yazınız",
                            "data-type" => "lastname",
                        ],
                    ]
                ]; // Soy Adı - adres_title
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
                        "text" => "Cinsiyeti",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Cinsiyeti  Label
                $col[] = [
                    "col" => ["6"],
                    "content" =>
                    [
                        "type" => "radiobox",
                        "control_class" => "customer_personals_fields",
                        "action" => "gender",
                        "radio" => [
                            [
                                "text" => "Kadın",
                                "attributes" => [
                                    "class" => "mt-radio",
                                    "value" => "2",
                                    "data-type" => "gender",
                                    "!" => $data->gender == $customer_constant::woman ? "checked" : null,
                                ],
                            ],
                            [
                                "text" => "Erkek",
                                "attributes" => [
                                    "class" => "mt-radio",
                                    "value" => "1",
                                    "data-type" => "gender",
                                    "!" => $data->gender == $customer_constant::man ? "checked" : null,
                                ],
                            ],
                            [
                                "text" => "Tanımsız",
                                "attributes" => [
                                    "class" => "mt-radio",
                                    "value" => "0",
                                    "data-type" => "gender",
                                    "!" => $data->gender == $customer_constant::undefine_person ? "checked" : null,
                                ],
                            ]
                        ],
                        "attributes" => [
                            "class" => "mt-radio-inline",
                        ],
                    ]
                ]; // kadın Erkek Check - delivery_adres
                $row[] = $col;
                $col = [];
                /* İkinci Satır * ********************************************************************************* */

                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Doğum Tarihi",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Dogum Tarihi  Label
                for ($i = 1; $i < 31; $i++)
                    $dy[] = ["text" => fixPre($i), "attributes" => ["value" => $i, "!" => $data->birth_day == $i ? "selected" : null]];

                $col[] = [
                    "col" => ["2"],
                    "content" => [
                        "type" => "select",
                        "control_class" => "customer_personals_fields",
                        "action" => "birth_day",
                        "datatype" => "birth_day",
                        "options" => $dy,
                        "attributes" => ["class" => "form-control"]
                    ]
                ]; // Gün
                for ($i = 1; $i < 13; $i++)
                    $mn[] = ["text" => fixPre($i), "attributes" => ["value" => $i, "!" => $data->birth_month == $i ? "selected" : null]];
                $col[] = [
                    "col" => ["2"],
                    "content" => [
                        "type" => "select",
                        "control_class" => "customer_personals_fields",
                        "action" => "birth_month",
                        "datatype" => "birth_month",
                        "options" => $mn,
                        "attributes" => ["class" => "form-control"]
                    ]
                ]; // Ay
                for ($i = 100; $i >= 0; $i--)
                    $yr[] = ["text" => date("Y", strtotime("now")) - $i, "attributes" => ["value" => date("Y", strtotime("now")) - $i, "!" => $data->birth_year == $i ? "selected" : null]];

                $col[] = [
                    "col" => ["2"],
                    "content" => [
                        "type" => "select",
                        "control_class" => "customer_personals_fields",
                        "action" => "birth_year",
                        "datatype" => "birth_year",
                        "options" => $yr,
                        "attributes" => ["class" => "form-control"]
                    ]
                ]; // Yıl

                $row[] = $col;
                $col = [];

                /* Ücüncü Satır * ********************************************************************************* */

                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Tc Kimlik No",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Tc Kimlik No Label
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "customer_personals_fields",
                        "action" => "idnumber",
                        "attributes" => [
                            "class" => "form-control",
                            "type" => "text",
                            "data-component_name" => "customer_personel_form",
                            "value" => $data->idnumber == null ? "" : $data->idnumber,
                            "placeholder" => "Kimlik Numarası",
                            "data-type" => "idnumber",
                        ],
                    ]
                ]; // Tc Kimlik No - adres_title

                $row[] = $col;
                $col = [];


                /* Altıncı  Satır  * ********************************************************************************* */
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Meslek",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Meslek Listesi -  Label
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "profession",
                        "control_class" => "customer_personals_fields",
                        "action" => "profession",
                        "selected_value" => $data->profession == null ? "" : $data->profession,
                        "attributes" => [
                            "class" => "form-control",
                            "data-component_name" => "customer_personel_form",
                            "data-type" => "profession",
                        ]
                    ]
                ]; // Meslek Listesi- select

                $row[] = $col;
                $col = [];
                /* Altıncı  Satır  * ********************************************************************************* */

                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Mesleki Görevi",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];  // Tc Kimlik No Label
                $col[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "customer_personals_fields",
                        "action" => "professional_duty",
                        "attributes" => [
                            "class" => "form-control",
                            "type" => "text",
                            "data-component_name" => "customer_personel_form",
                            "value" => $data->professional_duty == null ? "" : $data->professional_duty,
                            "placeholder" => "Mesleki Görevi",
                            "data-type" => "professional_duty",
                        ],
                    ]
                ]; // Tc Kimlik No - adres_title

                $row[] = $col;
                $col = [];

                $template[] = $row;
                echo '<input type="hidden" data-block_personel_company data-json="' . base64_encode(json_encode($template)) . '"/>';
            }
        }


        $col[] = [
            "content" => [
                "type" => "secret_number",
                "control_class" => "customer_personals_fields",
            ]
        ];
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "label",
                "text" => "Adı",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Adı Label
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "input",
                "control_class" => "customer_personals_fields",
                "action" => "name",
                "attributes" => [
                    "class" => "form-control",
                    "type" => "text",
                    "data-component_name" => "customer_personel_form",
                    "value" => $customer_personel_data->name == null ? "" : $customer_personel_data->name,
                    "placeholder" => "Adını Yazınız",
                    "data-type" => "name",
                ],
            ]
        ]; // Adı - adres_title
        $col[] = [
            "col" => ["1"],
            "content" =>
            [
                "type" => "label",
                "text" => "SoyAdı",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Soy Adı  Label
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "input",
                "control_class" => "customer_personals_fields",
                "action" => "lastname",
                "attributes" => [
                    "class" => "form-control",
                    "type" => "text",
                    "data-component_name" => "customer_personel_form",
                    "value" => $customer_personel_data->lastname == null ? "" : $customer_personel_data->lastname,
                    "placeholder" => "Soyadını Yazınız",
                    "data-type" => "lastname",
                ],
            ]
        ]; // Soy Adı - adres_title
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
                "text" => "Cinsiyeti",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Cinsiyeti  Label
        $col[] = [
            "col" => ["6"],
            "content" =>
            [
                "type" => "radiobox",
                "control_class" => "customer_personals_fields",
                "action" => "gender",
                "radio" => [
                    [
                        "text" => "Kadın",
                        "attributes" => [
                            "class" => "mt-radio",
                            "value" => "2",
                            "data-type" => "gender",
                            "!" => $customer_personel_data->gender == $customer_constant::woman ? "checked" : null,
                        ],
                    ],
                    [
                        "text" => "Erkek",
                        "attributes" => [
                            "class" => "mt-radio",
                            "value" => "1",
                            "data-type" => "gender",
                            "!" => $customer_personel_data->gender == $customer_constant::man ? "checked" : null,
                        ],
                    ],
                    [
                        "text" => "Tanımsız",
                        "attributes" => [
                            "class" => "mt-radio",
                            "value" => "0",
                            "data-type" => "gender",
                            "!" => $customer_personel_data->gender == $customer_constant::undefine_person ? "checked" : null,
                        ],
                    ]
                ],
                "attributes" => [
                    "class" => "mt-radio-inline",
                ],
            ]
        ]; // kadın Erkek Check - delivery_adres
        $row[] = $col;
        $col = [];
        /* İkinci Satır * ********************************************************************************* */

        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "label",
                "text" => "Doğum Tarihi",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Dogum Tarihi  Label
        for ($i = 1; $i < 31; $i++)
            $dy[] = ["text" => fixPre($i), "attributes" => ["value" => $i]];

        $col[] = [
            "col" => ["2"],
            "content" => [
                "type" => "select",
                "control_class" => "customer_personals_fields",
                "action" => "birth_day",
                "datatype" => "birth_day",
                "options" => $dy,
                "attributes" => ["class" => "form-control"]
            ]
        ]; // Gün
        for ($i = 1; $i < 13; $i++)
            $mn[] = ["text" => fixPre($i), "attributes" => ["value" => $i]];
        $col[] = [
            "col" => ["2"],
            "content" => [
                "type" => "select",
                "control_class" => "customer_personals_fields",
                "action" => "birth_month",
                "datatype" => "birth_month",
                "options" => $mn,
                "attributes" => ["class" => "form-control"]
            ]
        ]; // Ay
        for ($i = 100; $i >= 0; $i--)
            $yr[] = ["text" => date("Y", strtotime("now")) - $i, "attributes" => ["value" => date("Y", strtotime("now")) - $i]];

        $col[] = [
            "col" => ["2"],
            "content" => [
                "type" => "select",
                "control_class" => "customer_personals_fields",
                "action" => "birth_year",
                "datatype" => "birth_year",
                "options" => $yr,
                "attributes" => ["class" => "form-control"]
            ]
        ]; // Yıl

        $row[] = $col;
        $col = [];

        /* Ücüncü Satır * ********************************************************************************* */

        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "label",
                "text" => "Tc Kimlik No",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Tc Kimlik No Label
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "input",
                "control_class" => "customer_personals_fields",
                "action" => "idnumber",
                "attributes" => [
                    "class" => "form-control",
                    "type" => "text",
                    "data-component_name" => "customer_personel_form",
                    "value" => "",
                    "placeholder" => "Kimlik Numarası",
                    "data-type" => "idnumber",
                ],
            ]
        ]; // Tc Kimlik No - adres_title

        $row[] = $col;
        $col = [];


        /* Altıncı  Satır  * ********************************************************************************* */
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "label",
                "text" => "Meslek",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Meslek Listesi -  Label
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "profession",
                "control_class" => "customer_personals_fields",
                "action" => "profession",
                "attributes" => [
                    "class" => "form-control",
                    "data-component_name" => "customer_personel_form",
                    "data-type" => "profession",
                ]
            ]
        ]; // Meslek Listesi- select

        $row[] = $col;
        $col = [];
        /* Altıncı  Satır  * ********************************************************************************* */

        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "label",
                "text" => "Mesleki Görevi",
                "attributes" => ["class" => "form-label"],
            ]
        ];  // Tc Kimlik No Label
        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "input",
                "control_class" => "customer_personals_fields",
                "action" => "professional_duty",
                "attributes" => [
                    "class" => "form-control",
                    "type" => "text",
                    "data-component_name" => "customer_personel_form",
                    "value" => "",
                    "placeholder" => "Mesleki Görevi",
                    "data-type" => "professional_duty",
                ],
            ]
        ]; // Tc Kimlik No - adres_title

        $row[] = $col;
        $col = [];

        $resettemplate[] = $row;
        echo '<input type="hidden" reset-block_personel_company data-json="' . base64_encode(json_encode($resettemplate)) . '"/>';
        ?>
    </div>

</div>
<?php component::end(); ?>
