var makexhr = function () {
    return {
        send: function (options) {
            var defaults = {
                component_name: "",
                action: "",
                data: {},
                before: function (data) { },
                complete: function (data) { },
                complete_component_run: function (options) { },
                error: function (data) { },
                error_component_run: function (options) { },

            }
            var settings = $.extend({}, defaults, options);
            const  urloptions = {
                component_name: settings.component_name,
                action: settings.action,
            }
            $.ajax({type: "post",
                url: component_controller_url(urloptions),
                data: settings.data,
                dataType: "json",
                beforeSend: function (data) {

                    toastr["warning"]("Kontrol Ediliyor")
                    if (typeof settings.before !== "undefined") {
                        settings.before(data);
                    }
                },
                success: function (data) {
                    if (data.sonuc) {
                        if (typeof settings.complete !== "undefined") {
                            settings.complete(data);
                        }
                        if (typeof data.msg !== "undefined") {
                            toastr["success"](data.msg)
                        } else {
                            if (typeof data.success_message != "undefined")
                                data.success_message.forEach(message => {
                                    toastr["success"](message)
                                })
                        }
                        if (typeof data.warning_message !== "undefined") {
                            data.warning_message.forEach(message => {
                                toastr["warning"](message)
                            })
                        }

                        if (typeof settings.complete_component_run !== "undefined") {
                            settings.complete_component_run();
                        }
                        if (data.redirect) {
                            window.location.href = data.redirect
                        }
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


                    } else {
                        if (typeof settings.error !== "undefined") {
                            settings.error(data);
                        }

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
    }
}();