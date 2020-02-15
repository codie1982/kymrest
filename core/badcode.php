<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of input
 *
 * @author engin
 */
class badcode {

    public static function makeBadCode($text) {
        $njob = new job();
        $badfilename = date("ymdhsi") . uniqid();
        $folder = ROOT . DS . 'app' . DS . "bad" . DS . $badfilename;
        if (!is_dir($folder))
            mkdir($folder);
        $file = $folder . DS . "badfile.hth";
        $dosya = fopen($file, 'w');
        $text = $text . getNow();
        fwrite($dosya, $text);
        fclose($dosya);
        $njob->addBadFile($jobID, $badfilename);
        return true;
    }

}
