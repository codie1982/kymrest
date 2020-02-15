<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class bulkmail_fields extends customer_rule {

    private $customer_id;
    private $name;
    private $lastname;
    private $mail;
    private $mail_subject;
    private $date;
    private $public;
    private $bulkmail_seccode;
    private $users_id;

    public function __construct() {
        $this->table_fields = "bulkmail";
        return true;
    }

    /* 	
      mail
      mail_subject
      date
      public
      bulkmail_seccode
      users_id
     */

    public function set_secret_number($value) {
        $this->secret_number = $value;
        data::add_secret_number($this->secret_number, $this->table_fields);
    }

    public function set_primary_key($value, $key) {
        $this->primary_key = $value;
        data::add($this->table_fields . "_id", $this->primary_key == "" ? NODATA : $this->primary_key, $this->table_fields, $key);
    }

    public function set_name($value, $key) {
        $pattern = '/[a-zA-Z0-9\ş\ç\ö\ğ\ü\ı\Ş\Ç\Ö\Ğ\Ü\İ\s]+/';
        preg_match_all($pattern, $value, $output);
        $this->name = $output[0][0];
        data::add("name", $this->name !== "" ? $this->name : NODATA, $this->table_fields, $key);
    }

    public function set_lastname($value, $key) {
        $pattern = '/[a-zA-Z0-9\ş\ç\ö\ğ\ü\ı\Ş\Ç\Ö\Ğ\Ü\İ\s]+/';
        preg_match_all($pattern, $value, $output);
        $this->lastname = $output[0][0];
        data::add("lastname", $this->lastname !== "" ? $this->lastname : NODATA, $this->table_fields, $key);
    }

    public function set_send($value, $key) {
        $this->send = $value;
        data::add("send", $this->send == "" ? 0 : $this->send, $this->table_fields, $key);
    }

    public function set_customer_id($value, $key) {
        $this->customer_id = $value;
        data::add("customer_id", $this->customer_id !== "" ? $this->customer_id : NODATA, $this->table_fields, $key);
    }

    public function set_mail($value, $key) {
        $this->mail = $value;
        data::add("mail", $this->mail !== "" ? $this->mail : NODATA, $this->table_fields, $key);
    }

    public function set_mail_subject($value, $key) {
        $this->mail_subject = $value;
        data::add("mail_subject", $this->mail_subject !== 0 ? $this->mail_subject : 0, $this->table_fields, $key);
    }

    public function set_date($value, $key) {
        data::add("date", $value != "" ? $value : getNow(), $this->table_fields, $key);
    }

    public function set_public($value, $key) {
        $this->public = $value;
        data::add("public", $this->public !== "" ? $this->public : NODATA, $this->table_fields, $key);
    }

    public function set_bulkmail_seccode($value, $key) {
        $this->bulkmail_seccode = $value;
        data::add("bulkmail_seccode", $this->bulkmail_seccode !== "" ? $this->bulkmail_seccode : 1, $this->table_fields, $key);
    }

    public function set_users_id($value, $key) {
        $this->users_id = session::get(CURRENT_USER_SESSION_NAME);
        data::add("users_id", $this->users_id !== NODATA ? $this->users_id : 0, $this->table_fields, $key);
    }

}
