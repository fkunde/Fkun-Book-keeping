<?php
session_start();
error_reporting(E_ALL || ~E_NOTICE);
/*
if(isset($_SESSION['user_shell']))
{
echo "<script language='javascript' type='text/javascript'>window.location.href='add.php'</script>";
}
*/
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FKUN记账系统</title>

    <link rel="stylesheet" type="text/css" href="css/default.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style type="text/css">
	canvas {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
                        }
        /* <![CDATA[ */
        #tab-title .selected { 
            color:#C96464;
        }
        #tab-title span {
            padding:0 18px 8px 0;
            cursor:pointer;
        }
        #tab-content .hide { 
            display:none;
        }
        #tab-content ul {
            /* overflow:hidden; */
            list-style:none
        }
        #tab-content ul li {
            overflow:hidden;
            border-top: 1px dotted #DDDDDD;
            line-height: 2.1em;
            padding: 0 1px;
        }
        #tab-content ul li span {
            color:#A1A3A6;
        }
        .tishi { 
            position:absolute;
            bottom:-15%;
           margin-left:5%;
           
        }
        /* ]]> */
    </style>

</head>

<body>
<script id="ribbon" src="js/canvasribbon.js"></script>
    <?php
    include("config.php");
    ?>


    <script type="text/javascript">
        //tab
        jQuery(document).ready(function() {
            jQuery('#tab-title span').click(function() {
                jQuery(this).addClass("selected").siblings().removeClass();
                jQuery("#tab-content > ul").fadeOut('0').eq(jQuery('#tab-title span').index(this)).fadeIn('0');
            });
        });
    </script>
    <div class='login'>

    <img src="./img/GTA.png" width="200px" style="margin-left:28%;margin-top:-15%;"/>
    <p style="margin-left:30%;margin-top:5%;color:#DEDEDE;font-size:19px;letter-spacing:4px">
    PLEASE LOG IN
    </p>
	


        <div id="tab-content" style="margin-left:22%;margin-top:1%;position:absolute;">



            <ul>
      <p style="margin-left:-307%;margin-top:-2%;color:#DEDEDE;font-size:20px;letter-spacing:3px;position:absolute;">
    Username
        </p>
        <p style="margin-left:-290%;margin-top:149%;color:#DEDEDE;font-size:20px;letter-spacing:3px;position:absolute;">
    Password
        </p>
                <form action="" method="post">
                    <div class='login_fields' style="margin-left:104%;margin-top:-5%;position:absolute;">

                        <div class='login_fields__user'>
                            <input placeholder='' type='text' id='username' name='username'>

                        </input>
                    </div>

                    <div class='login_fields__password' style="margin-left:0%;margin-top:11%;position:absolute;">
                        <input placeholder='' type='password' id='password' name='password'">
                    </div>

                    <div class='login_fields__submit'style="margin-left:64%;margin-top:34%;position:absolute;">
                        <input type='submit' value='Log In' name='submit'>
                    </div>

                </div>
            </form>
        </ul>
        <p style="margin-left:-215%;margin-top:326%;color:#8A8A8A;font-size:15px;letter-spacing:0px;position:absolute;">
 VERSION 1.2.5
        </p>



        <div class='login_title' style="margin-left:-213%;margin-top:314%;color:#DEDEDE; position:absolute;">
            <div id="tab-title">
                <h3><span class="selected" style="font-size:10px;">Login</span><span style="font-size:10px;">Signup</span>
				<!-- <span>找回密码</span> -->
				</h3>
            </div>
        </div>

        <ul class="hide">

            <form action="" method="post" name="submitzhuce">
                <div class='login_fields'>
 
                    <div class='login_fields__user'>

                        <input placeholder='USERNAME' type='text' id='username' name='username'>

                        <div class='validation'>
                            <img src='img/tick.png'>
                        </div>
                    </input>
                </div>

                <div class='login_fields__user'>

                    <input placeholder='EMAIL' type='text' name='email' id='email'>
                    <div class='validation'>
                        <img src='img/tick.png'>
                    </div>
                </input>
            </div>

            <div class='login_fields__password'>

                <input placeholder='PASSWORD' type='password' id='password' name='password'>
                <div class='validation'>
                    <img src='img/tick.png'>
                </div>
                <div class='login_fields__submit'>
                    <input type='submit' value='SUBMIT' name='Submitzhuce'>
                </div>
            </div>


        </div>
    </form>
</ul>

<ul class="hide">
    <form action="" method="post">
        <div class='login_fields'>

            <div class='login_fields__user'>
                <div class='icon'>
                    <img src='img/user_icon_copy.png'>
                </div>
                <input placeholder='EMAIL' type='text' name='email' id='email'>
                <div class='validation'>
                    <img src='img/tick.png'>
                </div>
            </input>
            <div class='login_fields__submit'>
                <input type='submit' value='找回' name='submitmima'>
            </div>
        </div>
    </div>
