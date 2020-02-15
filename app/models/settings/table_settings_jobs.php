<?php
/**
 * Description of settings
 *
 * @author engin
 */
class table_settings_jobs extends general {

    public function __construct($table = "") {
        $this->selecttable = "settings_jobs";
        parent::__construct($this->selecttable);
        return true;
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
