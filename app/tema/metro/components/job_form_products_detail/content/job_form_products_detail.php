<?php component::start(); ?>
<?php $product_data = component::get_props("product_data") ?>
<?php $product_price = component::get_props("product_price") ?>
<?php $product_sales_price = component::get_props("product_sales_price") ?>

<?php $product_settings = component::get_props("product_settings") ?>
<?php $product_transport_settings = component::get_props("product_transport_settings") ?>
<?php $selected_job_id = component::get_props("selected_job_id") ?>
<?php $customer_id = component::get_props("customer_id") ?>
<?php $product_constant = new product_constant(); ?>
<?php //dnd($product_data); ?>
<?php if (!empty($product_data)): ?>
    <form class="form-horizontal"  data-send="xhr" method="post" data-component_name="job_form"
          data-action="add_new_job_product"> 
              <?php $rnd = rand(999, 9999); ?>
        <input type="hidden" name="@job_products_fields$secret_number:<?= $rnd ?>" value="<?= $rnd ?>"/>
        <input type="hidden" name="@job_products_fields$job_id:<?= $rnd ?>" value="<?= $selected_job_id ?>"/>
        <input type="hidden" name="@job_products_fields$product_type:<?= $rnd ?>" value="<?= "standart" ?>"/>
        <input type="hidden" name="@job_products_fields$customer_id:<?= $rnd ?>" value="<?= $customer_id ?>"/>
        <input type="hidden" name="@job_products_fields$product_id:<?= $rnd ?>" value="<?= $product_data["product"]->product_id ?>"/>


        <input type="hidden" name="@job_products_fields$product_tax_price:<?= $rnd ?>" value="<?= component::get_props("product_tax_price") ?>"/>
        <input type="hidden" name="@job_products_fields$product_tax_price_unit:<?= $rnd ?>" value="<?= component::get_props("product_tax_price_unit") ?>"/>
        <input type="hidden" name="@job_products_fields$product_tax_rate:<?= $rnd ?>" value="<?= component::get_props("product_tax_rate") ?>"/>
        <input type="hidden" name="@job_products_fields$product_intax:<?= $rnd ?>" value="<?= component::get_props("product_intax") ?>"/>
        <div class="product_container m-l-10">
            <div class="product_info">
                <div class="product_header">
                    <div class="product_header_image">
                        <div class="image_section"><img src="<?= get_image(component::get_props("product_image_info"), 100) ?>" alt="<?= ucwords_tr($product_data["product"]->product_name) ?>" /></div>
                    </div>
                    <div class="product_header_info">
                        <div class="product_title"><?= ucwords_tr($product_data["product"]->product_name) ?></div>
                        <div class="product_subtitle"><?= ucwords_tr($product_data["product"]->product_sub_name) ?></div>
                    </div>
                    <div class="product_price_amount">
                        <div class="product_amount_plus"><button class="product_price_button" data-product_detail_action="minus">-</button></div>
                        <div class="product_amount"><input id="product_amount_input" name="@job_products_fields$amount:<?= $rnd ?>" type="number" min="1" value="1"/></div>
                        <div class="product_amount_minus"><button class="product_price_button" data-product_detail_action="plus">+</button></div>
                    </div>
                    <input type="hidden" name="@job_products_fields$product_price_type:<?= $rnd ?>" value="<?= $product_data["product"]->product_price_type ?>"/>
                    <div class="product_price_info">
                        <div class="product_first_price"><?= number_format($product_price["product_price"], 2) ?> <?= strtoupper($product_price["product_price_unit"]) ?></div>

                        <div class="product_price"><?= number_format($product_sales_price["product_sales_price"], 2) ?> <?= strtoupper($product_sales_price["product_sales_price_unit"]) ?></div>
                        <input type="hidden" name="@job_products_fields$product_price:<?= $rnd ?>" value="<?= $product_sales_price["product_sales_price"] ?>"/>
                        <input type="hidden" name="@job_products_fields$product_price_unit:<?= $rnd ?>" value="<?= $product_sales_price["product_sales_price_unit"] ?>"/>
                    </div>
                    <div class="product_price_action">
                        <button type="submit" class="btn btn-info">Ekle</button>
                    </div>
                </div>
                <?php if ($product_data["product"]->product_price_type == "options"): ?>

                    <div class="product_descriptions">
                        <h4>Ürün Seçenekleri</h4>
                        <div class="product_price_options">
                            <?php //dnd($product_data["product_price_group"]);  ?>
                            <?php foreach ($product_data["product_price_group"] as $group): ?>
                                <?php $group_id = $group->product_price_group_id ?>
                                <div class="options">
                                    <div class="product_option_header"><?= ucwords_tr($group->group_title) ?></div>
                                    <div class="<?= $group->group_type == "radio" ? 'mt-radio-list' : 'mt-checkbox-list' ?>">
                                        <?php foreach ($product_data["product_price_option"] as $option): ?>
                                            <?php $options_rand = rand(999, 9999); ?>
                                            <?php $options_id = $option->product_price_option_id; ?>
                                            <?php if ($option->product_price_group_id == $group_id): ?>
                                                <?php
                                                $checked = $option->default_selection == "unselected" ? "" : "checked";
                                                switch ($group->group_type) {
                                                    case"radio":
                                                        ?>
                                                        <label class="mt-radio mt-radio-outline"> 
                                                            <div class="header_title">
                                                                <div class="header_title_text"><?= $option->product_price_title ?></div>
                                                                <?php if ($option->direction == "increase"): ?>
                                                                    <?php if ($option->type == "minus"): ?>
                                                                        <div class="header_title_extra">+ <?= number_format($option->value, 2) ?> <?= strtoupper(default_currency()) ?></div>
                                                                    <?php elseif ($option->type == "rate"): ?>
                                                                        <div class="header_title_extra">+ <?= number_format($option->value, 2) ?>% <?= strtoupper(default_currency()) ?></div>
                                                                    <?php endif; ?>
                                                                <?php elseif ($option->direction == "decrease"): ?>
                                                                    <?php if ($option->type == "minus"): ?>
                                                                        <div class="header_title_extra">- <?= number_format($option->value, 2) ?> <?= strtoupper(default_currency()) ?></div>
                                                                    <?php elseif ($option->type == "rate"): ?>
                                                                        <div class="header_title_extra">- <?= number_format($option->value, 2) ?>% <?= strtoupper(default_currency()) ?></div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                            </div>
                                                            <input type="radio" product_options value="1" name="!<?= $group_id ?>" <?= $checked ?>
                                                                   data-parent_key="<?= $rnd ?>"
                                                                   data-secret_number="<?= $options_rand ?>"
                                                                   data-options_id="<?= $options_id ?>"
                                                                   data-job_id="<?= $selected_job_id ?>"
                                                                   data-group_id="<?= $group->product_price_group_id ?>"
                                                                   data-group_title="<?= $group->group_title ?>"
                                                                   data-group_type="<?= $group->group_type ?>"
                                                                   data-price_title="<?= $option->product_price_title ?>"
                                                                   data-direction="<?= $option->direction ?>"
                                                                   data-type="<?= $option->type ?>"
                                                                   data-value="<?= $option->value ?>"
                                                                   data-currency="<?= default_currency() ?>"
                                                                   />
                                                            <span></span>
                                                        </label>

                                                        <?php
                                                        break;
                                                    case"checkbox":
                                                        ?>
                                                        <label class="mt-checkbox mt-checkbox-outline"> 
                                                            <div class="header_title">
                                                                <div class="header_title_text"><?= $option->product_price_title ?></div>
                                                                <?php if ($option->direction == "increase"): ?>
                                                                    <?php if ($option->type == "minus"): ?>
                                                                        <div class="header_title_extra">+ <?= number_format($option->value, 2) ?> <?= strtoupper(default_currency()) ?></div>
                                                                    <?php elseif ($option->type == "rate"): ?>
                                                                        <div class="header_title_extra">+ <?= number_format($option->value, 2) ?>% <?= strtoupper(default_currency()) ?></div>
                                                                    <?php endif; ?>
                                                                <?php elseif ($option->direction == "decrease"): ?>
                                                                    <?php if ($option->type == "minus"): ?>
                                                                        <div class="header_title_extra">- <?= number_format($option->value, 2) ?> <?= strtoupper(default_currency()) ?></div>
                                                                    <?php elseif ($option->type == "rate"): ?>
                                                                        <div class="header_title_extra">- <?= number_format($option->value, 2) ?>% <?= strtoupper(default_currency()) ?></div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                            </div>
                                                            <input type="checkbox" product_options  value="1" name="!<?= $group_id ?>" <?= $checked ?>
                                                                   data-parent_key="<?= $rnd ?>"
                                                                   data-secret_number="<?= $options_rand ?>"
                                                                   data-options_id="<?= $options_id ?>"
                                                                   data-job_id="<?= $selected_job_id ?>"
                                                                   data-group_id="<?= $group->product_price_group_id ?>"
                                                                   data-group_title="<?= $group->group_title ?>"
                                                                   data-group_type="<?= $group->group_type ?>"
                                                                   data-price_title="<?= $option->product_price_title ?>"
                                                                   data-direction="<?= $option->direction ?>"
                                                                   data-type="<?= $option->type ?>"
                                                                   data-value="<?= $option->value ?>"
                                                                   data-currency="<?= default_currency() ?>"
                                                                   />
                                                            <span></span>
                                                        </label>
                                                        <?php
                                                        break;
                                                }
                                                ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div id="product_options"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="@job_products_fields$payment_method_workable_type:<?= $rnd ?>" value="<?= $product_settings->extra_field_workable_type ?>"/>
                <?php //if ($product_settings->extra_field_workable_type == "changeable"): ?>
                <?php if (false): ?>
                    <?php $payment_info = component::get_props("payment_info"); ?>
                    <?php if (count($payment_info) == 1): ?>
                        <div class="product_payment_group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-offset-9 col-sm-3">

                                        <div id="selected_product_payment_info">
                                            <?php
                                            switch ($payment_info[0]["method"]) {
                                                case $product_constant::credicart:
                                                    echo '<p>Kredi Kartı İle Ödeme  +' . number_format($payment_info[0]["price"], 2) . ' ' . strtoupper($payment_info[0]["unit"]) . ' Extra Bedeli var</p>';
                                                    echo '<input type="hidden" name="@job_products_fields$payment_method:' . $rnd . '" value="' . $payment_info[0]["method"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price:' . $rnd . '" value="' . $payment_info[0]["price"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price_unit:' . $rnd . '" value="' . $payment_info[0]["unit"] . '"/>';
                                                    break;
                                                case $product_constant::atthedoor:
                                                    echo '<p>Kapıda Ödeme +' . number_format($payment_info[0]["price"], 2) . ' ' . strtoupper($payment_info[0]["unit"]) . ' Extra Bedeli var</p>';
                                                    echo '<input type="hidden" name="@job_products_fields$payment_method:' . $rnd . '" value="' . $payment_info[0]["method"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price:' . $rnd . '" value="' . $payment_info[0]["price"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price_unit:' . $rnd . '" value="' . $payment_info[0]["unit"] . '"/>';
                                                    break;
                                                case $product_constant::bank:
                                                    echo '<p>Banka Havalesi ile Ödeme  +' . number_format($payment_info[0]["price"], 2) . ' ' . strtoupper($payment_info[0]["unit"]) . ' Extra Bedeli var</p>';
                                                    echo '<input type="hidden" name="@job_products_fields$payment_method:' . $rnd . '" value="' . $payment_info[0]["method"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price:' . $rnd . '" value="' . $payment_info[0]["price"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price_unit:' . $rnd . '" value="' . $payment_info[0]["unit"] . '"/>';
                                                    break;
                                                case $product_constant::inplace:
                                                    echo '<p>Yerinde Ödeme  +' . number_format($payment_info[0]["price"], 2) . ' ' . strtoupper($payment_info[0]["unit"]) . ' Extra Bedeli var</p>';
                                                    echo '<input type="hidden" name="@job_products_fields$payment_method:' . $rnd . '" value="' . $payment_info[0]["method"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price:' . $rnd . '" value="' . $payment_info[0]["price"] . '"/>';
                                                    echo '<input type="hidden" name="@job_products_fields$product_extra_price_unit:' . $rnd . '" value="' . $payment_info[0]["unit"] . '"/>';
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="product_payment_group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-offset-9 col-sm-3">
                                        <select class="form-control" id="selected_product_payment_method">
                                            <option value="<?= NODATA ?>">Ödeme Yöntemi Seçiniz</option>
                                            <?php foreach ($payment_info as $pymt): ?>
                                                <option value="<?= $pymt["method"] ?>" secret_key="<?= $rnd ?>" price="<?= $pymt["price"] ?>" price_unit="<?= $pymt["unit"] ?>"><?= $pymt["title"] ?> ile +<?= number_format($pymt["price"], 2) ?> <?= strtoupper($pymt["unit"]) ?>  Ekstra Bedel</option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div id="selected_product_payment_info"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <input type="hidden" name="@job_products_fields$payment_method:<?= $rnd ?>" value="<?= component::get_props("payment_method") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_extra_price:<?= $rnd ?>" value="<?= component::get_props("product_extra_price") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_extra_price_unit:<?= $rnd ?>" value="<?= component::get_props("product_extra_price_unit") ?>"/>
                <?php endif; ?>


                <?php if (false): ?>
                <?php //if ($product_transport_settings->workable_type == "changeable"): ?>

                    <input type="hidden" name="@job_products_fields$product_delivery_workable_type:<?= $rnd ?>" value="<?= component::get_props("product_delivery_workable_type") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_type:<?= $rnd ?>" value="<?= component::get_props("product_delivery_type") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_price:<?= $rnd ?>" value="<?= component::get_props("product_delivery_price") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_price_unit:<?= $rnd ?>" value="<?= component::get_props("product_delivery_price_unit") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_price_in:<?= $rnd ?>" value="<?= component::get_props("product_intransportproduct") ?>"/>

                    <div class="product_transport">
                        <div class="form-group">
                            <div class="row">
                                <div class=" col-sm-offset-9 col-sm-3">
                                    <?php
                                    switch (component::get_props("product_delivery_type")) {
                                        case $product_constant::transport_no:
                                            break;
                                        case $product_constant::transport_messenger:
                                            echo '<p>Kurye ile Gönderim  +' . number_format(component::get_props("product_delivery_price"), 2) . ' ' . strtoupper(component::get_props("product_delivery_price_unit")) . ' Gönderim Ücreti</p>';
                                            break;
                                        case $product_constant::transport_cargo:
                                            echo '<p>Kargo ile Gönderim  +' . number_format(component::get_props("product_delivery_price"), 2) . ' ' . strtoupper(component::get_props("product_delivery_price_unit")) . ' Gönderim Ücreti</p>';
                                            break;
                                        case $product_constant::transport_truck:
                                            echo '<p>Nakliye ile Gönderim  +' . number_format(component::get_props("product_delivery_price"), 2) . ' ' . strtoupper(component::get_props("product_delivery_price_unit")) . ' Gönderim Ücreti</p>';
                                            break;
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>

                    <input type="hidden" name="@job_products_fields$product_delivery_workable_type:<?= $rnd ?>" value="<?= component::get_props("product_delivery_workable_type") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_type:<?= $rnd ?>" value="<?= component::get_props("product_delivery_type") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_price:<?= $rnd ?>" value="<?= component::get_props("product_delivery_price") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_price_unit:<?= $rnd ?>" value="<?= component::get_props("product_delivery_price_unit") ?>"/>
                    <input type="hidden" name="@job_products_fields$product_delivery_price_in:<?= $rnd ?>" value="<?= component::get_props("product_intransportproduct") ?>"/>
                <?php endif; ?>
            </div>
        </div>
    </form>

<?php else : ?>
    <div class="row">
        <div class="col-sm-12">
            <p>Ürünler Arama Çubuğundan bir ürün araması yapın</p>
        </div>
    </div>
<?php endif; ?>
<?php component::end(); ?>
