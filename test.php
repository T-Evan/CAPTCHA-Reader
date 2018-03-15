<?php

use Mohuishou\ImageOCR;
require 'vendor/autoload.php';
showImg('http://coin.lib.scuec.edu.cn/reader/captcha.php');

function showImg($img){
    $file_content=chunk_split(base64_encode(file_get_contents($img)));//base64编码

    $img='data:image/'.'png'.';base64,'.$file_content;//合成图片的base64编码
    echo "<img src='".$img."'>";
    $image_ocr=new  Mohuishou\ImageOCR\Image($img);
//$image_ocr=new  Mohuishou\ImageOCR\Image("./captcha.png");

    $image_ocr->draw();
    print_r($image_ocr->find()) ;


}