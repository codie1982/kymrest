<?php

if (MAINTENANCE) {
    if (cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
        $ncustomer = new table_customer();
        $ncustomer->loginUserFromCookie();
        $nadmin_user = new table_admin_user();
        if ($nadmin_user->check_admin_user(session::get(CURRENT_USER_SESSION_NAME))) {
            
        } else {
            die("Site Bakımda. Çok Yakında Tekrar Görüşmek Üzere");
        }
    } else {
        die("Site Bakımda. Çok Yakında Tekrar Görüşmek Üzere");
    }
}