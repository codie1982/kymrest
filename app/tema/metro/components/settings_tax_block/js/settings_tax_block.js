var settings_tax_block = function () {
    var settings_tax = function () {
        var predata = document.querySelectorAll('[data-settings_tax_block]');
        let options = {
            component_name: "settings_tax_block",
            secret_number: false,
            formGroup: true,
            templateStyle: [
                {
                    parameter: "background",
                    value: "#fff",
                }
            ],
            content: []
        };


        if (typeof predata.length !== "undefined") {
            for (let i = 0; i < predata.length; i++) {
                options.content = (JSON.parse(atob(predata[i].getAttribute("data-json"))));
            }
        } else {
            options.content = [
                [
                    [
                        {
                            col: ["3"],
                            content: {
                                type: "label",
                                text: "Firma İsmi",
                                attributes:
                                        {
                                            "class": "form-label",
                                        }
                            }
                        },
                        {
                            col: ["6"],
                            content: {
                                type: "input",
                                control_class: "settings_general_fields",
                                action: "company_name",
                                attributes:
                                        {
                                            "class": "form-control",
                                            "data-component_name": "settings_tax_block",
                                            "data-type": "company_name",
                                        }
                            }
                        }
                    ],
                    [

                        {
                            col: ["3"],
                            content: {
                                type: "label",
                                text: "Vergi Dairesi",
                                attributes:
                                        {
                                            "class": "form-label",
                                        }
                            }
                        },
                        {
                            col: ["2"],
                            content: {
                                type: "province",
                                control_class: "settings_general_fields",
                                action: "tax_province",
                                attributes:
                                        {
                                            "class": "form-control",
                                            "data-component_name": "settings_tax_block",
                                            "data-type": "tax_province",
                                        }
                            }
                        },
                        {
                            col: ["2"],
                            content: {
                                type: "tax_office",
                                control_class: "settings_general_fields",
                                action: "tax_office",
                                attributes:
                                        {
                                            "class": "form-control",
                                            "data-component_name": "settings_tax_block",
                                            "data-type": "tax_office",
                                        },
                            }
                        },
                        {
                            col: ["2"],
                            content: {
                                type: "input",
                                control_class: "settings_general_fields",
                                action: "tax_number",
                                attributes:
                                        {
                                            "class": "form-control",
                                            "type": "text",
                                            "data-component_name": "settings_tax_block",
                                            "value": "0",
                                            "placeholder": "Vergi Numaranızı Giriniz",
                                            "data-type": "tax_number",
                                        },
                            }
                        },
                    ]
                ]
            ]
        }
        $(".settings_tax_content").makeForm(options);
    }
    return {
        init: function () {
            settings_tax();
        }
    }
}();
jQuery(document).ready(function () {
    settings_tax_block.init(); // init metronic core componets
});