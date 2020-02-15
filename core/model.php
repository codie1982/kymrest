<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model
 *
 * @author engin
 */
class model {

    public $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [], $_showsql = false;
    public $id;

    public function __construct($table) {
        $this->_db = db::getInstance();
        // $this->_db = new db();
        $this->_table = $table;
        $this->_setTableColumns();

        $this->_modelName = str_replace(' ', '', ucwords(str_replace("_", " ", $this->_table)), $count);
    }

    protected function _setTableColumns() {

        $columns = $this->get_columns();
        foreach ($columns as $column) {
            $columnName = $column->Field;
            $this->_columnNames[] = $column->Field;
            $this->{$columnName} = null;
        }
    }

    public function showsql($val) {
        return $this->_db->_showsql = $val;
    }

    public function get_columns() {
        $db = new db();
        return $db->get_cloumns($this->_table);
    }

    public function find($params = []) {
        $results = [];
        $resultsQuery = $this->_db->find($this->_table, $params);
        if (!empty($resultsQuery)) {
            foreach ($resultsQuery as $result) {
                $obj = new $this->_modelName($this->_table);
                $obj->populateObjData($result);
                $results[] = $obj;
            }
        }

        return $results;
    }

    public function findFirst($params = []) {
        $resultsQuery = $this->_db->findFirst($this->_table, $params);
        $result = new $this->_modelName($this->_table);

        if (!empty($resultsQuery))
            if ($resultsQuery) {
                $result->populateObjData($resultsQuery);
            }

        return $result;
    }

    public function findById($id) {
        return $this->findFirst(["condition" => $this->_table . "_id = ?", "bind" => [$id]]);
    }

    public function save() {
        $fields = [];
        if (!empty($this->_columnNames))
            foreach ($this->_columnNames as $column) {
                $fields[$column] = $this->$column;
            }
        //determine whether to update or insert
        //Buradına Bakmamız gerekecek BAK
        if (property_exists($this, $this->_table . "_id") && $this->id != "") {
            return $this->update($this->id, $fields);
        } else {
            return $this->insert($fields);
        }
    }

    public function insert($fields) {
        if (empty($fields))
            return false;
        else
            return $this->_db->insert($this->_table, $fields);
    }

    public function update($id, $fields, $updateFields = null) {
        if (empty($fields)) {
            return false;
        } else {
            // update($table, $id, $fields = [], $id_table = null)
            return $this->_db->update($this->_table, $id, $fields, $updateFields);
        }
    }

    public function delete($id = "", $delete_field = null) {
        if ($id == "" && $this->id == "")
            return false;
        $id = ($id == "") ? $this->_id : $id;
        if ($this->_softDelete) {
            return $this->update($id, ["deleted" => 1]);
        } else {
            return $this->_db->delete($this->_table, $id, $delete_field);
        }
    }

    public function turncate_table() {
        return $this->_db->turncate($this->_table);
    }

    public function query($sql, $bind = []) {
        // dnd($sql);
        if ($sql != "") {
            return $this->_db->query($sql, $bind);
        } else {
            return false;
        }
    }

    public function data() {
        $data = new stdClass();
        foreach ($this->_columnNames as $column) {
            $data->column = $this->column;
        }
        return $data;
    }

    public function assing($params) {
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                if (in_array($key, $this->_columnNames)) {
                    $this->$key = sanitize($val);
                }
            }
            return true;
        }
        return false;
    }

    protected function populateObjData($result) {
        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

}
