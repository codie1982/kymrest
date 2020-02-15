var component_run = function () {
    let recomponent = "";
    function rn(component_name, component_action, data, $this) {
        if (component_action == "") {
            component_action = "load"
        }
        options = {
            component_name: component_name,
            action: component_action,
            data: data,
            complete: function (data) {
                if (data.sonuc) {
                    
                   
                    if (typeof data.remove !== "undefined")
                        if (data.remove) {
                            $this.parents(data.parents).fadeOut(500, function () {
                                $(this).remove()
                            })
                        }

                    if (typeof data.addtype === "undefined") {
                        $('[component_name="' + component_name + '"]').html(data.content)
                    } else {
                        if (data.addtype == "append") {
                            if (typeof data.$this !== "undefined") {
                                if (typeof data.find !== "undefined") {
                                    $('[component_name="' + component_name + '"]').find(data.find).append(data.content)
                                } else {
                                    $('[component_name="' + component_name + '"]').append(data.content)
                                }
                            } else {
                                if (typeof data.find !== "undefined") {
                                    $('[component_name="' + component_name + '"]').find(data.find).append(data.content)
                                } else {
                                    $('[component_name="' + component_name + '"]').append(data.content)
                                }
                            }
                        } else if (data.addtype == "html") {
                            if (typeof data.find !== "undefined") {
                                $('[component_name="' + component_name + '"]').find(data.find).html(data.content)
                            } else {
                                $('[component_name="' + component_name + '"]').html(data.content)
                            }

                        }
                    }
console.log(data)
                    if (typeof data.starter != "undefined") {
                        data.starter.forEach(function (item, index) {
                            eval(item + ".init()");
                        })
                    }
                    
                    if (typeof data.modal != "undefined") {
                        $(data.modal).modal("show")
                    }
                }
            }
        }
        makexhr.send(options)
    }
    return {
        run: function (component_options) {
            var component_name, component_action, component_key, component_data, component_object = {}, modal, starter, $this, parents;

            if (typeof component_options !== "undefined") {
                component_name = component_options.component_name
                component_action = component_options.component_action
                component_key = component_options.component_key
                component_data = component_options.component_data
                component_object = component_options.component_object
                recomponent = component_options.recomponent
                modal = component_options.modal
                starter = component_options.starter
            }
            var data = {};
            if (typeof component_object === "undefined") {
                if (typeof component_key === "undefined") {
                    data.data = ["empty"];
                } else {
                    data[component_key] = component_data;

                }
            } else {
                data = component_object;
            }


            if (typeof modal != "undefined") {
                data.modal = modal;
            }
            if (typeof starter != "undefined") {
                let start_array = [];
                start_array = starter.split(",")
                data.starter = start_array;
            }
            rn(component_name, component_action, data);

        },
        init: function () {
            $('[data-component_run]').off()
            $('[data-component_run]').on("click", function (e) {
                e.preventDefault();
                var component_name, component_action, component_key, component_data, modal, starter;
                var $this = $(this)

                component_name = $(this).data("component_run")
                component_action = $(this).data("component_action")
                component_key = $(this).data("component_key")
                component_data = $(this).data("component_data")
                recomponent = $(this).data("recomponent")
                modal = $(this).data("modal")
                starter = $(this).data("starter")

                var data = {};
                if (typeof component_key === "undefined") {
                    data.data = ["empty"];
                } else {
                    var ck = component_key.split(",");
                    if (ck.length > 1) {
                        var cd = component_data.split(",");
                        for (let i = 0; i < ck.length; i++) {
                            data[ck[i]] = cd[i];
                        }
                    } else {
                        data[component_key] = component_data;
                    }


                }
                if (typeof modal != "undefined") {
                    data.modal = modal;
                }
                if (typeof starter != "undefined") {
                    let start_array = [];
                    start_array = starter.split(",")
                    data.starter = start_array;
                }
                rn(component_name, component_action, data, $this);
            })
        }
    }

}();

$(document).ready(function () {
    component_run.init(); // init metronic core componets
});












