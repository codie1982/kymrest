<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author engin
 */
class mail_confirm_controller extends controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        tema::set_selected_tema("mail_confirm");
        tema::set_selected_template("standart");
    }

    public function indexAction($id = array()) {
        if(is_array($id)){
            $mailid = $id[0];
        }else {
            $mailid = $id;
        }
        $ncustomer_mail = new table_customer_mail();
        $ncustomer_mail->select();
        $ncustomer_mail->add_condition("customer_mail_id", $mailid);
        $ncustomer_mail_info = $ncustomer_mail->get_alldata(true);

        
        $customer_id = $ncustomer_mail_info->customer_id;
        $ncustomer_personel = new table_customer_personel();
        $ncustomer_personel->select();
        $ncustomer_personel->add_condition("customer_id", $customer_id);
        $ncustomer_personel_info = $ncustomer_personel->get_alldata(true);
        $customer_name = $ncustomer_personel_info->name . " " . $ncustomer_personel_info->lastname;

        $site_link = site_info("site_link");
        //$sitelogo = $site_link . site_logo(500);
        $sitelogo = null;

        $confirm_link = $site_link . module_link("admin/mailconfirm", $ncustomer_mail_info->confirm_code);

        component::import_component("confirm", ["type" => "mail/mail_confirm"]);
        $this->view->add_page(component::get_component_module());
        $this->view->prepare_page();
        $content = $this->view->get_content();

        $search = ["*|MC:SUBJECT|*", "*|USER_NAME|*", "*|MC_PREVIEW_TEXT|*", "*|BRAND:LOGO|*", "*|CURRENT_YEAR|*", "*|CONFIRM_LINK|*"];
        $replace = ["Üyelik Kaydınız", $customer_name, "Mail Kaydınız Hk.", $sitelogo, date("Y"), $confirm_link];
        return str_replace($search, $replace, $content["confirm"]);
    }

}
