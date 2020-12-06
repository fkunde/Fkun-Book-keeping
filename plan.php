<?php
include_once("header.php");
?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<script language="JavaScript">
    function checkpost() {
        if (myform.plan.value == "") {
            alert("请输入预算名称");
            window.location = 'add.php';
            return false;
        }
    }
</script>

<script language="JavaScript">
    function checkpost() {
        if (myform3.base.value == "") {
            alert("请输入基础开销名称");
            window.location = 'add.php';
            return false;
        }
    }
</script>


<?php
if ($_GET['ok']) {
$setdate = strtotime("$_GET[timedate]");
 $sql = "update ".$prename."date set date='".$setdate."' where ufid='".$_SESSION['uid']."' and datetype='0'";
 $result = mysqli_query($conn,$sql);
    if ($result)
        echo("<script type='text/javascript'>alert('修改成功！');history.go(-1);</script>");
    else
        echo("<script type='text/javascript'>alert('修改失败！');history.go(-1);</script>");
} else {
        $sqlget = "select * from ".$prename."date where ufid='".$_SESSION['uid']."'";
        $resultget = mysqli_query($conn,$sqlget);
        $rowget = mysqli_fetch_array($resultget);
            echo"
			 <form method=get action=''>

			计划目标日期：<input rows='1' cols='20' name='timedate' class='sang_Calender' value='".date('Y-m-d H:i',$rowget['date'])."'> 
		<input type=submit name=ok value='提交' class='btn'>	
		</form>
		<br />
		
		";
	}
?>

<?php
if ($_GET['okdate2']) {
 $sql = "update ".$prename."date set date='$_GET[timedate2]' where ufid='".$_SESSION['uid']."' and datetype='1'";
 $result = mysqli_query($conn,$sql);
    if ($result)
        echo("<script type='text/javascript'>alert('修改成功！');history.go(-1);</script>");
    else
        echo("<script type='text/javascript'>alert('修改失败！');history.go(-1);</script>");
} else {
        $sqlget2 = "select * from ".$prename."date where ufid='".$_SESSION['uid']."' and datetype='1'";
        $resultget2 = mysqli_query($conn,$sqlget2);
        $rowget2 = mysqli_fetch_array($resultget2);
            echo"
			 <form method=get action=''>
			中断时长：<input name='timedate2' size='3' value='".$rowget2['date']."'>天
		     <input type=submit name=okdate2 value='提交' class='btn'>	
		
		</form>
		<br />
		
		";
	}
?>

<?php
if ($_GET["Submit"]) {
    $sql = "select * from ".$prename."plan where plan='$_GET[plan]' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    $attitle = is_array($row = mysqli_fetch_array($query));
    if ($attitle) {
        $status_text = "此预算已存在！";
    } else {
        $sql = "insert into ".$prename."plan (plan, ufid, planamount) values ('$_GET[plan]', $_SESSION[uid], '$_GET[planamount]')";
        $query = mysqli_query($conn,$sql);
        if ($query) {
            $status_text = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=plan.php'>";
        } else {
            $status_text = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=plan.php'>";
        }
    }
}
?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　添加普通预算  (例如大额消费计划)</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="myform" name="form2" method="get" onsubmit="return checkpost();">
               预算名称：<input name="plan" type="text" id="plan" />
                <br /><br />
				预算金额：<input name="planamount" type="text" id="planamount" />
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
        <td bgcolor="#EBEBEB">预算管理</td>
    </tr>
</table>

<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

    <tr>
        <th align="left" bgcolor="#EBEBEB">预算名称</th>
		
		<th align="left" bgcolor="#EBEBEB">预算金额</th>

        <th align="left" bgcolor="#EBEBEB">操作</th>
    </tr>
    <?php
    $sql = "select * from ".$prename."plan where ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row['plan']."</font></td>";
		echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row['planamount']."</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><a href='edit_plan.php?type=1&planid=".$row['planid']."'>修改</a> <a href='edit_plan.php?type=3&planid=".$row['planid']."'>删除</a></td></tr>";
    }
    echo "</tr>";
    ?>
</table>



<!-- 固定开销 -->
<?php
if ($_GET["Submit2"]) {
    $sql = "select * from ".$prename."base where base='$_GET[base]' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    $attitle = is_array($row = mysqli_fetch_array($query));
    if ($attitle) {
        $status_text2 = "此固定开销已存在！";
    } else {
        $sql = "insert into ".$prename."base (base, ufid, baseamount) values ('$_GET[base]', $_SESSION[uid], '$_GET[baseamount]')";
        $query = mysqli_query($conn,$sql);
        if ($query) {
            $status_text2 = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=plan.php'>";
        } else {
            $status_text2 = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=plan.php'>";
        }
    }
}
?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　添加每月基础开销  (例如房租)</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="myform2" name="form3" method="get" onsubmit="return checkpost();">
               基础开销名称：<input name="base" type="text" id="base" />
                <br /><br />
				基础开销金额：<input name="baseamount" type="text" id="baseamount" />
                <br /><br />



                <input type="submit" name="Submit2" value="新建" class="btn" />
                <?php echo $status_text2;
                ?>
            </form>
        </td>
    </tr>
</table>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　基础开销管理</td>
    </tr>
</table>

<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

    <tr>
        <th align="left" bgcolor="#EBEBEB">基础开销名称</th>
		
		<th align="left" bgcolor="#EBEBEB">基础开销金额</th>

        <th align="left" bgcolor="#EBEBEB">操作</th>
    </tr>
    <?php
    $sql = "select * from ".$prename."base where ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row['base']."</font></td>";
		echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".$row['baseamount']."</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><a href='edit_base.php?type=1&baseid=".$row['baseid']."'>修改</a> <a href='edit_base.php?type=3&baseid=".$row['baseid']."'>删除</a></td></tr>";
    }
    echo "</tr>";
    ?>
</table>


<?php
include_once("footer.php");
?>