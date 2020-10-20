
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<?php
session_start();
?>
<?php
if (isset($_GET['tj']) AND $_GET['tj'] == 'logout') {
    session_start();
    //开启session

    unset($_SESSION['user_shell']);
    //session_destroy();  //注销session
    header("location:index.php");
    //跳转到首页
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">

    <!-- 包含头部信息用于适应不同设备 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 包含 bootstrap 样式表 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	 <link rel="shortcut icon" href="https://fkun.tech/favicon.ico">
    <title>FKUN记账系统</title>

</head>

<body>
    <?php
    include("config.php");
    $arr = user_shell($_SESSION['uid'],$_SESSION['user_shell']);
    //对权限进行判断
    ?>
    <div style="max-width:100vw;width:auto;margin-left: auto;margin-right: auto;padding:5px;">
        <div class="table-responsive">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#example-navbar-collapse">
                            <span class="sr-only">菜单</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="add.php">记账</a>
                    </div>
                    <div class="collapse navbar-collapse" id="example-navbar-collapse">
                        <ul class="nav navbar-nav">
                             
                            <li><a href="annual_stat.php">统计</a></li>
							<li><a href="prediction.php">状态</a></li>
							<li><a href="food.php">饮食</a></li>
							<li><a href="plan.php">计划</a></li>

							<li><a href="category.php">分类</a></li>
							<li><a href="payway.php">方式</a></li>
                            <li><a href="search.php">导出</a></li>
                            <li><a href="edit.php">总览</a></li>
                            <li><a href="users.php"><?php echo"账号：";
                                echo $arr['username'];
                                ?></a></li>
                            <li><a href="logout.php">登出</a></li>
                            <?php //index.php?tj=logout ?>

                        </ul>
                    </div>
                </div>
            </nav>