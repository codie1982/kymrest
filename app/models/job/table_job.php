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
class table_job extends general {

    const BASKET = 0;
    const PAYMENT = 1;

    public function __construct($all = true) {
        $this->selecttable = "job";
        parent::__construct($this->selecttable);
    }

    public function get_table_name() {
        return $this->selecttable;
    }

    public function getJobSeccodeFromID($jobID) {
        if ($r = $this->query("SELECT job_seccode FROM $this->selecttable WHERE job_id = ?", [$jobID])->one()) {
            return $r->job_seccode;
        } else {
            return false;
        }
    }

    public function getJobIDfromSeccode($job_seccode) {
        if ($r = $this->query("SELECT job_id FROM $this->selecttable WHERE job_seccode = ?", [$job_seccode])->one()) {
            return $r->job_id;
        } else {
            return false;
        }
    }

    public function addNewJob($source, $customer_id = 0, $job_status = self::BASKET) {
        $enddate = date("Y-m-d H:i:s", strtotime(getNow()) + (15 * 86400)); //15 Gün Geçerli
        $fields = [
            "customer_id" => $customer_id,
            "start_date" => getNow(),
            "end_date" => $enddate,
            "job_seccode" => seccode(),
            "date" => getNow(),
            "job_status" => $job_status,
            "public" => 1,
            "admin_public" => 1,
            "job_number" => "---",
            "users_id" => $source["mode"] != "customer" ? session::get(CURRENT_USER_SESSION_NAME) : -1,
        ];

        if ($this->insert($fields)) {
            $jobID = $this->_db->lastinsertID();
            $fields = [
                "job_id" => $jobID,
                "event" => $job_status,
                "event_date" => getNow(),
                "event_seccode" => seccode(),
                "users_id" => $source["mode"] != "customer" ? session::get(CURRENT_USER_SESSION_NAME) : -1,
            ];
            $this->_db->insert("job_event", $fields);
            $user_ip = get_ipno();
            $geo = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$user_ip"));

            if ($geo->status == "success") {
                $fields = [
                    "customer_id" => $customer_id,
                    "job_id" => $jobID,
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

            return $jobID;
        } else {
            return false;
        }
    }

    public function getJobsInfo($start = 0, $end = 10, $all = false, &$totaljob = 30) {
        if ($start == 0 && $end == 0) {
            $limit = "";
        } else {
            $limit = " LIMIT " . $start . "," . ($end - $start);
        }
        if ($all) {
            $r = $this->query("SELECT * FROM $this->selecttable WHERE complete=? ORDER BY date DESC $limit", [0])->results();
            $_t = $this->query("SELECT COUNT(*) FROM $this->selecttable  WHERE complete=? ORDER BY date DESC ", [0])->one();
            $totaljob = $_t->{"COUNT(*)"};
        } else {
            $r = $this->query("SELECT * FROM $this->selecttable WHERE complete=? AND end_date > CURDATE() ORDER BY date DESC $limit", [0])->results();
            $_t = $this->query("SELECT COUNT(*) FROM $this->selecttable  WHERE complete=? AND end_date > CURDATE() ORDER BY date DESC ", [0])->one();
            $totaljob = $_t->{"COUNT(*)"};
        }

        return $r;
    }

    public function getJobCompleteInfo($start = 0, $end = 10, &$totaljob = 30, $all = false) {
        if ($start == 0 && $end == 0) {
            $limit = "";
        } else {
            $limit = " LIMIT " . $start . "," . ($end - $start);
        }
        if ($all) {
            $r = $this->query("SELECT * FROM $this->selecttable WHERE complete=? ORDER BY date DESC $limit", [1])->results();
            $_t = $this->query("SELECT COUNT(*) FROM $this->selecttable  WHERE complete=? ORDER BY date DESC ", [1])->one();
            $totaljob = $_t->{"COUNT(*)"};
        } else {
            $r = $this->query("SELECT * FROM $this->selecttable WHERE complete=? AND end_date > CURDATE() ORDER BY date DESC $limit", [1])->results();
            $_t = $this->query("SELECT COUNT(*) FROM $this->selecttable  WHERE complete=? AND end_date > CURDATE() ORDER BY date DESC ", [1])->one();
            $totaljob = $_t->{"COUNT(*)"};
        }
        return $r;
    }

    public function getJobInfo($jobID, $filter = " * ") {
        if ($r = $this->query("SELECT $filter FROM $this->selecttable WHERE job_id = ?", [$jobID])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function setJobTable($job_info, $show = 10, $start = 0, $end = 10, $total = 30, $message = "") {
//  dnd($product_info);
        $njob_table = new job_table($job_info);
        $njob_table->set_error_message($message);
        $njob_table_cloumb = [
            "cloumb" => [
                ["thead_title" => "#",
                    "thead_attr" => ["style" => "width:1%font-size:12px;", "class" => "v-align-middle text-center"],
                    "tbody_varible" => "checkbox",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Sipariş Numarası",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kodu"],
                    "tbody_varible" => "job_number",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Adı Soyadı",
                    "thead_attr" => ["style" => "width:15%;font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün adı"],
                    "tbody_varible" => "costumer_name",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Ürün Sayısı",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün kategorisi"],
                    "tbody_varible" => "total_product",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Toplam Ücret",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün stok sayısı"],
                    "tbody_varible" => "total_price",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Toplam İndirim",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün gönderim ücreti"],
                    "tbody_varible" => "total_discount",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Toplam Kar",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "total_profit",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Alınan Ödeme",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "total_payment",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Sipariş Zamanı",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "job_time",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Sonraki Aşama",
                    "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün indirim fiyatı"],
                    "tbody_varible" => "job_state",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
                ["thead_title" => "Eylemler",
                    "thead_attr" => ["class" => "v-align-middle text-center", "title" => "eylemler"],
                    "tbody_varible" => "actions",
                    "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
                ],
            ]
        ];

        /*
          ["thead_title" => "Toplam Maliyet",
          "thead_attr" => ["style" => "font-size:12px;", "class" => "v-align-middle text-center", "title" => "ürün fiyatı"],
          "tbody_varible" => "total_cost",
          "tbody_attr" => ["class" => "v-align-middle semi-bold text-center"],
          ], */

        $njob_table->set_table_info($njob_table_cloumb);
        $njob_table->set_show_item($show);
        $njob_table->set_start_item($start);
        $njob_table->set_end_item($end);
        $njob_table->set_total_item($total);
        $njob_table->set_table_header(FALSE);
        $njob_table->set_table_footer(true);

        return $njob_table->add_table(false);
    }

