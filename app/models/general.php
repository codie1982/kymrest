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
class general extends model implements general_interface {

    protected $selecttable;
    public $contidion = array();
    public $contidion_oparator = array();
    private $join_list = array();
    public $contidion_value = array();
    public $where_value = array();
    public $search_data = array();
    public $filter_data = array();
    private $where;
    private $join;
    public $order;
    public $direction;
    public $direction_by;
    public $direction_table;
    public $limit_start;
    public $limit_end;
    public $sql;
    private $add_join = false;
    private $add_filter_vl = false;
    private $count = false;
    private $filter = "*";
    private $add_condition = false;
    private $add_order = false;
    private $add_limit = false;
    private $add_between = false;
    private $between_first;
    private $between_second;
    private $between_oparation;

    public function __construct($table) {
        parent::__construct($table);
        $table = $this->selecttable;
        $this->sql = "";
        $this->where = "";
        $this->join = "";
        $this->order = "";
        $this->direction = "";
        $this->direction_by = "";
        $this->limit_start = "";
        $this->limit_end = "";
    }

    public function set_condition() {
        $this->contidion = [];
    }

// $this->sql = "SELECT * FROM $this->selecttable";

    public function set_count() {
        $this->count = true;
    }

    public function filter($text = "") {
        $this->filter_data;
        $filter_text = "";
        if (!empty($this->filter_data)) {
            foreach ($this->filter_data as $dt) {
                $filter = $dt["table"] . DOT . $dt["filter"];
                $filter_text .= $filter . " ";
                if (!empty($dt["as"])) {
                    $as = $dt["as"];
                    $filter_text .= " as " . $as;
                }
                $filter_text .= " , ";
            }
        } else {
            $filter_text = $text;
        }

        return rtrim($filter_text, " , ");
    }

    public function select($filter = "*") {
        if ($this->count) {
            $filter = "COUNT(*)";
        }
        $this->filter = $this->filter($filter);
        // dnd($this->filter);
        $this->sql = "SELECT $this->filter FROM $this->selecttable ";
    }

    public function search_item($table, $field) {
        $this->search_data[] = ["table" => $table, "field" => $field];
    }

    public function add_filter($filter, $as = "", $table_name = "") {
        $this->add_filter_vl = true;
        if ($table_name == "") {
            $this->filter_data[] = ["filter" => $filter, "as" => $as, "table" => $this->selecttable];
        } else {
            $this->filter_data[] = ["filter" => $filter, "as" => $as, "table" => $table_name];
        }
    }

    public function set_where() {
        $this->sql .= $this->where;
    }

// $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE date BETWEEN '$end_date' AND '$start_date'";
    private function where() {
        $this->where = "";
        foreach ($this->contidion as $table_name => $value) {
            if (is_array($value)) {
                $i = 0;
                foreach ($value as $v) {
                    $fields = key($v);
                    if (is_array($v[$fields])) {
                        $event = key($v[$fields]);
                        switch ($event) {
                            case"BETWEEN":
//dnd($v[$fields][$event]);
                                $first = $v[$fields][$event][0];
                                $second = $v[$fields][$event][1];
                                $oparation = $v[$fields][$event][2];
                                $this->where .= ' ' . $table_name . '.' . key($v) . ' ' . $event . ' ' . ' ? ' . ' ' . $oparation . ' ' . ' ? ' . ' && ';
                                $this->where_value[] = $second;
                                $this->where_value[] = $first;
                                break;
                            case"LIKE":
                                //WHERE CustomerName LIKE '%or%'
                                $qsef = "%{$v[$fields][$event][0]}%";
                                $this->where .= ' ' . $table_name . '.' . key($v) . ' ' . $event . ' ' . '?' . ' && ';
                                $this->where_value[] = $qsef;
                                break;
                        }
                    } else {
                        $this->where .= ' ' . $table_name . '.' . key($v) . $this->contidion_oparator[$table_name][$i][key($v)] . '?' . ' && ';
                        $this->where_value[] = current($v);
                    }
                    $i++;
                }
            }
        }
        if (strlen($this->where) != 0) {
            $this->where = "WHERE " . $this->where;
        }
        return rtrim($this->where, "&& ");
    }

