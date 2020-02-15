<?php component::start(); ?>
<?php $settings_id = component::get_props("settings_id"); ?>
<?php $my_company_data = component::get_props("my_company_data"); ?>

<?php if ($my_company_data): ?>
    <div class="row">
        <div class="col-sm-3">
            <label for="" class="control-label">Sizin Firmanız</label>
        </div>
        <div class="col-sm-6">
            <?php
            if ($my_company_data["customer_company"][0]->company_type == "person") {
                $company_type = "(Şahıs Şirketi)";
            }
            ?>
            <h4><strong><?= ucwords_tr(html_entity_decode($my_company_data["customer_company"][0]->customer_company_title)) ?> <?= $company_type ?></strong></h4>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-danger btn-circle" data-component_run="general_settings_mycompany" data-component_action="remove_company" data-component_key="key" data-component_data="<?= $settings_id ?>">Kaldır</button>
        </div>
    </div>
<?php endif; ?>
<?php component::end(); ?>
