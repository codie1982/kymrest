<?php component::start(); ?>
<?php $customer_bank_data = component::get_props("customer_bank_data"); ?>
<div data-section="bank">
    <div class="form-group">
        <div class="row margin-bottom-10">
            <div class="col-sm-3">
                <button type="none" class="btn btn-circle red btn-outline" data-max="10" data-bank="add">Banka Hesabı Ekle</button>
            </div>
        </div>
        <div class="bank_content">
            <?php
            $template = [];
            if (!empty($customer_bank_data)) {
                foreach ($customer_bank_data as $data) {
                    $prk = $data->primary_key;
                    $col = [];
                    $row = [];
                    
                    $col[] = [
                        "content" => [
                            "type" => "primary_key",
                            "control_class" => "customer_bank_fields",
                            "primary_id" => $data->$prk,
                        ]
                    ];
                    $col[] = [
                        "content" => [
                            "type" => "secret_number",
                            "control_class" => "customer_bank_fields",
                        ]
                    ];  //secret_number
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Banka Hesab Bilgisi",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // Banka Hesab Bilgisi - label


                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_bank_fields",
                            "action" => "bank_name",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_bank_company",
                                "value" => $data->bank_name == null ? "" : $data->bank_name,
                                "placeholder" => "Banka İsmi",
                                "data-type" => "bank_name",
                            ],
                        ]
                    ]; // IBAN 
                    $col[] = [
                        "col" => ["1"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "IBAN",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // Banka Hesab Bilgisi - label

                    $col[] = [
                        "col" => ["2"],
                        "content" =>
                        [
                            "type" => "input",
                            "control_class" => "customer_bank_fields",
                            "action" => "iban",
                            "attributes" => [
                                "class" => "form-control",
                                "type" => "text",
                                "data-component_name" => "block_bank_company",
                                "value" => $data->iban == null ? "" : $data->iban,
                                "placeholder" => "IBAN",
                                "data-type" => "iban",
                            ],
                        ]
                    ]; // Telefon Numarası 


                    $col[] = [
                        "col" => ["1"],
                        "content" => [
                            "type" => "removeButton",
                            "key" => $data->$prk,
                        ]
                    ];

                    $row[] = $col;

                    $resettemplate[] = $row;

                    echo '<input type="hidden" data-block_bank_company data-json="' . base64_encode(json_encode($template)) . '"/>';
                }
            }


            $col = [];
            $row = [];
            $resettemplate = [];
            $col[] = [
                "content" => [
                    "type" => "secret_number",
                    "control_class" => "customer_bank_fields",
                ]
            ];  //secret_number
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Banka Hesab Bilgisi",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // Banka Hesab Bilgisi - label


            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_bank_fields",
                    "action" => "bank_name",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_bank_company",
                        "value" => "",
                        "placeholder" => "Banka İsmi",
                        "data-type" => "bank_name",
                    ],
                ]
            ]; // IBAN 
            $col[] = [
                "col" => ["1"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "IBAN",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // Banka Hesab Bilgisi - label

            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_bank_fields",
                    "action" => "iban",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_bank_company",
                        "value" => "",
                        "placeholder" => "IBAN",
                        "data-type" => "iban",
                    ],
                ]
            ]; // Telefon Numarası 


            $col[] = [
                "col" => ["1"],
                "content" => [
                    "type" => "removeButton",
                ]
            ];

            $row[] = $col;

            $resettemplate[] = $row;

            echo '<input type="hidden" reset-block_bank_company data-json="' . base64_encode(json_encode($resettemplate)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
