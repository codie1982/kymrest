var short_table = function () {

    return {
        init: function () {

            $("#category_table tbody").sortable({
                opacity: 0.5,
                delay: 250,
                update: function (event, ui) {
                    console.log($(this))
                    var category_seccode = [];
                    $(this).children("tr").each(function () {
                        category_seccode.push($(this).find('input[name="category_id"]').val())
                    })


//                var scriptURL = "/xhr/productcategory/linecategory";
//                $.ajax({type: "post",
//                    url: scriptURL,
//                    async: true,
//                    cache: false,
//                    data: {"category_seccode": category_seccode},
//                    dataType: "json",
//                    beforeSend: function () {
//                        $("body").find(".waiting_screen").fadeIn()
//                    },
//                    success: function (data) {
//                        $("body").find(".waiting_screen").fadeOut()
//                        if (data.sonuc) {
//                            toastr["success"](data.msg)
//                        } else {
//                            toastr["success"](data.msg)
//                        }
//                    }
//                });

                }

            })
        }
    }
}()

$(document).ready(function () {
    short_table.init(); // init metronic core componets
});