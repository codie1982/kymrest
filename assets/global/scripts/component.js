$('[data-component_run]').on("click", function (e) {
    e.preventDefault();
    const component_name = $(this).data("component_run")
    const action = $(this).data("component_action")
    const component_data = $(this).data("component-data")
    const  options = {
        component_name: component_name,
        action: action,

    }
    console.log("de")
    $.ajax({type: "post",
        url: component_controller_url(options),
        data: {"formdata": component_data},
        dataType: "json",
        beforeSend: function () {
            toastr["warning"]("Kontrol Ediliyor")
        },
        success: function (data) {
            if (data.sonuc) {
                if (typeof data.msg !== "undefined") {
                    toastr["success"](data.msg)
                } else {
                    data.success_message.forEach(message => {
                        toastr["success"](message)
                    })
                }
                if (typeof data.warning_message !== "undefined") {
                    data.warning_message.forEach(message => {
                        toastr["warning"](message)
                    })
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

})
