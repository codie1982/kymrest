<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of iyzico_start
 *
 * @author engin
 */
class iyzico_start {

    public static function options() {
        $options = new \Iyzipay\Options();
        //DBDEN ALMASI GEREKLİ
        $options->setApiKey("sandbox-KcnsKwpwp26FeJKMGjymEK0rfdbP20qL");
        $options->setSecretKey("sandbox-nR25yoeWjI4qIRkvtqUTfBgbiI11Y7uY");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");

        return $options;
    }

}
