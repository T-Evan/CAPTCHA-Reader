<?php
use Mohuishou\ImageOCR;
set_time_limit(0);
require 'vendor/autoload.php';
$t1 = microtime(true);

showImg('http://coin.lib.scuec.edu.cn/reader/captcha.php');
$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3).'秒<br>';
echo '内存使用: ' . memory_get_usage()/1024 . 'kb<br />';
//showImg('../captcha.png');
//showImg('../testff.png');
function showImg($img){
    $file_content=chunk_split(base64_encode(file_get_contents($img)));//base64编码

    $img='data:image/'.'png'.';base64,'.$file_content;//合成图片的base64编码
    echo "<img src='".$img."'>";
    $image_ocr=new  ImageOCR\Image($img);
//$image_ocr=new  Mohuishou\ImageOCR\Image("./captcha.png");

//    $img=$image_ocr->imageStandard(file_get_contents($img));
    print_r($image_ocr->find()) ;
//    imagepng($img,'./0.png');

}