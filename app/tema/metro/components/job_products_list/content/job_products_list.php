<?php component::start($props); ?>
<div class="product_list_content">
    <?php $job = component::get_props("job"); ?>
    <?php if (!empty($job)): ?>

        <ul class="product_list">
            <?php foreach (component::get_props("job_products") as $job_product): ?>
                <li class="item">
                    <?php
                    $nproduct_info = new table_product();
                    $nproduct_info->select();
                    $nproduct_info->add_condition("product_id", $job_product->product_id);
                    $nproduct_info->add_condition("public", 1);
                    $product_info = $nproduct_info->get_alldata(true);
                    ?>
                    <?php if (!empty($product_info)): ?>
                        <a href="javascript:void(0)">
                            <div class="product_list_info">
                                <div class="title"><?= ucwords_tr($product_info->product_name) ?></div>
                                <div class="amnout"><?= $job_product->amount ?> Adet</div>
                                <div class="price"><?= number_format($job_product->product_price, 2); ?> <?= strtoupper($job_product->product_price_unit) ?></div>
                            </div>
                            <?php
                            $groupid = [];


                            if (!empty(component::get_props("job_products_options"))) {
                                foreach (component::get_props("job_products_options") as $grp) {
                                    if ($grp->job_products_id == $job_product->job_products_id) {
                                        $groupid[] = $grp->job_product_price_group_id;
                                        $grouptitle[] = $grp->job_product_price_group_title;
                                    }
                                }
                                $fgroupid = fix_array(array_unique($groupid));
                                $fgrouptitle = fix_array(array_unique($grouptitle));
                                $i = 0;


                                while ($i <= count($fgroupid) - 1) {
                                    echo '<div class="product_list_info_detail"><div class="info_detail">';
                                    echo '<h5 class="mega_title">' . $fgrouptitle[$i] . '</h5>';
                                    echo '<ul class="options_list">';
                                    foreach (component::get_props("job_products_options") as $ggrp) {
                                        if ($ggrp->job_products_id == $job_product->job_products_id) {
                                            if ($fgroupid[$i] == $ggrp->job_product_price_group_id) {
                                                echo '<li class="options"><span>' . $ggrp->price_title . '</span></li>';
                                            }
                                        }
                                    }
                                    echo '</ul>';
                                    echo '</div></div>';
                                    $i++;
                                }
                            }
                            ?>

                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>


        <div class="product_footer">
            <div class="product_total_price">Toplam 22.00 TL</div>
        </div>
    <?php else: ?>
        <div class="product_footer">
            <p>Sipariş Kartınız Boş Gözüküyor. <br />Sipariş Kartınıza bir kaç ürün eklemeyi deneyin</p>
        </div>
    <?php endif; ?>



</div>
<?php component::end(); ?>
