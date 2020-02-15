<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sidebar
 *
 * @author engin
 */
class sendmail_action extends component {

    public function render($parameter) {
        $this->set_component_name("sendmail_action");
        $this->make_component($parameter["type"]);
    }

    public function sendAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_REQUEST) {
                $data = $_REQUEST["data"];
                if (isset($_REQUEST["modal"])) {
                    $data["modal"] = $_REQUEST["modal"];
                }
                if (isset($_REQUEST["starter"])) {
                    $data["tempstarter"] = $_REQUEST["starter"];
                }

//                $nsend_mail = new sendmail();
//                $nsend_mail->set_send_email("info@grntsoftware.com");
//                $nsend_mail->set_send_username("Engin EROL");
//                $nsend_mail->send_mail();

                $email = new Imap();
                $inbox = null;
                $email->connect('{mail.grntsoftware.com:143/notls}INBOX', "girisimtwiter@grntsoftware.com", "WTkb51C7");
                $inbox = $email->getMessages("text");

                dnd($inbox);


//                $nview->prepare_page();
//                $content = $nview->get_content();
//                $data["content"] = $content["product_form"];
                $data["starter"] = component::starter($data["tempstarter"]);
                $data["sonuc"] = true;
                $nvalidate->addSuccess("Form verileri alınmıştır..");
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Bu alana bu şekilde giriş yapamazsınız.");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Öncelikle Giriş Yapmanız gerekmektedir.");
        }
        if (!empty($nvalidate->get_warning()))
            foreach ($nvalidate->get_warning() as $wr) {
                $data["warning_message"][] = $wr;
            }
        if (!empty($nvalidate->get_success()))
            foreach ($nvalidate->get_success() as $sc) {
                $data["success_message"][] = $sc;
            }
        if (!empty($nvalidate->get_errors()))
            foreach ($nvalidate->get_errors() as $err) {
                $data["error_message"][] = $err;
            }

        echo json_encode($data);
    }

}
