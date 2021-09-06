<?php
include_once("header.php");
?>
<script language="JavaScript">
    function checkpost() {
        if (myform.money.value == "") {
            alert("请输入金额");
            window.location = 'add.php';
            return false;
        }
        if (myform.classid.value == "") {
            alert("请添加分类");
            window.location = 'classify.php';
            return false;
        }
        if (myform.time.value == "") {
            alert("请选择日期");
            window.location = 'add.php';
            return false;
        }
    }

    function checkpost2() {

        if (myform2.money.value == "") {
            alert("请请输入金额");
            window.location = 'add.php';
            return false;
        }
        if (myform2.classid.value == "") {
            alert("请添加分类");
            window.location = 'classify.php';
            return false;
        }
        if (myform2.time.value == "") {
            alert("请选择日期");
            window.location = 'add.php';
            return false;
        }
    }
</script>

<?php
$income = 0;
$spending = 0;
//检查是否记账并执行
if (isset($_POST['Submit'])) {
    $time100 = strtotime($_POST['time']);
    $sql = "insert into " . $prename . "account (acamount, acclassid, actime, acremark, accategory, acuserid, acplace, acpayway, acname, ac0, ac1, ac2) values ('$_POST[money]', '$_POST[classid]', '$time100', '$_POST[remark]', '$_POST[category]', '$_SESSION[uid]', '$_POST[place]', '$_POST[payway]', '$_POST[name]', '$_POST[special]', '$_POST[classid]', '')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $prompttext = "<font color='#009900'>记录成功！</font>";
        header("Location:add.php");
        //跳转到add.php防止手动刷新重复提交
    } else {
        $prompttext = "<font color='red'>写入数据库时出错！</font>";
    }
}
if (isset($time100)) {
   // echo $time100;
}
if (isset($sql)) {
    //echo $sql;
}

?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" class='table table-striped table-bordered'>
    <tr >
        <td bgcolor="#e8e8e8">账目内容</td>
        <!-- <td bgcolor="#e8e8e8">记账内容 （目前依然为beta测试版，遇到BUG欢迎在<span><a href="https://bbs.fkun.tech/">论坛bbs.fkun.tech</a></span>或<span><a href="https://blog.fkun.tech/">博客blog.fkun.tech</a></span>中留言反馈。）</td> -->
    </tr>
    <tr>
        <td bgcolor="#e8e8e8">
            <form id="form2" name="myform2" method="post" onsubmit="return checkpost2();">
                <font> 账目金额: </font><input name="money" type="text" id="money" size="8" />
                <div style="display:none;">

                </div>
                <!-- <font> €</font> -->

                <br /><br />

                <font> 账目分类: </font><select name="category" id="categoryid" style="height:26px;">
                    <?php
                    $sql = "select * from " . $prename . "category where ufid='$_SESSION[uid]'";
                    $query = mysqli_query($conn, $sql);
                    while ($accategory = mysqli_fetch_array($query)) {
                        echo "<option value='$accategory[categoryid]'>$accategory[categoryname]</option>";
                    }

                    ?>
                </select>
                <font color="red"><a href="category.php" style="color:#7f7f7f;">管理类别</a></font>

                <br /><br />

                <font> 支付方式: </font><select name="payway" id="payid" style="height:26px;">
                    <?php
                    $sql = "select * from " . $prename . "account_payway where ufid='$_SESSION[uid]'";
                    $query = mysqli_query($conn, $sql);

                    while ($acpayway = mysqli_fetch_array($query)) {

                        echo "<option value='$acpayway[payid]'>$acpayway[paywayname]</option>";
                    }

                    ?>
                </select>
                <font color="red"><a href="payway.php" style="color:#7f7f7f;">管理支付方式</a></font>
                <br /><br /> 账目名称: 
                <input name="name" type="text" id="name" />
                <br /><br /> 交易地点: 
                <input name="place" type="text" id="place" />
                <br /><br /> 账目备注: 
                <input name="remark" type="text" id="remark" />
                <br /><br />
              
                交易时间: <input type="text" name="time" id="time" class="Calender" value="<?php $addnow = date("Y-m-d H:i:s");
                echo "$addnow";?>"></input>
                <script src="js/laydate/laydate.js"></script> 
                <script>
                //执行一个laydate实例
                laydate.render({
                  elem: '.Calender' //指定元素
                  ,type: 'datetime'
                  ,theme: '#39C5BB'
                });
                </script>
                <br /><br />
                <font> 收支类型: </font><select name="classid" id="classid" style="height:26px;">
                    <option value='2'>支出</option>
                    <option value='1'>收入</option>
                </select>
                <font color="red"><a href="classify.php" style="color:#7f7f7f;"></a></font>
                <br /><br /> 特殊消费: 
                <select name="special" id="special" style="height:26px;">
                    <option value='0'>否</option>
                    <option value='1'>周期消费</option>
                    <option value='2'>偶然消费</option>
                </select>
                <input name="Submit" type="submit" id="submit" value="记账" style=" 
			            background-color: #4CAF50;
                        border: none;
                        color: white;
						width: 100px;
                        height: 50px;
                        position: absolute;
                        margin-left: 25px;
                        margin-top: -30px;
                        padding: 12px 20px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
						border-radius: 8px;
                        font-size: 18px;" />

            </form>
        </td>
    </tr>

    </div>

