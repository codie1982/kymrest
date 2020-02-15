<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adres
 *
 * @author engin
 */
class table_job_transport extends general {

    public function __construct($all = true) {
        $this->selecttable = "job_transport";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    public function addNewJobProductTransport($jobID, $customer_adres_id) {

        $fields = [
            "job_id" => $jobID,
            "costumer_adres_id" => $customer_adres_id,
            "date" => getNow(),
            "job_transport_seccode" => seccode(),
            "public" => 1,
            "users_id" => session::exists(CURRENT_USER_SESSION_NAME) ? session::get(CURRENT_USER_SESSION_NAME) : -1,
        ];
        if ($this->insert($fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Adres Bilgisi Kayıt edilemedi&jobid=' . $jobID . '&customer_adres_id=' . $customer_adres_id . '&model=job_transportModel&method=addNewJobProductTransport&post=' . json_encode($post));
            return false;
        }
    }

    public function getJobAdresInfo($jobID) {
        if ($r = $this->query("SELECT costumer_adres_id FROM $this->selecttable WHERE job_id=?  ", [$jobID])->one()) {
            //İş Bazında Kampanyaları denetleyebiliriz.//KAMPANYA
            return $r->costumer_adres_id;
        } else {
            return false;
        }
    }

}
