<?php component::start(); ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-social-dribbble font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">Kategorileriniz</span>
        </div>
        <div class="actions">
            <a class="btn btn-circle btn-icon-only btn-default" style="color:#111" href="javascript:;">
                <i class="fa fa-refresh" data-component_run="category_tree_list" data-component_action="load"  data-starter="component_run"></i>
            </a>
        </div>
    </div>
    <div id="category_tree"></div>
    <input type="hidden" id="selected_category_id" />
    <input type="hidden" id="selected_category_name" />
    <input type="hidden" id="category_starter" />
</div>
<?php component::end(); ?>
