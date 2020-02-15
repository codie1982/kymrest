<?php component::start($props); ?>
<?php ?>  
<div class="modal fade bs-modal-lg " id="jobs" tabindex="-1" role="basic" aria-hidden="true" >
    <div class="modal-dialog modal-lg" style="width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">

                <div class="row"> 
                    <div class="col-md-12">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption m-heading-1 border-green m-bordered " style="width: 100%;">
                                    <i class="icon-settings font-dark" style="margin-left: 10px;"></i>
                                    <span class="caption-subject font-dark sbold uppercase">Yeni Sipariş Ekleyin</span>
                                </div>
                            </div>

                            <div class="portlet-body">

                                <div class="form-wizard">
                                    <div class="form-body">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li class="active" >
                                                <a href="#tab1" data-toggle="tab" class="step">
                                                    <span class="number"> 1 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Müşteri </span>
                                                </a>
                                            </li>
                                            <li   >
                                                <a href="#tab2" data-toggle="tab" class="step" aria-expanded="true">
                                                    <span class="number"> 2</span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Ürünleri </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab4" data-toggle="tab" class="step">
                                                    <span class="number"> 3 </span>
                                                    <span class="desc">
                                                        <i class="fa fa-check"></i> Siparişi Tamamla </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success"> </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                <h3 class="block">Kullanıcı Belirleyin</h3>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kullanıcı Seçin
                                                    </label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" id="customer_search" data-search="customer" ></select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <?= component::get_props("job_new") ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                <?= component::get_props("job_id") ?>
                                                <h3 class="block">Ürünlerinizi Ekleyin</h3>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="control-label col-md-3">Ürünler</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control" id="products_search" data-search="products" ></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="height: 100%;">
                                                    <div class="col-md-8">
                                                        <?= component::get_props("job_form_products_detail") ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?= component::get_props("job_products_list") ?>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="tab-pane" id="tab3">
                                                <h3 class="block">Sipariş için Ödeme Yöntemleri ve Ardes Bilgisini Ekleyin</h3>
                                            </div>
                                            <div class="tab-pane" id="tab4">
                                                <h3 class="block">Siparişi Tamamlayın</h3>
                                                <h4 class="form-section">Sipariş Bilgileri</h4>
                                                <div class="form-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit"  class="btn green btn-block btn-lg"> Siparişi Tamamla
                                                                <i class="fa fa-check"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php component::end(); ?>
