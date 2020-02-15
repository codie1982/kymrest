var bulk_mail_form = function () {
    var startsendmail;
    var interval_input;
    var sendmail = function () {
        //setInterval(function,miliseconds);
        $("#bulkmail_switch").on("change", function () {
            interval_input = document.getElementById("interval_value").value
            var mlscnd = interval_input * 1000;
            if ($(this).prop("checked")) {
                startsendmail = setInterval(myMail, mlscnd);
            } else {
                clearMyTime();
            }
        })

        $("#interval_value").on("keyup", function () {
            if ($("#bulkmail_switch").prop("checked")) {
                clearMyTime();
                var mlscnd = $(this).val() * 1000
                startsendmail = setInterval(myMail, mlscnd);
            }

        })
    }


    function myMail() {
        interval_input = document.getElementById("interval_value").value
        var d = new Date();
        var t = d.toLocaleTimeString();
        console.log(t + " " + interval_input + " sn aralıklarla mail gönderiliyor")
    }
    function clearMyTime() {
        clearInterval(startsendmail);
        console.log("Mail Gönderimi Durduruldu")
    }

    return {
        init: function () {
            sendmail();
        }
    }
}();
