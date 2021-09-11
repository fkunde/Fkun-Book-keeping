<?php
include_once("header.php");
?>

<script type="text/javascript">
    var checkall = document.getElementsByName("del_id[]");

    function select() {
        //全选
        for (var $i = 0; $i < checkall.length; $i++) {
            checkall[$i].checked = true;
        }
    }

    function fanselect() {
        //反选
        for (var $i = 0; $i < checkall.length; $i++) {
            if (checkall[$i].checked) {
                checkall[$i].checked = false;
            } else {
                checkall[$i].checked = true;
            }
        }
    }

    function noselect() {
        //全不选
        for (var $i = 0; $i < checkall.length; $i++) {
            checkall[$i].checked = false;
        }
    }
</script>

<script>
    window.onload = function() {
        var oTxt1 = document.getElementById('zhuan');
        var oBtn1 = document.getElementById('zhuan1');
        oBtn1.onclick = function() {
            location.href = "edit.php?p=" + oTxt1.value + "";
        }
    }
</script>


<!-- 记住选择页js <script language="javascript" type="text/javascript">
    function save() {
        selectIndex = document.getElementById("tiao").selectedIndex;
        document.cookie = 'selectIndex =' + selectIndex;
    }
    window.onload = function () {
        var cooki = document.cookie;
        if (cooki != "") {
            cooki = "{\"" + cooki + "\"}";
            cooki = cooki.replace(/\s*/g, "").replace(/=/g, '":"').replace(/;/g, '","');
            var json = eval("(" + cooki + ")"); //将coolies转成json对象
            document.getElementById("tiao").options[json.selectIndex].selected = true;
        }
        else
            save();
    }
</script> -->


<?php

if ($_GET['ok']) {

    //针对$ok被激活后的处理：
    $sqltime = strtotime("$_GET[time]");
    $sql = "update " . $prename . "account set acamount='" . $_GET['amount'] . "',acplace='" . $_GET['place'] . "',accategory='" . $_GET['accategory'] . "',acpayway='" . $_GET['acpayway'] . "',acname='" . $_GET['name'] . "',acremark='" . $_GET['beizhu'] . "',ac0='" . $_GET['ac0'] . "',actime='" . $sqltime . "' where acid='" . $_GET['id'] . "' and acuserid='" . $_SESSION['uid'] . "'";
    $result = mysqli_query($conn, $sql);
    if ($result)
        echo ("<script type='text/javascript'>alert('修改成功！');history.go(-2);</script>");
    else
        echo ("<script type='text/javascript'>alert('修改失败！');history.go(-2);</script>");
} else {
    if ($_GET['id']) {
        $sql = "select * from " . $prename . "account where acid='" . $_GET['id'] . "' and acuserid='" . $_SESSION['uid'] . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $sql2 = "select * from " . $prename . "category where categoryid= '" . $row['accategoryid'] . "' and ufid='" . $_SESSION['uid'] . "'";
        $categoryquery = mysqli_query($conn, $sql2);
        $categoryinfo = mysqli_fetch_array($categoryquery, MYSQLI_ASSOC);

        echo "<table align='left' width='100%' border='0' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
      <tr>
        <td bgcolor='#EBEBEB'>　账目修改</td>
      </tr>
      <tr>
        <td bgcolor='#FFFFFF'>
   <form method=get action=''>
<INPUT TYPE='hidden' name='id' value=" . $row['acid'] . ">
        账目金额: <input type=text name='amount' value=" . $row['acamount'] . "><br /><br />";

        echo "账目分类: <select name='accategory'>";

        $sqlold = "select * from " . $prename . "category where categoryid=" . $row['accategory'] . " and ufid='" . $_SESSION['uid'] . "'";
        $queryold = mysqli_query($conn, $sqlold);
        $rowold = mysqli_fetch_array($queryold);

        echo "<option value=" . $rowold['categoryid'] . ">" . $rowold['categoryname'] . "</option>";

        $sqlcategory = "select * from " . $prename . "category where ufid='" . $_SESSION['uid'] . "'";
        $categoryquery = mysqli_query($conn, $sqlcategory);
        while ($categoryname = mysqli_fetch_array($categoryquery)) {
            echo " <option value=" . $categoryname['categoryid'] . ">" . $categoryname['categoryname'] . "</option>";
        }
        echo "</select><br /><br />";
        echo "支付方式: <select name='acpayway'>";

        $sqlold = "select * from " . $prename . "account_payway where payid=" . $row['acpayway'] . " and ufid='" . $_SESSION['uid'] . "'";
        $queryold = mysqli_query($conn, $sqlold);
        $rowold = mysqli_fetch_array($queryold);
        echo "<option value=" . $rowold['payid'] . ">" . $rowold['paywayname'] . "</option>";

        $sqlpayway = "select * from " . $prename . "account_payway where ufid='" . $_SESSION['uid'] . "'";
        $paywayquery = mysqli_query($conn, $sqlpayway);
        while ($paywayinfo = mysqli_fetch_array($paywayquery)) {
            echo " <option value=" . $paywayinfo['payid'] . ">" . $paywayinfo['paywayname'] . "</option>";
        }
        echo "</select><br /><br />";
        echo "
        账目名称: <input type=text name='name' value=" . $row['acname'] . "><br /><br />
        交易时间: <input rows='1' cols='20' name='time' class='Calender' value='" . date('Y-m-d H:i', $row['actime']) . "'> 
        <script src='js/laydate/laydate.js'></script> 
        <script>
        //执行一个laydate实例
        laydate.render({
          elem: '.Calender' //指定元素
          ,type: 'datetime'
          ,theme: '#39C5BB'
        });
        </script>
        <br /><br />
        交易地点: <input type=text name='place' value=" . $row['acplace'] . "><br /><br />
        账目备注: <input type=text name='beizhu' value=" . $row['acremark'] . "><br /><br />
        特殊消费: 
         <select name='ac0' id='ac0' style='height:26px;'>
            <option value=" . $row['ac0'] . ">
            ";
        if ($row['ac0'] == "0") {
            echo "否";
        } elseif ($row['ac0'] == "1") {
            echo "周期消费";
        } elseif ($row['ac0'] == "2") {
            echo "偶然消费";
        }else{
            echo "金融交易";
        }
        echo "
            </option>
            <option value='0'>否</option>
            <option value='1'>周期消费</option> 
            <option value='2'>偶然消费</option> 
            <option value='3'>金融交易</option> 	
             </select>	
 <br /><br />            
 收入/支出: ";
 if ($row['ac1'] == '1') {
     echo '收入';
     $income = $income + $row['acamount'];
 } else {
     echo '支出';
     $spending = $spending + $row['acamount'];
 }
 echo "<br /><br />
 



　<input type=submit name=ok value='提交' class='btn btn-default'>
   </form>		</td>
      </tr>
    </table>";
    }
}
?>


