<?php component::start($props); ?>
<div class="row margin-bottom-15">
    <div class="col-sm-12">
        <div class="btn-toolbar">
            <div class="btn-group">
                <a class="btn green" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-anchor"></i> Yeni Medya Ekleyin
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a data-component_run="load_image_form" data-component_action="load" data-modal="#load_image_form"  data-starter="form,component_run" ><i class="fa fa-image"></i> Yeni Resim Yükle </a></li>
                    <li><a data-component_run="load_video_form" data-component_action="load" data-modal="#load_video_form" data-starter="form,component_run"  ><i class="fa fa-video-camera"></i> Yeni Video Yükle</a></li>
                    <li><a data-component_run="load_audio_form" data-component_action="load" data-modal="#load_audio_form" data-starter="form,component_run"  ><i class="fa fa-lastfm"></i> Yeni Ses Yükle</a></li>
                    <li><a data-component_run="load_document_form" data-component_action="load" data-modal="#load_document_form" data-starter="form,component_run"  ><i class="fa fa-file"></i> Yeni Döküman Yükle</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php component::end(); ?>
