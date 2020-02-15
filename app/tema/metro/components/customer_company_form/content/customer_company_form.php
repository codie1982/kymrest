<?php component::start($props); ?><?php$form_action = component::get_props("form_action");$button_text = component::get_props("button_text");$customer_data = component::get_props("customer_data");$customer_company_data = component::get_props("customer_company_data");?><?php date_default_timezone_set('europe/istanbul');                        ?><div class="modal fade bs-modal-lg " id="customers_company" tabindex="-1" role="basic" aria-hidden="true" >    <div class="modal-dialog modal-lg">        <div class="modal-content">            <div class="modal-header">                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>            </div>            <div class="modal-body">                <div class="row">                    <div class="col-md-12">                        <div class="portlet">                             <div class="portlet-title">                                <div class="caption">                                    <i class="icon-settings font-dark"></i>                                    <span class="caption-subject font-dark sbold uppercase">Kurumsal Müşterinizi Tanımlayın</span>                                </div>                            </div>                            <div class="portlet-body form ">                                <div class="m-heading-1 border-green m-bordered">                                    <div class="caption">                                        <i class="icon-settings font-dark"></i>                                        <span class="caption-subject font-dark sbold uppercase">Müşteri Bilgilerini Giriniz.</span>                                    </div>                                </div>                                <?php // dnd($customer_data);  ?>                                <?php // dnd($customer_personel_data); ?>                                <form class="form-horizontal" role="form" data-send="xhr" method="post" data-component_name="customer_company_form"                                      data-action="<?= $form_action == "" ? "add_new_customer" : $form_action ?>" >                                    <div class="form-body">                                        <div class="company_form">                                            <?php                                            $col = [];                                            $row = [];                                            $template = [];                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_fields",                                                    "action" => "type",                                                    "attributes" => [                                                        "type" => "hidden",                                                        "value" => "company",                                                    ],                                                ]                                            ]; // kullanıcı Tipi                                             $row[] = $col;                                            if (component::isset_probs("customer_id")) {                                                $col[] = [                                                    "col" => ["12"],                                                    "content" =>                                                    [                                                        "type" => "input",                                                        "control_class" => "customer_company_fields",                                                        "action" => "customer_id",                                                        "attributes" => [                                                            "type" => "hidden",                                                            "value" => component::get_props("customer_id"),                                                        ],                                                    ]                                                ]; // kullanıcı Tipi                                             }                                            $col = [];                                            if (!empty($customer_data)) {                                                $prk = $customer_data->primary_key;                                                $col[] = [                                                    "content" => [                                                        "type" => "primary_key",                                                        "control_class" => "customer_fields",                                                        "primary_id" => $customer_data->$prk,                                                    ]                                                ];                                            }                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Firma Ünvanı",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Firma Tipi Label                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_company_fields",                                                    "action" => "company_type",                                                    "datatype" => "company_type",                                                    "options" => [                                                        [                                                            "text" => "Sahış Şirketi",                                                            "attributes" => [                                                                "value" => "person",                                                                "!" => $customer_company_data->company_type == "person" ? "selected" : "",                                                            ]                                                        ],                                                        [                                                            "text" => "Limited Şirketi",                                                            "attributes" => [                                                                "value" => "limited",                                                                "!" => $customer_company_data->company_type == "limited" ? "selected" : "",                                                            ]                                                        ],                                                        [                                                            "text" => "Anonim Ortaklığı",                                                            "attributes" => [                                                                "value" => "ao",                                                                "!" => $customer_company_data->company_type == "ao" ? "selected" : "",                                                            ]                                                        ],                                                        [                                                            "text" => "Holding",                                                            "attributes" => [                                                                "value" => "holding",                                                                "!" => $customer_company_data->company_type == "holding" ? "selected" : "",                                                            ]                                                        ]                                                    ],                                                    "attributes" => [                                                        "class" => "form-control",                                                    ]                                                ]                                            ]; // Firma Tipi select                                            $col[] = [                                                "col" => ["7"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_company_fields",                                                    "action" => "customer_company_title",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "data-component_name" => "adres_block",                                                        "value" => $customer_company_data->customer_company_title == null ? "" : $customer_company_data->customer_company_title,                                                        "placeholder" => "Firma Unvanı",                                                        "data-type" => "customer_company_title",                                                    ],                                                ]                                            ]; // Firma Ünvanı - input                                            $row[] = $col;                                            $col = [];                                            /* Birinci Satır * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_tax_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_tax_company"),                                                ]                                            ];  // tax block component                                            $row[] = $col;                                            $col = [];                                            /* İkinci Satır * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Mersis No",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Mersis No Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_company_fields",                                                    "action" => "mersisno",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "data-component_name" => "adres_block",                                                        "value" => $customer_company_data->mersisno == null ? "" : $customer_company_data->mersisno,                                                        "placeholder" => "Mersis No",                                                        "data-type" => "mersisno",                                                    ],                                                ]                                            ]; // Mersis No - adres_title                                            $row[] = $col;                                            $col = [];                                            /* Ücüncü Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Kuruluş Yılı",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Kuruluş Yılı  Label                                            for ($i = 1; $i < 31; $i++)                                                $dy[] = ["text" => fixPre($i), "attributes" => ["value" => $i, "!" => $data->start_day == 1 ? "selected" : null]];                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_company_fields",                                                    "action" => "start_day",                                                    "datatype" => "start_day",                                                    "options" => $dy,                                                    "attributes" => [                                                        "class" => "form-control",                                                    ]                                                ]                                            ]; // gün                                            for ($i = 1; $i < 13; $i++)                                                $mn[] = ["text" => fixPre($i), "attributes" => ["value" => $i, "!" => $customer_company_data->start_month == 1 ? "selected" : null]];                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_company_fields",                                                    "action" => "start_month",                                                    "datatype" => "start_month",                                                    "options" => $mn,                                                    "attributes" => [                                                        "class" => "form-control",                                                    ]                                                ]                                            ]; // Ay                                            for ($i = 0; $i > -200; $i--)                                                $yr[] = ["text" => date("Y", strtotime("now")) + $i, "attributes" => ["value" => date("Y", strtotime("now")) + $i, "!" => $data->start_year == 1 ? "selected" : null]];                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_company_fields",                                                    "action" => "start_year",                                                    "datatype" => "start_year",                                                    "options" => $yr,                                                    "attributes" => [                                                        "class" => "form-control",                                                    ]                                                ]                                            ]; // Yıl                                            $row[] = $col;                                            $col = [];                                            /* Dördüncü Satır * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Faaliyet Alanı",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Faaliyet Alanı  Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_company_fields",                                                    "action" => "workspace",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "value" => $customer_company_data->workspace == null ? "" : $customer_company_data->workspace,                                                        "placeholder" => "Faaliyet Alanı",                                                        "data-type" => "workspace",                                                    ],                                                ]                                            ]; // Faaliyet Alanı - input                                            $row[] = $col;                                            $col = [];                                            /* Beşinci Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_tag_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_tag_company"),                                                ]                                            ];  // adres blok component                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_email_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_email_company"),                                                ]                                            ];  // adres blok component                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_adres_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_adres_company"),                                                ]                                            ];  // adres blok component                                            $row[] = $col;                                            $col = [];                                            /* Yedinci  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_phone_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_phone_company"),                                                ]                                            ];  // phone_block component                                            $row[] = $col;                                            $col = [];                                            /* Sekisinci  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_credicard_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_credicard_company"),                                                ]                                            ];  // credicard_block component                                            $row[] = $col;                                            $col = [];                                            /* Dokuzuncu  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_bank_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_bank_company"),                                                ]                                            ];  // credicard_block component                                            $row[] = $col;                                            $col = [];                                            /* Dokuzuncu  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_personel_company",                                                    "type" => "component",                                                    "content" => component::get_props("block_personel_company"),                                                ]                                            ];  // personel component                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Açıklama",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Kullanıcı Açıklaması - label                                            $col[] = [                                                "col" => ["9"],                                                "content" =>                                                [                                                    "type" => "textarea",                                                    "control_class" => "customer_company_fields",                                                    "action" => "description",                                                    "text" => $customer_company_data->description == null ? "" : $customer_company_data->description,                                                    "attributes" => [                                                        "class" => "form-control",                                                        "rows" => "3", "cols" => "50",                                                        "data-component_name" => "adres_block",                                                        "data-type" => "description",                                                    ],                                                ]                                            ]; // Açıklama                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $template[] = $row;                                            echo '<input type="hidden" data-customer_company_form data-json="' . base64_encode(json_encode($template)) . '"/>';                                            ?>                                        </div>                                    </div>                                    <div class="form-actions">                                        <div class="row">                                            <div class="col-md-offset-9 col-md-3">                                                <button type="submit" class="btn green"><?= $button_text == "" ? "Kaydet" : $button_text ?></button>                                            </div>                                        </div>                                    </div>                                </form>                            </div>                        </div>                    </div>                </div>                <div class="note note-info margin-bottom-15">                    <div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i> </div> <p>Kullanıcılarınız için bilgileri detaylı girmeye özen gösterin. </p>                </div>            </div>            <div class="modal-footer">                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>            </div>        </div>        <!-- /.modal-content -->    </div>    <!-- /.modal-dialog --></div><?php component::end(); ?>