    private function join() {
        $this->join = "";
        foreach ($this->join_list as $join_table => $subparameter) {
            $this->join = "INNER JOIN " . $join_table . " ON ";
            $this->join .= $this->selecttable . '.' . $subparameter . "=" . $join_table . "." . $subparameter . " ";
        }
        return $this->join;
    }

    protected function get_sql() {
//        if ($this->add_filter_vl)
//            $this->sql .= $this->filter();

        if ($this->add_join)
            $this->sql .= $this->join();

        if ($this->add_condition)
            $this->sql .= $this->where();

        if ($this->add_order)
            $this->sql .= $this->order();

        if ($this->add_limit)
            $this->sql .= $this->limit();

        return $this->sql;
    }

    public function show_sql() {
        dnd($this->sql);
    }

    public function show_where() {
        dnd($this->where);
    }

    public function show_where_value() {
        dnd($this->where_value);
    }

    private function contidion_value() {
        return $this->where_value;
    }

    public function add_direction($direction) {
        $this->add_order = true;
        $this->direction = strtoupper($direction);
    }

    public function add_direction_by($direction_by, $table = "") {
        $this->add_order = true;
        $this->direction_by = $direction_by;
        if ($table == "") {
            $this->direction_table = $this->selecttable;
        } else {
            $this->direction_table = $table;
        }
    }

    public function order() {
        $direction_table = $this->direction_table == "" ? $this->selecttable : $this->direction_table;

        $direction_by = $this->direction_by == "" ? $direction_table . DOT . $this->selecttable . "_id" : $direction_table . DOT . $this->direction_by;

        $direction = $this->direction == "" ? "DESC" : $this->direction;
        return " " . trim(" ORDER BY " . $direction_by . " " . $direction);
    }

    public function limit() {
        return " " . rtrim(" LIMIT " . $this->limit_start . "," . $this->limit_end, ",");
    }

    public function add_limit_start($limit_start) {
        $this->add_limit = true;
        $this->limit_start = $limit_start;
    }

    public function add_limit_end($limit_end) {
        $this->limit_end = $limit_end;
    }

    public function add_condition($key, $value, $oparator = "=", $table = "") {
        if ($table == "") {
            $table = $this->selecttable;
        }
        $this->add_condition = true;
        if (is_array($value)) {
            switch (key($value)) {
                case"BETWEEN":
                    /*
                      $nimage_gallery->add_condition("date", [
                      "BETWEEN" => ["first" => date("Y-m-d H:i:s", $start_date), "second" => date("Y-m-d H:i:s", $end_date), "oparation" => "AND"]
                      ]);
                     *
                     *       */
                    $this->add_between = true;
                    $this->between_first = $value["BETWEEN"]["first"];
                    $this->between_second = $value["BETWEEN"]["second"];
                    $this->between_oparation = $value["BETWEEN"]["oparation"];
                    $btvalue["BETWEEN"] = [$this->between_first, $this->between_second, $this->between_oparation];
                    $this->contidion[$table][][$key] = $btvalue;
                    $this->contidion_oparator[$table][][$key] = null;
                    break;
                case"LIKE":
                    /*
                      $nimage_gallery->add_condition("date", [
                      "LIKE" => [name]
                      ]);
                     */

                    if (is_array($value["LIKE"])) {
                        $lk["LIKE"] = [$value["LIKE"][0]];
                    } else {
                        $lk["LIKE"] = [$value["LIKE"]];
                    }

                    $this->contidion[$table][][$key] = $lk;
                    $this->contidion_oparator[$table][][$key] = null;
                    break;
                case"LLIKE":
                    /*
                      $nimage_gallery->add_condition("date", [
                      "LLIKE" => [name]
                      ]);
                     */
                    break;
                case"RLIKE":
                    /*
                      $nimage_gallery->add_condition("date", [
                      "RLIKE" => [name]
                      ]);
                     */
                    break;
            }
        } else {
            $this->contidion[$table][][$key] = $value;
            $this->contidion_oparator[$table][][$key] = $oparator;
            $this->contidion_value[$table][$key] = $value;
        }
    }

//add_join("table_product", "product_id")
    public function add_join($join_table, $cloumb) {
        $this->add_join = true;
        $this->join_list[$join_table] = $cloumb;
    }