</form>
</ul>


</div>
<div class="tishi">
<p>
<?php
if ($_POST['submit']) {
$username = str_replace(" ","",$_POST['username']);
//去除空格
$sql = "SELECT * FROM ".$prename."user WHERE username = '$username'";
$query = mysqli_query($conn,$sql);
$exist = is_array($row = mysqli_fetch_array($query));
//判断是否存在这样一个用户
$exist2 = $exist?md5($_POST['password']) == $row['password']:FALSE;
//判断密码
if ($exist2) {
$_SESSION['uid'] = $row['uid'];
// session赋值
$_SESSION['user_shell'] = md5($row['username'].$row['password']);
echo "<br><br><font color='green' size='5px'>Login Success...</font><meta http-equiv=refresh content='0; url=add.php'>";
} else {
echo "<br><br><font color='red' size='5px'>Check your Password or Username!</font>";
SESSION_DESTROY();
}
}
?>

<?php if ($_POST[$Submitzhuce]) {
if (empty($_POST[$email]) ) {
echo "<br><br><font color='red'>请输入邮箱</font>";
exit;
}
$sql = "select * from ".$prename."user where username='$_POST[username]' or email='$_POST[email]'";
$query = mysqli_query($conn,$sql);
$attitle = is_array($row = mysqli_fetch_array($query));
if ($attitle) {
echo "<br><br><font color='red'>用户或邮箱已存在！</font>";
exit();
} else {
$umima = md5($_POST[$password]);
$utime =time();
$sql = "insert into ".$prename."user (username, password,email,utime) values ('$_POST[username]', '$umima', '$_POST[email]', '$utime')";
$query = mysqli_query($conn,$sql);
if ($query) {
echo "<br><br><font color='green'>OK，你已经成功注册！随时可以登录！</font><script>alert('注册成功，登陆前请仔细阅读用户协议') </script>";
} else
{
echo "<br><br><font color='red'>出错啦，写入数据库时出错！</font>";
}
//给用户增加默认分类
$sql = "select * from ".$prename."user where username='$_POST[username]'";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);
$uid = $row['uid'];
$sql = "insert into ".$prename."account_class (classname, classtype,ufid) values ('收入', '1','".$uid."'),('支出', '2','".$uid."')";
$query = mysqli_query($conn,$sql);
if ($query) {
echo "<br><font color='green'>增加默认分类成功！</font>";
} else
{
echo "<br><font color='red'>增加默认分类出错！</font>";
}
//给用户增加默认time
$sql = "select * from ".$prename."user where username='$_POST[username]'";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($query);
$uid = $row['uid'];
$sql = "insert into ".$prename."date (date,datetype, ufid) values ('1', '0','".$uid."'),('0', '1','".$uid."')";
$query = mysqli_query($conn,$sql);
if ($query) {
echo "<br><font color='green'>增加默认time成功！</font>";
} else
{
echo "<br><font color='red'>增加默认time出错！</font>";
}
}
}
?>

</p>
</div>
</div>
<script type="text/javascript" src='js/stopExecutionOnTimeout.js?t=1'></script>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script>
$('input[type="submit"]').click(function () {
$('.login').addClass('test');
setTimeout(function () {
$('.login').addClass('testtwo');
}, 300);
setTimeout(function () {
$('.authent').show().animate({
right: -320
}, {
easing: 'easeOutQuint',
duration: 600,
queue: false
});
$('.authent').animate({
opacity: 1
}, {
duration: 200,
queue: false
}).addClass('visible');
}, 500);
setTimeout(function () {
$('.authent').show().animate({
right: 90
}, {
easing: 'easeOutQuint',
duration: 600,
queue: false
});
$('.authent').animate({
opacity: 0
}, {
duration: 200,
queue: false
}).addClass('visible');
$('.login').removeClass('testtwo');
}, 2500);
setTimeout(function () {
$('.login').removeClass('test');
$('.login div').fadeOut(123);
}, 2800);
setTimeout(function () {
$('.success').fadeIn();
}, 3200);
});
$('input[type="text"],input[type="password"]').focus(function () {
$(this).prev().animate({
'opacity': '1'
}, 200);
});
$('input[type="text"],input[type="password"]').blur(function () {
$(this).prev().animate({
'opacity': '.5'
}, 200);
});
$('input[type="text"],input[type="password"]').keyup(function () {
if (!$(this).val() == '') {
$(this).next().animate({
'opacity': '1',
'right': '30'
}, 200);
} else {
$(this).next().animate({
'opacity': '0',
'right': '20'
}, 200);
}
});
var open = 0;
$('.tab').click(function () {
$(this).fadeOut(200, function () {
$(this).parent().animate({
'left': '0'
});
});
});
</script>
</body>
</html>