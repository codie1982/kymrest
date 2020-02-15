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
class _client extends model {

    private $_selecttable;
    private $adres;
    private $province;
    private $district;
    private $neighborhood;
    private $_sessionName;
    private $_cookieName;

    public function __construct($customer_id = "") {
        $this->_selecttable = "customer";
        parent::__construct($this->_selecttable);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
    }

    public function set_adres($val) {
        return $this->adres = $val;
    }

    public function set_province($val) {
        return $this->province = $val;
    }

    public function set_district($val) {
        return $this->district = $val;
    }

    public function set_neighborhood($val) {
        return $this->neighborhood = $val;
    }

    public function getClientIDFromSeccode($client_seccode) {
        $r = $this->query("SELECT customer_id FROM $this->_selecttable WHERE customer_seccode = ? ", [$client_seccode])->one();

        return $r->customer_id;
    }

    public function getClientIDFromSeccodeArr($client_seccode) {
        $r = $this->query("SELECT customer_id FROM $this->_selecttable WHERE customer_seccode = ? ", [$client_seccode])->results();
        return $r;
    }

    public function getClientAdresInfo($client_id, $filter = " * ") {
        $r = $this->_db->query("SELECT $filter FROM customer_adres WHERE customer_id = ? ", [$client_id])->results();
        return $r;
    }

    public function getClientPhoneInfo($client_id, $filter = " * ") {
        $r = $this->_db->query("SELECT * FROM customer_phone WHERE customer_id = ? ", [$client_id])->results();
        if ($filter == " * ") {
            return $r;
        } else {
            return $r->$filter;
        }
    }

    public function getCrediCardInfo($client_id, $filter = " * ") {
        $r = $this->_db->query("SELECT * FROM customer_credi_card WHERE customer_id = ? ", [$client_id])->results();
        if ($filter == " * ") {
            return $r;
        } else {
            return $r->$filter;
        }
    }

    public function getClientInfo($client_id, $filter = " * ") {
        $r = $this->query("SELECT $filter FROM $this->_selecttable WHERE customer_add_state<>'automatic' && customer_id = ? ", [$client_id])->one();
        if ($filter == " * ") {
            return $r;
        } else {
            return $r->$filter;
        }
    }

    public function getClientsInfoFromAdres($start, $end, $total) {
        $contidion_arr = [];
        $limit = " LIMIT " . $start . "," . ($end - $start);

        $sql .= "SELECT * FROM $this->_selecttable INNER JOIN customer_adres ON customer_adres.customer_id=$this->_selecttable.customer_id";
        $_sql .= "SELECT COUNT(*) FROM $this->_selecttable INNER JOIN customer_adres ON customer_adres.customer_id=$this->_selecttable.customer_id";
        $sql .= " WHERE customer_adres.province = ? AND ";
        $contidion_arr[] = $this->province;
        if ($this->district != "---") {
            $sql .= " customer_adres.district = ? AND";
            $contidion_arr[] = $this->district;
        }
        if ($this->neighborhood != "---") {
            $sql .= " customer_adres.neighborhood = ? AND";
            $contidion_arr[] = $this->neighborhood;
        }
        $sql .= " customer_add_state <>'automatic' ORDER BY $this->_selecttable.date DESC $limit";
        $r = $this->query($sql, $contidion_arr)->results();

        $total = count($r);

        return $r;
    }

    public function getClientsInfo($start = 0, $end = 10, &$total = 30) {
        $contidion_arr = [];
        $limit = " LIMIT " . $start . "," . ($end - $start);

        $r = $this->query("SELECT * FROM $this->_selecttable WHERE customer_add_state <>'automatic' ORDER BY date DESC $limit", $contidion_arr)->results();
        $_t = $this->query("SELECT COUNT(*) FROM $this->_selecttable WHERE  customer_add_state <>'automatic' ORDER BY date DESC ", $contidion_arr)->one();

        $total = $_t->{"COUNT(*)"};
        return $r;
    }

