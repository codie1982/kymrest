<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category_module
 *
 * @author engin
 */
class prepare_customer_data extends data {

    public function __construct() {
        $this->control_tag = "customer";
        return true;
    }

    public function set_new_customer_data($post) {
        data::set_control_module($this->get_control_tag());
        $customer_data = $this->seperate_data($post);


        $customer_adres_secrets = data::get_secret_number($this->get_control_tag(), "customer_adres");
        $customer_phone_secrets = data::get_secret_number($this->get_control_tag(), "customer_phone");
        $customer_credi_card_secrets = data::get_secret_number($this->get_control_tag(), "customer_credi_card");

        $customer_data[] = ["class" => "customer_fields", "function" => "set_public", "parameter" => 1];
        $customer_data[] = ["class" => "customer_fields", "function" => "set_date", "parameter" => null];
        $customer_data[] = ["class" => "customer_fields", "function" => "set_repassword", "parameter" => 1];
        $customer_data[] = ["class" => "customer_fields", "function" => "set_customer_seccode", "parameter" => ""];

        if (!empty($customer_adres_secrets))
            foreach ($customer_adres_secrets as $sc) {
                $customer_data[] = ["class" => "customer_adres_fields", "function" => "set_adres_seccode", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_adres_fields", "function" => "set_confirm", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_adres_fields", "function" => "set_public", "parameter" => null, "key" => 2];
                $customer_data[] = ["class" => "customer_adres_fields", "function" => "set_date", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_adres_fields", "function" => "set_users_id", "parameter" => null, "key" => $sc];
            }
        if (!empty($customer_phone_secrets))
            foreach ($customer_phone_secrets as $sc) {
                $customer_data[] = ["class" => "customer_phone_fields", "function" => "set_phone_seccode", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_phone_fields", "function" => "set_confirm", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_phone_fields", "function" => "set_public", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_phone_fields", "function" => "set_date", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_phone_fields", "function" => "set_users_id", "parameter" => null, "key" => $sc];
            }
        if (!empty($customer_credi_card_secrets))
            foreach ($customer_credi_card_secrets as $sc) {
                $customer_data[] = ["class" => "customer_credicard_fields", "function" => "set_date", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_credicard_fields", "function" => "set_credi_card_seccode", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_credicard_fields", "function" => "set_public", "parameter" => null, "key" => $sc];
                $customer_data[] = ["class" => "customer_credicard_fields", "function" => "set_users_id", "parameter" => null, "key" => $sc];
            }

        // $customer_data = $this->integration($customer_data);

        $this->data_exec($customer_data);
        return $this->get_control_tag();
    }

    public function set_personel_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

    public function set_company_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

    public function set_favorites_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

    public function set_visitor_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

    public function set_adres_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

    public function set_credicard_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

    public function set_phone_data($post) {
        data::set_control_module($this->get_control_tag());
        $data = $this->seperate_data($post);
        $data = $this->integration($data);
        $this->data_exec($data);
        return $this->get_control_tag();
    }

}
