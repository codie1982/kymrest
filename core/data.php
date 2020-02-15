<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of data
 *
 * @author engin
 */
class data {

    private static $fields = array();
    private static $postdata = array();
    private $control_class = "";
    private $control_function = "";
    private static $plasebofields = array();
    private $create_class;
    private $contidions = array();
    private $contidion_value;
    private $function;
    private $key;
    private static $secret_number = array();
    private static $parent = [];
    private static $control_module;
    private static $insert_data_id;
    private static $user_permission = [];
    private static $GET = [];
    private static $POST = [];
    private static $APIERROR = false;
    private static $GETPARAMETER = [];
    protected $control_tag;

    public function __construct() {
        return true;
    }

    public static function set_control_module($val) {

        self::$control_module = $val;
    }

    public static function ADD_GETDATA($dt) {
        self::$GET = $dt;
    }

    public static function ADD_POSTDATA($dt) {
        self::$POST = $dt;
    }

    public static function ADD_APIERROR() {
        self::$APIERROR = true;
    }

    public static function GET_APIERROR() {
        return self::$APIERROR;
    }

    public static function ADD_GETPARAMETER($dt) {
        self::$GETPARAMETER = $dt;
    }

    public static function GET_GETPARAMETER($key = "") {
        if ($key != "") {
            return self::$GETPARAMETER;
        } else {
            return self::$GETPARAMETER[$key];
        }
    }

    public static function GET_GETDATA() {
        return self::$GET;
    }

    public static function GETPOSTDATA($jsonencode = true) {
        if ($jsonencode) {
            return json_decode(self::$POST);
        } else {
            return self::$POST;
        }
    }

    public static function ISSET_GETDATA() {
        return empty(self::$GET) ? false : true;
    }

    public static function ISSET_POSTDATA() {
        return empty(self::$POST) ? false : true;
    }

    public static function get_file_name($file) {
        $file_ex = explode(".", $file);
        return $file_ex[0];
    }

    public static function get_file_extendion($file) {
        $file_ex = explode(".", $file);
        return $file_ex[1];
    }

    public function get_control_tag() {
        return $this->control_tag;
    }

    public static function set_user_permission($value) {
        self::$user_permission[] = $value;
    }

    public static function get_user_permission() {
        return self::$user_permission;
    }

    public static function search_user_permission($search_text) {
        return in_array($search_text, self::$user_permission);
    }

    public static function make_postdata() {
        self::$postdata = [];
    }

    public function set_control_class($val) {
        $this->control_class = $val;
    }

    public function set_control_function($val) {
        $this->control_function = $val;
    }

    public static function add_post_data($control_class, $control_function, $parameter, $keyvalue = "", $condition_field = "", $condition_value = "") {
        if ($condition_field != "") {
            $condition = $condition_field . "=" . $condition_value;
        }
        if ($control_class != "") {
            $class = "@" . $control_class;
        }
        if ($control_function != "") {
            $action = "$" . $control_function;
        }
        if ($keyvalue != "") {
            $key = ":" . $keyvalue;
        }
        $srt = $condition . $class . $action . $key;
        self::$postdata[$srt] = $parameter;
    }

    public static function get_postdata() {
        return self::$postdata;
    }

    public static function find_fields($value, $data, $one = true) {
        arrtolist::cleanList();
        search_arrays($data, $value);
        $list = (arrtolist::get_List());
        if ($one) {
            return $list[0][$value];
        } else {
            return $list;
        }
    }

