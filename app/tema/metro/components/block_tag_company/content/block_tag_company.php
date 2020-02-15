<?php component::start(); ?>
<?php $customer_tag_data = component::get_props("customer_tag_data"); ?>
<?php $customer_tag_list = component::get_props("customer_tag_list"); ?>

<div data-section="tag">
    <div class="form-group">
        <div class="row margin-bottom-10">
            <div class="col-sm-3">
                <button type="none" class="btn btn-circle red btn-outline" data-max="<?= count($customer_tag_list) ?>" data-tag="add">Kullanıcı Etiketleri Oluştur</button>
            </div>
        </div>
        <div class="tag_content">
            <?php
            $template = [];
            if (!empty($customer_tag_data)) {
                foreach ($customer_tag_data as $data) {
                    $prk = $data->primary_key;
                    $col = [];
                    $row = [];

                    $col[] = [
                        "content" => [
                            "type" => "primary_key",
                            "control_class" => "customer_tag_fields",
                            "primary_id" => $data->$prk,
                        ]
                    ];
                    $col[] = [
                        "content" => [
                            "type" => "secret_number",
                            "control_class" => "customer_tag_fields",
                        ]
                    ];  //secret_number
                    $col[] = [
                        "col" => ["3"],
                        "content" =>
                        [
                            "type" => "label",
                            "text" => "Kullanıcı Etiketleri",
                            "attributes" => ["class" => "form-label"],
                        ]
                    ];  // Kullanıcı Etiketleri - label

                    $taglist = [];
                    $taglist[] = ["text" => "Bir Kullanıcı Etiketi Seçiniz", "attributes" => ["value" => NODATA]];
                    for ($i = 0; $i < count($customer_tag_list); $i++)
                        $taglist[] = ["text" => $customer_tag_list[$i],
                            "attributes" => ["value" => $customer_tag_list[$i], "!" => $data->tag == $customer_tag_list[$i] ? "selected" : ""]];
                    $col[] = [
                        "col" => ["2"],
                        "content" => [
                            "type" => "select",
                            "control_class" => "customer_tag_fields",
                            "action" => "tag",
                            "datatype" => "tag",
                            "options" => $taglist,
                            "attributes" => [
                                "class" => "form-control",
                            ]
                        ]
                    ]; // Kullanıcı Etiketleri - select
                    $col[] = [
                        "col" => ["1"],
                        "content" => [
                            "type" => "removeButton",
                            "key" => $data->$prk,
                        ]
                    ];

                    $row[] = $col;
                    $template[] = $row;

                    echo '<input type="hidden" data-block_tag_company data-json="' . base64_encode(json_encode($template)) . '"/>';
                }
            }


            $col = [];
            $row = [];
            $resettemplate = [];
            $col[] = [
                "content" => [
                    "type" => "secret_number",
                    "control_class" => "customer_tag_fields",
                ]
            ];  //secret_number
            $col[] = [
                "col" => ["3"],
                "content" =>
                [
                    "type" => "label",
                    "text" => "Kullanıcı Etiketleri",
                    "attributes" => ["class" => "form-label"],
                ]
            ];  // Kullanıcı Etiketleri - label

            $taglist = [];
            $taglist[] = ["text" => "Bir Kullanıcı Etiketi Seçiniz", "attributes" => ["value" => NODATA]];
            for ($i = 0; $i < count($customer_tag_list); $i++)
                $taglist[] = ["text" => $customer_tag_list[$i], "attributes" => ["value" => $customer_tag_list[$i], "!" => $data->tag == $customer_tag_list[$i] ? "selected" : ""]];
            $col[] = [
                "col" => ["2"],
                "content" => [
                    "type" => "select",
                    "control_class" => "customer_tag_fields",
                    "action" => "tag",
                    "datatype" => "tag",
                    "options" => $taglist,
                    "attributes" => [
                        "class" => "form-control",
                    ]
                ]
            ]; // Kullanıcı Etiketleri - select
            $col[] = [
                "col" => ["1"],
                "content" => [
                    "type" => "removeButton",
                ]
            ];

            $row[] = $col;
            $resettemplate[] = $row;

            echo '<input type="hidden" reset-block_tag_company data-json="' . base64_encode(json_encode($resettemplate)) . '"/>';
            ?>
        </div>
    </div>
</div>
<?php component::end(); ?>
