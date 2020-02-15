<?php

class table_bulkmail extends general {

    public function __construct() {
        parent::__construct("bulkmail");
        $this->selecttable = "bulkmail";
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
