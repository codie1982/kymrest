<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setdb
 *
 * @author engin
 */
class setdb {

    function __construct() {
        return true;
    }

    static function setconfigfile($data) {
//        $module_path = ROOT . DS . 'module.json';
//        $modulefile = file_get_contents($module_path);
//        $config_data = json_decode($modulefile);
//        $config_data->envormient->database->$data;
//        file_put_contents($module_path, $config_data);
//        fwrite($fp, json_encode($data));
//        fclose($fp);
        return true;
    }

    static function createdbtables() {
        require_once(ROOT . DS . 'core' . DS . 'db' . '.php');
        $ndb = new db();

        $sq = "SET GLOBAL time_zone = 'Europe/Istanbul';";
        $ndb->query($sql, []);
        $sq = "SET GLOBAL time_zone = 'Europe/Istanbul';";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `admin_user` (
        `admin_user_id` int(11) NOT NULL AUTO_INCREMENT,
        `customer_id` int(11) NOT NULL DEFAULT '0',
        `public` int(11) NOT NULL DEFAULT '1',
        `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        `admin_seccode` varchar(45) NOT NULL DEFAULT ' ---',
        PRIMARY KEY (`admin_user_id`)
        ) ENGINE = MyISAM DEFAULT CHARSET = utf8  AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `adres` (
                `adres_id` int(11) NOT NULL AUTO_INCREMENT,
                `AAulkKodu` varchar(25) NOT NULL,
                `AAilNo` int(11) NOT NULL,
                `AAilceNo` int(11) NOT NULL,
                `AASmtBckNo` int(11) NOT NULL,
                `AAmhlKoyNo` int(11) NOT NULL,
                `AAmhlKoyAdi` varchar(45) NOT NULL,
                `AApostakodu` varchar(45) NOT NULL,
                `AASmtBckAdi` varchar(45) NOT NULL,
                `AAilceAdi` varchar(45) NOT NULL,
                `AAilAdi` varchar(45) NOT NULL,
                PRIMARY KEY (`adres_id`)
              ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `category` (
      `category_id` int(11) NOT NULL AUTO_INCREMENT,
      `parent_category_id` int(11) NOT NULL DEFAULT '0',
      `category_name` varchar(70) NOT NULL DEFAULT '---',
      `category_name_sef` varchar(70) NOT NULL DEFAULT '---',
      `category_description` varchar(455) NOT NULL DEFAULT '---',
      `category_keywords` varchar(255) NOT NULL DEFAULT '---',
      `special_fileds` varchar(455) NOT NULL DEFAULT '---',
      `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `category_seccode` varchar(45) NOT NULL DEFAULT '---',
      `sort_category` int(11) NOT NULL DEFAULT '0',
      `public` int(11) NOT NULL DEFAULT '1',
      `users_id` int(11) NOT NULL DEFAULT '0',
      PRIMARY KEY (`category_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `category_gallery` (
  `category_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_type` varchar(11) NOT NULL DEFAULT 'standart',
  `category_id` int(45) NOT NULL DEFAULT '0',
  `image_gallery_id` varchar(45) NOT NULL DEFAULT '---',
  `thumbnail` varchar(455) NOT NULL DEFAULT '---',
  `label` varchar(45) NOT NULL DEFAULT '---',
  `redirect` varchar(455) NOT NULL DEFAULT '---',
  `main_image` int(11) NOT NULL DEFAULT '0',
  `image_line` int(11) NOT NULL DEFAULT '0',
  `slider_image` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";


        $ndb->query($sql, []);
        $sql = "CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '---',
  `lastname` varchar(240) NOT NULL DEFAULT '---',
  `name_sef` varchar(255) NOT NULL DEFAULT '---',
  `email` varchar(255) NOT NULL DEFAULT '---',
  `email_cofirm` int(11) NOT NULL DEFAULT '1',
  `email_cofirm_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `password` varchar(455) NOT NULL DEFAULT '---',
  `repassword` int(11) NOT NULL DEFAULT '0',
  `repassword_code` varchar(455) NOT NULL DEFAULT '---',
  `gender` int(11) NOT NULL DEFAULT '1',
  `birthdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(45) NOT NULL DEFAULT '---',
  `customer_idnumber` varchar(455) NOT NULL DEFAULT '---',
  `customer_company_title` varchar(455) NOT NULL DEFAULT '---',
  `customer_company_tax_province` int(11) NOT NULL DEFAULT '0',
  `customer_company_tax_office` int(11) NOT NULL DEFAULT '0',
  `customer_company_tax_number` varchar(255) NOT NULL DEFAULT '---',
  `description` text NOT NULL,
  `customer_type` varchar(45) NOT NULL DEFAULT 'manuel',
  `visitor_id` int(11) NOT NULL DEFAULT '0',
  `visitor_ip` varchar(255) NOT NULL DEFAULT '---',
  `visitor_referer` varchar(255) NOT NULL DEFAULT '---',
  `visitor_uagent` varchar(255) NOT NULL DEFAULT '---',
  `customer_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` int(11) NOT NULL DEFAULT '0',
  `sales` int(11) NOT NULL DEFAULT '1',
  `customer_seccode` varchar(255) NOT NULL DEFAULT '---',
  `customer_code` varchar(45) NOT NULL DEFAULT '---',
  `contract` int(11) NOT NULL DEFAULT '0',
  `contract_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `advertisement` int(11) NOT NULL DEFAULT '0',
  `advertisement_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);


        $ndb->query($sql, []);
        $sql = "CREATE TABLE IF NOT EXISTS `customer_adres` (
  `customer_adres_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `adres_title` varchar(45) NOT NULL DEFAULT '---',
  `province` int(11) NOT NULL DEFAULT '0',
  `district` int(11) NOT NULL DEFAULT '0',
  `neighborhood` int(11) NOT NULL DEFAULT '0',
  `description` varchar(455) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` int(11) NOT NULL DEFAULT '1',
  `confirm` int(11) NOT NULL DEFAULT '1',
  `adres_seccode` varchar(255) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_adres_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0; ";
        $ndb->query($sql, []);

        $ndb->query($sql, []);
        $sql = "CREATE TABLE IF NOT EXISTS `customer_credi_card` (
  `customer_credi_card_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `credi_card_number` varchar(45) NOT NULL DEFAULT '---',
  `month` int(11) NOT NULL DEFAULT '0',
  `year` int(11) NOT NULL DEFAULT '0',
  `card_security_number` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `credi_card_seccode` varchar(255) NOT NULL DEFAULT '---',
  `public` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_credi_card_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `customer_login` (
  `customer_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL DEFAULT '0',
  `customer_location_region` varchar(255) NOT NULL DEFAULT '---',
  `customer_location_country` varchar(255) NOT NULL DEFAULT '---',
  `customer_location_continent` varchar(255) NOT NULL DEFAULT '---',
  `ipType` varchar(255) NOT NULL DEFAULT '---',
  `isp` varchar(255) NOT NULL DEFAULT '---',
  `user_ip` varchar(255) NOT NULL DEFAULT '---',
  `customer_location_lat` varchar(255) NOT NULL DEFAULT '---',
  `customer_location_lon` varchar(255) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_login_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `customer_mail` (
  `customer_mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_mail` varchar(45) NOT NULL DEFAULT '---',
  `customer_mail_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_mail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `customer_page` (
  `customer_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `page` varchar(1024) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `customer_phone` (
  `customer_phone_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(255) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `phone_seccode` varchar(255) NOT NULL DEFAULT '---',
  `public` int(11) NOT NULL DEFAULT '1',
  `confirm` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_phone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `customer_wrong_password` (
  `customer_worng_password_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customer_email` varchar(255) NOT NULL DEFAULT '---',
  `customer_password` varchar(255) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_worng_password_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `image_gallery` (
  `image_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_type` varchar(45) NOT NULL DEFAULT '',
  `image_name` varchar(255) NOT NULL DEFAULT '---',
  `file` varchar(455) NOT NULL DEFAULT '---',
  `image_uniqid` varchar(255) NOT NULL DEFAULT '---',
  `image_folder` varchar(455) NOT NULL DEFAULT '---',
  `first_image_name` varchar(455) NOT NULL DEFAULT '---',
  `extention` varchar(455) NOT NULL DEFAULT '---',
  `gallery_seccode` varchar(255) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `job` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_seccode` varchar(255) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_status` int(11) NOT NULL DEFAULT '0',
  `public` int(11) NOT NULL DEFAULT '1',
  `admin_public` int(11) NOT NULL DEFAULT '1',
  `confirm` int(11) NOT NULL DEFAULT '0',
  `confirm_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `complete` int(11) NOT NULL DEFAULT '0',
  `complete_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_price` double NOT NULL DEFAULT '0',
  `job_price_unit` varchar(45) NOT NULL DEFAULT '---',
  `job_price_discount` double NOT NULL DEFAULT '0',
  `job_extra_price` double NOT NULL DEFAULT '0',
  `job_extra_price_discount` double NOT NULL DEFAULT '0',
  `job_cargo_price` double NOT NULL DEFAULT '0',
  `job_cargo_price_discount` double NOT NULL DEFAULT '0',
  `job_tax_price` double NOT NULL DEFAULT '0',
  `job_tax_price_discount` double NOT NULL DEFAULT '0',
  `job_total_price` double NOT NULL DEFAULT '0',
  `job_total_price_discount` double NOT NULL DEFAULT '0',
  `product_settings` text NOT NULL,
  `product_currency` text NOT NULL,
  `return_request` int(11) NOT NULL DEFAULT '0',
  `return_request_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `return` int(11) NOT NULL DEFAULT '0',
  `return_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `send_cargo` int(11) NOT NULL DEFAULT '0',
  `send_cargo_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delivery_cargo` int(11) NOT NULL DEFAULT '0',
  `delivery_cargo_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_received` int(11) NOT NULL DEFAULT '0',
  `payment_received_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_number` varchar(255) NOT NULL DEFAULT '---',
  `job_confirm_page` int(11) NOT NULL DEFAULT '0',
  `job_confirm_page_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_rate` double NOT NULL DEFAULT '0',
  `badfile` varchar(455) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `job_event` (
  `job_event_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL DEFAULT '0',
  `event` varchar(255) NOT NULL DEFAULT '---',
  `event_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_seccode` varchar(255) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`job_event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `job_payment` (
  `job_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL DEFAULT '0',
  `payment` double NOT NULL DEFAULT '0',
  `payment_unit` varchar(11) NOT NULL DEFAULT '---',
  `payment_method` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`job_payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `job_products` (
  `job_products_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_type` varchar(45) NOT NULL DEFAULT 'standart',
  `poster_width` int(11) NOT NULL DEFAULT '0',
  `poster_height` int(11) NOT NULL DEFAULT '0',
  `poster_crop_data` varchar(455) NOT NULL DEFAULT '---',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `product_amount` int(11) NOT NULL DEFAULT '0',
  `job_price_type` varchar(11) NOT NULL DEFAULT 'flat',
  `job_price_option_id` int(11) NOT NULL DEFAULT '0',
  `job_price` double NOT NULL DEFAULT '0',
  `job_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `job_extra_price` double NOT NULL DEFAULT '0',
  `job_extra_price_discount` double NOT NULL DEFAULT '0',
  `job_cargo_price` double NOT NULL DEFAULT '0',
  `job_cargo_price_discount` double NOT NULL DEFAULT '0',
  `job_tax_price` double NOT NULL DEFAULT '0',
  `job_tax_price_discount` double NOT NULL DEFAULT '0',
  `job_price_general_total` double NOT NULL DEFAULT '0',
  `job_price_general_total_discount` double NOT NULL DEFAULT '0',
  `discount` varchar(11) NOT NULL DEFAULT 'rate',
  `discount_amount` int(11) NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `payment_rate` int(11) NOT NULL DEFAULT '0',
  `job_payment_method` varchar(11) NOT NULL DEFAULT '---',
  `public` int(11) NOT NULL DEFAULT '1',
  `admin_public` int(11) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_products_seccode` varchar(255) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`job_products_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `job_return` (
  `job_return_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL DEFAULT '0',
  `return_description` varchar(255) NOT NULL DEFAULT '---',
  `broken` int(11) NOT NULL DEFAULT '0',
  `notexpecting` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`job_return_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `job_transport` (
  `job_transport_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL DEFAULT '0',
  `costumer_adres_id` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `job_transport_seccode` varchar(255) NOT NULL DEFAULT '---',
  `public` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`job_transport_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `middelslider_gallery` (
  `middelslider_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_gallery_id` int(11) NOT NULL DEFAULT '0',
  `text` varchar(255) NOT NULL DEFAULT '---',
  `main_image` int(11) NOT NULL DEFAULT '0',
  `slider_image` int(11) NOT NULL DEFAULT '1',
  `target_url` varchar(455) NOT NULL DEFAULT '---',
  `line` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`middelslider_gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL DEFAULT '---',
  `product_name_sef` varchar(455) NOT NULL DEFAULT '---',
  `product_sub_name` varchar(255) NOT NULL DEFAULT '---',
  `product_category` varchar(455) NOT NULL,
  `special_fields_value` varchar(255) NOT NULL DEFAULT '---',
  `product_code` varchar(255) NOT NULL DEFAULT '---',
  `product_cost` double NOT NULL DEFAULT '0',
  `product_cost_unit` varchar(11) NOT NULL DEFAULT '---',
  `product_flat_price_productunit` varchar(45) NOT NULL DEFAULT '---',
  `product_price_type` varchar(255) NOT NULL DEFAULT 'flat',
  `product_price` double NOT NULL DEFAULT '0',
  `product_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `product_discount_type` varchar(11) NOT NULL DEFAULT '---',
  `product_discount_price` double NOT NULL DEFAULT '0',
  `product_tax_zone` varchar(11) NOT NULL DEFAULT '---',
  `product_intax` int(11) NOT NULL DEFAULT '0',
  `product_transport_type` varchar(45) NOT NULL DEFAULT '---',
  `product_transport_price` double NOT NULL DEFAULT '0',
  `product_transport_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `product_intransport` int(11) NOT NULL DEFAULT '0',
  `product_delivey_time` varchar(11) NOT NULL DEFAULT '0',
  `product_nostock` int(11) NOT NULL DEFAULT '0',
  `product_stock` int(11) NOT NULL DEFAULT '0',
  `payment_method` varchar(45) NOT NULL DEFAULT '---',
  `product_type` varchar(11) NOT NULL DEFAULT 'standart',
  `product_description` text NOT NULL,
  `product_keywords` varchar(455) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` int(11) NOT NULL DEFAULT '1',
  `product_seccode` varchar(45) NOT NULL DEFAULT '---',
  `main_page` int(11) NOT NULL DEFAULT '0',
  `main_page_line` int(11) NOT NULL DEFAULT '0',
  `main_page_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `product_category` (
            `product_category_id` int(11) NOT NULL AUTO_INCREMENT,
            `category_id` int(11) NOT NULL DEFAULT '0',
            `product_id` int(11) NOT NULL,
            `users_id` int(11) NOT NULL,
            PRIMARY KEY (`product_category_id`)
          ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `product_currency` (
  `product_currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` int(11) NOT NULL DEFAULT '1',
  `product_currency_type` varchar(25) NOT NULL DEFAULT '---',
  `product_currency_price` double NOT NULL DEFAULT '0',
  `product_currency_seccode` varchar(255) NOT NULL DEFAULT '---',
  `last_upgrade_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`product_currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "INSERT INTO `product_currency` (`product_currency_id`, `key`, `product_currency_type`, `product_currency_price`, `product_currency_seccode`, `last_upgrade_date`) VALUES(8, 1, 'dl', 6.05, 'WPH5cfe53f5313ae', '2019-06-10 12:58:29'),(7, 1, 'tl', 1, 'CFM5cfe53f530aaf', '2019-06-10 12:58:29'),(9, 1, 'eu', 6.75, 'TVF5cfe53f531a38', '2019-06-10 12:58:29')";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `product_gallery` (
  `product_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `image_gallery_id` int(11) NOT NULL DEFAULT '0',
  `template` varchar(11) NOT NULL DEFAULT '---',
  `first_image` int(11) NOT NULL DEFAULT '0',
  `image_line` int(11) NOT NULL DEFAULT '0',
  `margin_left` varchar(11) NOT NULL DEFAULT '---',
  `margin_top` varchar(11) NOT NULL DEFAULT '---',
  `width` varchar(11) NOT NULL DEFAULT '---',
  `height` varchar(11) NOT NULL DEFAULT '---',
  `set_image` int(11) NOT NULL DEFAULT '0',
  `product_gallery_seccode` varchar(45) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `product_payment_method` (
  `product_payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `payment_method` varchar(45) NOT NULL DEFAULT '---',
  `payment_method_extra_price` double NOT NULL DEFAULT '0',
  `extra_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `product_payment_method_seccode` varchar(45) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_payment_method_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `product_price_option` (
  `product_price_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `product_price` double NOT NULL DEFAULT '0',
  `product_price_unit` varchar(45) NOT NULL DEFAULT '---',
  `product_price_title` varchar(255) NOT NULL DEFAULT '---',
  `activePrice` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` int(11) NOT NULL DEFAULT '1',
  `admin_public` int(11) NOT NULL DEFAULT '1',
  `product_price_option_seccode` varchar(45) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_price_option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `product_raiting` (
  `product_raiting_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `raiting` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `raiting_seccode` varchar(45) NOT NULL DEFAULT '---',
  PRIMARY KEY (`product_raiting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `product_settings` (
  `product_settings_id` int(11) NOT NULL,
  `product_sub_title` int(11) NOT NULL DEFAULT '1',
  `product_code` int(11) NOT NULL DEFAULT '1',
  `product_flat_price` int(11) NOT NULL DEFAULT '1',
  `product_cost_price` int(11) NOT NULL DEFAULT '1',
  `product_options_price` int(11) NOT NULL DEFAULT '1',
  `product_default_currency` varchar(25) NOT NULL DEFAULT 'tl',
  `product_no_unit` int(11) NOT NULL DEFAULT '1',
  `product_unit_list` varchar(455) NOT NULL DEFAULT '---',
  `product_sales_anchor` varchar(45) NOT NULL DEFAULT 'product',
  `product_sales_threshold` int(11) NOT NULL DEFAULT '0',
  `product_sales_threshold_type` varchar(25) NOT NULL DEFAULT 'rate',
  `product_sales_threshold_amount` int(11) NOT NULL DEFAULT '0',
  `extra_field_workable_type` varchar(45) NOT NULL DEFAULT 'changeable',
  `credicart` int(11) NOT NULL DEFAULT '1',
  `credicart_extra_price` int(11) NOT NULL DEFAULT '0',
  `credicart_extra_price_alert` int(11) NOT NULL DEFAULT '1',
  `atthedoor_price` double NOT NULL DEFAULT '0',
  `atthedoor_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `credicart_price` double NOT NULL DEFAULT '0',
  `credicart_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `atthedoor` int(11) NOT NULL DEFAULT '1',
  `atthedoor_extra_price` int(11) NOT NULL DEFAULT '0',
  `atthedoor_extra_price_alert` int(11) NOT NULL DEFAULT '1',
  `bank` int(11) NOT NULL DEFAULT '1',
  `bank_extra_price` int(11) NOT NULL DEFAULT '0',
  `bank_extra_price_alert` int(11) NOT NULL DEFAULT '1',
  `bank_price` float NOT NULL DEFAULT '0',
  `bank_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `inplace` int(11) NOT NULL DEFAULT '1',
  `inplace_extra_price` int(11) NOT NULL DEFAULT '0',
  `inplace_extra_price_alert` int(11) NOT NULL DEFAULT '1',
  `inplace_price` double NOT NULL DEFAULT '0',
  `inplace_price_unit` varchar(11) NOT NULL DEFAULT '---',
  `product_extra_anchor` varchar(45) NOT NULL DEFAULT 'product',
  `product_extra_function` varchar(45) NOT NULL DEFAULT 'product',
  `product_extra_threshold` int(11) NOT NULL DEFAULT '0',
  `product_extra_threshold_type` varchar(25) NOT NULL DEFAULT 'rate',
  `product_extra_threshold_amount` int(11) NOT NULL DEFAULT '0',
  `product_cargo_anchor` varchar(45) NOT NULL DEFAULT 'self',
  `product_cargo_function` varchar(45) NOT NULL DEFAULT 'product',
  `product_cargo_threshold` int(11) NOT NULL DEFAULT '0',
  `product_cargo_threshold_type` varchar(25) NOT NULL DEFAULT 'rate',
  `product_cargo_threshold_amount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `product_special_fields_value` (
  `special_fields_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`special_fields_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `send_mail` (
  `send_mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_account` varchar(45) NOT NULL DEFAULT '---',
  `mail_type` varchar(255) NOT NULL DEFAULT '---',
  `mail_adres` varchar(255) NOT NULL DEFAULT '---',
  `mail_subject` varchar(455) NOT NULL DEFAULT '---',
  `user_fullname` varchar(455) NOT NULL DEFAULT '---',
  `mail_content` text NOT NULL,
  `send_mail_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mail_seccode` varchar(455) NOT NULL DEFAULT '---',
  `mail_see` int(11) NOT NULL DEFAULT '0',
  `mail_see_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mail_check` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `error` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`send_mail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `site_adres` (
  `site_adres_id` int(11) NOT NULL AUTO_INCREMENT,
  `province` int(11) NOT NULL DEFAULT '0',
  `district` int(11) NOT NULL DEFAULT '0',
  `neighborhood` int(11) NOT NULL,
  `description` varchar(455) NOT NULL DEFAULT '---',
  `adres_seccode` varchar(45) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`site_adres_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `site_bank` (
  `site_bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) NOT NULL DEFAULT '0',
  `bank_account` varchar(255) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `account_seccode` varchar(255) NOT NULL DEFAULT '---',
  PRIMARY KEY (`site_bank_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `site_settings` (
  `site_settings_id` int(11) NOT NULL,
  `site_title` varchar(255) NOT NULL DEFAULT '---',
  `prepare` varchar(255) NOT NULL DEFAULT '0',
  `site_description` varchar(455) NOT NULL DEFAULT '---',
  `site_logo_seccode` varchar(255) NOT NULL DEFAULT '---',
  `site_url_protocol` varchar(45) NOT NULL DEFAULT '---',
  `site_url` varchar(255) NOT NULL DEFAULT '---',
  `site_keywords` varchar(255) NOT NULL DEFAULT '---',
  `site_general_mail` varchar(45) NOT NULL DEFAULT '---',
  `site_phone_number` varchar(45) NOT NULL DEFAULT '---',
  `company_name` varchar(255) NOT NULL DEFAULT '---',
  `company_tax_place_province` int(11) NOT NULL DEFAULT '0',
  `company_tax_place` int(11) NOT NULL DEFAULT '0',
  `company_tax_number` varchar(155) NOT NULL DEFAULT '---',
  `site_maintenance` int(11) NOT NULL DEFAULT '0',
  `block_user_listings` int(11) NOT NULL DEFAULT '0',
  `block_comments` int(11) NOT NULL DEFAULT '0',
  `allow_foreign_users` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`site_settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `prepare` (
  `prepare_id` int(11) NOT NULL,
  `prepare_table` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`prepare_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        $ndb->query($sql, []);


        $sql = "CREATE TABLE IF NOT EXISTS `specialfields` (
  `specialfields_id` int(11) NOT NULL AUTO_INCREMENT,
  `fields_name` varchar(455) NOT NULL DEFAULT '---',
  `fields_name_sef` varchar(455) NOT NULL DEFAULT '---',
  `fields_type` varchar(45) NOT NULL DEFAULT '---',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` int(11) NOT NULL DEFAULT '1',
  `specialfields_seccode` varchar(255) NOT NULL DEFAULT '---',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`specialfields_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `specialfields_value` (
  `specialfields_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `specialfields_id` varchar(455) NOT NULL DEFAULT '---',
  `specialfields_value_name` varchar(455) NOT NULL DEFAULT '---',
  `specialfields_value_name_sef` varchar(455) NOT NULL DEFAULT '---',
  `line` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `public` int(11) NOT NULL DEFAULT '1',
  `specialfields_value_seccode` varchar(45) NOT NULL DEFAULT '---',
  `users_id` varchar(75) NOT NULL DEFAULT '---',
  PRIMARY KEY (`specialfields_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `description` text,
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `tax_office` (
  `tax_office_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_office_name` varchar(45) NOT NULL,
  `tax_office_code` int(11) NOT NULL,
  `il_no` int(11) NOT NULL,
  PRIMARY KEY (`tax_office_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `topban_gallery` (
  `topban_gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_gallery_id` int(11) NOT NULL DEFAULT '0',
  `background` varchar(11) NOT NULL DEFAULT 'ffffff',
  `public` int(11) NOT NULL DEFAULT '0',
  `line` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`topban_gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL DEFAULT '---',
  `lname` varchar(255) NOT NULL DEFAULT '---',
  `email` varchar(255) NOT NULL DEFAULT '---',
  `password` varchar(255) NOT NULL DEFAULT '---',
  `fname_sef` varchar(255) NOT NULL DEFAULT '---',
  `gender` int(11) NOT NULL DEFAULT '1',
  `acl` text NOT NULL,
  `ipno` varchar(75) NOT NULL DEFAULT '---',
  `users_seccode` varchar(150) NOT NULL DEFAULT '---',
  `users_number` varchar(150) NOT NULL DEFAULT '---',
  `users_confirm` int(11) NOT NULL DEFAULT '0',
  `users_confirm_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_public` int(11) NOT NULL DEFAULT '0',
  `users_public_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `users_last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);

        $sql = "CREATE TABLE IF NOT EXISTS `user_session` (
  `users_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`users_session_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;";
        $ndb->query($sql, []);
        return true;
    }

    static function checkbtables() {
        require_once(ROOT . DS . 'core' . DS . 'db' . '.php');
        $ndb = new db();
        $r = $ndb->query("SELECT prepare_table from prepare")->one();
        if ($r->prepare_table == 0)
            return false;
        return true;
    }

    static function updateTablePrepare() {
        require_once(ROOT . DS . 'core' . DS . 'db' . '.php');
        $ndb = new db();
        $r = $ndb->query("SELECT prepare_table from prepare")->one();

        if ($r) {

            if ($ndb->update("prepare", 0, ["prepare_table" => 1]))
                return true;
            return false;
        } else {

            if ($ndb->insert("prepare", ["prepare_table" => 1]))
                return true;
            return false;
        }
    }

}