    public static function update_data($table_name, $data, $primary_field = "", $primary_value = "") {
        $cls = "table_" . $table_name;
        if ($primary_field == "") {
            $primary_field = $table_name . "_id";
        }
        if (class_exists($cls)) {
            $ntbl = new $cls;
            $key_name = array_keys($data);
            if (!is_array($data[$key_name[0]])) {
                $tableInfo = data::tableInfo($table_name, $primary_value);
                $filename = time() . "-" . $table_name . "-" . "update" . "-" . $primary_value . DOT . "json";
                $recyclebin = ROOT . DS . "recyclebin" . DS . $filename;
                file_put_contents($recyclebin, json_encode(object_to_array($tableInfo)));

                if ($prmid = $ntbl->update_data($data, $primary_value, $primary_field)) {
                    return $prmid;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function get_parent_data() {
        return self::$insert_data_id;
    }

    private static function find_parent_info($findkey) {
        $result = [];
        $data = self::get_parent_data();

        if (!empty($data)) {
            foreach ($data as $tablename => $tablevalue) {
                foreach ($tablevalue as $key => $id) {
                    if ($key == $findkey) {
                        $result[] = ["table" => $tablename, "id" => $id];
                    }
                }
            }
        }
        return $result;
    }

    public static function insert_data($table_name, $data, $backup = true, $parent_key = "", $parent_value = "") {
        $class_name = "table_" . $table_name;
        $primary_key = $table_name . "_id";


        if (class_exists($class_name)) {
            $ntbl = new $class_name;
            $key_name = array_keys($data);
            if (is_array($data[$key_name[0]])) {
                $rn = [];
                foreach ($data as $key => $dt) {
                    if (isset($dt[$primary_key])) {
                        if ($backup) {
                            $tableInfo = data::tableInfo($table_name, $dt[$primary_key]);
                            $filename = time() . "-" . $table_name . "-" . "update" . "-" . $dt[$primary_key] . DOT . "json";
                            $recyclebin = ROOT . DS . "recyclebin" . DS . $filename;
                            file_put_contents($recyclebin, json_encode(object_to_array($tableInfo)));
                        }
                    }
                    if (isset($dt["parent_key"])) {
                        $search_parent_key = $dt["parent_key"];
                        $res = self::find_parent_info($search_parent_key);

                        unset($dt["parent_key"]);
                        foreach ($res as $vl) {
                            $parent_table = $vl["table"] . "_id";
                            $parent_table_id = $vl["id"];
                            $dt[$parent_table] = $parent_table_id;
                        }
                    }

                    if ($parent_key != "") {
                        $dt[$parent_key] = $parent_value;
                    }

                    if ($prmid = $ntbl->insert_data($dt)) {
                        $rn[] = $prmid;
                        self::$insert_data_id[$table_name][$key] = $prmid;
                    }
                }
                if (!empty($rn)) {
                    return $rn;
                } else {
                    return false;
                }
            } else {
                if (isset($data[$primary_key])) {
                    if ($backup) {
                        $tableInfo = data::tableInfo($table_name, $data[$primary_key]);
                        $filename = time() . "-" . $table_name . "-" . "update" . "-" . $data[$primary_key] . DOT . "json";
                        $recyclebin = ROOT . DS . "recyclebin" . DS . $filename;
                        file_put_contents($recyclebin, json_encode(object_to_array($tableInfo)));
                    }
                }
                if ($parent_key != "") {
                    $data[$parent_key] = $parent_value;
                }
                

                if ($prmid = $ntbl->insert_data($data)) {
                    return $prmid;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function turncate($table_name, $backup = true) {
        if ($backup) {
            $tableInfo = data::tableInfo($table_name, $primary_value);
            $filename = time() . "-" . $table_name . "-" . "remove" . "-" . "-" . $primary_value . DOT . "json";
            $recyclebin = ROOT . DS . "recyclebin" . DS . $filename;

            file_put_contents($recyclebin, json_encode(object_to_array($tableInfo)));
        }


        $cls = "table_" . $table_name;
        if (class_exists($cls)) {
            $ntable = new $cls;
            $fonk = "turncate";
            if (method_exists($ntable, $fonk)) {
                return $ntable->turncate();
            } else {
                return false;
            }
        }
    }

    public static function remove($table_name, $primary_value, $backup = true) {

        if ($backup) {
            $tableInfo = data::tableInfo($table_name, $primary_value);
            $filename = time() . "-" . $table_name . "-" . "remove" . "-" . "-" . $primary_value . DOT . "json";
            $recyclebin = ROOT . DS . "recyclebin" . DS . $filename;
            file_put_contents($recyclebin, json_encode(object_to_array($tableInfo)));
        }

        $cls = "table_" . $table_name;
        if (class_exists($cls)) {
            $ntable = new $cls;
            $fonk = (is_array($primary_value)) ? "remove_array" : "remove";
            if (method_exists($ntable, $fonk)) {
                return $ntable->$fonk($primary_value);
            } else {
                return false;
            }
        }
    }

    public static function searchfunction($search_value, $data = "") {
        if (is_array($data)) {
            foreach ($data as $dt) {
                if ($dt["function"] == "set_" . $search_value) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    public static function tableInfo($table_name, $primary_value) {
        $cls = "table_" . $table_name;
        $primary_key = $table_name . "_id";
        $ntable = new $cls;
        $ntable->select();
        $ntable->add_condition($primary_key, $primary_value);
        $temp = $ntable->get_alldata();
//        $fonk = "get_data";
//        $temp = $ntable->$fonk($primary_value);
        return $tempdata[$table_name] = $temp;
    }

    public static function tableInfoMainKey($table_name, $primary_value) {
        $cls = "table_" . $table_name;
        $ntable = new $cls;
        $fonk = "get_data_main_key";
        $temp = $ntable->$fonk($primary_value);
        return $tempdata[$table_name] = $temp;
    }

    public static function removeAll($table_name, $primary_value, $backup = true) {
        if (self::remove($table_name, $primary_value)) {
            $sub_tables = self::get_table_subtables($table_name);
            if (!empty($sub_tables)) {
                $fsub_tables = array_values($sub_tables);
                if (!empty($fsub_tables))
                    foreach ($fsub_tables as $tbl) {
                        if ($backup) {
                            $tableInfo = self::tableInfoMainKey($tbl, $primary_value);
                            $filename = time() . "-" . $table_name . "-" . "remove" . "-" . "-" . $primary_value . DOT . "json";
                            $recyclebin = ROOT . DS . "recyclebin" . DS . $filename;
                            file_put_contents($recyclebin, json_encode(object_to_array($tableInfo)));
                        }


                        if (!empty($tableInfo))
                            foreach ($tableInfo as $info) {
                                $prm = $info->primary_key;
                                $key = $info->$prm;
                                $cls = "table_" . $tbl;
                                if (class_exists($cls)) {
                                    $ntable = new $cls;
                                    $fonk = "remove";
                                    if (method_exists($ntable, $fonk)) {
                                        $ntable->$fonk($key);
                                    }
                                }
                            }
                    }
            }

            return true;
        } else {
            return false;
        }
    }

    public static function removeMedia($table_name, $primary_value) {
        $cls = 'table_' . $table_name;
        $tbl = new $cls;
        $tbl->select();
        $key = $table_name . "_id";
        $tbl->add_condition($key, $primary_value);
        $data = $tbl->get_alldata(true);
        $path = ROOT . DS . "assets" . DS . "media" . DS . $data->image_type . DS . $data->image_uniqid;
        $resulation = get_image_variations($data);
        $files = [];
        if ($files[] = get_image_file_path($data)) {
            if (!empty($resulation))
                foreach ($resulation as $res) {
                    $files[] = get_image_file_path($data, $res);
                }
        }

        if (!empty($files))
            foreach ($files as $file) {
                unlink($file);
            }
        if (self::remove($table_name, $primary_value, false)) {
            return true;
        } else {
            return false;
        }
    }

    public static function allInfo($table_name, $primary_value) {
        $table_list = [];
        $temp = [];
        $table_list[] = $table_name;
        $cls = "table_" . $table_name;
        $mainprimary_key = $table_name . "_id";
        $ntable = new $cls;
        $ntable->select();
        $ntable->add_condition($mainprimary_key, $primary_value);
        $temp = $ntable->get_alldata(true);
        $tempdata = [];
        $tempdata[$table_name] = $temp;
        $sub_tables = self::get_table_subtables($table_name);
        $i = 0;
        if (!empty($sub_tables)) {
            foreach ($sub_tables as $sb) {
                if ($sb == $table_name) {
                    unset($sub_tables[$i]);
                }
                $i++;
            }

            $fsub_tables = array_values($sub_tables);
            foreach ($fsub_tables as $tbl) {
                $cls = "table_" . $tbl;
                if (class_exists($cls)) {
                    $primary_key = $table_name . "_id";
                    $ntable = new $cls;
                    $ntable->select();
                    $ntable->add_condition($primary_key, $primary_value);
                    $dt = $ntable->get_alldata();
                    if ((!empty($dt))) {
                        $tempdata[$tbl] = $dt;
                    } else {
                        $tempdata[$tbl] = [];
                    }
                } else {
                    new Exception($cls . " Class Dosyası Bulunanmamıştır");
                }
            }
        } else {
            dnd($cls . " Alt Tablolar Bulunamamıştır");
        }

        return $tempdata;
    }

    public static function get_table_subtables($main_table) {
        $ndb = new db();
        $tables = $ndb->get_tables($table);
        $tablenames = [];
        $searchtablenames = [];
        $module_path = ROOT . DS . 'module.json';
        $modulefile = file_get_contents($module_path);
        $config_data = json_decode($modulefile);

        $envormient = $config_data->envormient;

        $tblin = "Tables_in_" . $envormient->database->db_name;
        foreach ($tables as $key => $table) {
            if ($table->$tblin != $main_table) {
                $tablenames[] = $table->$tblin;
            }
        }

        foreach ($tablenames as $tablename) {
            $fmain_table = $main_table . "_";
            if (substr($tablename, 0, strlen($fmain_table)) == $fmain_table) {
                $searchtablenames[] = $tablename;
            }
        }
        return $searchtablenames;
    }

    public static function get_table_cloumns($table) {
        $ndb = new db();
        $cloumns = $ndb->get_cloumns($table);
        $fcloumnd = array_shift($cloumns);
        $result = [];
        foreach ($cloumns as $cl) {
            $result[] = $cl->Field;
        }
        return $result;
    }

    /**
     * @param $key
     * @param $value
     * @return db değişkenini hazırlar();
     */
    static function add($key, $value = null, $table, $secret = "") {
        if ($secret == "") {
            return self::$fields[self::$control_module][$table][$key] = $value;
        } else {
            return self::$fields[self::$control_module][$table][$secret][$key] = $value;
        }
    }

    /**
     * @param $key
     * @param $value
     * @return db değişkenini hazırlar();
     */
    static function get($key, $table, $secret = "") {
        if ($secret == "") {
            return self::$fields[self::$control_module][$table][$key];
        } else {
            return self::$fields[self::$control_module][$table][$secret][$key];
        }
    }

    static function addPlasebo($key, $value = null, $secret = "") {
        if ($secret == "") {
            return self::$plasebofields[self::$control_module][$key] = $value;
        } else {
            return self::$plasebofields[self::$control_module][$secret][$key] = $value;
        }
    }

    static function addextra($key, $value, $control_module, $table, $secret = null, $main_table = "", $exec = false) {
        if ($exec) {
            return true;
        } else {
            if ($table == "sub") {
                $temp_fields = self::$fields[$control_module];
                unset($temp_fields[$main_table]);
                $dnd = $temp_fields;
                foreach ($dnd as $tablename => $table_fileds) {

                    if (is_array($table_fileds)) {
                        foreach ($table_fileds as $tbsc => $tb) {

                            if (!is_array($tb)) {
                                self::$fields[$control_module][$tablename][$key] = $value;
                            } else {
                                $tbl = self::$fields[$control_module][$tablename];
                                foreach ($secret as $sec) {
                                    foreach ($tbl as $k => $v) {
                                        if ($k == $sec) {

                                            self::$fields[$control_module][$tablename][$sec][$key] = $value;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if (is_null($secret)) {
                    return self::$fields[$control_module][$table][$key] = $value;
                } else {
                    if (is_array($secret)) {
                        $tbl = self::$fields[$control_module][$table];
                        foreach ($secret as $sec) {
                            foreach ($tbl as $k => $v) {
                                if ($k == $sec) {
                                    self::$fields[$control_module][$table][$sec][$key] = $value;
                                }
                            }
                        }
                    } else {
                        $tbl = self::$fields[$control_module][$table];
                        foreach ($tbl as $k => $v) {
                            if ($k == $secret) {
                                self::$fields[$control_module][$table][$secret][$key] = $value;
                            }
                        }
                        return self::$fields;
                    }
                }
            }
        }
    }

    static function addextrafunction($key, $value, $control_module, $table, $secret = null, $exec = false) {
        if ($exec) {
            
        } else {
            if (is_null($secret)) {
                return self::$fields[$control_module][$table][$key] = $value;
            } else {
                $tbl = self::$fields[$control_module][$table];
                foreach ($tbl as $k => $v) {
                    if ($k == $secret) {
                        self::$fields[$control_module][$table][$secret][$key] = $value;
                    }
                }
                return self::$fields;
            }
        }
    }

    static function add_secret_number($secret_number, $table_field) {
        return self::$secret_number[self::$control_module][$table_field][] = $secret_number;
    }

    static function add_parent($parent_key, $table_field) {
        return self::$parent[self::$control_module][] = $parent_key;
    }

    /**
     * @return db Değişkenini geriye döndürür();
     */
    public function getFields() {
        return self::$fields;
    }

    public function get_condition($string) {
        $pattern = "/([a-z_]+)([a-z_]+)(&?)(\|?)/";
        preg_match_all($pattern, $string, $output);
        if (!empty($output[0])) {
            return $output[1][0];
        } else {
            return false;
        }
    }

    public function get_condition_value($string) {
        $pattern = "/([a-z_]+)=([a-z_]+)(&?)(\|?)/";
        preg_match_all($pattern, $string, $output);
        if (!empty($output[0])) {
            return $output[2][0];
        } else {
            return false;
        }
    }

    public function get_class_name($string) {
        $pattern = "/@{1}[a-z_]+/";
        preg_match_all($pattern, $string, $output);
        if (!empty($output[0])) {
            return substr($output[0][0], 1);
        } else {
            return false;
        }
    }

    public function get_function_name($string) {
        $pattern = '/\${1}[a-z_]+/';
        preg_match_all($pattern, $string, $output);
        if (!empty($output[0])) {
            return substr($output[0][0], 1);
        } else {
            return false;
        }
    }

    public function get_key($string) {
        $pattern = '/\:{1}(\d+)/';
        preg_match_all($pattern, $string, $output);

        if (!empty($output[0])) {
            return substr($output[0][0], 1);
        } else {
            return false;
        }
    }

    public function search_function($post, $search_function_name) {
        foreach ($post as $key => $value) {
            $function_name = $this->get_function_name($key);
            if ($search_function_name == $function_name) {
                return $value;
            }
        }
    }

    public function seperate_data($post) {
        $data = array();
        foreach ($post as $key => $value) {
            if ($key[0] !== "!") {
                $class_name = $this->get_class_name($key);

                $function_name = $this->get_function_name($key);
                $parameter = $value;
                $parameter_key = $this->get_key($key);
                if ($class_name != "") {
                    if ($class_name == PLASEBO) {
                        self::addPlasebo($function_name, $parameter, $parameter_key);
                    } else {
                        if ($condition = $this->get_condition($key)) {
                            $condition_value = $this->get_condition_value($key);
                            $search_value = $this->search_function($post, $condition);
                            if ($search_value == $condition_value) {
                                $data[] = ["class" => $class_name, "function" => "set_" . $function_name, "parameter" => $parameter, "key" => $parameter_key];
                            }
                        } else {
                            $data[] = ["class" => $class_name, "function" => "set_" . $function_name, "parameter" => $parameter, "key" => $parameter_key];
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function integration($data) {
        $list = [];
        $class_list = [];
        $temp = [];
        foreach ($data as $pack) {
            $class = $pack["class"];
            $function = $pack["function"];
            $parameter = $pack["parameter"];
            $key = $pack["key"];
            if ($class != "") {
                $list[$class][$key][] = $function;
            }
        }
        foreach ($list as $class_name => $lt) {
            if (class_exists($class_name)) {
                try {
                    $ncls = new $class_name;
                } catch (Exception $ex) {
                    // dnd($ex);
                }

                $table_name = $ncls->table_fields;
                $id = "set_" . $table_name . "_id";
                $table_cloumns = self::get_table_cloumns($table_name);
                $stable_cloumns = self::set_table_prefix("set_", $table_cloumns);

                foreach ($stable_cloumns as $clmb) {
                    foreach ($lt as $key => $val) {
                        if (!in_array($clmb, $val)) {
                            if ($id != $clmb) {
                                ($key == 0) ? "" : $key;
                                $temp[] = ["class" => $class_name, "function" => $clmb, "parameter" => "", "key" => $key];
                            }
                        }
                    }
                }
            } else {
                die($class_name . " Adında bir Class Bulunmamaktadır.");
            }
        }
        foreach ($temp as $pack) {
            $data[] = $pack;
        }
        return $data;
    }

    public function _integration($data) {
        $temp_data = $data;
        $delete_data = $data;
        $temp = [];
        foreach ($data as $dt) {
            $cls = $dt["class"];
            $ncls = new $cls;
            $table_name = $ncls->get_table_fields();
            $table_cloumns = self::get_table_cloumns($table_name);
            // dnd($table_name);
            $table_cloumns = self::set_table_prefix("set_", $table_cloumns);
            $temp_table_data = $table_cloumns;
            // dnd($table_cloumns);

            foreach ($data as $dtd) {
                if ($dtd["class"] == $cls) {
                    $ff = $dtd["function"];
                    $key = $dtd["key"];
                    if ($ff != "set_secret_key") {
                        
                    }
                    $index = 0;
                    foreach ($table_cloumns as $tc) {
                        if ($ff === $tc) {
                            unset($temp_table_data[$index]);
                        } else {
                            //dnd("****" . $tc . "******");
//                                dnd($index);
//                                dnd($table_cloumns[$index]);
//                                $index++;
                        }
                        $index++;
                    }

                    //dnd($dtd);
                }
            }
        }

//        foreach ($data as $dt) {
//            $cls = $dt["class"];
////            $ncls = new $cls;
////            $table_name = $ncls->get_table_fields();
////            $key_list = self::get_secret_number($this->get_control_tag(), $table_name);
//            dnd($dt);
//        }
        dnd($temp_table_data);
//        foreach ($temp_table_data as $dtdt) {
//            $temp_data[] = ["class" => $cls, "function" => $dtdt];
//        }
//        dnd($temp_data);

        return $temp_data;
    }

    public function set_table_prefix($prefix, $array) {
        $result = [];
        foreach ($array as $ar) {
            $result[] = $prefix . $ar;
        }
        return $result;
    }

    private function data_search($key, $data_array) {
        $index = 0;
        $select_index = -1;
        foreach ($data_array as $ar) {
            if ($key == $ar) {
                $select_index = $index;
                return strval($select_index);
            }
            $index++;
        }
    }

    public function _seperate_data($data, $value) {
        $con = explode("#", $data);
        if (count($con) >= 2) {
            $ex_data = explode("@", $con[1]);
            $this->create_class = $ex_data[0];
            $con_ex = explode("=", $con[0]);
            $result["condition"] = $con_ex[0];
            $result["condition_value"] = $con_ex[1];
        } else {
            $ex_data = explode("@", $data);
            $this->create_class = $ex_data[0];
        }
        // preg_match('/[^a-zA-Z]+/', $data, $matches);

        $ex_function = explode(":", $ex_data[1]);
        if (count($ex_function) >= 2) {
            $this->function = $ex_function[0];
            $this->key = $ex_function[1];
            $result["key"] = $this->key;
        } else {
            $this->function = $ex_data[1];
        }
        $con = explode("#", $ex_data[0]);
        //TODO : ":" ile ayırıp function ve key numarasını ayırmak lazım
        $result["create_class"] = $this->create_class;
        $result["function"] = $this->function;


        return $result;
    }

    public function data_exec($datasets) {
        if (!empty($datasets))
            foreach ($datasets as $data) {
                $parameters = array();
                $class = $data["class"];
                $function = $data["function"];
                $parameters[] = $data["parameter"];
                if (isset($data["key"])) {
                    $parameters[] = $data["key"];
                }

                //temaözellikleri ve plugin manipulasyonlarını burada kontrol edebiliriz.


                if (class_exists($class)) {
                    if (method_exists($class, $function)) {
                        $dispatch = new $class($class, $function);
                        call_user_func_array([$dispatch, $function], $parameters);
                    } else {
                        //die($class . "-" . $function . "-" . "Methoda Ulaşılamıyor");
                    }
                } else {
                    die($class . "-" . "Class'a Ulaşılamıyor");
                }
            }
    }

    public static function check_data($control_module, $table_fields) {
        if (isset(self::$fields[$control_module][$table_fields])) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_data($control_module, $table_fields = "") {
        if ($table_fields != "") {
            if (isset(self::$fields[$control_module][$table_fields])) {
                return self::$fields[$control_module][$table_fields];
            } else {
                return false;
            }
        } else {
            return self::$fields[$control_module];
        }
    }

    public static function remove_data($control_module, $table_fields) {
        if (isset(self::$fields[$control_module][$table_fields])) {
            unset(self::$fields[$control_module][$table_fields]);
        } else {
            return false;
        }
    }

    public static function get_plasebo_data($control_module) {
        if ($control_module != "") {
            return self::$plasebofields[$control_module];
        } else {
            return false;
        }
    }

    public static function get_secret_number($control_module, $table_fields = "") {
        if ($table_fields != "") {
            return self::$secret_number[$control_module][$table_fields];
        } else {
            return self::$secret_number[$control_module];
        }
    }

}
