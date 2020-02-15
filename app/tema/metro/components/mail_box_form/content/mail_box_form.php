<?php component::start($props); ?>

<div class="inbox">
    <div class="row">
        <div class="col-md-2">
            <div class="inbox-sidebar">
                <a href="javascript:;" data-title="Compose" class="btn red compose-btn btn-block">
                    <i class="fa fa-edit"></i> Compose </a>
                <ul class="inbox-nav">
                    <li class="active">
                        <a href="javascript:;" data-type="inbox" data-title="Inbox"> Inbox
                            <span class="badge badge-success">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-type="important" data-title="Inbox"> Important </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-type="sent" data-title="Sent"> Sent </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-type="draft" data-title="Draft"> Draft
                            <span class="badge badge-danger">8</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:;" class="sbold uppercase" data-title="Trash"> Trash
                            <span class="badge badge-info">23</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-type="inbox" data-title="Promotions"> Promotions
                            <span class="badge badge-warning">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-type="inbox" data-title="News"> News </a>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col-md-10">
            <div class="inbox-body">
                <div class="inbox-header">
                    <h1 class="pull-left">Inbox</h1>
                    <form class="form-inline pull-right" action="index.html">
                        <div class="input-group input-medium">
                            <input type="text" class="form-control" placeholder="Password">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn green">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                    </form>
                </div>
                <div class="inbox-content">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="mail-group-checkbox" />
                                        <span></span>
                                    </label>
                        <div class="btn-group input-actions">
                            <a class="btn btn-sm blue btn-outline dropdown-toggle sbold" href="javascript:;" data-toggle="dropdown"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-pencil"></i> Mark as Read </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-ban"></i> Spam </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </li>
                            </ul>
                        </div>
                        </th>
                        <th class="pagination-control" colspan="3">
                            <span class="pagination-info"> 1-30 of 789 </span>
                            <a class="btn btn-sm blue btn-outline">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="btn btn-sm blue btn-outline">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="unread" data-messageid="1">
                                <td class="inbox-small-cells">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="mail-checkbox" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Petronas IT </td>
                        <td class="view-message "> New server for datacenter needed </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> 16:30 PM </td>
                        </tr>
                        <tr class="unread" data-messageid="2">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Daniel Wong </td>
                        <td class="view-message"> Please help us on customization of new secure server </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="3">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="4">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Facebook </td>
                        <td class="view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="5">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star inbox-started"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="6">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star inbox-started"></i>
                        </td>
                        <td class="view-message hidden-xs"> Facebook </td>
                        <td class="view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="7">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star inbox-started"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="8">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Facebook </td>
                        <td class="view-message view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="9">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="10">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Facebook </td>
                        <td class="view-message view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="11">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star inbox-started"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="12">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star inbox-started"></i>
                        </td>
                        <td class="hidden-xs"> Facebook </td>
                        <td class="view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="13">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="14">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="hidden-xs"> Facebook </td>
                        <td class="view-message view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="15">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="16">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Facebook </td>
                        <td class="view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="17">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star inbox-started"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells"> </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        <tr data-messageid="18">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> Facebook </td>
                        <td class="view-message view-message"> Dolor sit amet, consectetuer adipiscing </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> March 14 </td>
                        </tr>
                        <tr data-messageid="19">
                            <td class="inbox-small-cells">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="mail-checkbox" value="1" />
                                    <span></span>
                                </label>
                            </td>
                            <td class="inbox-small-cells">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="view-message hidden-xs"> John Doe </td>
                        <td class="view-message"> Lorem ipsum dolor sit amet </td>
                        <td class="view-message inbox-small-cells">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="view-message text-right"> March 15 </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="inbox-header inbox-view-header">
                        <h1 class="pull-left">New server for datacenter needed
                            <a href="javascript:;"> Inbox </a>
                        </h1>
                        <div class="pull-right">
                            <a href="javascript:;" class="btn btn-icon-only dark btn-outline">
                                <i class="fa fa-print"></i>
                            </a>
                        </div>
                    </div>
                    <div class="inbox-view-info">
                        <div class="row">
                            <div class="col-md-7">
                                <img src="../assets/pages/media/users/avatar1.jpg" class="inbox-author"/>
                                <span class="sbold">Petronas IT </span>
                                <span>&#60;support@go.com&#62; </span> to
                                <span class="sbold"> me </span> on 08:20PM 29 JAN 2013 </div>
                            <div class="col-md-5 inbox-info-btn">
                                <div class="btn-group">
                                    <button data-messageid="23" class="btn green reply-btn">
                                        <i class="fa fa-reply"></i> Reply
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;" data-messageid="23" class="reply-btn">
                                                <i class="fa fa-reply"></i> Reply </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-arrow-right reply-btn"></i> Forward </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-print"></i> Print </a>
                                        </li>
                                        <li class="divider"> </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-ban"></i> Spam </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <i class="fa fa-trash-o"></i> Delete </a>
                                        </li>
                                        <li>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="inbox-view">
                                                <p>
                                                    <strong>Lorem ipsum</strong>dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl
                                                    ut aliquip ex ea commodo consequat. </p>
                                                <p> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et
                                                    <a href="javascript:;"> iusto odio dignissim </a> qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi
                                                    non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. </p>
                                                <p> Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. </p>
                                                <p> Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem
                                                    modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum. </p>
                                            </div>
                                            <hr>
                                            <div class="inbox-attached">
                                                <div class="margin-bottom-15">
                                                    <span>attachments — </span>
                                                    <a href="javascript:;">Download all attachments </a>
                                                    <a href="javascript:;">View all images </a>
                                                </div>
                                                <div class="margin-bottom-25">
                                                    <img src="../assets/pages/media/gallery/image4.jpg"/>
                                                    <div>
                                                        <strong>image4.jpg</strong>
                                                        <span>173K </span>
                                                        <a href="javascript:;">View </a>
                                                        <a href="javascript:;">Download </a>
                                                    </div>
                                                    <div class="margin-bottom-25">
                                                        <img src="../assets/pages/media/gallery/image3.jpg"/>
                                                        <div>
                                                            <strong>IMAG0705.jpg</strong>
                                                            <span>14K </span>
                                                            <a href="javascript:;">View </a>
                                                            <a href="javascript:;">Download </a>
                                                        </div>
                                                    </div>
                                                    <div class="margin-bottom-25">
                                                        <img src="../assets/pages/media/gallery/image5.jpg"/>
                                                        <div>
                                                            <strong>test.jpg</strong>
                                                            <span>132K </span>
                                                            <a href="javascript:;">View </a>
                                                            <a href="javascript:;">Download </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            <form class="inbox-compose form-horizontal" id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                                                <div class="inbox-compose-btn">
                                                    <button class="btn green">
                                                        <i class="fa fa-check"></i>Send</button>
                                                    <button class="btn default inbox-discard-btn">Discard</button>
                                                    <button class="btn default">Draft</button>
                                                </div>
                                                <div class="inbox-form-group mail-to">
                                                    <label class="control-label">To:</label>
                                                    <div class="controls controls-to">
                                                        <input type="text" class="form-control" name="to">
                                                            <span class="inbox-cc-bcc">
                                                                <span class="inbox-cc"> Cc </span>
                                                                <span class="inbox-bcc"> Bcc </span>
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="inbox-form-group input-cc display-hide">
                                                    <a href="javascript:;" class="close"> </a>
                                                    <label class="control-label">Cc:</label>
                                                    <div class="controls controls-cc">
                                                        <input type="text" name="cc" class="form-control"> </div>
                                                </div>
                                                <div class="inbox-form-group input-bcc display-hide">
                                                    <a href="javascript:;" class="close"> </a>
                                                    <label class="control-label">Bcc:</label>
                                                    <div class="controls controls-bcc">
                                                        <input type="text" name="bcc" class="form-control"> </div>
                                                </div>
                                                <div class="inbox-form-group">
                                                    <label class="control-label">Subject:</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control" name="subject"> </div>
                                                </div>
                                                <div class="inbox-form-group">
                                                    <textarea class="inbox-editor inbox-wysihtml5 form-control" name="message" rows="12"></textarea>
                                                </div>
                                                <div class="inbox-compose-attachment">
                                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                    <span class="btn green btn-outline fileinput-button">
                                                        <i class="fa fa-plus"></i>
                                                        <span> Add files... </span>
                                                        <input type="file" name="files[]" multiple> </span>
                                                    <!-- The table listing the files available for upload/download -->
                                                    <table role="presentation" class="table table-striped margin-top-10">
                                                        <tbody class="files"> </tbody>
                                                    </table>
                                                </div>
                                                <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                                                    <tr class="template-upload fade">
                                                    <td class="name" width="30%">
                                                    <span>{%=file.name%}</span>
                                                    </td>
                                                    <td class="size" width="40%">
                                                    <span>{%=o.formatFileSize(file.size)%}</span>
                                                    </td> {% if (file.error) { %}
                                                    <td class="error" width="20%" colspan="2">
                                                    <span class="label label-danger">Error</span> {%=file.error%}</td> {% } else if (o.files.valid && !i) { %}
                                                    <td>
                                                    <p class="size">{%=o.formatFileSize(file.size)%}</p>
                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                    </div>
                                                    </td> {% } else { %}
                                                    <td colspan="2"></td> {% } %}
                                                    <td class="cancel" width="10%" align="right">{% if (!i) { %}
                                                    <button class="btn btn-sm red cancel">
                                                    <i class="fa fa-ban"></i>
                                                    <span>Cancel</span>
                                                    </button> {% } %}</td>
                                                    </tr> {% } %} </script>
                                                <!-- The template to display files available for download -->
                                                <script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
                                                    <tr class="template-download fade"> {% if (file.error) { %}
                                                    <td class="name" width="30%">
                                                    <span>{%=file.name%}</span>
                                                    </td>
                                                    <td class="size" width="40%">
                                                    <span>{%=o.formatFileSize(file.size)%}</span>
                                                    </td>
                                                    <td class="error" width="30%" colspan="2">
                                                    <span class="label label-danger">Error</span> {%=file.error%}</td> {% } else { %}
                                                    <td class="name" width="30%">
                                                    <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
                                                    </td>
                                                    <td class="size" width="40%">
                                                    <span>{%=o.formatFileSize(file.size)%}</span>
                                                    </td>
                                                    <td colspan="2"></td> {% } %}
                                                    <td class="delete" width="10%" align="right">
                                                    <button class="btn default btn-sm" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}" {% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                                                    <i class="fa fa-times"></i>
                                                    </button>
                                                    </td>
                                                    </tr> {% } %} </script>
                                                <div class="inbox-compose-btn">
                                                    <button class="btn green">
                                                        <i class="fa fa-check"></i>Send</button>
                                                    <button class="btn default">Discard</button>
                                                    <button class="btn default">Draft</button>
                                                </div>
                                            </form>

                                            <?php component::end(); ?>
