<?php component::start(); ?>
<?php $data = component::get_props("customer_company_data"); ?>

<div data-section="tax">

    <div class="tax_content">

        <?php
         $template = [];
        if (!empty($data)) {
            $prk = $data->primary_key;
            $col[] = [
                "content" => [
                    "type" => "primary_key",
                    "control_class" => "customer_company_fields",
                    "primary_id" => $data->$prk,
                ]
            ];
            $col[] = [
                "content" => [
                    "type" => "secret_number",
                    "control_class" => "customer_company_fields",
                ]
            ];

            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Vergi Dairesi",
                    "attributes" => ["class" => "form-label"],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "province",
                    "control_class" => "customer_company_fields",
                    "action" => "tax_province",
                    "selected_value" => $data->tax_province,
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "block_tax_company",
                        "data-type" => "tax_province",
                    ],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "tax_office",
                    "control_class" => "customer_company_fields",
                    "action" => "tax_office",
                    "selected_value" => $data->tax_office,
                    "taxOffice_list" => base64_encode(json_encode($tax_office_list)),
                    "attributes" => [
                        "class" => "form-control",
                        "data-component_name" => "block_tax_company",
                        "data-type" => "tax_office",
                    ],
                ]
            ];
            $col[] = [
                "col" => ["2"],
                "content" =>
                [
                    "type" => "input",
                    "control_class" => "customer_company_fields",
                    "action" => "tax_number",
                    "attributes" => [
                        "class" => "form-control",
                        "type" => "text",
                        "data-component_name" => "block_tax_company",
                        "value" => $data->tax_number,
                        "data-type" => "tax_number",
                    ],
                ]
            ];
            $row[] = $col;
            $template[] = $row;
            echo '<input type="hidden" data-block_tax_company data-json="' . base64_encode(json_encode($template)) . '"/>';
        }


        $col = [];
        $row = [];
        $template = [];
        $col[] = [
            "content" => [
                "type" => "secret_number",
                "control_class" => "customer_company_fields",
            ]
        ];




        $col[] = [
            "col" => ["3"],
            "content" =>
            [
                "type" => "label",
                "text" => "Vergi Dairesi",
                "attributes" => ["class" => "form-label"],
            ]
        ];
        $col[] = [
            "col" => ["2"],
            "content" =>
            [
                "type" => "province",
                "control_class" => "customer_company_fields",
                "action" => "tax_province",
                "attributes" => [
                    "class" => "form-control",
                    "data-component_name" => "block_tax_company",
                    "data-type" => "tax_province",
                ],
            ]
        ];
        $col[] = [
            "col" => ["2"],
            "content" =>
            [
                "type" => "tax_office",
                "control_class" => "customer_company_fields",
                "action" => "tax_office",
                "attributes" => [
                    "class" => "form-control",
                    "data-component_name" => "tax_block",
                    "data-type" => "tax_office",
                ],
            ]
        ];
        $col[] = [
            "col" => ["2"],
            "content" =>
            [
                "type" => "input",
                "control_class" => "customer_company_fields",
                "action" => "tax_number",
                "attributes" => [
                    "class" => "form-control",
                    "type" => "text",
                    "data-component_name" => "block_tax_company",
                    "value" => "",
                    "placeholder" => "Vergi Numaranızı Yazınız",
                    "data-type" => "tax_number",
                ],
            ]
        ];
        $row[] = $col;
        $template[] = $row;

        echo '<input type="hidden" reset-block_tax_company data-json="' . base64_encode(json_encode($template)) . '"/>';
        ?>
    </div>

</div>
<?php component::end(); ?>