<?php

if ($_POST['Submit']) {
    echo "";
} else {
    if ($conn) {
        mysqli_select_db($conn, "jizhang");
        if (!$_GET['id']) {
            //$result = mysqli_query($conn,"select * from jizhang");

            //每页显示的数
            $pagesize = 50;

            //确定页数 p 参数
            $p = $_GET['p'] ? $_GET['p'] : 1;

            //数据指针
            $offset = ($p - 1) * $pagesize;

            //查询本页显示的数据
            $query_sql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' ORDER BY actime DESC LIMIT  $offset , $pagesize";

            $query = mysqli_query($conn, $query_sql);


            //echo $query_sql;

            echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                <tr>
                <th bgcolor='#EBEBEB'>时间</th>
				<th bgcolor='#EBEBEB'>交易对象</th>
				<th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>交易类型</th>
                <th bgcolor='#EBEBEB'>备注</th>
				<th bgcolor='#EBEBEB'>位置</th>
				<th bgcolor='#EBEBEB'>支付方式</th>
				<th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>操作</th>
                </tr>";
            if ($result === FALSE) {
                die();

                // TODO: better error handling
                // <th bgcolor='#EBEBEB'><form action='delete.php' method='post'><a href='javascript:select()'>全选</a> | <a href='javascript:fanselect()'>反选</a> | <a href='javascript:noselect()'>不选</a> <input type='submit' name='delete' value='删除'/></th>

            }

            while ($row = mysqli_fetch_array($query)) {

                $sqlpay = "select * from " . $prename . "account_payway where payid=$row[acpayway] and ufid='$_SESSION[uid]'";
                $payquery = mysqli_query($conn, $sqlpay);
                $payinfo = mysqli_fetch_array($payquery);

                $sqlcategory = "select * from " . $prename . "category where categoryid=$row[accategory] and ufid='$_SESSION[uid]'";
                $categoryquery = mysqli_query($conn, $sqlcategory);
                $categoryname = mysqli_fetch_array($categoryquery);
                echo "<tr>";
                if ($row['ac1'] == 1) {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . date("Y-m-d", $row['actime']) . "</font></td>";
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acname'] . "</font></td>";
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $categoryname['categoryname'] . "</font></td>";
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
                } elseif ($row['ac0'] == '1') {
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . date("Y-m-d", $row['actime']) . "</font></td>";
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acname'] . "</font></td>";
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $categoryname['categoryname'] . "</font></td>";
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
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $categoryname['categoryname'] . "</font></td>";
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
                    echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $categoryname['categoryname'] . "</font></td>";
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

            //计算总数
            $count_result = mysqli_query($conn, "SELECT count(*) as count FROM " . $prename . "account where acuserid='$_SESSION[uid]'");
            $count_array = mysqli_fetch_array($count_result);

            //计算总的页数
            $pagenum = ceil($count_array['count'] / $pagesize);
            echo "<ul class='pagination'>";
            echo '<li class="disabled"><a href="#">共', $count_array['count'], '条 <span id="total" style="display:none">', $pagenum, '</span></a></li>';
            //后面共几页

            if ($pagenum > 1) {
                for ($i = 1; $i < $pagenum; $i++) {
                    if ($i == $p) {
                        echo "<span id='pagingText' style='display:none'>$i</span>";
                    }
                }
            }

            /* echo "<select name='tiao' id='tiao' style='height:18px' onchange='self.location.href=options[selectedIndex].value;onchange=save()'>";
echo "<option value='edit.php?p=1'>跳转</option>";
if ($pagenum > 1) {
    for($i=1;$i<=$pagenum;$i++) {
            echo "<option value='edit.php?p=$i'>$i</option>";
    }
}
echo "</select>"; */

            //循环输出各页数目及连接	echo ' <a href="edit.php?p=',$i-1,'">上一页</a>';

            //echo " <li><a href='edit.php?p=1'>首页</a></li>";
            //echo "<li><a href='edit.php?p=$pagenum'>尾页</a></li>";
            if ($pagenum > 1) {
                for ($i = 1; $i <= $pagenum; $i++) {
                    if ($i == $p) {
                        if ($i != 1) {
                            echo '<li><a href="edit.php?p=', $i - 1, '">&laquo;</a></li>';
                        }
                    }
                }
            }

            if ($pagenum > 1) {
                for ($i = 1; $i < $pagenum; $i++) {
                    if ($i == $p) {
                        echo '<li><a href="edit.php?p=', $i + 1, '">&raquo;</a></li>';
                    }
                }
            }

            echo "</ul>";
            echo "<ul class='pagination' id='pagingDiv'><ul/>";
            echo "</td>";
            // echo "<td align='right' width='10%' bgcolor='#FFFFFF'><input type='text' name='zhuan' id='zhuan' style='width:35px'/> <input type='submit' name='go' id='go' value='go' /></td>"; //跳转页面


            echo "</form>";
            echo "</table>";
            /*echo "<table width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>";
		echo "<tr><td align='left' bgcolor='#FFFFFF'><ul class='pagination' id='pagingDiv'><ul/></td></tr>";
		echo "</table>"; */
        }
    }
    //显示列表的内容

}
?>

<script language="javascript">
    //首先获取当前的总页数，一般是后台传递过来的，这里假定40页。
    var total = document.getElementById("total").innerHTML;
    //id="pagingDiv"的div通过pagingConstruct函数构造，比如加载网页是第1页的
    var url = window.location.href;
    var index = +url.substring(url.lastIndexOf('=') + 1);
    if (index > 0) {
        pagingConstruct(index);
    } else {
        pagingConstruct(1);
    }

    //形式参数paging是指当前页
    function pagingConstruct(paging) {
        //先更新一下行内文本
        document.getElementById("pagingText").innerHTML = paging;
        var pagingDivInnerHTML = "";
        //这里是加载省略号的flag
        var isHiddenExist = 0;
        //从第1页读到第40页。
        for (var i = 1; i <= total; i++) {
            //如果读到当前页，就仅仅加载一个文本，不放链接
            if (i == paging) {
                pagingDivInnerHTML += "<li class='active'><a href='#'>" + i + "</a></li>";
            } else {
                //如果是页首，中间页，页尾，当前页的前后三页则不省略。
                //if (i < 4 || i < (paging + 3) && i > (paging - 3)|| i > (total / 2 - 2) && i < (total / 2 + 2) || i > (total - 1)) {
                if (i < 2 || i < (paging + 4) && i > (paging - 4) || i > (total - 1)) {
                    pagingDivInnerHTML += "<li><a href='edit.php?p=" + i + "' onclick='pagingConstruct(" + i + ")'>" + i + "</a></li>";
                    isHiddenExist = 0;
                }
                //否则就构造...
                else {
                    if (isHiddenExist == 0) {
                        pagingDivInnerHTML += ""; //引号里面放这个<li><a href='#'>...</a></li>显示...
                        isHiddenExist = 1;
                    }
                }
            }
        }
        //把构造的内容放上去pagingDiv
        document.getElementById("pagingDiv").innerHTML = pagingDivInnerHTML;
    }
</script>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　查询修改</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="form1" name="form1" method="post" action="">
                选择分类：
                <select name="accategory" id="accategory" style="height:26px;">
                <option value='quan'>ALL</option>

                    <?php
                    $sqlcategory = "select * from " . $prename . "category where ufid='$_SESSION[uid]'";
                    $querycategory = mysqli_query($conn, $sqlcategory);
                    while ($rowcategory = mysqli_fetch_array($querycategory)) {
                        echo "<option value='$rowcategory[categoryid]'>$rowcategory[categoryname]</option>";
                    }

                    ?>

                </select><br /><br />
                日期：从 <input type="date" name="time1" id="time1" style="height:26px;width:115px;" /> 到 <input type="date" name="time2" id="time2" style="height:23px;width:115px;" />
                <br /><br />
                备注：<input type="text" name="beizhu" id="beizhu" /> 留空则输出全部，或输入金额范围格式：1-100，支持小数点。<br /><br />

                <input type="submit" name="Submit" value="查询" class="btn btn-default" /><br /><br />
                <input type="submit" name="Submitfanwei" value="点这里查询金额范围" class="btn btn-default" /><br /><br />

            </form>
        </td>
    </tr>

</table>


<?php if ($_POST['Submit']) {
    $a = "%";
    $b = $_POST['beizhu'];
    $c = $a . $b . $a;
    //只查询备注
    if ($_POST['accategory'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] <> "") {

        $sql = "select * from " . $prename . "account where acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }
    //什么都没填
    if ($_POST['accategory'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
        $sql = "select * from " . $prename . "account where acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }
    //只查询分类
    if ($_POST['accategory'] <> "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
        $sqlcategory = "accategory=" . $_POST['accategory'];
        $sql = "select * from " . $prename . "account where " . $sqlcategory . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }

    //只查询日期
    if ($_POST['accategory'] == "quan" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {

        $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");
        $sql = "select * from " . $prename . "account where " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }
    //------------------------------
    //查询分类，日期，备注
    if ($_POST['accategory'] <> "" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] <> "") {

        $sqlcategory = "accategory=" . $_POST['accategory'];
        $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

        $sql = "select * from " . $prename . "account where " . $sqlcategory . " and " . $sqltime . " and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }


    //查询日期，备注
    if ($_POST['categoryid'] == "quan" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] <> "") {

        $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

        $sql = "select * from " . $prename . "account where " . $sqltime . " and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }


    //--------------------------------------
    //查询分类，备注
    if ($_POST['accategory'] <> "quan" && $_POST['accategory'] <> "sr" && $_POST['accategory'] <> "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] <> "") {

        $sqlcategory = "accategory=" . $_POST['accategory'];

        $sql = "select * from " . $prename . "account where " . $sqlcategory . " and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }

    //查询分类，日期
    if ($_POST['accategory'] <> "quan" && $_POST['accategory'] <> "sr" && $_POST['accategory'] <> "zc" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {

        $sqlcategory = "accategory=" . $_POST['accategory'];
        $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

        $sql = "select * from " . $prename . "account where " . $sqlcategory . " and " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
    }


    echo "
				<table align='left' width='100%' height='20' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
  <tr>
  <td align='left' bgcolor='#EBEBEB'>　查询结果&nbsp;<font id='stat'></font></td>
  </tr>
</table>
<form action='delete.php' method='post'>
 <table id='excel' class='table table-striped' width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
                <tr>
                <th bgcolor='#EBEBEB'>时间</th>
				<th bgcolor='#EBEBEB'>交易对象</th>
				<th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>交易类型</th>
                <th bgcolor='#EBEBEB'>备注</th>
				<th bgcolor='#EBEBEB'>位置</th>
				<th bgcolor='#EBEBEB'>支付方式</th>
				<th bgcolor='#EBEBEB'>金额</th>
                <th bgcolor='#EBEBEB'>操作</th>
				<th bgcolor='#EBEBEB'><a href='javascript:select()'>全选</a> | <a href='javascript:fanselect()'>反选</a> | <a href='javascript:noselect()'>不选</a> <input type='submit' name='delete' value='删除'/></th>
                </tr>
				";


    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $sqlcategory = "select * from " . $prename . "category where categoryid=$row[accategory] and ufid='$_SESSION[uid]'";
        $categoryquery = mysqli_query($conn, $sqlcategory);
        $categoryname = mysqli_fetch_array($categoryquery);

        echo "<tr>";
        if ($row['ac1'] == '1' && $row['ac0'] !== '1') {
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . date("Y-m-d", $row['actime']) . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $categoryname['categoryname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acremark'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acplace'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $payinfo['paywayname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acamount'] . "</font></td>";
        } elseif ($row['ac0'] == '1') {
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . date("Y-m-d", $row['actime']) . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $categoryname['categoryname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acremark'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acplace'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $payinfo['paywayname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acamount'] . "</font></td>";
        } elseif ($row['ac0'] == "2") {
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . date("Y-m-d", $row['actime']) . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $categoryname['categoryname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acremark'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acplace'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $payinfo['paywayname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='#E3AB20'>" . $row['acamount'] . "</font></td>";
        } else {
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . date("Y-m-d", $row['actime']) . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $categoryname['categoryname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acremark'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acplace'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $payinfo['paywayname'] . "</font></td>";
            echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acamount'] . "</font></td>";
        }
        echo "<td align='left' bgcolor='#FFFFFF'><a href=edit.php?id=" . $row['acid'] . ">编辑</a> <a href=delete.php?id=" . $row['acid'] . ">删除</a>
				<input name='del_id[]' type='checkbox' id='del_id[]' value=" . $row['acid'] . " /></td>";
        echo "</tr>";
    }
    echo "</table></form>
				";
}
?>

<?php if ($_POST['Submitfanwei']) {
    if ($_POST['beizhu'] <> "") {
        $b = $_POST['beizhu'];
        $str = trim($b);
        if (empty($str)) {
            return '';
        }
        $temp = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '.');
        $mumList = array();
        $result = '';
        $maxNum = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if (in_array($str[$i], $temp)) {

                if (is_numeric($str[$i])) {
                    $result .= $str[$i];
                }
                if ($str[$i] == '.' && is_numeric($str[$i - 1]) && is_numeric($str[$i - 1])) {
                    $result .= $str[$i];
                }
                if (($i + 1) == strlen($str)) {

                    if ($maxNum == 0 || $maxNum < $result) {
                        $maxNum = $result;
                    }

                    $mumList[] = $result;
                    $result = '';
                }
            } else {
                if ($maxNum == 0 || $maxNum < $result) {
                    $maxNum = $result;
                }
                $mumList[] = $result;
                $result = '';
            }
        }
        $mumList = array_values(array_filter($mumList));
        $a = $mumList[0];
        $c = $mumList[1];
        //只查询备注
        if ($_POST['accategory'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] <> "") {

            $sql = "select * from " . $prename . "account where acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        //什么都没填
        if ($_POST['accategory'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
            $sql = "select * from " . $prename . "account where acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        //只查询分类
        if ($_POST['accategory'] <> "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
            $sqlcategory = "accategory=" . $_POST['categoryid'];
            $sql = "select * from " . $prename . "account where " . $sqlcategory . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }

        //只查询分类收
        if ($_POST['accategory'] == "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {

            $sql = "select * from " . $prename . "account where ac0='0' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        if ($_POST['accategory'] == "sr" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {

            $sql = "select * from " . $prename . "account where ac0>'0' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        //只查询分类支

        //只查询日期
        if ($_POST['accategory'] == "quan" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");
            $sql = "select * from " . $prename . "account where " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        if ($_POST['accategory'] == "quan" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");
            $sql = "select * from " . $prename . "account where " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        //------------------------------
        //查询分类，日期，备注
        if ($_POST['accategory'] <> "" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] <> "") {

            $sqlcategory = "accategory=" . $_POST['accategory'];
            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where " . $sqlcategory . " and " . $sqltime . " and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        //----------------------------------------
        //查询收支，备注
        if ($_POST['accategory'] == "sr" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] <> "") {
            $type = "0";


            $sql = "select * from " . $prename . "account where ac0='$type' and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        if ($_POST['accategory'] == "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] <> "") {
            $type != "0";


            $sql = "select * from " . $prename . "account where ac0='$type' and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }

        //查询收支，日期
        if ($_POST['accategory'] == "sr" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {
            $type = "0";

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where ac0='$type' and " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        if ($_POST['accategory'] == "zc" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {
            $type != "0";

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where ac0='$type' and " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        //查询收支，日期，备注
        if ($_POST['accategory'] == "sr" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] <> "") {
            $type = "0";

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where ac0='$type' and " . $sqltime . " and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }
        if ($_POST['accategory'] == "zc" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] <> "") {
            $type != "0";

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where ac0='$type' and " . $sqltime . " and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }

        //查询日期，备注
        if ($_POST['accategory'] == "quan" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] <> "") {

            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where " . $sqltime . " and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }


        //--------------------------------------
        //查询分类，备注
        if ($_POST['accategory'] <> "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] <> "") {

            $sqlcategory = "accategory=" . $_POST['accategory'];

            $sql = "select * from " . $prename . "account where " . $sqlcategory . " and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }

        //查询分类，日期
        if ($_POST['accategory'] <> "quan" && $_POST['time1'] <> "" && $_POST['time2'] <> "" && $_POST['beizhu'] == "") {

            $sqlcategory = "accategory=" . $_POST['accategory'];
            $sqltime = " actime >" . strtotime($_POST['time1'] . " 0:0:0") . " and actime <" . strtotime($_POST['time2'] . " 23:59:59");

            $sql = "select * from " . $prename . "account where " . $sqlcategory . " and " . $sqltime . " and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        }


        echo "
				<table align='left' width='100%' height='20' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
  <tr>
  <td align='left' bgcolor='#EBEBEB'>　查询结果&nbsp;<font id='stat'></font></td>
  </tr>
</table>
<form action='delete.php' method='post'>
 <table id='excel' class='table table-striped' width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
                <tr>
				<th bgcolor='#EBEBEB'>时间</th>
				<th bgcolor='#EBEBEB'>交易对象</th>
				<th bgcolor='#EBEBEB'>分类</th>
                <th bgcolor='#EBEBEB'>备注</th>
				<th bgcolor='#EBEBEB'>位置</th>
				<th bgcolor='#EBEBEB'>支付方式</th>
				<th bgcolor='#EBEBEB'>金额</th>
				<th bgcolor='#EBEBEB'><a href='javascript:select()'>全选</a> | <a href='javascript:fanselect()'>反选</a> | <a href='javascript:noselect()'>不选</a> <input type='submit' name='delete' value='删除'/></th>
                </tr>
                ";

        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $sqlpay = "select * from " . $prename . "account_payway where payid=$row[acpayway] and ufid='$_SESSION[uid]'";
            $payquery = mysqli_query($conn, $sqlpay);
            $sqlcategory = "select * from " . $prename . "category where categoryid=$row[accategory] and ufid='$_SESSION[uid]'";
            $categoryquery = mysqli_query($conn, $sqlcategory);
            $payinfo = mysqli_fetch_array($payquery);
            $categoryname = mysqli_fetch_array($categoryquery);
            echo "<tr>";
            if ($row['ac1'] == '1' && $row['ac0'] !== '1') {
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . date("Y-m-d", $row['actime']) . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $categoryname['categoryname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acremark'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acplace'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $payinfo['paywayname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acamount'] . "</font></td>";
            } elseif ($row['ac0'] !== '0') {
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . date("Y-m-d", $row['actime']) . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $categoryname['categoryname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acremark'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acplace'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $payinfo['paywayname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='#308AF7'>" . $row['acamount'] . "</font></td>";
            } else {
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . date("Y-m-d", $row['actime']) . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $categoryname['categoryname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acremark'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acplace'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $payinfo['paywayname'] . "</font></td>";
                echo "<td align='left' bgcolor='#FFFFFF'><font color='red'>" . $row['acamount'] . "</font></td>";
            }
            echo "<td align='left' bgcolor='#FFFFFF'><a href=edit.php?id=" . $row['acid'] . ">编辑</a> <a href=delete.php?id=" . $row['acid'] . ">删除</a>
				<input name='del_id[]' type='checkbox' id='del_id[]' value=" . $row['acid'] . " /></td>";
            echo "</tr>";
        }
        echo "</table></form>
				";
    }
}
?>
</div>


<script language="javascript">
    document.getElementById("stat").innerHTML = "<?= '总共收入<font color=blue> ' . $income . '</font> 总共支出 <font color=red>' . $spending . '</font>' ?>"
</script>



<?php
include_once("footer.php");
?>