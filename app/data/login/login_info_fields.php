<?php

/**
 * Description of productfields
 *
 * @author engin
 */
class login_info_fields extends customer_rule {

    public function __construct() {
        $this->table_fields = "login_info";
        return true;
    }

    private $customer_id;
    private $continent;
    private $country;
    private $city;
    private $isp;
    private $lat;
    private $lon;
    private $date;

    public function set_customer_id($customer_id) {
        $this->customer_id = $customer_id;
        data::add("customer_id", $this->customer_id !== "" ? $this->customer_id : NODATA, $this->table_fields);
    }

    public function set_continent($continent) {
        $this->continent = $continent;
        data::add("continent", $this->continent !== "" ? $this->continent : NODATA, $this->table_fields);
    }

    public function set_country($country) {
        $this->country = $country;
        data::add("country", $this->country !== "" ? $this->country : NODATA, $this->table_fields);
    }

    public function set_city($city) {
        $this->city = $city;
        data::add("city", $this->city !== "" ? $this->city : NODATA, $this->table_fields);
    }

    public function set_isp($isp) {
        $this->isp = $isp;
        data::add("isp", $this->isp !== "" ? $this->isp : NODATA, $this->table_fields);
    }

    public function set_lat($lat) {
        $this->lat = $lat;
        data::add("lat", $this->lat !== "" ? $this->lat : NODATA, $this->table_fields);
    }

    public function set_lon($lon) {
        $this->lon = $lon;
        data::add("lon", $this->lon !== "" ? $this->lon : NODATA, $this->table_fields);
    }

    public function set_date($date) {
        $this->date = $date;
        data::add("date", $this->date !== "" ? $this->date : getNow(), $this->table_fields);
    }

}
