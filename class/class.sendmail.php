<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author ENG
 */
class sendmail extends phpmailer {

    private $send_email;
    private $send_username;
    private $mail_controller;
    private $mail_action;
    private $mail_parameters = [];

    public function __construct($exceptions = false) {
        parent::__construct($exceptions);
    }

    public function get_send_email() {
        return $this->send_email;
    }

    public function get_send_username() {
        return $this->send_username;
    }

    public function set_send_email($send_email) {
        $this->send_email = $send_email;
        return $this;
    }

    public function set_mail_controller($value) {
        $this->mail_controller = $value . "_controller";
    }

    public function set_mail_action($value) {
        $this->mail_action = $value . "Action";
    }

    public function set_mail_subject($value) {
        $this->mail_subject = $value;
    }

    public function set_mail_parameters($value) {
        $this->mail_parameters[] = $value;
    }

    public function set_send_username($send_username) {
        $this->send_username = $send_username;
        return $this;
    }

    public function send_mail($send = TRUE, $mail_account = "") {
        $mail = new PHPMailer();
        $envormient = modules::getModuleList("envormient");
        $mail_settings = $envormient->mail;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $mail_settings->mail_host;
        $mail->Port = 587;
        $mail->Username = $mail_settings->mail_username;
        $mail->Password = $mail_settings->mail_password;

        $mail->SetFrom($mail->Username, "grnt"); //mail Konu Satırı
        $mail->AddAddress($this->send_email, $this->send_username);
        $mail->Subject = $this->mail_subject;

        $mail->CharSet = 'UTF-8';

        $controller = $this->mail_controller;
        $action = $this->mail_action == "" ? "indexAction" : $this->mail_action;
        // $parameters = $this->mail_parameters;
        $dispatch = new $controller($controller, $action);
      
        $content = call_user_func_array([$dispatch, $action], $this->mail_parameters);
        $mail->MsgHTML($content);

        if (@$mail->Send()) {
            return TRUE;
        } else {
            dnd($mail->ErrorInfo);
            return $mail->ErrorInfo;
        }

        if ($send) {
            $this->save_mail($content);
        } else {
            return TRUE;
        }
    }

    private function save_mail($content) {
        $table_name = "send_mail";
        $dir = $_SERVER["DOCUMENT_ROOT"] . "/mail/mail_content/";
        $file_name = $dir . $this->mail_content_id . ".lnp";
        $content = $this->mail_template;

        $dosya = fopen($file_name, 'w');
        if (fwrite($dosya, trim($content))) {
            
        }
        fclose($dosya);
        //$this->send_content_type, $this->send_subject, $this->send_user_email, $this->send_user_fullname, $this->mail_seccode, $this->mail_content_id, $mail->Username
        $fields = [
            "mail_account" => $this->mail_account,
            "mail_type" => $this->send_content_type,
            "mail_adres" => $this->send_user_email,
            "mail_subject" => $this->send_subject,
            "user_fullname" => $this->send_user_fullname,
            "mail_content" => $this->mail_content_id,
            "mail_seccode" => $this->mail_seccode,
            "send_mail_date" => getNow(),
        ];

        $ndb = new db();
        if ($ndb->insert("send_mail", $fields)) {
            
        } else {
            return FALSE;
        }
        return TRUE;
    }

}
