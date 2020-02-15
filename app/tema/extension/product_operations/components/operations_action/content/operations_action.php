<?php component::start($props); ?>
<div class="row margin-bottom-15">
    <div class="col-sm-12">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn green" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Toplu İşlemler
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Kategori Değiştir </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Maliyetleri Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Fiyatları Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> İndirim Türünü Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Vergi Dilimlerini Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Gönderim Şekillerini Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Kargo Bedellerini Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Ödeme Yöntemlerini Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Teslimat Zamanlarını Düzenle </a></li>
                    <li><a data-component_run="category_form" data-component_action="load" data-modal="#category_modal"  data-starter="form,component_run" ><i class="fa fa-pencil"></i> Stok Sayısını Düzenle </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
