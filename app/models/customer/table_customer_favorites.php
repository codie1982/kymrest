<?php
/**
 * Description of adres
 *
 * @author engin
 */
class table_customer_favorites extends general {

    public function __construct($all = true) {
        parent::__construct("customer_favorites");
        $this->selecttable = "customer_favorites";
    }

    public function get_table_name() {
        return $this->selecttable;
    }

}
