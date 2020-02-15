<?php

header('Content-Type: application/json');
//if (isset($_SERVER['HTTP_ORIGIN'])) {
//    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');
//}
//header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
/* To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_category
 *
 * @author engin
 */
class apiauth {

    public function __construct() {
        return true;
    }

    public function userloginAction() {

        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        // $data["postdata"] = $postdata;
                        $user_email = $postdata->user_email;
                        $user_password = $postdata->user_password;
                        if ($user_email != "") {
                            if ($user_password != "") {
                                if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                                    $ncustomer_account = new table_customer_siteaccount();
                                    $ncustomer_account->select();
                                    $ncustomer_account->add_condition("customer_email", $user_email);
                                    if ($customer_account_info = $ncustomer_account->get_alldata(true)) {


                                        $customer_id = $customer_account_info->customer_id;
                                        if (password_verify($user_password, $customer_account_info->password)) {

                                            data::add_post_data("login_info_fields", "customer_id", $customer_id);
                                            data::add_post_data("login_info_fields", "date", getNow());
                                            $nprp = new prepare_login_data();
                                            $control_module = $nprp->set_login_data(data::get_postdata());
                                            $login_data = data::get_data($control_module);
                                            data::insert_data("login_info", $login_data["login_info"]);

                                            $ncustomer = new table_customer();
                                            $ncustomer->select();
                                            $ncustomer->add_condition("customer_id", $customer_id);
                                            $ncustomer->add_condition("public", 1);
                                            if ($customer_info = $ncustomer->get_alldata(true)) {
                                                if ($customer_info->type == "personel") {
                                                    $ncustomer_personel = new table_customer_personel();
                                                    $ncustomer_personel->select();
                                                    $ncustomer_personel->add_condition("customer_id", $customer_id);

                                                    if ($customer_personel_data = $ncustomer_personel->get_alldata(true)) {
                                                        //Kullanıcı Etiketleri
                                                        $ncustomer_tag = new table_customer_tag();
                                                        $ncustomer_tag->select();
                                                        $ncustomer_tag->add_condition("customer_id", $customer_id);
                                                        $ncustomer_tag->add_condition("public", 1);
                                                        $customer_tags = [];
                                                        if ($tags = $ncustomer_tag->get_alldata()) {
                                                            foreach ($tags as $tag) {
                                                                $customer_tags[] = ["tag" => $tag->tag];
                                                            }
                                                        }
                                                        //Kullanıcı Adresi
                                                        $ncustomer_adres = new table_customer_adres();
                                                        $ncustomer_adres->select();
                                                        $ncustomer_adres->add_condition("customer_id", $customer_id);
                                                        $ncustomer_adres->add_condition("public", 1);
                                                        $customer_adres = [];
                                                        if ($adress = $ncustomer_adres->get_alldata()) {
                                                            if (!empty($adress))
                                                                foreach ($adress as $adres) {

                                                                    $nadres = new table_adres();
                                                                    $province = $nadres->getprovince($adres->province);
                                                                    $district = $nadres->getdistrict($adres->province, $adres->district);
                                                                    $neighborhood = $nadres->getneighborhood($adres->neighborhood);

                                                                    $customer_adres[] = [
                                                                        "adres_title" => $adres->adres_title,
                                                                        "adres_id" => [
                                                                            "province_id" => $adres->province,
                                                                            "district_id" => $adres->adres_title,
                                                                            "neighborhood_id" => $adres->adres_title,
                                                                        ],
                                                                        "adres_text" => [
                                                                            "province" => $province,
                                                                            "district" => $district,
                                                                            "neighborhood" => $neighborhood,
                                                                        ],
                                                                        "street" => $adres->street,
                                                                        "mail_code" => $adres->mail_code,
                                                                        "description" => $adres->description,
                                                                        "delivery_adres" => $adres->delivery_adres,
                                                                        "shipping_adres" => $adres->shipping_adres,
                                                                        "confirm" => $adres->confirm,
                                                                    ];
                                                                }
                                                        }
                                                        //Kullanıcı Telefon Numaraları
                                                        $ncustomer_phone = new table_customer_phone();
                                                        $ncustomer_phone->select();
                                                        $ncustomer_phone->add_condition("customer_id", $customer_id);
                                                        $ncustomer_phone->add_condition("public", 1);
                                                        $customer_phone = [];
                                                        if ($phones = $ncustomer_phone->get_alldata()) {
                                                            if (!empty($phones))
                                                                foreach ($phones as $phone) {
                                                                    $customer_phone[] = [
                                                                        "phone_type" => $phone->phone_type,
                                                                        "area_code" => $phone->area_code,
                                                                        "phone_number" => $phone->phone_number,
                                                                        "confirm" => $phone->confirm,
                                                                    ];
                                                                }
                                                        }

                                                        //Kullanıcı Kredi Kartları
                                                        $ncustomer_credi_card = new table_customer_credi_card();
                                                        $ncustomer_credi_card->select();
                                                        $ncustomer_credi_card->add_condition("customer_id", $customer_id);
                                                        $ncustomer_credi_card->add_condition("public", 1);
                                                        $customer_credi_card = [];
                                                        if ($cards = $ncustomer_credi_card->get_alldata()) {
                                                            if (!empty($cards))
                                                                foreach ($cards as $card) {
                                                                    $customer_credi_card[] = [
                                                                        "credi_card_number" => $card->credi_card_number,
                                                                        "month" => $card->month,
                                                                        "year" => $card->year,
                                                                        "card_security_number" => $card->card_security_number,
                                                                    ];
                                                                }
                                                        }

                                                        //Kullanıcı mail Adresleri
                                                        $ncustomer_mail = new table_customer_mail();
                                                        $ncustomer_mail->select();
                                                        $ncustomer_mail->add_condition("customer_id", $customer_id);
                                                        $customer_mail = [];
                                                        if ($mails = $ncustomer_mail->get_alldata()) {
                                                            if (!empty($mails))
                                                                foreach ($mails as $mail) {
                                                                    $customer_mail[] = [
                                                                        "customer_mail" => $mail->customer_mail,
                                                                        "confirm" => $mail->confirm,
                                                                    ];
                                                                }
                                                        }



                                                        $data["customer_info"] = [
                                                            "customer_id" => $customer_id,
                                                            "customer_email" => $user_email,
                                                            "customer_name" => $customer_personel_data->name,
                                                            "customer_lastname" => $customer_personel_data->lastname,
                                                            "customer_gender" => $customer_personel_data->gender,
                                                            "customer_birth_day" => $customer_personel_data->birth_day,
                                                            "customer_birth_month" => $customer_personel_data->birth_month,
                                                            "customer_birth_year" => $customer_personel_data->birth_year,
                                                            "customer_profession" => $customer_personel_data->profession,
                                                            "customer_professional_duty" => $customer_personel_data->professional_duty,
                                                            "customer_idnumber" => $customer_personel_data->idnumber,
                                                            "public" => $customer_info->public,
                                                            "sales" => $customer_info->sales,
                                                            "customer_tag" => $customer_tags,
                                                            "customer_adress" => $customer_adres,
                                                            "customer_phones" => $customer_phone,
                                                            "customer_credi_card" => $customer_credi_card,
                                                            "customer_mail" => $customer_mail,
                                                        ];
                                                        $data["type"] = "SUCCESS_LOGIN";
                                                        $data["message"] = "Giriş Başarılı.";
                                                    } else {
                                                        $data["type"] = "NO_PERSONEL_INFO";
                                                        $data["error"] = true;
                                                        $data["message"] = "Kişisel verilerilerinizi ulaşamıyoruz. Lütfen hesabınızı yeniden düzenlemeyi deneyiniz.";
                                                    }
                                                } else {
                                                    $data["type"] = "NO_COMPANY";
                                                    $data["error"] = true;
                                                    $data["message"] = "Bu Alandan Firma hesabi ile giriş yapamazsınız.Kişisel hesabınız ile kayıt olmayı ve giriş yapmayı deneyiniz.";
                                                }
                                            } else {
                                                $data["type"] = "NO_RECORD";
                                                $data["error"] = true;
                                                $data["message"] = "Mail adresiniz ve şifreniz sistem ile uyuşmakta ancak kullanıcı bilgilerinize ulaşamıyoruz.Bu hata için sistem yöneticisi ile acilen temasa geçmenizi öneriyoruz.";
                                            }
                                        } else {
                                            $data["type"] = "WRONG_PASSWORD";
                                            $data["error"] = true;
                                            $data["message"] = "Şifreniz Doğru değil.";
                                        }
                                    } else {
                                        $data["type"] = "WRONG_EMAIL";
                                        $data["error"] = true;
                                        $data["message"] = "Bu mail adresi sisteme kayıtlı değil.";
                                    }
                                } else {
                                    $data["type"] = "INVALID_EMAIL";
                                    $data["error"] = true;
                                    $data["message"] = "Doğru bir email adresi girmeye çalışın";
                                }
                            } else {
                                $data["type"] = "NO_PASSWORD";
                                $data["error"] = true;
                                $data["message"] = "Şifre Alanınızı Boş Bırakmayınız";
                            }
                        } else {
                            $data["type"] = "NO_EMAIL";
                            $data["error"] = true;
                            $data["message"] = "Email adresinizi Boş Bırakmayınız";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $data[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $data[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

    public function userregisterAction() {
        if (!data::GET_APIERROR()) {
            if (!empty(data::ISSET_POSTDATA())) {
                $getdata = data::GET_GETDATA();
                $postdata = data::GETPOSTDATA();
                if (isset($getdata[0])) {
                    if (isset($getdata[1])) {
                        //$data["postdata"] = $postdata;
                        $user_email = $postdata->user_email;
                        $user_password = $postdata->user_password;
                        $user_repassword = $postdata->user_repassword;
                        $user_name = $postdata->user_name;
                        $user_lastname = $postdata->user_lastname;
                        $privacy_policy = $postdata->privacy_policy;
                        $advertisement = $postdata->advertisement;
                        if ($user_email != "") {
                            if ($user_password != "") {
                                if ($user_repassword == $user_password) {
                                    if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {

                                        //geçerli bir mail adresi olup olmadığınıda kontrol edilmesi gerekiyor.
                                        $ncustomer_siteaccount = new table_customer_siteaccount();
                                        $ncustomer_siteaccount->add_filter("customer_id");
                                        $ncustomer_siteaccount->select();
                                        $ncustomer_siteaccount->add_condition("customer_email", $user_email);
                                        $customer_data = $ncustomer_siteaccount->get_alldata(true);
                                        if (!$customer_data = $ncustomer_siteaccount->get_alldata(true)) {

                                            $nvisitor_module = new visitor_module();
                                            if ($customer_id = $nvisitor_module->new_visitor(get_ipno())) {
                                                //Post Datasını Oluşuturuyoruz

                                                data::add_post_data("customer_siteaccount_fields", "customer_id", $customer_id);
                                                data::add_post_data("customer_siteaccount_fields", "customer_email", $user_email);
                                                data::add_post_data("customer_siteaccount_fields", "password", $user_password);
                                                data::add_post_data("customer_siteaccount_fields", "re_password", 0);
                                                data::add_post_data("customer_siteaccount_fields", "re_password_code", rand(99999, 9999999));
                                                data::add_post_data("customer_siteaccount_fields", "customer_seccode", seccode());
                                                data::add_post_data("customer_siteaccount_fields", "date", getNow());
                                                data::add_post_data("customer_siteaccount_fields", "users_id", $customer_id);
                                                $rawdata = data::get_postdata();
                                                $nprepare = new prepare_admin_login();
                                                $control_module = $nprepare->user_register_data($rawdata);
                                                $siteaccount_data = data::get_data($control_module);
                                                //"$siteaccount_data" 'yı DB Kayıt ediliyor
                                                //dnd($siteaccount_data);

                                                if ($customer_siteaccount_id = data::insert_data("customer_siteaccount",
                                                                $siteaccount_data["customer_siteaccount"])) {

                                                    //data::remove_data($control_module, "customer_siteaccount");
                                                    //İlk Kayıt esnasında "automatic"  olan kullanıcı kaydı personel olarak
                                                    // ve Kullanım Koşulları ve Reklam verme Koşulları bilgilerini değiştiriliyor
                                                    data::update_data("customer", [
                                                        "type" => "personel",
                                                        "contract" => $privacy_policy,
                                                        "contract_date" => getNow(),
                                                        "advertisement" => $advertisement,
                                                        "advertisement_date" => getNow(),
                                                        "users_id" => $customer_id,
                                                            ], "customer_id", $customer_id);



                                                    //Personel olarak da kayıt etmemiz gerekmektedir
                                                    data::add_post_data("customer_personal_fields", "customer_id", $customer_id);
                                                    data::add_post_data("customer_personal_fields", "name", $user_name);
                                                    data::add_post_data("customer_personal_fields", "lastname", $user_lastname);
                                                    data::add_post_data("customer_personal_fields", "users_id", $customer_id);
                                                    $rawdata = data::get_postdata();
                                                    $nprp = new prepare_customer_data();
                                                    $control_module = $nprp->set_personel_data($rawdata);
                                                    $personel_data = data::get_data($control_module);

                                                    //"$personel_data" 'yı DB Kayıt ediliyor
                                                    //
                                                    if (!$customer_personel_id = data::insert_data("customer_personel", $personel_data["customer_personel"])) {
                                                        $data["type"] = "NO_PERSONEL";
                                                        $data["error"] = true;
                                                        $data["message"] = "Kişisel Verileriniz Kayıt Edilmedi";
                                                    }
//                                                //Mail Bilgisini Kullanıcı mail tablosuna kayıt ediyoruz
                                                    data::add_post_data("customer_mail_fields", "customer_id", $customer_id, 1);
                                                    data::add_post_data("customer_mail_fields", "customer_mail", $user_email, 1);
                                                    data::add_post_data("customer_mail_fields", "customer_mail_date", getNow(), 1);
                                                    data::add_post_data("customer_mail_fields", "confirm_code", md5(time() . uniqid()), 1);
                                                    data::add_post_data("customer_mail_fields", "users_id", $customer_id, 1);
                                                    $rawdata = data::get_postdata();
                                                    $nprp = new prepare_admin_register();
                                                    $control_module = $nprp->user_mail_data($rawdata);
                                                    $mail_data = data::get_data($control_module);
                                                    //dnd($mail_data);
                                                    if ($customer_mail_id = data::insert_data("customer_mail", $mail_data["customer_mail"])) {
                                                        $nsend_mail = new sendmail();
                                                        $nsend_mail->set_send_email($user_email);
                                                        $nsend_mail->set_send_username($user_name . " " . $user_lastname);
                                                        $nsend_mail->set_mail_controller("mail_confirm");
                                                        $nsend_mail->set_mail_parameters($customer_mail_id[0]);
                                                        $nsend_mail->set_mail_subject("Mail Onayı");
                                                        if ($nsend_mail->send_mail()) {


                                                            $data["customer_info"] = [
                                                                "customer_id" => $customer_id,
                                                                "customer_email" => $user_email,
                                                                "customer_name" => $user_name,
                                                                "customer_lastname" => $user_lastname,
                                                                "customer_mail" => [
                                                                    "customer_mail" => $user_email,
                                                                    "confirm" => 0,
                                                                ]
                                                            ];


                                                            $data["type"] = "SUCCESS_REGISTER";
                                                            $data["message"] = "Kayıt İşlemi Başarılı";
                                                        } else {
                                                            $data["type"] = "NO_EMAIL_CONFIRM_MAIL";
                                                            $data["error"] = true;
                                                            $data["message"] = "Onay Mailiniz Gönderilemedi. Sistem Yöneticisi ile bağlantı kurun";
                                                        }
                                                    } else {
                                                        $data["type"] = "NO_EMAIL_DATA";
                                                        $data["error"] = true;
                                                        $data["message"] = "Mail Bilgileriniz Kayıt edilmedi";
                                                    }
                                                } else {
                                                    $data["type"] = "NO_DATABASE";
                                                    $data["error"] = true;
                                                    $data["message"] = "Kayıtları Database Girilemedi";
                                                }
                                            } else {
                                                $data["type"] = "NO_VISITOR_DATA";
                                                $data["error"] = true;
                                                $data["message"] = "customer_visitor_kaydı yapılamadı";
                                            }

                                            $data["site_account_data"] = $siteaccount_data;
                                        } else {
                                            $data["type"] = "COPY_EMAIL";
                                            $data["error"] = true;
                                            $data["message"] = "Bu Mail Adresi daha önce kayıt edilmiş. Başka bir mail adresi seçmeye çalışın";
                                        }
                                    } else {
                                        $data["type"] = "INVALID_EMAIL";
                                        $data["error"] = true;
                                        $data["message"] = "Doğru bir email adresi girmeye çalışın";
                                    }
                                } else {
                                    $data["type"] = "NO_PASSWORD_MATCH";
                                    $data["error"] = true;
                                    $data["message"] = "Şifreleriniz birbiriyle eşleşmiyor";
                                }
                            } else {
                                $data["type"] = "NO_PASSWORD";
                                $data["error"] = true;
                                $data["message"] = "Şifre Alanınızı Boş Bırakmayınız";
                            }
                        } else {
                            $data["type"] = "NO_EMAIL";
                            $data["error"] = true;
                            $data["message"] = "Email adresinizi Boş Bırakmayınız";
                        }
                    } else {
                        $data["type"] = "NO_ACTION";
                        $data["error"] = true;
                        $data["message"] = $data[1] . " - " . " Fonksiyon Mehhoduna Ulaşılamıyor";
                    }
                } else {
                    $data["type"] = "NO_CONTROLLER";
                    $data["error"] = true;
                    $data["message"] = $data[0] . " - " . " Class Dosyasına Ulaşılamıyor";
                }
            }
        } else {
            $data["type"] = "NO_APIKEY";
            $data["error"] = true;
            $data["message"] = "Aplikasyon Güvenlik Numarası Geçersiz";
        }
        echo json_encode($data);
    }

 

}
