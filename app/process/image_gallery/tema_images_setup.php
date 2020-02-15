<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of image_setup
 *
 * @author engin
 */
class tema_images_setup {

    //put your code here

    public function upload_imagesAction() {
        $data = [];
        $nvalidate = new validate();
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {


                /* Gelen Veri */
                $images = $_FILES["images"]; // Gelen Dosyalar -- 
                $imagecount = $_POST["imagecount"];
                $uniqid = $_POST["uniqid"];
                $form_type = $_POST["form_type"];
                $media_type = $_POST["media_type"];
                $multiple = $_POST["multiple"] == "true" ? 1 : 0;
                $dummy = $_POST["dummy"];
                if ($dummy !== NODATA)
                    $data["dummy"] = base64_decode($dummy);
                //   $multiple == "true" ? 0 : 1;
                if ($uniqid == "0") {
                    $uniqid = seccode();
                }

                $data["uniqid"] = $uniqid;
                $nprepare_image = new prepare_image();
                $image_folder = $nprepare_image->setImageFolder($media_type, $uniqid);

//                dnd($image_folder);
                /* Benzersiz Klasor Yolu */

                /*                 * ****Dosya Yükleme *********  */
                //Belirtilen Klasöre Yükleme Yapar.
                //Çoklu Dosya Yüklemesi için Son Değer True
                //Gelen $_FILES Değerini de array olarak vermek gerekli
                $files = $this->upload_multi_file($images, $image_folder, $multiple, 25242880, $form_type);


                /*                 * ****Dosya Yükleme *********  */


                /*                 * ****Resimler genel resim galerisine kayıt ediliyor. *********  */
                $images_seccode = [];
                $images_info = [];
                if (isset($files["hata"])) {
                    $data["hata"] = $files["hata"];
                    $data["sonuc"] = false;
                    $data["msg"] = "Resim Yüklenemedi";
                } else {

                    data::make_postdata();

                    foreach ($files as $file) {
                        //dnd($file);

                        $nprepare_image = new prepare_image();
                        $nimage_gallery = new table_image_gallery();
                        //Tüm resimler ilk önce silinemez şekilde genel resim galerisine kayıt edilir.
                        $image_info = $nprepare_image->explode_image_path($file);


                        $gallery_seccode = seccode();
                        $image_info["galery_seccode"] = $gallery_seccode;
                        data::add_post_data("image_gallery_fields", "file", $file);
//                        data::add_post_data("image_gallery_fields", "form_type", "");
                        data::add_post_data("image_gallery_fields", "media_type", $image_info["media_type"]);
                        data::add_post_data("image_gallery_fields", "image_name", $image_info["image_name"]);
                        data::add_post_data("image_gallery_fields", "image_uniqid", $image_info["image_uniqid"]);
                        data::add_post_data("image_gallery_fields", "image_folder", $image_info["image_folder"]);
                        data::add_post_data("image_gallery_fields", "image_relative_path", $image_info["image_relative_path"]);
                        data::add_post_data("image_gallery_fields", "first_image_name", $image_info["first_image_name"]);
                        data::add_post_data("image_gallery_fields", "extention", $image_info["extention"]);
                        data::add_post_data("image_gallery_fields", "gallery_seccode", $gallery_seccode);
                        data::add_post_data("image_gallery_fields", "date", getNow());
                        data::add_post_data("image_gallery_fields", "users_id", session::get(CURRENT_USER_SESSION_NAME));


                        $gallery_image_postdata = data::get_postdata();

                        //TODO : Data integration İşleminin Yapılması gerekiyor


                        $nprepare_image_gallery_data = new prepare_image_gallery_data();
                        $control_module = $nprepare_image_gallery_data->set_new_image_gallery_data($gallery_image_postdata);
                        $image_data = data::get_data($control_module, "image_gallery");

//                        dnd($control_module);
//                        dnd($gallery_image_postdata);
//                        dnd($image_data);


                        $image_gallery_id = $nimage_gallery->add_new_gallery_item($image_data);
                        $image_info["image_gallery_id"] = $image_gallery_id;
                        $images_info[] = $image_info;
                    }
                    /*                     * ****Geriye Dönen Değerler. *********  */
                    $data["filename"] = $files;
                    $data["imagecount"] = count($files) + $imagecount;
                    $data["images_info"] = $images_info;
                    $data["sonuc"] = true;
                    $nvalidate->addSuccess("Medya Dosyası Başarıyla Yüklendi");
                    /*                     * ****Geriye Dönen Değerler. *********  */
                }
            } else {
                $data["sonuc"] = false;
                $nvalidate->addError("Resim Yüklenmedi");
            }
        } else {
            $data["sonuc"] = false;
            $nvalidate->addError("Bu Alana Bu şekilde giriş yapamazsınız");
        }

