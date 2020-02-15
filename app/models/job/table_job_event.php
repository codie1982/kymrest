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
class table_job_event extends general {

    public function __construct($all = true) {
        $this->selecttable = "job_event";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    public function addJobEvent($jobID, $event) {
        $fields = [
            "job_id" => $jobID,
            "event" => $event,
            "event_date" => getNow(),
            "event_seccode" => seccode(),
            "users_id" => session::exists(CURRENT_USER_SESSION_NAME) ? session::get(CURRENT_USER_SESSION_NAME) : "-1",
        ];


        if ($this->insert($fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş İçin bir Olay Eklenemedi&jobid=' . $jobID . '&payment=' . $njob::PAYMENT . '&model=job_eventModel&method=addJobEvent&post=' . json_encode($post));
            return false;
        }
    }

}