    public function get_condition() {
        return $this->contidion;
    }

    public function get_alldata($one = false) {
        if ($one) {
            if ($res = $this->query($this->get_sql(), $this->contidion_value())->one()) {
                if ($this->count) {
                    return $res->{"COUNT(*)"};
                } else {
                    $res->primary_key = $this->selecttable . "_id";
                    return $res;
                }
            } else {
                return false;
            }
        } else {
            if ($res = $this->query($this->get_sql(), $this->contidion_value())->alldata()) {
                foreach ($res as $r) {
                    $r->primary_key = $this->selecttable . "_id";
                }
                return $res;
            } else {
                return false;
            }
        }
    }

    public function _get_alldata($condition = array(), $direction = "DESC", $by = "default", $count = "0", $filter = null) {
        $prm = $this->selecttable . "_id";
        if ($by == "default")
            $by = $prm;
        if ($count != 0) {
            $order = "ORDER BY $by $direction LIMIT $count";
        } else {
            $order = "";
        }

        $where = "";
        $arwhere = [];
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $where .= " " . $key . " = " . "?" . " && ";
                $arwhere[] = $value;
            }
        }
        if (strlen($where) != 0) {
            $where = "WHERE " . $where;
        }
        $fwhere = rtrim($where, "&& ");

        $sql = "SELECT * FROM $this->selecttable $fwhere $order";
        if ($res = $this->query($sql, $arwhere)->results()) {
            foreach ($res as $r) {
                $r->primary_key = $prm;
            }
            return $res;
        } else {
            return false;
        }
    }

    public function get_data($primary_id = null) {
        $prm = $this->selecttable . "_id";
        if (is_null($primary_id)) {
            $sql = "SELECT * FROM $this->selecttable ORDER BY $prm DESC LIMIT 1";
            $arr = [];
        } else {
            $sql = "SELECT * FROM $this->selecttable WHERE $prm = ?";
            $arr = [$primary_id];
        }
        if ($r = $this->query($sql, $arr)->one()) {
            $r->primary_key = $prm;
            return $r;
        } else {
            return false;
        }
    }

    public function get_data_main_key($category_id) {
        $prm = $this->selecttable . "_id";
        if ($res = $this->query("SELECT * FROM $this->selecttable WHERE category_id = ?", [$category_id])->results()) {
            foreach ($res as $r) {
                $r->primary_key = $prm;
            }
            return $res;
        } else {
            return false;
        }
    }

    public function insert_data($data) {
        $primary_key = $this->selecttable . "_id";
        if (isset($data[$primary_key])) {
            $pr = $data[$primary_key];
            if ($this->update($pr, $data)) {
                return $data[$primary_key];
            } else {
                return false;
            }
        } else {
            if ($this->insert($data)) {
                return $this->_db->lastinsertID();
            } else {
                return false;
            }
        }
    }

    public function update_data($data, $primary_id, $primary_key) {
        if ($this->update($primary_id, $data, $primary_key)) {
            return true;
        } else {
            return false;
        }
    }

    public function remove($key) {
        if ($this->delete($key)) {
            return true;
        } else {
            return false;
        }
    }

    public function remove_array($keys) {
        $sql = 'DELETE FROM ' . $this->selecttable . ' ';
        if (!empty($keys)) {
            $where = "WHERE ";
            foreach ($keys as $key => $value) {
                $where .= $key . "=" . "'" . $value . "'" . " && ";
            }
        }
        $where = rtrim($where, " && ");
        $sql .= $where;
        if ($this->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function turncate() {
        if ($this->turncate_table($this->selecttable)) {
            return true;
        } else {
            return false;
        }
    }

}
