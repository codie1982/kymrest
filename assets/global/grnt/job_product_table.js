$.fn.job_product_table = function (options) {
    var $this = this;

    var defaults = {
        html: true,
        job_product_seccode: "---",
    }
    var settings = $.extend({}, defaults, options);


    var _html = settings.html

    if (_html) {
        addTable();
    }

    function addTable() {
        var scriptURL = "/xhr/sendjob/getjobproducttable";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "job_seccode": settings.job_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                //$("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                //$("body").find(".waiting_screen").fadeOut()

                if (data.sonuc) {
                    toastr["success"](data.msg)
                    //Plugin haline getirelim
                    $this.html(data.table)

                    $('[data-job_product="job_product_detail"]').on("click", function (e) {
                        e.preventDefault()
                        var btn = $(this);
                        var job_product_seccode = btn.data("job_product_seccode")
                        getJobProductDetail(job_product_seccode, btn)
                    })
                    $('[data-job="remove_job_product"]').on("click", function (e) {
                        e.preventDefault()
                        var btn = $(this);
                        var job_product_seccode = btn.data("job_products_seccode")
                        remove_job_product(job_product_seccode, btn)
                    })


                } else {
                    $this.html(data.table)
                    toastr["error"](data.msg)
                }
            }
        });
    }

    function getJobProductDetail(job_product_seccode, btn) {
        var scriptURL = "/xhr/sendjob/getjobproductdetail";
        var modal = $("#job_product_detail")
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "job_product_seccode": job_product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
                modal.find('[data-job_product]').each(function () {
                    $(this).html("")
                })
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
                    modal.find('[data-job_product="job_product_image"]').html('<img class="img-responsive" src="' + data.job_product_image + '" alt="' + data.job_product_name + '" />')
                    modal.find('[data-job_product="job_product_name"]').html(data.job_product_name)
                    modal.find('[data-job_product="job_product_type"]').html(data.job_product_type)
                    modal.find('[data-job_product="job_product_price"]').html(data.job_product_price)
                    modal.find('[data-job_product="job_product_amount"]').html(data.job_product_amount)
                    modal.find('[data-job_product="job_product_price"]').html(data.job_product_price)
                    modal.find('[data-job_product="product_sizes"]').html(data.product_sizes)
                    modal.find('[data-job_product="job_product_cargo_price"]').html(data.job_product_cargo_price)
                    modal.find('[data-job_product="job_product_discount_price"]').html(data.job_product_discount_price)
                    modal.find('[data-job_product="job_product_total_price"]').html(data.job_product_total_price)
                    if (data.job_product_type == "poster") {
                        modal.find('[data-job_product="image_button"]').html('<a class="btn btn-xs btn-info" href="#job_product_image_detail" data-toggle="modal" data-job_product="get_detail_image" data-job_product_seccode="' + job_product_seccode + '">Resmi İncele</a>')
                    }
                    $('[data-job_product="get_detail_image"]').on("click", function (e) {
                        e.preventDefault()
                        var job_product_seccode = $(this).data("job_product_seccode");
                        job_product_image_detail(job_product_seccode)
                    })


                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
    function job_product_image_detail(job_product_seccode) {
        var modal = $("#job_product_image_detail")
        var scriptURL = "/xhr/sendjob/getjobproductimagedetail";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "job_product_seccode": job_product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
                $("body").find(".waiting_screen").fadeIn()
            },
            success: function (data) {
                $("body").find(".waiting_screen").fadeOut()
                if (data.sonuc) {
                    toastr["success"](data.msg)
//                        $data["job_product_image"] = $orjimg;
//                        $data["job_product_crop_image"] = $cropimg;
                    var imgorj = '<img class="job_product_image_orjinal" src="' + data.job_product_image + '" alt="---" />';
                    var imgorj_width = $("img.job_product_image_orjinal").outerWidth()
                    console.log(data.crop_data)
                    var crop = '<img style="left:' + data.crop_data.imageX + 'px;top:' + data.crop_data.imageY + 'px" class="job_product_image_crop"  src="' + data.job_product_crop_image + '" alt="---" />';
                    var container = '<div class="job_product_image_container">' + imgorj + crop + '</div>';
                    modal.find('[data-job_product="job_product_image_detail"]').html(container)
                    modal.find('[data-job_product="job_product_image_crop_data_x"]').html("Soldan : " + data.crop_data.imageX + " px")
                    modal.find('[data-job_product="job_product_image_crop_data_y"]').html("Yukardan : " + data.crop_data.imageY + " px")
                } else {
                    toastr["error"](data.msg)
                }
            }
        });
    }
  

 

    //data-job="remove_job_product"
    $('[data-job="remove_job_product"]').on("click", function (e) {
        e.preventDefault()
        var btn = $(this);
        var job_product_seccode = btn.data("job_products_seccode")

        remove_job_product(job_product_seccode, btn)
    })

    function remove_job_product(job_product_seccode, btn) {
        var scriptURL = "/xhr/sendjob/removejobproduct";
        $.ajax({type: "post",
            url: scriptURL,
            data: {
                "job_product_seccode": job_product_seccode,
            },
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                if (data.sonuc) {

                    if (typeof btn !== "undefined") {
                        btn.parents("tr").fadeOut("500", function () {
                            $(this).remove()
                        })
                    } else {
                        $this.find("table tr").each(function () {
                            var checkbox = $(this).children("td").find('input[type="checkbox"]')
                            var checkbox_job_seccode = checkbox.data("job_seccode")
                            if (checkbox_job_seccode == job_seccode) {
                                $(this).remove()
                            }
                        })
                    }


                    btn.parents("li").fadeOut("500", function () {
                        $(this).remove()
                    })
                    toastr["success"](data.msg)
                } else {
                    toastr["danger"](data.msg)
                }
            }
        });
    }

    return {
        addTable: function () {
            //addTable()
            return $this;
        },
        remove_job_product: function (job_product_seccode) {
            remove_job_product(job_product_seccode)
            return $this;
        },
      

    }
}

