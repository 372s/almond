<?php
$img = imagecreatetruecolor(70, 30);
$black = imagecolorallocate($img, 0, 0, 0);
$green = imagecolorallocate($img, 0, 255, 0);
$white = imagecolorallocate($img, 255, 255, 255);
// 图片背景颜色
imagefill($img,0,0,$white);
//生成随机的验证码
$code = '';
//4位数的验证码
for($i = 0; $i < 4; $i++) {
    $code .= rand(0, 9);
}

$code = getCodeB();
imagestring($img, 5, 0, 0, $code, $black);

//加入噪点干扰
for($i=0;$i<50;$i++) {
    //imagesetpixel — 画一个单一像素，语法: bool imagesetpixel ( resource $image , int $x , int $y , int $color )
    imagesetpixel($img, rand(0, 100) , rand(0, 100) , $black);
    imagesetpixel($img, rand(0, 100) , rand(0, 100) , $green);
}
for ($i=0; $i <3 ; $i++) {   
    //干扰线的颜色  
    $linecolor=imagecolorallocate($img, rand(80, 220), rand(80, 220), rand(80, 220));  
    //画出每条干扰线  
    imageline($img, rand(1, 99), rand(1, 29), rand(1, 99), rand(1,29), $linecolor);  
}

// 输出验证码
header("content-type: image/png");
// imagepng($img, './captcha/cap_'.$code.'.png');
// 以 PNG 格式将图像输出到浏览器或文件
imagepng($img);
// 图像处理完成后，使用 imagedestroy() 指令销毁图像资源以释放内存，虽然该函数不是必须的，但使用它是一个好习惯。 
imagedestroy($img);


function getCodeA() {
    $captch_code = "";
    for ($i = 0; $i < 4; $i++) {
        $data = "1234567890abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ";
        $fontcontent = substr($data, rand(0,strlen($data)), 1);
        $captch_code .= $fontcontent;
    }
    return $captch_code;
}

function getCodeB() {
    $str = "1234567890abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ";
    $sub = str_shuffle($str);
    return substr($sub, 0, 4);
}
?>