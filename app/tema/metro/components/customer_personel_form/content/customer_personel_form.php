<?php component::start($props); ?><?php$form_action = component::get_props("form_action");$button_text = component::get_props("button_text");$customer_data = component::get_props("customer_data");$customer_personel_data = component::get_props("customer_personel_data");$customer_constant = new customer_constant();date_default_timezone_set('europe/istanbul');?><div class="modal fade bs-modal-lg " id="customers_personel" tabindex="-1" role="basic" aria-hidden="true" >    <div class="modal-dialog modal-lg">        <div class="modal-content">            <div class="modal-header">                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>            </div>            <div class="modal-body">                <div class="row">                    <div class="col-md-12">                        <div class="portlet">                             <div class="portlet-title">                                <div class="caption">                                    <i class="icon-settings font-dark"></i>                                    <span class="caption-subject font-dark sbold uppercase">Yeni Müşteri Tanımlayın</span>                                    <span class="help-inline"> Yeni ürün Ayarlarınızı Yapılandırın. </span>                                </div>                            </div>                            <div class="portlet-body form ">                                <div class="m-heading-1 border-green m-bordered">                                    <div class="caption">                                        <i class="icon-settings font-dark"></i>                                        <span class="caption-subject font-dark sbold uppercase">Müşteri Bilgilerini Giriniz.</span>                                    </div>                                </div>                                <?php // dnd($customer_data);  ?>                                <?php // dnd($customer_personel_data); ?>                                <form class="form-horizontal" role="form" data-send="xhr" method="post" data-component_name="customer_personel_form"                                      data-action="<?= $form_action == "" ? "add_new_customer" : $form_action ?>" >                                    <div class="form-body">                                        <div class="personel_form">                                            <?php                                            $col = [];                                            $row = [];                                            $template = [];                                            if (component::isset_probs("customer_id")) {                                                $col[] = [                                                    "col" => ["12"],                                                    "content" =>                                                    [                                                        "type" => "input",                                                        "control_class" => "customer_personal_fields",                                                        "action" => "customer_id",                                                        "attributes" => [                                                            "type" => "hidden",                                                            "value" => component::get_props("customer_id"),                                                        ],                                                    ]                                                ]; // kullanıcı Tipi                                             }                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_fields",                                                    "action" => "type",                                                    "attributes" => [                                                        "type" => "hidden",                                                        "value" => "personel",                                                    ],                                                ]                                            ]; // kullanıcı Tipi                                             if (!empty($customer_data)) {                                                $prk = $customer_data->primary_key;                                                $col[] = [                                                    "content" => [                                                        "type" => "primary_key",                                                        "control_class" => "customer_fields",                                                        "primary_id" => $customer_data->$prk,                                                    ]                                                ];                                            }                                            $row[] = $col;                                            $col = [];                                            if (!empty($customer_personel_data)) {                                                $prk = $customer_personel_data->primary_key;                                                $col[] = [                                                    "content" => [                                                        "type" => "primary_key",                                                        "control_class" => "customer_personal_fields",                                                        "primary_id" => $customer_personel_data->$prk,                                                    ]                                                ];                                            }                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Adı",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Adı Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "name",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "data-component_name" => "customer_personel_form",                                                        "value" => $customer_personel_data->name == null ? "" : $customer_personel_data->name,                                                        "placeholder" => "Adını Yazınız",                                                        "data-type" => "name",                                                    ],                                                ]                                            ]; // Adı - adres_title                                            $col[] = [                                                "col" => ["2"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "SoyAdı",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Soy Adı  Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "lastname",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "data-component_name" => "customer_personel_form",                                                        "value" => $customer_personel_data->lastname == null ? "" : $customer_personel_data->lastname,                                                        "placeholder" => "Soyadını Yazınız",                                                        "data-type" => "lastname",                                                    ],                                                ]                                            ]; // Soy Adı - adres_title                                            $row[] = $col;                                            $col = [];                                            /* Birinci Satır * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Cinsiyeti",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Cinsiyeti  Label                                            $col[] = [                                                "col" => ["6"],                                                "content" =>                                                [                                                    "type" => "radiobox",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "gender",                                                    "radio" => [                                                        [                                                            "text" => "Kadın",                                                            "attributes" => [                                                                "class" => "mt-radio",                                                                "value" => "2",                                                                "data-type" => "gender",                                                                "!" => $customer_personel_data->gender == $customer_constant::woman ? "checked" : null,                                                            ],                                                        ],                                                        [                                                            "text" => "Erkek",                                                            "attributes" => [                                                                "class" => "mt-radio",                                                                "value" => "1",                                                                "data-type" => "gender",                                                                "!" => $customer_personel_data->gender == $customer_constant::man ? "checked" : null,                                                            ],                                                        ],                                                        [                                                            "text" => "Tanımsız",                                                            "attributes" => [                                                                "class" => "mt-radio",                                                                "value" => "0",                                                                "data-type" => "gender",                                                                "!" => $customer_personel_data->gender == $customer_constant::undefine_person ? "checked" : null,                                                            ],                                                        ]                                                    ],                                                    "attributes" => [                                                        "class" => "mt-radio-inline",                                                    ],                                                ]                                            ]; // kadın Erkek Check - delivery_adres                                            $row[] = $col;                                            $col = [];                                            /* İkinci Satır * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Doğum Tarihi",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Dogum Tarihi  Label                                            for ($i = 1; $i < 31; $i++)                                                $dy[] = ["text" => fixPre($i), "attributes" => ["value" => $i, "!" => $customer_personel_data->birth_day == $i ? "selected" : null]];                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "birth_day",                                                    "datatype" => "birth_day",                                                    "options" => $dy,                                                    "attributes" => ["class" => "form-control"]                                                ]                                            ]; // Gün                                            for ($i = 1; $i < 13; $i++)                                                $mn[] = ["text" => fixPre($i), "attributes" => ["value" => $i, "!" => $customer_personel_data->birth_month == $i ? "selected" : null]];                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "birth_month",                                                    "datatype" => "birth_month",                                                    "options" => $mn,                                                    "attributes" => ["class" => "form-control"]                                                ]                                            ]; // Ay                                            for ($i = 100; $i >= 0; $i--)                                                $yr[] = ["text" => date("Y", strtotime("now")) - $i, "attributes" => ["value" => date("Y", strtotime("now")) - $i, "!" => $customer_personel_data->birth_year == $i ? "selected" : null]];                                            $col[] = [                                                "col" => ["2"],                                                "content" => [                                                    "type" => "select",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "birth_year",                                                    "datatype" => "birth_year",                                                    "options" => $yr,                                                    "attributes" => ["class" => "form-control"]                                                ]                                            ]; // Yıl                                            $row[] = $col;                                            $col = [];                                            /* Ücüncü Satır * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Tc Kimlik No",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Tc Kimlik No Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "idnumber",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "data-component_name" => "customer_personel_form",                                                        "value" => $customer_personel_data->idnumber == null ? "" : $customer_personel_data->idnumber,                                                        "placeholder" => "Kimlik Numarası",                                                        "data-type" => "idnumber",                                                    ],                                                ]                                            ]; // Tc Kimlik No - adres_title                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Meslek",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Meslek Listesi -  Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "profession",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "profession",                                                    "selected_value" => $customer_personel_data->profession == null ? "" : $customer_personel_data->profession,                                                    "attributes" => [                                                        "class" => "form-control",                                                        "data-component_name" => "customer_personel_form",                                                        "data-type" => "profession",                                                    ]                                                ]                                            ]; // Meslek Listesi- select                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Mesleki Görevi",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Tc Kimlik No Label                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "input",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "professional_duty",                                                    "attributes" => [                                                        "class" => "form-control",                                                        "type" => "text",                                                        "data-component_name" => "customer_personel_form",                                                        "value" => $customer_personel_data->professional_duty == null ? "" : $customer_personel_data->professional_duty,                                                        "placeholder" => "Mesleki Görevi",                                                        "data-type" => "professional_duty",                                                    ],                                                ]                                            ]; // Tc Kimlik No - adres_title                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                    "component_name" => "block_tag_personel",                                                    "type" => "component",                                                    "content" => component::get_props("block_tag_personel"),                                                ]                                            ];  // adres blok component                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                     "component_name" => "block_email_personel",                                                    "type" => "component",                                                    "content" => component::get_props("block_email_personel"),                                                ]                                            ];  // adres blok component                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                     "component_name" => "block_adres_personel",                                                    "type" => "component",                                                    "content" => component::get_props("block_adres_personel"),                                                ]                                            ];  // adres blok component                                            $row[] = $col;                                            $col = [];                                            /* Yedinci  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                     "component_name" => "block_phone_personel",                                                    "type" => "component",                                                    "content" => component::get_props("block_phone_personel"),                                                ]                                            ];  // phone_block component                                            $row[] = $col;                                            $col = [];                                            /* Sekisinci  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["12"],                                                "content" =>                                                [                                                     "component_name" => "block_credicard_personel",                                                    "type" => "component",                                                    "content" => component::get_props("block_credicard_personel"),                                                ]                                            ];  // credicard_block component                                            $row[] = $col;                                            $col = [];                                            /* Dokuzuncu  Satır  * ********************************************************************************* */                                            $col[] = [                                                "col" => ["3"],                                                "content" =>                                                [                                                    "type" => "label",                                                    "text" => "Açıklama",                                                    "attributes" => ["class" => "form-label"],                                                ]                                            ];  // Kullanıcı Açıklaması - label                                            $col[] = [                                                "col" => ["9"],                                                "content" =>                                                [                                                    "type" => "textarea",                                                    "control_class" => "customer_personal_fields",                                                    "action" => "description",                                                    "text" => $customer_personel_data->description == null ? "" : $customer_personel_data->description,                                                    "attributes" => [                                                        "class" => "form-control",                                                        "rows" => "3", "cols" => "50",                                                        "data-component_name" => "customer_personel_form",                                                        "data-type" => "description",                                                    ],                                                ]                                            ]; // Açıklama                                            $row[] = $col;                                            $col = [];                                            /* Altıncı  Satır  * ********************************************************************************* */                                            $template[] = $row;                                            echo '<input type="hidden" data-customer_personel_form data-json="' . base64_encode(json_encode($template)) . '"/>';                                            ?>                                        </div>                                    </div>                                    <div class="form-actions">                                        <div class="row">                                            <div class="col-md-offset-9 col-md-3">                                                <button type="submit" class="btn green"><?= $button_text == "" ? "Kaydet" : $button_text ?></button>                                            </div>                                        </div>                                    </div>                                </form>                            </div>                        </div>                    </div>                </div>                <div class="note note-info margin-bottom-15">                    <div class="fa-item col-md-1 col-sm-1"><i class="fa fa-bell-o"></i> </div> <p>Kullanıcılarınız için bilgileri detaylı girmeye özen gösterin. </p>                </div>            </div>            <div class="modal-footer">                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>            </div>        </div>        <!-- /.modal-content -->    </div>    <!-- /.modal-dialog --></div><?php component::end(); ?>