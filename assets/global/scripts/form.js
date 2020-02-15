var form = function () {
    var sendxhr = function () {
        async function sendform(form) {
            var url = window.location.href;
            var a = document.createElement('a');
            a.href = url;
            var hostname = "http://" + a.hostname;
            let formdata = form.serialize();
            let component_name = form.data("component_name");
            let action = form.data("action");
            const  options = {
                component_name: component_name,
                action: action,
            }
            console.log(component_controller_url(options))
            $.ajax({type: "post",
                url: component_controller_url(options),
                data: {"formdata": formdata},
                dataType: "json",
                beforeSend: function () {
                    toastr["warning"]("Kontrol Ediliyor")
                },
                success: function (data) {
                    console.log(data)

                    if (data.sonuc) {
                        if (typeof data.msg !== "undefined") {
                            toastr["success"](data.msg)
                        } else {
                            if (typeof data.success_message !== "undefined")
                                data.success_message.forEach(message => {
                                    toastr["success"](message)
                                })
                        }
                        if (typeof data.warning_message !== "undefined") {
                            data.warning_message.forEach(message => {
                                toastr["warning"](message)
                            })
                        }
//                      $data["recomponent"][] = ["component_name" => "category_tree_list", "component_action" => "load"];
//                      $data["recomponent"][] = ["component_name" => "category_main_list", "component_action" => "load"];
//                      $data["recomponent"][] = ["component_name" => "category_table", "component_action" => "load"];


                        if (typeof data.recomponent != "undefined") {
                            if (data.recomponent) {
                                for (let i = 0; i < data.recomponent.length; i++) {
                                    let component = data.recomponent[i]
                                    if (component.data != "undefined") {
                                        component_run.run({
                                            component_name: component.component_name,
                                            component_action: component.component_action,
                                            component_object: component.component_object,
                                        })
                                    } else {
                                        component_run.run({
                                            component_name: component.component_name,
                                            component_action: component.component_action,
                                        })
                                    }

                                }
                            }
                        }

                        if (data.redirect) {
                            window.location.href = data.redirect
                        }
                    } else {
                        console.log(data.error_message)
                        if (typeof data.msg !== "undefined") {
                            toastr["error"](data.msg)
                        } else {
                            data.error_message.forEach(message => {
                                toastr["error"](message)
                            })
                        }

                        if (data.redirect) {
                            window.location.href = hostname + data.redirect
                        }
                    }
                }
            });
        }
        $('[data-send="xhr"]').off()
        $('[data-send="xhr"]').on("submit", function (e) {
            e.preventDefault();
            let $this = $(this)
//    console.log($this.data("component_name"))
//    console.log($this.data("action"))
            if ($this.data("component_name") === "" || typeof $this.data("component_name") === "undefined") {
                if ($this.data("action") === "" || typeof $this.data("action") === "undefined") {
                    console.error("Form Bilginiz içersinde 'action' bilgisi bulunmamaktadır. data-action=\"fonksiyon ismi\" şeklinde ekleyiniz");
                } else {
                    console.error("Form Bilginiz içersinde 'component_name' alanı bulunmamaktadır. data-component_name=\"Component İsmi\" şeklinde ekleyiniz");
                }
            } else {
                sendform($this)
            }

        })
    }
    return {
        init: function () {
            sendxhr()
        }
    }
}();

jQuery(document).ready(function () {
    form.init(); // init metronic core componets
});