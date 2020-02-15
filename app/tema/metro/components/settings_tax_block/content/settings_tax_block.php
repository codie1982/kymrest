<?php component::start(); ?>
<?php $tax_info = component::get_props("tax_info"); ?>
<?php $tax_office_list = component::get_props("tax_office_list"); ?>
<?php //dnd($tax_info);         ?>
<?php //dnd($tax_office_list);       ?>
<div data-section="tax">
    <div class="form-group">
        <div class="settings_tax_content">


            <?php
            if (!empty($tax_info)) {

                $col1[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Firma İsmi",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];
                $col1[] = [
                    "col" => ["6"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "settings_general_fields",
                        "action" => "company_name",
                        "attributes" => [
                            "class" => "form-control",
                            "value" => $tax_info["company_name"],
                            "data-component_name" => "settings_tax_block",
                            "data-type" => "company_name",
                        ],
                    ]
                ];
                $row[] = $col1;


                $col2[] = [
                    "col" => ["3"],
                    "content" =>
                    [
                        "type" => "label",
                        "text" => "Vergi Dairesi",
                        "attributes" => ["class" => "form-label"],
                    ]
                ];
                $col2[] = [
                    "col" => ["2"],
                    "content" =>
                    [
                        "type" => "province",
                        "control_class" => "settings_general_fields",
                        "action" => "tax_province",
                        "selected_value" => $tax_info["tax_province"],
                        "attributes" => [
                            "class" => "form-control",
                            "data-component_name" => "settings_tax_block",
                            "data-type" => "tax_province",
                        ],
                    ]
                ];
                $col2[] = [
                    "col" => ["2"],
                    "content" =>
                    [
                        "type" => "tax_office",
                        "control_class" => "settings_general_fields",
                        "action" => "tax_office",
                        "selected_value" => $tax_info["tax_office"],
                        "taxOffice_list" => base64_encode(json_encode($tax_office_list)),
                        "attributes" => [
                            "class" => "form-control",
                            "data-component_name" => "settings_tax_block",
                            "data-type" => "tax_office",
                        ],
                    ]
                ];
                $col2[] = [
                    "col" => ["4"],
                    "content" =>
                    [
                        "type" => "input",
                        "control_class" => "settings_general_fields",
                        "action" => "tax_number",
                        "attributes" => [
                            "class" => "form-control",
                            "type" => "text",
                            "data-component_name" => "settings_tax_block",
                            "value" => $tax_info["tax_number"],
                            "data-type" => "tax_number",
                        ],
                    ]
                ];
                $row[] = $col2;
                $template[] = $row;
                echo '<input type="hidden" data-settings_tax_block data-json="' . base64_encode(json_encode($template)) . '"/>';
            }
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>


