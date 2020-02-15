<?php

/**
 *
 * @author engin
 */
class table_product_transport extends general  {


    public function __construct($all = true) {
        $this->selecttable = "product_transport";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

//   public function get_data($primary_id = null) {
//        $prm = $this->selecttable . "_id";
//        if (is_null($primary_id)) {
//            $sql = "SELECT * FROM $this->selecttable ORDER BY $prm DESC LIMIT 1";
//            $arr = [];
//        } else {
//            $sql = "SELECT * FROM $this->selecttable WHERE $prm = ?";
//            $arr = [$primary_id];
//        }
//        if ($r = $this->query($sql, $arr)->one()) {
//            $r->primary_key = $prm;
//            return $r;
//        } else {
//            return false;
//        }
//    }
//
//
//    public function get_data_main_key($product_id) {
//        $prm = $this->selecttable . "_id";
//        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE product_id=?", [$product_id])->results()) {
//            foreach ($res as $r) {
//                $r->primary_key = $prm;
//            }
//            return $res;
//        } else {
//            return false;
//        }
//    }
//
//    public function insert_data($data) {
//        $primary_key = $this->selecttable . "_id";
//        if (isset($data[$primary_key])) {
//            $pr = $data[$primary_key];
//            if ($this->update($pr, $data)) {
//                return $data[$primary_key];
//            } else {
//                return false;
//            }
//        } else {
//            if ($this->insert($data)) {
//                return $this->_db->lastinsertID();
//            } else {
//                return false;
//            }
//        }
//    }
//
//    public function remove($key) {
//        if ($this->delete($key)) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function get_product_transport($product_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable  WHERE product_id = ? ", [$product_id])->results()) {
            return $r;
        } else {
            return false;
        }
    }

}
