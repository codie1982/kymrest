<?php component::start() ?>
<!-- BEGIN PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-red-sunglo hide"></i>
            <span class="caption-subject font-dark bold uppercase">Genel İşleyiş Grafiği</span>
            <span class="caption-helper">Süreç...</span>
        </div>
 
        <div class="actions">
            <div class="clearfix">  
                <div class="btn-group chart_list">
                    <label class="btn btn-default active" >
                        <input type="checkbox" data-chart="visitor_count" style="opacity: 0" /> Ziyaretçi Sayısı </label>
                    <label class="btn btn-default ">
                        <input type="checkbox" data-chart="sales_count" style="opacity: 0"/> Satışlar </label>
                    <label class="btn btn-default">
                        <input type="checkbox" data-chart="sales_onbasket_count" style="opacity: 0"/> Sepete Atılanlar </label>
                    <label class="btn btn-default">
                        <input type="checkbox" data-chart="return_sales_count" style="opacity: 0"/> İade Edilen Satışlar</label>
                </div>
                <div class="btn-group">
                    <a href="" class="btn dark btn-outline dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Zaman
                        <span class="fa fa-angle-down"> </span>
                    </a>
                    <ul  class="dropdown-menu pull-right time-list ">
                        <li class="active"><a  href="javascript:;" data-time="today"> Bugün </a></li>
                        <li><a  href="javascript:;" data-time="yesterday"> Dün </a></li>
                        <li><a  href="javascript:;" data-time="last_7"> Son 7 Gün </a></li>
                        <li><a  href="javascript:;" data-time="last_30"> Son 30 Gün </a></li>
                        <li><a  href="javascript:;" data-time="last_60"> Son 60 Gün </a></li>
                        <li><a  href="javascript:;" data-time="last_90"> Son 90 Gün </a></li>
                        <li><a  href="javascript:;" data-time="custom"> Tarih Seçin </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="custom_time_start" value="" />
    <input type="hidden" id="custom_time_end" value="" />
    <div class="portlet-body">
        <!--<div id="site_activities_loading"><img src="assets/global/img/loading.gif" alt="loading" /> </div>-->
        <div id="area-chart"></div>
    </div>
</div>
<!-- END PORTLET-->
<?php component::end("general_chart") ?>