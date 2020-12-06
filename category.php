<?php
include_once("header.php");
?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<script language="JavaScript">
    function checkpost() {
        if (myform.category.value == "") {
            alert("请输入类别名称");
            window.location = 'add.php';
            return false;
        }
    }
</script>
<?php
if ($_GET["Submit"]) {
    $sql = "select * from ".$prename."category where categoryname='$_GET[categoryname]' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    $attitle = is_array($row = mysqli_fetch_array($query));
    if ($attitle) {
        $status_text = "类别已存在！";
    } else {
        $sql = "insert into ".$prename."category (categoryname, ufid) values ('$_GET[categoryname]', $_SESSION[uid])";
        $query = mysqli_query($conn,$sql);
        if ($query) {
            $status_text = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=category.php'>";
        } else {
            $status_text = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=category.php'>";
        }
    }
}
?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　添加分类   (例如 食物)</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="myform" name="form2" method="get" onsubmit="return checkpost();">
               分类名称：<input name="categoryname" type="text" id="categoryname" />
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
        <td bgcolor="#EBEBEB">　分类管理</td>
    </tr>
</table>

<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

    <tr>
        <th align="left" bgcolor="#EBEBEB">分类名称</th>
        <th align="left" bgcolor="#EBEBEB">操作</th>
    </tr>
    <?php
    $sql = "select * from ".$prename."category where ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row['categoryname']."</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><a href='edit_category.php?type=1&categoryid=".$row['categoryid']."'>修改</a> <a href='edit_category.php?type=2&categoryid=".$row['categoryid']."'>转移</a> <a href='edit_category.php?type=3&categoryid=".$row['categoryid']."'>删除</a></td>";
    }
    echo "</tr>";
    ?>
</table>


<?php
include_once("footer.php");
?>