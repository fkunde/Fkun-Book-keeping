<?php
include_once("header.php");
?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<script language="JavaScript">
    function checkpost() {
        if (myform.payway.value == "") {
            alert("请输入交易方式名称");
            window.location = 'add.php';
            return false;
        }
    }
</script>
<?php
if ($_GET["Submit"]) {
    $sql = "select * from ".$prename."account_payway where paywayname='$_GET[paywayname]' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    $attitle = is_array($row = mysqli_fetch_array($query));
    if ($attitle) {
        $status_text = "交易方式已存在！";
    } else {
        $sql = "insert into ".$prename."account_payway (paywayname, ufid) values ('$_GET[paywayname]', $_SESSION[uid])";
        $query = mysqli_query($conn,$sql);
        if ($query) {
            $status_text = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=payway.php'>";
        } else {
            $status_text = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=payway.php'>";
        }
    }
}
?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　添加交易方式  (例如 现金)</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="myform" name="form2" method="get" onsubmit="return checkpost();">
               交易方式名称：<input name="paywayname" type="text" id="paywayname" />
                <br /><br />



                <input type="submit" name="Submit" value="新建" class="btn btn-default" />
                <?php echo $status_text;
                ?>
            </form>
        </td>
    </tr>
</table>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　交易方式管理</td>
    </tr>
</table>

<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

    <tr>
        <th align="left" bgcolor="#EBEBEB">交易方式名称</th>
        <th align="left" bgcolor="#EBEBEB">操作</th>
    </tr>
    <?php
    $sql = "select * from ".$prename."account_payway where ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row['paywayname']."</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><a href='edit_payway.php?type=1&payid=".$row['payid']."'>修改</a> <a href='edit_payway.php?type=2&payid=".$row['payid']."'>转移</a> <a href='edit_payway.php?type=3&payid=".$row['payid']."'>删除</a></td>";
    }
    echo "</tr>";
    ?>
</table>


<?php
include_once("footer.php");
?>