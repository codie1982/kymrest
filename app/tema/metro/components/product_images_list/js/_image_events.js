var image_events = function () {
    return {
        init: function (images_info) {
            if (typeof images_info !== "undefined") {
                var url = window.location.href;
                var a = document.createElement('a');
                a.href = url;
                var hostname = "http://" + a.hostname + "/";

                var content = "";
                var img_souce = "";


                //console.log(images_info)
                var output = $("#output_gallery");
                var sort_len = output.find(".sortable").length

                if (sort_len == 0) {
                    content = '<ul class="sortable">';
                    content += '';
                }

                for (var i = 0; i < Object.keys(images_info).length; i++) {
                    var key = Math.round((Math.random() * 1000));
                    img_souce = images_info[i].relative_path + images_info[i].first_image_name + "_ORJ." + images_info[i].extention
                    content += '<li>\n\
                <div class="product_gallery">\n\
                    <div style="position:relative">\n\
                    <input type="hidden" name="@product_gallery_fields$secret_number:' + key + '" value="' + key + '">\n\
                    <input class="image_gallery_id" type="hidden" name="@product_gallery_fields$image_gallery_id:' + key + '" value="' + images_info[i].image_gallery_id + '" />\n\
                    <input class="image_line_id" type="hidden" name="@product_gallery_fields$image_line:' + key + '" value="' + (i + 1) + '" />\n\
                    <img class="img-responsive img-thumbnail" src="/' + img_souce + '" alt="product_gallery_image"/>\n\
                    <button class="btn btn-danger btn-rounded btn-xs" data-product_image="remove" style="position:absolute;right:0;top:0;border-radius:10% !important"><span class="fa fa-trash"></span></button>\n\
                    </div>\n\
                </div>\n\
            </li>'
                }

                if (sort_len == 0) {
                    content += '</ul>'
                }
                if (sort_len == 0) {
                    $("#output_gallery").append(content)
                } else {
                    $(".sortable").append(content)
                }
                var count = 1;
                $("ul.sortable li").each(function () {
                    $(this).find('input.image_line_id').val(count);
                    count++;
                })

                // $("#product_gallery_image_line").html('<input type="hidden" name="@product_gallery_fields$image_line" value="' + img_line.join(", ") + '" />')

                $('[data-product_image="remove"]').on("click", function (e) {
                    $(this).parents("li").remove()
                })
                $(".sortable").sortable({
                    opacity: 0.5,
                    delay: 250,
                    start: function (event, ui) {

                    },
                    stop: function (event, ui) {
                        $("#event_list").html("Sonlandı")
                    },
                    sort: function (event, ui) {
                        $("#event_list").html("Sıralandı")
                    },
                    activate: function (event, ui) {
                        $("#event_list").html("activate")
                    },
                    update: function (event, ui) {
                        var image_line = 0;
                        var imgline = "";
                        var vla;
                        var count = 1;
                        var img_line = [];
                        $("#product_gallery_image_line").html("")
                        $("ul.sortable li").each(function () {
                            $(this).find('input.image_line_id').val(count);
                            count++;
                        })
                    }
                });
            }
        }
    }
}()