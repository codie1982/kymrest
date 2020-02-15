<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class db {

    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastinsertID = null;
    public $_showsql = false;

    public function __construct() {
        try {

            $this->_pdo = @new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';', DBUSER, DBPASSWORD);

            $this->_pdo->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
        } catch (PDOException $exp) {
            $this->_error = $exp->getMessage();
            print "Hata!: DB Bağlantısı Bulunmamakta Config Dosyasını yeniden ayarlamak için sayfayı yenileyin <br/>" . $this->_error;
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new db();
        }
        return self::$_instance;
    }

    public function query($sql, $params = []) {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);

                $this->_count = $this->_query->rowCount();
                $this->_lastinsertID = $this->_pdo->lastInsertId();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function like($sql, $params = []) {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, "'%" . $param . "%'");
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_lastinsertID = $this->_pdo->lastInsertId();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function insert($table, $fields = []) {
        $fieldString = '';
        $valueString = '';
        $values = [];
        //dnd($table);
        foreach ($fields as $field => $value) {
            $fieldString .= '`' . $field . '`' . ",";
            $valueString .= '?,';
            $values[] = $value;
            //$valueString .=  '`' . $value . '`' . ",";;
        }
        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

        if ($this->_showsql) {
            foreach ($fields as $field => $value) {
                $_fieldString .= '`' . $field . '`' . "=" . '\'' . $value . '\',';
            }

            $_fieldString = rtrim($_fieldString, ',');

            echo "INSERT INTO {$table} SET  {$_fieldString}";
            echo "<br />";
        }
        if (!$er = $this->query($sql, $values)->error()) {
            return true;
        }
        return false;
    }

    public function update($table, $id, $fields = [], $id_columb = null) {
        $fieldsString = '';
        $values = [];
        foreach ($fields as $field => $value) {
            $fieldsString .= '`' . $field . '`' . '=?,';
            $values[] = $value;
        }
        $fieldsString = trim($fieldsString);
        $fieldsString = rtrim($fieldsString, ",");
        if (is_null($id_columb)) {
            $id_columb = $table . "_id";
        }


        $sql = "UPDATE {$table} SET {$fieldsString} WHERE {$id_columb}='{$id}'";

        if ($this->_showsql) {
            $fieldsString = '';
            //$values = [];
            foreach ($fields as $_field => $_value) {
                $_fieldString .= '`' . $_field . '`' . '=' . '\'' . $_value . '\'' . ',';
                //$values[] = $value;
            }
            $_fieldString = trim($_fieldString);
            $_fieldString = rtrim($_fieldString, ",");
            if (is_null($id_columb)) {
                $_id_columb = $table . "_id";
            }

            echo "UPDATE {$table} SET {$_fieldString} WHERE {$_id_columb}='{$id}'";
            echo "<br />";
        }
      
        if (!$this->query($sql, $values)->error()) {
            return true;
        }
        return false;
    }

    public function delete($table, $id, $id_table = null) {
        if (is_null($id_table)) {
            $id_table = $table . "_id";
        }
        $sql = "DELETE FROM {$table} WHERE {$id_table}='{$id}'";
        if (!$this->query($sql, $values)->error()) {

            return true;
        }
        return false;
    }

    public function turncate($table) {
        $sql = "TRUNCATE TABLE {$table} ";


        if (!$this->query($sql)->error()) {
            return true;
        }
        return false;
    }

    public function getQuery() {
        return $this->_query;
    }

    public function alldata() {
        if (!empty($this->_result)) {
            return $this->_result;
        } else {
            return false;
        }
    }

    public function results() {
        if (is_array($this->_result)) {
            return $this->_result;
        } else {
            return false;
        }
    }

    public function one() {
        if (is_array($this->_result)) {
            if (count($this->_result) == 1) {
                return $this->_result[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function find($table, $params = []) {
        if ($this->_read($table, $params)) {
            return $this->results();
        }
        return false;
    }

    public function findFirst($table, $params = []) {
        if ($this->_read($table, $params)) {
            return $this->one();
        }
        return false;
    }

    public function _read($table, $params = []) {
        $conditionString = "";
        $bind = [];
        $order = "";
        $limit = "";
//conditions
        if (isset($params["conditions"])) {
            if (is_array($params["conditions"])) {
                foreach ($params["conditions"] as $condition) {
                    $conditionString .= ' ' . $condition . " AND";
                }
                $conditionString = trim($conditionString);
                $conditionString = rtrim($conditionString, " AND");
            } else {
                $conditionString = $params["conditions"];
            }
            if ($conditionString != "")
                $conditionString = " WHERE " . $conditionString;
        }
        //bind
        if (array_key_exists("bind", $params)) {
            $bind = $params["bind"];
        }

        //order
        if (array_key_exists("order", $params)) {
            $order = " ORDER BY " . $params["order"];
        }
        //limit
        if (array_key_exists("limit", $params)) {
            $limit = " LIMIT " . $params["limit"];
        }
        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
        if ($this->query($sql, $bind)) {
            if (!count($this->_result)) {
                return false;
            }
            return true;
        }
    }

    public function get_cloumns($table) {
        return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }

    public function get_tables() {
        return $this->query("SHOW TABLES")->results();
    }

    public function lastinsertID() {
        return $this->_lastinsertID;
    }

    public function count() {
        return $this->_count;
    }

    public function error() {
        return $this->_error;
    }

}
