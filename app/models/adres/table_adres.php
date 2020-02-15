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
class table_adres extends model {

    private $selecttable;

    public function __construct() {
        $this->selecttable = "adres";
        parent::__construct($this->selecttable);
    }

    public function getdistrictlist($province_id) {
        $sql = "SELECT AAilceAdi,AAilceNo FROM $this->selecttable WHERE AAilNo = ? GROUP BY AAilceNo";
        return $this->query($sql, [$province_id])->results();
    }

    public function getneighborhoodSmtlist($province_id, $district_id) {
        $sql = "SELECT AASmtBckAdi,AAmhlKoyAdi,adres_id FROM $this->selecttable WHERE AAilNo = ? && AAilceNo = ? GROUP BY AASmtBckAdi";
        return $this->query($sql, [$province_id, $district_id])->results();
    }

    public function getneighborhoodlist($province_id, $district_id) {
        $sql = "SELECT AASmtBckAdi,AAmhlKoyAdi,adres_id FROM $this->selecttable WHERE AAilNo = ? && AAilceNo = ?";
        return $this->query($sql, [$province_id, $district_id])->results();
    }

    public function getprovincelist() {
        $sql = "SELECT AAilAdi,AAilNo FROM $this->selecttable WHERE AAilNo <> ? GROUP BY AAilAdi";
        return $this->query($sql, [""])->results();
    }

    public function getprovince($provinceid) {
        $sql = "SELECT AAilAdi FROM $this->selecttable WHERE AAilNo = ? AND AAilceNo =? AND AASmtBckNo = ? AND AAmhlKoyNo = ?";
        if ($r = $this->query($sql, [$provinceid, 0, 0, 0])->one()) {
            return $r->AAilAdi;
        } else {
            return false;
        }
    }

    public function getdistrict($provinceid, $district) {
        $sql = "SELECT AAilceAdi FROM $this->selecttable WHERE AAilNo = ? AND AAilceNo =? AND AASmtBckNo = ? AND AAmhlKoyNo = ?";
        if ($r = $this->query($sql, [$provinceid, $district, 0, 0])->one()) {
            return $r->AAilceAdi;
        } else {
            return false;
        }
    }

    public function getneighborhood($neighborhood) {
        $sql = "SELECT AAmhlKoyAdi FROM $this->selecttable WHERE adres_id = ? ";
        if ($r = $this->query($sql, [$neighborhood])->one()) {
            return $r->AAmhlKoyAdi;
        } else {
            return false;
        }
    }

    public function searchAdres($q) {
        $qsef = sef_link($q);
        $_qsef = "%{$qsef}%";
        $r = $this->_db->query("SELECT adres_id as id,
            AAilNo as provinceid,
            AAilceNo as districtid,
            AASmtBckNo as neighborhoodid,
            AAmhlKoyAdi as kyAdi,
            AASmtBckAdi as smtAdi,
            AAilceAdi as ilceAdi,
            AAilAdi as ilAdi 
            FROM $this->selecttable as id 
            WHERE AAilAdi LIKE ? OR AAilceAdi LIKE ? OR AASmtBckAdi LIKE ? OR AAmhlKoyAdi LIKE ?  OR AApostakodu LIKE ? GROUP BY AASmtBckAdi", [$_qsef, $_qsef, $_qsef, $_qsef, $_qsef])->results();
        if ($r) {
            return $r;
        } else {
            return false;
        }
    }

}