        if (!empty($nvalidate->get_success()))
            foreach ($nvalidate->get_success() as $sc) {
                $data["success_message"][] = $sc;
            }
        if (!empty($nvalidate->get_warning()))
            foreach ($nvalidate->get_warning() as $wr) {
                $data["warning_message"][] = $wr;
            }
        if (!empty($nvalidate->get_errors()))
            foreach ($nvalidate->get_errors() as $sc) {
                $data["error_message"][] = $sc;
            }
        echo json_encode($data);
    }

    public function reResulotionAction() {
        $data = [];
        if (session::exists(CURRENT_USER_SESSION_NAME)) {
            if ($_POST) {
                $image_info = $_POST["image_info"];

                $sizes = $_POST["resulotion_size"];
                //$imageex = explode(DS, $filename);
                // $_lenght = count($imageex);
                $image_name = $image_info["first_image_name"];
                $extention = $image_info["extention"];
                $uniqid = $image_info["uniqid"];
                $form_type = $image_info["form_type"];
                $image_folder = $image_info["image_folder"];
                // $_image_folder = rtrim($image_folder, DS);
//                $image_name_ex = explode(".", $image_name);
//                $image_path = $image_folder . DS . ltrim($image_name_ex[0], DS) . "_ORJ." . $image_name_ex[1];
//                $image_name = $image_name_ex[0];
//                $extention = $image_name_ex[1];
                $image_path = $image_folder . DS . $image_name . "_ORJ." . $extention;
                $image_type = image_type_to_mime_type(exif_imagetype($image_path));
                // $file_size = array("1000", "500", "300", "250"); // Dosyaların Ölçekleneceği Boyutlar -- width Değeri -- 
                //  $ngeneral = new general_function();
                //$ngeneral->setup_image($image_path, $_image_folder, $image_name, $extention, $image_type, $file_size);

                if ($image_type == "image/jpeg") {
                    $resim = @imagecreatefromjpeg($image_path);
                } elseif ($image_type == "image/png") {
                    $resim = @imagecreatefrompng($image_path);
                } elseif ($image_type == "image/gif") {
                    $resim = @imagecreatefromgif($image_path);
                } elseif ($image_type == "image/jpg") {
                    $resim = @imagecreatefromjpeg($image_path);
                }

                // Yüklenen resimden oluşacak yeni bir JPEG resmi oluşturuyoruz..
                $boyutlar = @getimagesize($image_path);   // Resmimizin boyutlarını öğreniyoruz
                $resimorani = $sizes / $boyutlar[0];    // Resmi küçültme/büyütme oranımızı hesaplıyoruz..
                $yeniyukseklik = $resimorani * $boyutlar[1];  // Bulduğumuz orandan yeni yüksekliğimizi hesaplıyoruz..
                $yeniresim = @imagecreatetruecolor($sizes, $yeniyukseklik); // Oluşturulan boş resmi istediğimiz boyutlara getiriyoruz..
                @imagealphablending($yeniresim, FALSE);
                @imagesavealpha($yeniresim, TRUE);
                $background = @imagecolorallocatealpha($yeniresim, 255, 255, 255, 127); /* In RGB colors- (Red, Green, Blue, Transparency ) */
                @imagefilledrectangle($yeniresim, 0, 0, $sizes, $yeniyukseklik, $background);
                $newPicName = $image_name . "_" . $sizes . "." . $extention;
                imagecopyresampled($yeniresim, $resim, 0, 0, 0, 0, $sizes, $yeniyukseklik, $boyutlar[0], $boyutlar[1]);
                // Yüklenen resmimizi istediğimiz boyutlara getiriyoruz ve boş resmin üzerine kopyalıyoruz..

                $yeniKonum = $image_folder . '/' . $newPicName;
                if ($image_type == "image/jpeg") {
                    @imagejpeg($yeniresim, $yeniKonum, 80);   // Ve resmi istediğimiz konuma kaydediyoruz..
                } elseif ($image_type == "image/png") {
                    @imagepng($yeniresim, $yeniKonum, 9);   // Ve resmi istediğimiz konuma kaydediyoruz..
                } elseif ($image_type == "image/gif") {
                    @imagegif($yeniresim, $yeniKonum, 100);
                } elseif ($image_type == "image/jpg") {
                    @imagejpeg($yeniresim, $yeniKonum, 100);
                }
                //Kaydettiğimiz yeni resimin yolunu $hedefdosya değişkeni taşımaktadır..
                chmod($yeniKonum, 0755);


                $data["data"] = $image_name;
                $data["sonuc"] = TRUE;
                $data["msg"] = "Sonuc Başarılı";
            } else {
                $data["sonuc"] = false;
                $data["msg"] = "Resim Düzenlenemedi";
            }
        } else {
            $data["sonuc"] = false;
            $data["msg"] = "Bu Alana Bu şekilde giriş yapamazsınız";
        }
        echo json_encode($data);
    }

    private function upload_multi_file($images, $folder, $multiple = FALSE, $filesize = 5242880, $form_type = "") {
        $result = array();
        $folder;

        if (!$multiple) {

            if (!is_dir($folder)) {
                mkdir($folder, 0777);
            }
            if (!empty($images)) {
                $count = count($images["name"]);
                //var_dump($images);
                $i = 0;
                $name = $images["name"];
                $type = $images["type"];
                $tmp_name = $images["tmp_name"];
                $error = $images["error"];
                $size = $images["size"];


                if (is_uploaded_file($tmp_name)) {
                    $dosyaUzantiEX = explode(".", $name);
                    $dosyaUzanti = end($dosyaUzantiEX);
                    $rand = date('YmdHis', time()) . mt_rand();
                    $dosyaAdi = $rand . '_ORJ.' . $dosyaUzanti;
                    $dosyaYolu = $folder . DS . $dosyaAdi;

                    if (move_uploaded_file($tmp_name, $dosyaYolu)) {
                        chmod($dosyaYolu, 0777);
                        $result[] = $folder . "/" . $rand . "." . $dosyaUzanti;
                    } else {
                        $result["hata"] = ' <div class="alert alert-danger" role="alert">
                      <button class="close" data-dismiss="alert"></button>
                      <strong>HATA  : </strong>Dosya Taşınamadı !.
                      </div>';
                    }
                } else {
                    $result["hata"] = ' <div class="alert alert-danger" role="alert">
                      <button class="close" data-dismiss="alert"></button>
                      <strong>HATA  : </strong>' . $name . 'İsimli Dosy Yüklenemedi !.
                    </div>';
                }
            }
        } else {

            $count = count($images["tmp_name"]);
            for ($i = 0; $i <= $count - 1; $i++) {
                $nprepare_image = new prepare_image();

                if (!is_dir($folder)) {
                    mkdir($folder, 0777);
                }
                $name = $images["name"][$i];
                $type = $images["type"][$i];
                $tmp_name = $images["tmp_name"][$i];
                $error = $images["error"][$i];
                $size = $images["size"][$i];

                if (empty($type)) {
                    $result["hata"] = ' <div class="alert alert-danger" role="alert">
                      <button class="close" data-dismiss="alert"></button>
                      <strong>HATA  : </strong>' . $name . ' İsimli Dosyanın Dosya Tipi Tespit Edilemiyor. Lütfen Başka bir İmaj Kullanın!.
                    </div>';
                } else {
                    if ($size >= $filesize) {

                        $result["hata"] = ' <div class="alert alert-danger" role="alert">
                      <button class="close" data-dismiss="alert"></button>
                      <strong>HATA  : </strong>' . $name . ' İsimli Dosya Boyutu 5 Mb Den Daha Büyük !.
                    </div>';
                    } else {
                        if (is_uploaded_file($tmp_name)) {
                            $dosyaUzantiEX = explode(".", $name);
                            $dosyaUzanti = end($dosyaUzantiEX);
                            $rand = date('YmdHis', time()) . mt_rand();
                            $dosyaAdi = $rand . '_ORJ.' . $dosyaUzanti;
                            $dosyaYolu = $folder . '/' . $dosyaAdi;
                            if (move_uploaded_file($tmp_name, $dosyaYolu)) {
                                chmod($dosyaYolu, 0777);
                                $result[] = $folder . "/" . $rand . "." . $dosyaUzanti;
                            } else {
                                $result["hata"] = ' <div class="alert alert-danger" role="alert">
                      <button class="close" data-dismiss="alert"></button>
                      <strong>HATA  : </strong>Dosya Taşınamadı !.
                    </div>';
                            }
                        } else {
                            $result["hata"] = ' <div class="alert alert-danger" role="alert">
                      <button class="close" data-dismiss="alert"></button>
                      <strong>HATA  : </strong>' . $name . ' İsimli Dosya Yüklenemedi !.
                    </div>';
                        }
                    }
                }
            }
        }
        return $result;
    }

}
