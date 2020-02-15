<?php

$ncustomer = new table_customer();

$customer_id = 0;
//Session açık ise bir işlem yapmaya gerek yok



if (session::exists(CURRENT_USER_SESSION_NAME)) {
    $customer_id = session::get(CURRENT_USER_SESSION_NAME);
} else {
    //Session açık değil ise çerez kontrol edilir
    if (cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
        //çerez var ise çerezden id numarası alınır ve auto giriş yapılır
        $customer_id = cookie::get(REMEMBER_ME_COOKIE_NAME);
        session::set(CURRENT_USER_SESSION_NAME, $customer_id);
    } else {

        if (!cookie::exists(VISITORID)) {
            $customer_ip = get_ipno();
            $ncustomer->add_filter("customer_id");
            $ncustomer->select();
            $ncustomer->add_condition("visitor_ip", $customer_ip);
            $ncustomer->add_limit_start(1);
            $ncustomer->add_direction("DESC");
            //kullanıcının ip numarasına göre ;
            if (!$customer_info = $ncustomer->get_alldata(true)) {
                $nvisitor_module = new visitor_module();
                $customer_id = visitor_module::new_visitor(get_ipno());
                cookie::set(VISITORID, $customer_id, VISITOR_COOKIE_EXPIRY);
            } else {
                cookie::set(VISITORID, $customer_info->customer_id, VISITOR_COOKIE_EXPIRY);
            }
            //eğer çerez yok ise kullanıcı customer tablosuna kayıt edilirce geçici bir id ataması yapılır;
            //eğer ip numarası sistemde kayıtlı gözüküyorsa bu kullanıcının kayıtlı olup olmadığı kontrolü yapılır.
            //ve kullanıcının sisteme girişi beklenir.
        } else {
              
        }
    }
}