    public function getClientstableInfo($clients_seccode, $start = 0, $end = 10, &$total = 30) {
        $limit = " LIMIT " . $start . "," . ($end - $start);
        if (is_array($clients_seccode)) {
            $contidion = " WHERE ";
            $client = implode(',', array_fill(0, count($clients_seccode), '?')); //create 3 question marks
            $contidion .= " customer_seccode IN($client)";
        }
        $r = $this->query("SELECT * FROM $this->_selecttable 
                $contidion ORDER BY date DESC $limit", $clients_seccode)->results();
// dnd($this);
        $total = count($clients_seccode);
        return $r;
    }

    public function checkCustomer($customer_email) {
        $customer = $this->query("SELECT * FROM customer WHERE customer_add_state<>'automatic' && email = ? ", [$customer_email])->one();
        if ($customer) {
            return $customer->customer_id;
        } else {

            return false;
        }
    }

    public function editCustomer($customer_id, $source) {
        if (!empty($source)) {
            preg_match_all('!\d+!', input::santize($source["customer_idnumber"]), $_idnumber);
            preg_match_all('!\d+!', input::santize($source["customer_company_tax_number"]), $_tax_number);

            $fields = [
                "name" => strtolower(input::santize($source["customer_fullname"])),
                "name_sef" => sef_link(strtolower(input::santize($source["customer_fullname"]))),
                "email" => filter_var(input::santize($source["customer_email"]), FILTER_VALIDATE_EMAIL) == true ? input::santize($source["customer_email"]) : "---",
                "type" => input::santize($source["customer_add_state"]) === "---" ? 0 : input::santize($source["customer_add_state"]),
                "customer_idnumber" => input::santize($source["customer_add_state"]) === "personel" ? $_idnumber[0][0] === "" ? "---" : $_idnumber[0][0] : "---",
                "customer_company_title" => input::santize($source["customer_add_state"]) === "company" ? input::santize($source["customer_company_title"]) === "" ? "---" : input::santize($source["customer_company_title"]) : "---",
                "customer_company_tax_province" => input::santize($source["customer_add_state"]) === "company" ? input::santize($source["customer_company_tax_province"]) === "0" ? "0" : input::santize($source["customer_company_tax_province"]) : "---",
                "customer_company_tax_office" => input::santize($source["customer_add_state"]) === "company" ? input::santize($source["customer_company_tax_office"]) === "0" ? "0" : input::santize($source["customer_company_tax_office"]) : "---",
                "customer_company_tax_number" => input::santize($source["customer_add_state"]) === "company" ? $_tax_number === "0" ? "0" : $_tax_number : "---",
                "description" => input::santize($source["customer_description"]) === "" ? "---" : input::santize($source["customer_description"]),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];
            if ($this->update($customer_id, $fields)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function addNewVisitor($visitor_ip, $visitor_referer, $visitor_uagent) {



        if (!$costumer_info = $this->query("SELECT customer_id FROM customer WHERE visitor_ip = ? ", [$visitor_ip])->one()) {
            $fields = [
                "customer_add_state" => "automatic",
                "visitor_ip" => $visitor_ip,
                "visitor_referer" => $visitor_referer,
                "visitor_uagent" => $visitor_referer,
                "date" => getNow(),
                "customer_seccode" => seccode("VIS"),
                "customer_code" => rand(9999, 99999),
            ];
            $this->insert($fields);
            $cid = $this->_db->lastinsertID();

//            $geo = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$visitor_ip"));
//            if ($geo->status == "success") {
//                $cid = $fields = [
//                    "customer_id" => $cid,
//                    "customer_location_region" => $geo->region,
//                    "customer_location_country" => $geo->country,
//                    "customer_location_continent" => $geo->continent,
//                    "ipType" => $geo->ipType,
//                    "isp" => $geo->isp,
//                    "user_ip" => $user_ip,
//                    "customer_location_lat" => $geo->lat,
//                    "customer_location_lon" => $geo->lon,
//                    "date" => getNow(),
//                ];
//                $this->_db->insert("customer_login", $fields);
//            }

            return $cid;
        }
        return $costumer_info->customer_id;
    }

    public function addNewCustomer($source) {
        if (!empty($source)) {
            if (isset($source["customer_idnumber"])) {
                preg_match_all('!\d+!', input::santize($source["customer_idnumber"]), $_idnumber);
                $idnumber = $_idnumber[0][0];
            } else {
                $idnumber = 0;
            }
            if (isset($source["customer_company_tax_number"])) {
                preg_match_all('!\d+!', input::santize($source["customer_company_tax_number"]), $_tax_number);
                $tax_number = $_tax_number[0][0];
            } else {
                $tax_number = 0;
            }

            $fields = [
                "name" => strtolower(input::santize($source["customer_name"])),
                "lastname" => strtolower(input::santize($source["customer_lastname"])),
                "name_sef" => sef_link(strtolower(input::santize($source["customer_name"]))),
                "email" => filter_var(input::santize($source["customer_email"]), FILTER_VALIDATE_EMAIL) == true ? input::santize($source["customer_email"]) : "---",
                "type" => input::santize($source["customer_add_state"]) === "---" ? 0 : input::santize($source["customer_add_state"]),
                "customer_idnumber" => input::santize($source["customer_add_state"]) === "personel" ? empty($idnumber) ? "---" : $idnumber : "---",
                "customer_company_title" => input::santize($source["customer_add_state"]) === "company" ? input::santize($source["customer_company_title"]) === "" ? "---" : input::santize($source["customer_company_title"]) : "---",
                "customer_company_tax_province" => input::santize($source["customer_add_state"]) === "company" ? input::santize($source["customer_company_tax_province"]) === "0" ? "0" : input::santize($source["customer_company_tax_province"]) : "---",
                "customer_company_tax_office" => input::santize($source["customer_add_state"]) === "company" ? input::santize($source["customer_company_tax_office"]) === "0" ? "0" : input::santize($source["customer_company_tax_office"]) : "---",
                "customer_company_tax_number" => input::santize($source["customer_add_state"]) === "company" ? $tax_number === "0" ? "0" : $tax_number : "---",
                "description" => input::santize($source["customer_description"]) === "" ? "---" : input::santize($source["customer_description"]),
                "date" => getNow(),
                "customer_seccode" => seccode(),
                "customer_code" => rand(9999, 99999),
                "users_id" => session::get(CURRENT_USER_SESSION_NAME),
            ];

            if ($this->insert($fields)) {
                $customer_id = $this->_db->lastinsertID();
//Adres Ekle
                if (isset($source["adres_random"])) {
                    $adres_random = $source["adres_random"];
                    foreach ($adres_random as $rnd) {
                        $adres_fields = [
                            "customer_id" => $customer_id,
                            "adres_title" => input::santize(strtolower($source["adres_title"][$rnd])),
                            "province" => $source["adres_il"][$rnd],
                            "district" => $source["adres_ilce"][$rnd],
                            "neighborhood" => $source["adres_mahalle"][$rnd],
                            "description" => input::santize(strtolower($source["adres_description"][$rnd])),
                            "date" => getNow(),
                            "adres_seccode" => seccode(),
                            "users_id" => session::get(CURRENT_USER_SESSION_NAME),
                        ];

                        $this->_db->insert("customer_adres", $adres_fields);
                    }
                }
//Telefon ekle
                if (isset($source["phone_random"])) {
                    $phone_random = $source["phone_random"];
                    foreach ($phone_random as $rnd) {
                        preg_match_all('!\d+!', $source["phone_number"][$rnd], $phone_number);
                        $phone_fields = [
                            "customer_id" => $customer_id,
                            "phone" => $phone_number[0][0],
                            "date" => getNow(),
                            "phone_seccode" => seccode(),
                            "users_id" => session::get(CURRENT_USER_SESSION_NAME),
                        ];

                        $this->_db->insert("customer_phone", $phone_fields);
                    }
                }
//Kredi Kartı Ekle
                if (isset($source["credicard_random"])) {
                    $card_random = $source["credicard_random"];
                    foreach ($card_random as $rnd) {
                        preg_match_all('!\d+!', $source["credicart_number"][$rnd], $card_number);
                        $card_fields = [
                            "customer_id" => $customer_id,
                            "credi_card_number" => $card_number[0][0],
                            "month" => $source["credi_cart_month"][$rnd] === "---" ? "0" : $source["credi_cart_month"][$rnd],
                            "year" => $source["credi_cart_year"][$rnd] === "---" ? "0" : $source["credi_cart_year"][$rnd],
                            "date" => getNow(),
                            "credi_card_seccode" => seccode(),
                            "users_id" => session::get(CURRENT_USER_SESSION_NAME),
                        ];

                        $this->_db->insert("customer_credi_card", $card_fields);
                    }
                }
                return $customer_id;
            } else {
                return false;
            }
        }
    }

    public function setClientTable($clientsInfo, $show = 10, $start = 0, $end = 10, $total = 30, $errormessage = "") {
        $nclient_table = new client_table($clientsInfo);
        $nclient_table->set_start_item($start);
        $nclient_table->set_end_item($end);
        $nclient_table->set_total_item($total);
        $nclient_table->set_show_item($show);
        $nclient_table->set_error_message($errormessage);
        $nclient_table_cloumb = [
            "cloumb" => [
                ["thead_title" => "#",
                    "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center"],
                    "tbody_varible" => "checkbox",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Müşteri Kodu",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kodu"],
                    "tbody_varible" => "client_code",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Adı Soyadı",
                    "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün adı"],
                    "tbody_varible" => "client_name",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Mail Adresi",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kategorisi"],
                    "tbody_varible" => "client_email",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Tipi",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün stok sayısı"],
                    "tbody_varible" => "client_type",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Sipariş Sayısı",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün gönderim ücreti"],
                    "tbody_varible" => "client_job_count",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "İlgilendiği Kateoriler	",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün fiyatı"],
                    "tbody_varible" => "client_interested_category",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Sipariş Miktarı",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "client_total_job_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Kullanıcı Varlıkları",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "client_presence",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Eylemler",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "eylemler"],
                    "tbody_varible" => "actions",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
            ]
        ];

        $nclient_table->set_table_info($nclient_table_cloumb);
        $nclient_table->set_table_header(FALSE);
        $nclient_table->set_table_footer(true);
        return $nclient_table->add_table(false);
    }

    public function removeCostumer($costumer_id) {
        if ($this->delete($costumer_id)) {
            return true;
        } else {
            return false;
        }
    }

    public function searchClient($q) {
        $qsef = sef_link($q);
        $_qsef = "%{$qsef}%";
        $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->_selecttable as id WHERE customer_add_state<>'automatic' AND name_sef LIKE ? ", [$_qsef])->results();
        if ($r) {
            return $r;
        } else {
            $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->_selecttable as id WHERE customer_add_state<>'automatic' AND email LIKE ? ", [$_qsef])->results();
            if ($r) {
                return $r;
            } else {
                $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->_selecttable as id WHERE customer_add_state<>'automatic' AND customer_code LIKE ? ", [$_qsef])->results();
                if ($r) {
                    return $r;
                } else {
                    $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->_selecttable as id WHERE customer_add_state<>'automatic' AND customer_idnumber LIKE ? ", [$_qsef])->results();
                    if ($r) {
                        return $r;
                    } else {
                        $r = $this->_db->query("SELECT customer_seccode as id,name as cname FROM $this->_selecttable as id WHERE customer_add_state<>'automatic' AND customer_company_tax_number LIKE ? ", [$_qsef])->results();
                        if ($r) {
                            return $r;
                        } else {
                            $r = $this->_db->query("SELECT customer.customer_seccode as id,customer.name as cname FROM $this->_selecttable  
                                INNER JOIN customer_phone ON customer_phone.customer_id = $this->_selecttable.customer_id
                                WHERE customer.customer_add_state<>'automatic' AND customer_phone.phone LIKE ? ", [$_qsef])->results();
                            if ($r) {
                                return $r;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            }
        }
    }

    public function searchClientAdres($q) {
        return true;
    }

    public function checkPublicCustomer($source) {
        $user_email = $source["user_email"];
        if ($r = $this->query("SELECT * FROM customer WHERE email = ? AND public = ?  ", [$user_email, "1"])->one()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkRepasswordCustomer($source) {
        $user_email = $source["user_email"];
        if ($r = $this->query("SELECT customer_seccode FROM customer WHERE email = ? AND repassword=? ", [$user_email, 1])->one()) {
            return $r->customer_seccode;
        } else {
            return false;
        }
    }

    public function newCustomer($source) {
        $visitor_ip = get_ipno();
        if ($costumer_info = $this->query("SELECT * FROM customer WHERE visitor_ip = ? ", [$visitor_ip])->one()) {
            $customer_id = $costumer_info->customer_id;
//Kullanıcı Bilgisi Var ise O kullanıcıyı güncelleyecez
            $user_email = $source["user_email"];
            if ($_costumer_info = $this->query("SELECT * FROM customer WHERE email = ? ", [$user_email])->one()) {
                $_customer_id = $_costumer_info->customer_id;
                $fields = [
                    "name" => input::santize($source["user_name"]),
                    "lastname" => isset($source["user_lastname"]) ? input::santize($source["user_lastname"]) : NODATA,
                    "name_sef" => input::santize(sef_link($source["user_name"])),
                    "password" => password_hash(input::santize($source["user_password"]), PASSWORD_DEFAULT),
                    "type" => "personel",
                    "customer_add_state" => "personel",
                    "public" => 1,
                    "contract" => isset($source["check"]) ? 1 : 0,
                    "contract_date" => getNow(),
                    "advertisement" => isset($source["advisor"]) ? 1 : 0,
                    "advertisement_date" => getNow(),
                    "customer_date" => getNow(),
                    "visitor_ip" => $visitor_ip,
                    "visitor_referer" => $costumer_info->visitor_referer,
                    "visitor_uagent" => $costumer_info->visitor_uagent,
                ];
                $this->update($_customer_id, $fields);
                if ($_customer_id !== $customer_id) {
                    $this->delete($customer_id);
                }
                $customer_id = $_customer_id;
            } else {
                /* Aynı Kişi Farklı mail adresinden kayıt yaparsa aynı kullanıcı idsi ve yeni mail adresi ile kayıt olmuş olur. Eski mail adresi ise "customer_mail" tablosunda yeralır. */
                $fileds_mail = [
                    "customer_id" => $customer_id,
                    "customer_mail" => $source["user_email"],
                    "customer_mail_date" => getNow()
                ];
                $this->_db->insert("customer_mail", $fileds_mail);

                $fields = [
                    "name" => input::santize($source["user_name"]),
                    "lastname" => isset($source["user_lastname"]) ? input::santize($source["user_lastname"]) : NODATA,
                    "name_sef" => input::santize(sef_link($source["user_name"])),
                    "email" => input::santize($source["user_email"]),
                    "email_cofirm" => 0,
                    "password" => password_hash(input::santize($source["user_password"]), PASSWORD_DEFAULT),
                    "type" => "personel",
                    "customer_add_state" => "personel",
                    "customer_date" => getNow(),
                    "contract" => isset($source["check"]) ? 1 : 0,
                    "contract_date" => isset($source["check"]) ? getNow() : "0000-00-00 00:00:00",
                    "advertisement" => isset($source["advisor"]) ? 1 : 0,
                    "advertisement_date" => isset($source["advisor"]) ? getNow() : "0000-00-00 00:00:00",
                ];
                $this->update($customer_id, $fields);
            }
            return $customer_id;
        } else {
            $fields = [
                "name" => input::santize($source["user_name"]),
                "lastname" => isset($source["user_lastname"]) ? input::santize($source["user_lastname"]) : NODATA,
                "name_sef" => input::santize(sef_link($source["user_name"])),
                "email" => input::santize($source["user_email"]),
                "email_cofirm" => 0,
                "password" => password_hash(input::santize($source["user_password"]), PASSWORD_DEFAULT),
                "type" => "personel",
                "customer_date" => getNow(),
                "customer_add_state" => "personel",
                "date" => getNow(),
                "customer_seccode" => seccode(),
                "customer_code" => rand(9999, 99999),
                "contract" => isset($source["check"]) ? 1 : 0,
                "contract_date" => getNow(),
                "advertisement" => isset($source["advisor"]) ? 1 : 0,
                "advertisement_date" => getNow(),
            ];
            $this->insert($fields);
            return $this->_db->lastinsertID();
//Eğer Yok ise O kullanıcıyı yeni kullanıcı olarak ekleyecez
        }
    }

    public function newCustomerZero($source) {
        $visitor_ip = get_ipno();
        $user_email = $source["user_email"];
        if ($_costumer_info = $this->query("SELECT * FROM customer WHERE email = ? ", [$user_email])->one()) {
            return false;
        } else {
            $fields = [
                "name" => input::santize($source["user_name"]),
                "name_sef" => input::santize(sef_link($source["user_name"])),
                "email" => input::santize($source["user_email"]),
                "email_cofirm" => 0,
                "repassword" => 1,
                "repassword_code" => rand(9999, 99999),
                "email_cofirm" => 0,
                "type" => "personel",
                "customer_add_state" => "personel",
                "customer_date" => getNow(),
                "customer_seccode" => seccode(),
                "contract" => isset($source["check"]) ? 1 : 0,
                "contract_date" => isset($source["check"]) ? getNow() : "0000-00-00 00:00:00",
                "advertisement" => isset($source["advisor"]) ? 1 : 0,
                "advertisement_date" => isset($source["advisor"]) ? getNow() : "0000-00-00 00:00:00",
            ];
            if ($this->insert($fields)) {
                return $this->_db->lastinsertID();
            } else {
                return false;
            }
        }
    }

    public function findByCustomer($user_email) {
        if ($r = $this->query("SELECT * FROM $this->_selecttable WHERE email = ? ", [$user_email])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function findByCustomerbyID($user_id) {
        if ($r = $this->query("SELECT * FROM $this->_selecttable WHERE customer_id = ? ", [$user_id])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function addWrongPassword($customer_id, $user_email, $user_password) {
        $fields = [
            "customer_id" => $customer_id,
            "customer_email" => $user_email,
            "customer_password" => $user_password,
            "date" => getNow(),
        ];
        $this->_db->insert("customer_wrong_password", $fields);
        return true;
    }

    public function customerAutoLogin($customer_session_code) {
        if ($r = $this->query("SELECT users_id FROM user_session WHERE session = ? ", [$customer_session_code])->one()) {
            $customer_id = $r->users_id;
            $this->customerLogin($customer_id, false);
        } else {
            return false;
        }
    }

    public function customerLogin($customer_id, $rememberme = true) {
        cookie::delete(VISITOR_COOKIE_NAME);
        session::set($this->_sessionName, $customer_id);

        $user_ip = get_ipno();
        $geo = @json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$user_ip"));

        if ($geo->status == "success") {
            $fields = [
                "customer_id" => $customer_id,
                "customer_location_region" => $geo->region,
                "customer_location_country" => $geo->country,
                "customer_location_continent" => $geo->continent,
                "ipType" => $geo->ipType,
                "isp" => $geo->isp,
                "user_ip" => $user_ip,
                "customer_location_lat" => $geo->lat,
                "customer_location_lon" => $geo->lon,
                "date" => getNow(),
            ];
            $this->_db->insert("customer_login", $fields);
        }
        if ($rememberme) {
            $hash = md5(uniqid() + time());
            $user_agent = session::uagent_no_version();
            cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
            $fields = ["session" => $hash, "user_agent" => $user_agent, "users_id" => $customer_id];
            $this->_db->query("DELETE FROM user_session WHERE users_id= ? AND user_agent= ?", [$customer_id, $user_agent]);
            $this->_db->insert("user_session", $fields);
        }
        return true;
    }

    public function loginUserFromCookie() {
        $customer_sesion_code = cookie::get(REMEMBER_ME_COOKIE_NAME);
        if ($customer_sesion_code != "") {
            $userinfo = new self($customer_id);
            $userinfo->customerAutoLogin($customer_sesion_code);
        }
    }

    public function editClientBasicInfo($customer_id, $source) {
        $fields = [
            "name" => input::santize($source["user_name"]),
            "name_sef" => input::santize(sef_link($source["user_name"])),
            "gender" => $source["user_sex"],
            "birthdate" => date("Y-m-d H:i:s", mktime(8, 0, 0, $source["birthdate_month"], $source["birthdate_day"], $source["birthdate_year"])),
        ];
        if ($this->update($customer_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function mailconfirm($mail_adres) {
        $fields = [
            "email_cofirm" => 1,
            "email_cofirm_date" => getNow(),
        ];
        if ($this->update($mail_adres, $fields, "email")) {
            return true;
        } else {
            return false;
        }
    }

    public function checkMailConfirm($mail_adres) {
        if ($r = $this->query("SELECT email_cofirm FROM $this->_selecttable WHERE email = ? ", [$mail_adres])->one()) {
            $email_cofirm = $r->email_cofirm;
            if ($email_cofirm == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function addChangePasswordRequest($user_seccode) {
        $fields = [
            "repassword" => 1,
        ];
        if ($this->update($user_seccode, $fields, "customer_seccode")) {
            return true;
        } else {
            return false;
        }
    }

    public function checkRePassword($user_id) {
        if ($r = $this->query("SELECT repassword,repassword_code FROM $this->_selecttable WHERE customer_id = ? ", [$user_id])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function changePassword($customer_id, $user_password) {
        $fields = [
            "password" => password_hash(input::santize($user_password), PASSWORD_DEFAULT),
            "repassword" => 0,
            "repassword_code" => "---",
        ];
        if ($this->update($customer_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function setupChangePassword($customer_id, $code) {
        $fields = [
            "repassword" => 1,
            "repassword_code" => $code,
        ];
        if ($this->update($customer_id, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomerCount($start_date = null, $end_date = null) {
        $sql = "SELECT COUNT(*) FROM $this->_selecttable WHERE date BETWEEN '$end_date' AND '$start_date'";
        //echo '<br />';
        if ($r = $this->query($sql, [])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

}
