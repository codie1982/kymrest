<?php
/**
 * Description of settings
 *
 * @author engin
 */
class table_settings_transport_location extends general {

    public function __construct($table = "") {
        $this->selecttable = "settings_transport_location";
        parent::__construct($this->selecttable);
        return true;
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
