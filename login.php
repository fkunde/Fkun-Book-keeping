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
    <title>FKUN SYSTEM</title>
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script type="text/javascript">
        function disable() {
            document.getElementById("accept").disabled = true
            document.getElementById("accept").style.background='#BFBFBF';
        }

        function enable() {
            document.getElementById("accept").disabled = false
            document.getElementById("accept").style.background='#bb2f2a';
        }
    </script>
</head>

<body>
   
<script type="text/javascript" src="js/three.js"></script>
    
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

        <img src="./img/GTA.png" width="200px" style="margin-left:28%;margin-top:-15%;" />




        <div id="tab-content" style="margin-left:22%;margin-top:11%;position:absolute;">



            <ul>
                <p style="margin-left:-60%;margin-top:-128%;width:300px;color:#DEDEDE;font-size:19px;letter-spacing:4px; position:absolute;">
                    PLEASE LOG IN
                </p>

                <p style="margin-left:-307%;margin-top:-2%;color:#DEDEDE;font-size:20px;letter-spacing:3px;position:absolute;">
                    Username
                </p>
                <p style="margin-left:-290%;margin-top:149%;color:#DEDEDE;font-size:20px;letter-spacing:3px;position:absolute;">
                    Password
                </p>
                <form action="" method="post">
                    <div class='login_fields' style="margin-left:104%;margin-top:-5%;position:absolute;">

                        <div class='login_fields__user'>
                            <input type='text' id='username' name='username'>

                            </input>
                        </div>

                        <div class='login_fields__password' style="margin-left:0%;margin-top:11%;position:absolute;">
                            <input type='password' id='password' name='password'">
                    </div>

                    <div class='login_fields__submit'style=" margin-left:64%;margin-top:34%;position:absolute;">
                            <input type='submit' value='Log In' name='submit'>
                        </div>

                    </div>
                </form>
            </ul>

            <ul class="hide">
                
                <p style="margin-left:57%;margin-top:-150%;width:300px;color:#DEDEDE;font-size:19px;letter-spacing:4px; position:absolute;">
                    SIGNUP
                    <br>
                    <a href="/eula.php" style="margin-left:-6%;font-size:8px;">Read the EULA</a>
                    
                </p>
                <form action="" method="post" name="submitzhuce">
                    <div class='login_fields'>

                        <div class='login_fields__user'>

                            <input placeholder='USERNAME' type='text' id='usernamereg' name='usernamereg' style="margin-left:-33%;margin-top:0%;position:absolute;">

                            <div class='validation'>
                                <img src='img/tick.png'>
                            </div>
                            </input>
                        </div>

                        <div class='login_fields__user'>

                            <input placeholder='EMAIL' type='text' name='emailreg' id='emailreg' style="margin-left:-33%;margin-top:31%;position:absolute;">
                            <div class='validation'>
                                <img src='img/tick.png'>
                            </div>
                            </input>
                        </div>

                        <div class='login_fields__password'>

                            <input placeholder='PASSWORD' type='password' id='passwordreg' name='passwordreg' style="margin-left:-33%;margin-top:62%;position:absolute;">
                            <div class='validation'>
                                <img src='img/tick.png'>
                            </div>
                            
                            <div class='login_fields__submit'>
                            
                                <input id="accept" disabled="true" type='submit' value='SUBMIT' name='Submitzhuce' style="margin-left:170%;margin-top:92%;background:#BFBFBF;" >
                                <p style="color:#fff;margin-top:-20%;margin-left:30%;width:100px;">Accept EULA</p>
                                <input type="checkBox" style="position:absolute;color:#fff;display: block;margin-top:-25%;margin-left:122%;" onclick="if (this.checked) {enable()} else {disable()}">
                            </div>
                        </div>

                        
                    </div>
                </form>
                
            </ul>
            <div style="margin-left:-215%;margin-top:280%;position:absolute;">
                <p style="color:#8A8A8A;font-size:15px;">
                    VERSION 1.2.5
                </p>
                <div class='login_title' style="color:#DEDEDE; margin-top:-20%;">
                    <div id="tab-title">
                        <h3><span class="selected" style="font-size:10px;">Login</span><span style="font-size:10px;">Signup</span>
                            <!-- <span>找回密码</span> -->
                        </h3>
                    </div>
                </div>
            </div>

        </div>
        <div class="tishi">
            <p>
                <?php
                if ($_POST['submit']) {
                    $username = str_replace(" ", "", $_POST['username']);
                    //去除空格
                    $sql = "SELECT * FROM " . $prename . "user WHERE username = '$username'";
                    $query = mysqli_query($conn, $sql);
                    $exist = is_array($row = mysqli_fetch_array($query));
                    //判断是否存在这样一个用户
                    $exist2 = $exist ? md5($_POST['password']) == $row['password'] : FALSE;
                    //判断密码
                    if ($exist2) {
                        $_SESSION['uid'] = $row['uid'];
                        // session赋值
                        $_SESSION['user_shell'] = md5($row['username'] . $row['password']);
                        echo "<br><br><font color='green' size='5px'>Login Successful...</font><meta http-equiv=refresh content='0; url=add.php'>";
                    } else {
                        echo "<br><br><font color='red' size='5px'>Check your Password or Username!</font>";
                        SESSION_DESTROY();
                    }
                }
                ?>

                <?php if ($_POST['Submitzhuce']) {
                    if (empty($_POST['emailreg'])) {
                        echo "<br><br><font color='red'>PLEASE ENTER EMAIL!</font>";
                        exit;
                    }
                    $sql = "select * from " . $prename . "user where username='$_POST[usernamereg]' or email='$_POST[emailreg]'";
                    $query = mysqli_query($conn, $sql);
                    $attitle = is_array($row = mysqli_fetch_array($query));
                    if ($attitle) {
                        echo "<br><br><font color='red'>USER OR EMAIL EXSIST!</font>";
                        exit();
                    } else {
                        $umima = md5($_POST['passwordreg']);
                        $utime = time();
                        $sql = "insert into " . $prename . "user (username, password,email,utime) values ('$_POST[usernamereg]', '$umima', '$_POST[emailreg]', '$utime')";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            echo "<br><br><font color='green'>Registration Successful!</font><script>alert('Registration Successful! Please read the EULA before login!') </script>";
                        } else {
                            echo "<br><br><font color='red'>SQL Erro!</font>";
                        }
                        //给用户增加默认time
                        $sql = "select * from " . $prename . "user where username='$_POST[usernamereg]'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($query);
                        $uid = $row['uid'];
                        $sql = "insert into " . $prename . "date (date,datetype, ufid) values ('1', '0','" . $uid . "'),('0', '1','" . $uid . "')";
                        $query = mysqli_query($conn, $sql);
                        if ($query) {
                            echo "<br><font color='green'>Usertimetable Create...OK</font>";
                        } else {
                            echo "<br><font color='red'>Usertimetable Create...Failure!!!</font>";
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
        $('input[type="submit"]').click(function() {
            $('.login').addClass('test');
            setTimeout(function() {
                $('.login').addClass('testtwo');
            }, 300);
            setTimeout(function() {
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
            setTimeout(function() {
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
            setTimeout(function() {
                $('.login').removeClass('test');
                $('.login div').fadeOut(123);
            }, 2800);
            setTimeout(function() {
                $('.success').fadeIn();
            }, 3200);
        });
        $('input[type="text"],input[type="password"]').focus(function() {
            $(this).prev().animate({
                'opacity': '1'
            }, 200);
        });
        $('input[type="text"],input[type="password"]').blur(function() {
            $(this).prev().animate({
                'opacity': '.5'
            }, 200);
        });
        $('input[type="text"],input[type="password"]').keyup(function() {
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
        $('.tab').click(function() {
            $(this).fadeOut(200, function() {
                $(this).parent().animate({
                    'left': '0'
                });
            });
        });
    </script>
<div class="footer">

Copyright © 2017-2020
<a href="https://fkun.tech/" target="_blank">FKUN </a> All Rights Reserved.
</div>
</body>


</html>