    public function getCustomerJobsInfo($customer_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE customer_id = ? ORDER BY date  DESC", [$customer_id])->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getCustomerPublicJobsInfo($customer_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE customer_id = ? AND (return_request = ? OR return    = ? )", [$customer_id, 0, 0])->results()) {
            dnd($r);
            return $r;
        } else {
            return false;
        }
    }

    public function getCustomerReturnJobsInfo($customer_id) {
        if ($r = $this->query("SELECT * FROM $this->selecttable WHERE customer_id = ? AND (return_request=? OR return = ?)", [$customer_id, 1, 1])->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getCustomerBasketJobsID($customer_id) {
        if ($r = $this->query("SELECT job_id FROM $this->selecttable WHERE customer_id = ? AND job_status = '0'", [$customer_id])->results()) {
            return $r;
        } else {
            return false;
        }
    }

    public function checkJobBasket($jobID) {
        if ($r = $this->query("SELECT job_id FROM $this->selecttable WHERE job_id=? AND job_status = ?", [$jobID, 0])->one()) {
            return $jobID;
        } else {
            return false;
        }
    }

    public function addJobCookie($jobID) {
        return cookie::set(VISITORJOB, base64_encode($jobID), REMEMBER_ME_COOKIE_EXPIRY);
    }

    public function getJobCookie() {
        if (isset($_COOKIE[VISITORJOB])) {
            $jobID = base64_decode($_COOKIE[VISITORJOB]);
            return $jobID;
        } else {
            return false;
        }
    }

    public function _addJobCookie($jobID) {

        if (isset($_COOKIE[VISITORJOB])) {
            $job_cookie = base64_decode($_COOKIE[VISITORJOB]);
            $job_cookie_ex = explode(",", $job_cookie);
            if (!in_array($jobID, $job_cookie_ex)) {
                $job_cookie_ex[] = $jobID;
            }
            return cookie::set(VISITORJOB, base64_encode(implode(",", $job_cookie_ex)), REMEMBER_ME_COOKIE_EXPIRY);
        } else {
            return cookie::set(VISITORJOB, base64_encode($jobID), 86400 * 30);
        }
    }

    public function _getJobCookie() {

        if (isset($_COOKIE[VISITORJOB])) {
            $job_cookie = base64_decode($_COOKIE[VISITORJOB]);
            $job_cookie_ex = explode(",", $job_cookie);

            return array_filter($job_cookie_ex);
        } else {
            return false;
        }
    }

    public function updateJobCustomer($jobID, $customer_id) {
        if ($r = $this->query("SELECT customer_id FROM $this->selecttable WHERE job_id = ?", [$jobID])->one()) {
            if ($r->customer_id == 0) {
                $fields = [
                    "customer_id" => $customer_id,
                ];
                //$table, $id, $fields = [], $id_table = null
                if ($this->update($jobID, $fields)) {
                    // $this->_db->update("job_products", $jobID, $fields, "job_id");
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function setJobStatus($jobID, $statu) {
        $fields = [
            "job_status" => $statu,
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş Statusu değişmedi&jobid=' . $jobID . '&payment=' . $njob::PAYMENT . '&model=jobModel&method=setJobStatus&post=' . json_encode($post));
            return false;
        }
    }

    public function addBadFile($jobID, $filenumber) {
        $fields = [
            "badfile" => $filenumber,
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function makeJobNumber($jobID) {
        $job_number = rand(1111, 9999) . "-" . rand(1111, 9999) . "-" . rand(1111, 9999) . "-" . rand(1111, 9999);
        $fields = [
            "job_number" => $job_number,
        ];
        if ($this->update($jobID, $fields)) {
            return $job_number;
        } else {
            badcode::makeBadCode('&msg=İş Numarası oluşturulmadı&jobid=' . $jobID . '&model=jobModel&method=makeJobNumber&post=' . json_encode($post));
            return false;
        }
    }

    public function checkJobConfirmPage($job_number) {
        if ($r = $this->query("SELECT job_id FROM $this->selecttable WHERE job_number = ? AND job_confirm_page= ? ", [$job_number, 0])->one()) {
            return $r->job_id;
        } else {
            return false;
        }
    }

    public function updateJobConfirmPage($jobID) {
        $fields = [
            "job_confirm_page" => 1,
            "job_confirm_page_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function confirmJob($jobID) {
        $fields = [
            "confirm" => 1,
            "confirm_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function sendCargoJob($jobID) {
        $fields = [
            "send_cargo" => 1,
            "send_cargo_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function deliveryCargoJob($jobID) {
        $fields = [
            "delivery_cargo" => 1,
            "delivery_cargo_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkJobReturnRequest($jobID) {
        if ($r = $this->query("SELECT job_id FROM $this->selecttable WHERE job_id = ? AND return_request=?", [$jobID, 0])->one()) {
            return $r->job_id;
        } else {
            return false;
        }
    }

    public function returnrequestJob($jobID, $source) {
        $fields = [
            "return_request" => 1,
            "return_request_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            //job_return

            $fields = [
                "job_id" => $jobID,
                "return_description" => input::santize($source["return_description"]),
                "broken" => isset($source["broken"]) ? 1 : 0,
                "notexpecting" => isset($source["notexpecting"]) ? 1 : 0,
                "date" => getNow(),
            ];
            if ($this->_db->insert("job_return", $fields)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function returnJob($jobID) {
        $fields = [
            "return" => 1,
            "return_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            //job_return
            return true;
        } else {
            return false;
        }
    }

    public function completeJob($jobID) {
        $fields = [
            "complete" => 1,
            "complete_date" => getNow(),
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    function removeJob($jobID) {
        $njob_product = new table_job_products();
        $jproducts = $njob_product->getJobProductList($jobID);
        if (!empty($jproducts)) {
            foreach ($jproducts as $jproduct) {
                $job_products_id = $jproduct->job_products_id;
                $njob_product->removeJobProduct($job_products_id, false);
            }
        }
        $this->_db->delete("job_payment", $jobID);
        $this->_db->delete("job_return", $jobID);
        $this->_db->delete("job_transport", $jobID);
        cookie::delete(VISITORJOB);
        $njob_event = new job_event();
        $njob_event->addJobEvent($jobID, "JobDelete");
        if ($this->delete($jobID)) {
            return true;
        } else {
            return false;
        }
    }

    const InBasket = 0;
    const requestReturn = 1;
    const requestReturnAprov = 2;
    const jobComplete = 3;
    const sendCargo = 4;
    const deliveryCargo = 5;
    const waitingDeliveryCargo = 7;
    const adminConfirm = 6;

    public function get_job_status($src) {
        $result;
        switch ($src->job_status) {
            case 0:
                $result["text"] = "Sepette";
                $result["status"] = self::InBasket;
                $result["date"] = $src->date;
                break;
            case 1:
                if ($src->return_request == 1) {
                    if ($src->return == 1) {
                        $result["text"] = 'İade İsteği Oluşturulmuş';
                        $result["status"] = self::requestReturn;
                        $result["date"] = $src->return_request_date;
                    } else {
                        $result["text"] = 'İadesi Onaylanmış';
                        $result["status"] = self::requestReturnAprov;
                        $result["date"] = $src->return_date;
                    }
                } else {
                    if ($src->confirm == 1) {
                        if ($src->send_cargo == 1) {
                            if ($src->delivery_cargo == 1) {
                                if ($src->complete == 1) {
                                    $result["text"] = 'İş Tamamlanmış';
                                    $result["status"] = self::jobComplete;
                                    $result["date"] = $src->complete_date;
                                } else {
                                    $result["text"] = 'Kargo Teslim Edilmiş';
                                    $result["status"] = self::deliveryCargo;
                                    $result["date"] = $src->delivery_cargo_date;
                                }
                            } else {
                                $result["text"] = 'Kargo Teslimi Bekleniyor';
                                $result["status"] = self::waitingDeliveryCargo;
                                $result["date"] = $src->delivery_cargo;
                            }
                        } else {
                            $result["text"] = 'Kargoda';
                            $result["status"] = self::sendCargo;
                            $result["date"] = $src->delivery_cargo;
                        }
                    } else {

                        $result["text"] = 'Onay Aşamasında';
                        $result["status"] = self::adminConfirm;
                        $result["date"] = "---";
                    }
                }
                break;
        }
        return $result;
    }

    public function get_job_return_info($jobID) {
        if ($r = $this->query("SELECT * FROM job_return WHERE job_id = ? ", [$jobID])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function addpaymentRate($jobID, $rate) {
        $fields = [
            "payment_rate" => $rate,
        ];
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Ödeme Oranı Eklenemedi&jobid=' . $jobID . '&complete_payment_price=' . $complete_payment_price . '&model=job&method=addpaymentRate&post=' . json_encode($post));
            return false;
        }
    }

    public function addJobPrice($jobID, $jobPrice) {
        $fields = [];
        $fields["job_price"] = $jobPrice["total"];
        $fields["job_price_unit"] = $jobPrice["unit"];
        if (is_array($jobPrice))
            if (array_key_exists("discount", $jobPrice)) {
                $fields["discount"] = $jobPrice["discount"];
            }

        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş İçin Fiyatı Eklenemedi&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobExtraPrice($jobID, $jobTotalExtraPrice) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        if (array_key_exists($nproduct_settings::basket, $jobTotalExtraPrice)) {
            $fields["job_extra_price"] = $jobTotalExtraPrice["extra"];
            if (array_key_exists("discount", $jobTotalExtraPrice)) {
                $fields["job_extra_price_discount"] = $jobTotalExtraPrice["discount"];
            }
        } else {
            $fields["job_extra_price"] = 0;
            $fields["job_extra_price_discount"] = 0;
        }
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İş İle ilgili extra ücretler eklenmemiş&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobCargoPrice($jobID, $jobTotalCargoPrice) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        if (array_key_exists($nproduct_settings::basket, $jobTotalCargoPrice)) {
            $fields["job_cargo_price"] = $jobTotalCargoPrice["cargo"];
            if (array_key_exists("discount", $jobTotalCargoPrice)) {
                $fields["job_cargo_price_discount"] = $jobTotalCargoPrice["discount"];
            }
        } else {
            $fields["job_cargo_price"] = 0;
            $fields["job_cargo_price_discount"] = 0;
        }

        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Kargo Ödemeleri Eklenmemiştir.&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobTaxPrice($jobID, $jobTotalTaxPrice) {

        $fields = [];
        $fields["job_tax_price"] = $jobTotalTaxPrice["tax"];
        if (array_key_exists("discount", $jobTotalTaxPrice)) {
            $fields["job_tax_price_discount"] = $jobTotalTaxPrice["discount"];
        }
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Vergilendirme Ücretleri Eklenmemiştir.&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobTotalPrice($jobID, $jobTotalPrice) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        $fields["job_total_price"] = $jobTotalPrice["total"];
        if (array_key_exists("discount", $jobTotalPrice)) {
            $fields["job_total_price_discount"] = $jobTotalPrice["discount"];
        } else {
            $fields["job_total_price_discount"] = 0;
        }
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=İçin Fiyatı Eklenemedi&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductSetting($jobID, $jsonProductSetting) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        $fields["product_settings"] = $jsonProductSetting;

        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Ürün Ayarları Eklenemedi&jobid=' . $jobID);
            return false;
        }
    }

    public function addJobProductCurrency($jobID, $jsonProductCurrency) {
        $nproduct_settings = new table_settings_product();
        $fields = [];
        $fields["product_currency"] = $jsonProductCurrency;
        if ($this->update($jobID, $fields)) {
            return true;
        } else {
            badcode::makeBadCode('&msg=Döviz Fiyatları Eklenemedi&jobid=' . $jobID);
            return false;
        }
    }

    public function getResultJobTotalPrice($jobID) {
        if ($r = $this->query("SELECT job_total_price,job_price_unit  FROM $this->selecttable WHERE job_id = ?", [$jobID])->one()) {
            return $r;
        } else {
            return false;
        }
    }

    public function getTotalCargoPriceFromJob($jobID) {
        if ($jobsInfo = $this->query("SELECT job_cargo_price,job_cargo_price_discount,product_settings FROM $this->selecttable WHERE job_id=? ", [$jobID])->one()) {
            $cargo_price = 0;
            $cargo_price_discount = 0;
            $currency = $jobsInfo->job_price_unit;
            $product_setting = json_decode($jobsInfo->product_settings);
            //dnd($product_setting);
            if ($product_setting->product_cargo_function == "basket") {
                $result["cargo"] = $jobsInfo->job_cargo_price;
                $result["discount"] = $jobsInfo->job_cargo_price_discount;
                $result["unit"] = $currency;
            } else {
                $njob_product = new table_job_products();
                $job_products = $njob_product->getJobProductList($jobID);
                foreach ($job_products as $job_product) {
                    $cargo_price = $cargo_price + $job_product->job_cargo_price;
                    $cargo_price_discount = $cargo_price_discount + $job_product->job_cargo_price_discount;
                    $result["discount"][$job_product->job_product_id] = $jobsInfo->job_cargo_price_discount;
                }
                $result["total_discount"] = $cargo_price;
                $result["cargo"] = $cargo_price;
                $result["unit"] = $currency;
            }
            return $result;
        } else {
            return false;
        }
    }

    public function getTotalExtraPriceFromJob($jobID) {
        if ($jobsInfo = $this->query("SELECT job_extra_price,job_extra_price_discount,product_settings FROM $this->selecttable WHERE job_id=? ", [$jobID])->one()) {
            $extra_price = 0;
            $extra_price_discount = 0;
            $currency = $jobsInfo->job_price_unit;
            $product_setting = json_decode($jobsInfo->product_settings);

            if ($product_setting->product_extra_function == "basket") {
                $result["extra"] = $jobsInfo->job_extra_price;
                $result["discount"] = $jobsInfo->job_extra_price_discount;
                $result["unit"] = $currency;
            } else {
                $njob_product = new table_job_products();
                $job_products = $njob_product->getJobProductList($jobID);
                foreach ($job_products as $job_product) {
                    $extra_price = $extra_price + $job_product->job_extra_price;
                    $extra_price_discount = $extra_price_discount + $job_product->job_extra_price_discount;
                    $result["discount"][$job_product->job_product_id] = $job_product->job_extra_price_discount;
                }
                $result["extra"] = $extra_price;
                $result["total_discount"] = $extra_price_discount;
                $result["unit"] = $currency;
            }
            return $result;
        } else {
            return false;
        }
    }

    public function updatePaymentMethod($jobID, $payment_method) {
        $njob_products = new table_job_products();
        if ($job_products = $njob_products->getJobProductList($jobID)) {
            foreach ($job_products as $job_product) {
                $job_product_id = $job_product->job_products_id;
                $njob_products->update_job_payment_method($job_product_id, $payment_method);
            }
            return true;
        } else {
            return false;
        }
    }

    public function isTherePaymentMethod($job_products) {
        $dt = true;
        foreach ($job_products as $job_product) {
            if ($job_product->job_payment_method == NODATA) {
                $dt = false;
            }
        }
        if ($dt) {
            return true;
        } else {
            return false;
        }
    }

    public function getJobCount($start_date = null, $end_date = null) {
        $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE date BETWEEN ? AND ? ORDER BY date DESC";
        if ($r = $this->query($sql, [$end_date, $start_date])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getJobAllCount() {
        $sql = "SELECT COUNT(*) FROM $this->selecttable ";
        if ($r = $this->query($sql, [])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getCompleteJobCount() {
        $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE  complete='1' ";
        if ($r = $this->query($sql, [])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getReturnJobCount() {
        $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE return='1' && complete='0' ";
        if ($r = $this->query($sql, [])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getInCargoJobCount() {
        $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE send_cargo='1' && complete='0' ";
        if ($r = $this->query($sql, [])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getInBasketJobCount() {
        $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE job_number='---'  ";
        if ($r = $this->query($sql, [])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getJobSalesCount($start_date = null, $end_date = null) {
        $nodata = NODATA;
        $sql = "SELECT COUNT(*) FROM $this->selecttable WHERE job_number<>? date BETWEEN ? AND ? ORDER BY date DESC";
        if ($r = $this->query($sql, [$nodata, $end_date, $start_date])->one()) {
            return $r->{"COUNT(*)"};
        } else {
            return false;
        }
    }

    public function getTotalJobPrice($start_date = null, $end_date = null) {
        $nodata = NODATA;
        $sql = "SELECT job_id as id FROM $this->selecttable WHERE job_number<>? date BETWEEN ? AND ? ORDER BY date DESC";
        if ($jobs = $this->query($sql, [$nodata, $end_date, $start_date])->results()) {
            $njob_products = new table_job_products();
            $total_price = 0;
            foreach ($jobs as $job) {
                $jpresult_info = $njob_products->getTotalJobPrice($job->id);
                $total_price = $total_price + $jpresult = $jpresult_info["total"];
            }

            $r["total"] = $total_price;
            $r["unit"] = $jpresult_info["unit"];
            return $r;
        } else {
            return false;
        }
    }

}