</table>



<?php

//每页显示的数
$pagesize = 20;
//确定页数 p 参数
$p = isset($_POST['p']) ? $_POST['p'] : 1;
//数据指针
$offset = ($p - 1) * $pagesize;

//查询本页显示的数据
$query_sql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' ORDER BY actime DESC LIMIT  $offset , $pagesize";
$query = mysqli_query($conn, $query_sql);

echo "<table width='100%' border='1' align='left' cellpadding='8' cellspacing='1' bgcolor='#696969' class='table table-striped table-bordered'>
                <tr>
				<th bgcolor='#EBEBEB'>时间</th>
				<th bgcolor='#EBEBEB'>交易对象</th>
				<th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>收支</th>
                <th bgcolor='#EBEBEB'>备注</th>
				<th bgcolor='#EBEBEB'>交易位置</th>
				<th bgcolor='#EBEBEB'>资金账户</th>
				<th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>操作</th>
                </tr>";

if ($result = FALSE) {
    die();
}

while ($row = mysqli_fetch_array($query)) {

    $sqlpay = "select * from " . $prename . "account_payway where payid=$row[acpayway] and ufid='$_SESSION[uid]'";
    $payquery = mysqli_query($conn, $sqlpay);
    $payinfo = mysqli_fetch_array($payquery);

    $sqlcategory = "select * from " . $prename . "category where categoryid=$row[accategory] and ufid='$_SESSION[uid]'";
    $categoryquery = mysqli_query($conn, $sqlcategory);
    $categoryinfo = mysqli_fetch_array($categoryquery);

    echo "<tr>";
    if ($row['ac1'] == "1") {
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . date("Y-m-d", $row['actime']) . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $categoryinfo['categoryname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>";
        if ($row['ac1'] == "1") {
            echo "收入";
        } else {
            echo "支出";
        }
        echo "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acremark'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acplace'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $payinfo['paywayname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acamount'] . "</font></td>";
    } elseif ($row['ac0'] == "1") {
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . date("Y-m-d", $row['actime']) . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $categoryinfo['categoryname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>";
        if ($row['ac1'] == "1") {
            echo "收入";
        } else {
            echo "支出";
        }
        echo "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acremark'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acplace'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $payinfo['paywayname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acamount'] . "</font></td>";
    } elseif ($row['ac0'] == "2") {
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . date("Y-m-d", $row['actime']) . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $categoryinfo['categoryname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>";
        if ($row['ac1'] == "1") {
            echo "收入";
        } else {
            echo "支出";
        }
        echo "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acremark'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acplace'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $payinfo['paywayname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acamount'] . "</font></td>";
    } else {
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . date("Y-m-d", $row['actime']) . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $categoryinfo['categoryname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>";
        if ($row['ac1'] == "1") {
            echo "收入";
        } else {
            echo "支出";
        }
        echo "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acremark'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acplace'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $payinfo['paywayname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acamount'] . "</font></td>";
    }
    echo "<td align='left' bgcolor='#FFFFFF'><a href=edit.php?id=" . $row['acid'] . ">编辑</a> <a href=delete.php?id=" . $row['acid'] . ">删除</a></td>";
    echo "</tr>";
}
echo "</table>";


echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr><td align='left' bgcolor='#FFFFFF'>";

//分页代码
//计算总数
$count_result = mysqli_query($conn, "SELECT count(*) as count FROM " . $prename . "account where acuserid='$_SESSION[uid]'");
$count_array = mysqli_fetch_array($count_result);
echo "
<table align='left' width='100%' height='20' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td align='left' bgcolor='#EBEBEB'>
            <font id='stat'></font>
        </td>
    </tr>
</table>";
//计算总的页数
$pagenum = ceil($count_array['count'] / $pagesize);
echo '共记 ', $count_array['count'], ' 条 ';
// echo ' 这里最多显示最近 ', $pagesize, ' 条';

//循环输出各页数目及连接

/*if ($pagenum > 1) {
    for($i=1;$i<=$pagenum;$i++) {
        if($i==$p) {
            echo ' [',$i,']';
        } else {
            echo ' <a href="add.php?p=',$i,'">',$i,'</a>';
        }
    }
}*/
echo "</td></tr></table>";

?>


<?php

$query = mysqli_query($conn, $sql);

    $sql = "select SUM(acamount) as income from " . $prename . "account where ac1='1' and acuserid='$_SESSION[uid]'";
    $classquery = mysqli_query($conn, $sql);
    $classinfo = mysqli_fetch_array($classquery);
    $income = $classinfo['income'];
    $sql = "select SUM(acamount) as spend from " . $prename . "account where ac1='2' and acuserid='$_SESSION[uid]'";
    $classquery2 = mysqli_query($conn, $sql);
    $classinfo2 = mysqli_fetch_array($classquery2);
    $spending = $classinfo2['spend'];
?>

<script language="javascript">
    document.getElementById("stat").innerHTML = "<?= '总共收入<font color=MediumSeaGreen> ' . $income . '</font> 总共支出 <font color=red>' . $spending . '</font>' ?>"
</script>
<?php
include_once("footer.php");
?>