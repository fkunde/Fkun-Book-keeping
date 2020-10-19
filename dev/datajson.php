<?php
session_start();
?>
<?php
if ($_GET['tj'] == 'logout') {
    session_start();
    //开启session

    unset($_SESSION['user_shell']);
    //session_destroy();  //注销session
    header("location:index.php");
    //跳转到首页
}
?>
    <?php
    include("config.php");
    $arr = user_shell($_SESSION['uid'], $_SESSION['user_shell']);
    //对权限进行判断
    ?>

<?php
header("content-type:text/json;charset=utf-8");
$con = mysqli_connect("localhost", "finance", "19980322Feng!");
if (!$con) {
    die('Could not connect database: ');
}
$db_selected = mysqli_select_db($con, "Billsys");
if (!$db_selected) {
    die("Can\'t use yxz : ");
}
mysqli_query($con, "SET CHARACTER SET utf8");
$sql = mysqli_query($con, "SELECT * FROM `Finance_account` where acuserid='$_SESSION[uid]'");
$arr = array();
while ($row = mysqli_fetch_array($sql)) {
    $count = count($row); //不能在循环语句中，由于每次删除 row数组长度都减小
    for ($i = 0; $i < $count; $i++) {
        unset($row[$i]); //删除冗余数据
    }
    array_push($arr, $row);
}
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
mysqli_close($con);
?>
