<?php
session_start();
session_destroy();
?>
    <html>
    <head>
        <title>session validate</title>
        <style type="text/css">
            #login p{
                margin-top: 15px;
                line-height: 20px;
                font-size: 14px;
                font-weight: bold;
            }
            #login img{
                cursor:pointer;
            }
            form{
                margin-left:20px;
            }
        </style>
    </head>
    <body>

    <form id="login" action="" method="post">
        <p>
            <span>验证码</span>
            <input type="text" name="validate" value="" size=10>
            <img  title="验证码" src="./captcha.php?validate=<?php echo time();?>" align="absbottom" onclick="this.src='captcha.php?'+Math.random();"></img>
        </p>
        <p>
            <input type="submit">
        </p>
    </form>
<?php
if(isset($_POST["validate"]) && $_POST["validate"]){
    $validate = strtolower($_POST["validate"]);
    if($validate != $_SESSION["authnum_session"]){
        echo "验证码错误";
    }else{
        echo "正确";
    }
} else {
    die('请输入验证码');
}
?>