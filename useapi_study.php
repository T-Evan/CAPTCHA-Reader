<?php
/**
 * Created by mohuishou<1@lailin.xyz>.
 * User: mohuishou<1@lailin.xyz>
 * Date: 2016/5/1 0001
 * Time: 20:44
 */
require_once 'vendor/autoload.php';
//$a=$db->get();
//print_r($a);
if(isset($_POST['send'])&&$_POST['send']=="send"){
    echo "<script>location.href='./study.php?t=".time()."'</script>";
}else{
    process('http://coin.lib.scuec.edu.cn/reader/captcha.php');
}
function process($img){
    $db=new \Mohuishou\ImageOCR\StorageFile();

    $file_content=urlencode(chunk_split(base64_encode(file_get_contents($img))));//base64编码
    $image=new \Mohuishou\ImageOCR\Image($img);

    $img='data:image/'.'png'.';base64,'.$file_content;//合成图片的base64编码
    echo "<img src='".$img."'>";
    $host = "http://route.showapi.com";
    $path = "/184-5";
    $method = "POST";
    $headers = array();
    array_push($headers, "Content-Type: application/x-www-form-urlencoded; charset=utf-8");
    $querys = "";
    $bodys = "showapi_appid=51809&showapi_sign=ba9ebbe7c4a84265bcf660855c04c5d2&typeId=24&img_base64=".$file_content;
    $url = $host . $path . "?" . $querys;

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curl, CURLOPT_FAILONERROR, false);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_HEADER, false);

    if (1 == strpos("$".$host, "https://"))

    {

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    }



    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);

    $response = json_decode(curl_exec($curl),true);

    $response=$response['showapi_res_body']['Result'];
    echo "识别结果".$response;
    $code_arr=str_split($response);
    for($i=0;$i<$image::CHAR_NUM;$i++){
        $hash_img_data=implode("",$image->splitImage($i));
        $db->add($code_arr[$i],$hash_img_data);
    }

    echo "<script>location.href='./study.php?t=".time()."'</script>";

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Study</title>
</head>
<body>
    <form action="" method="post">
        <img src="img/inImgTemp.png">
        <input type="text" name="code">
        <input name="send" type="submit" value="send" />
    </form>
</body>
</html>