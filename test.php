<?php
require __DIR__.'/vendor/image-ocr/Image.php';
use My\ImageOCR\Image as Image;
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
    $image_ocr=new Image($img);
    print_r($image_ocr->find()) ;
}
