<?php
include_once("header.php");
?>

<?php
$income = 0;
$spending = 0;
?>
<script type="text/javascript">
    function GetCurrentStyle(obj, prop) {
        if (obj.currentStyle) {
            return obj.currentStyle[prop];
        } else if (window.getComputedStyle) {
            return window.getComputedStyle(obj, null)[prop];
        }
        return null;
    }
    window.onload = function() {
        var show = document.getElementById("show");
        var hide = document.getElementById("hide");
        var bt = document.getElementById("btn");
        bt.onclick = function(evt) {
            if (GetCurrentStyle(hide, "display") == "none") {
                hide.style.display = "block";
                bt.value = "隐藏";
            } else {
                hide.style.display = "none";
                bt.value = "显示导入格式";
            }
            var e = evt || window.event;
            window.event?e.cancelBubble = true: e.stopPropagation();
        }
        document.onclick = function() {
            hide.style.display = "none";
            bt.value = "显示导入格式";
        }
    }
</script>
<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">　导出导入</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="addform" action="export.php?action=import" method="post" enctype="multipart/form-data">
                <input type="button" id="btn" value="显示导入格式" class="btn btn-default"><br /><br />
                <div id="hide" style="display:none">
                    用文本复制以下内容保存为csv后缀名<br />
                    或excel导出csv格式文件，格式必须如下：<br /><br />
                    日期,交易对象,分类,交易类型,备注,位置,支付方式,金额,特殊消费<br />
                    2015-11-30 05:15,IKEA,一般支出,家具,JÜLICH,233.33,0<br />
                    2015-11-30 05:15,IKEA,一般支出,备注,JÜLICH,233.33,2<br /><br />
                </div>
                <p>
                    请选择要导入的CSV文件：<br /><br />
                    <input type="file" name="file"><br /><br /><input type="submit" class="btn btn-default" value="导入CSV"><br /><br />
                    <input type="button" class="btn btn-default" id="exportCSV" value="导出全部记账CSV" onClick="window.location.href='export.php?action=export'">
                </p>
            </form>
        </form>
    </td>
</tr>

</table>


<table align="center" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" class='table table-striped table-bordered'>
<tr>
<td align="left" valign="middle" bgcolor="#EBEBEB" style="color: #666666;">注意：按查询导出推荐使用Chrome、Firefox、Safari</td>
</tr>
</table>

<script language="javascript">
var daochu = (function() {
var uri = 'data:application/vnd.ms-excel;base64,', template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv=Content-Type content="text/html; charset=utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><style> .xl24{mso-style-parent:style0;font-size:10.0pt;text-align:center;border:.5pt solid windowtext;white-space:normal;}.xl25{mso-style-parent:style0;font-size:10.0pt;text-align:center;border-top:.5pt solid windowtext;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl26{mso-style-parent:style0;font-size:10.0pt;mso-number-format:"Short Date";text-align:center;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:.5pt solid windowtext;white-space:normal;}.xl27{mso-style-parent:style0;font-size:10.0pt;text-align:center;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl28{mso-style-parent:style0;font-size:10.0pt;text-align:left;width:200pt;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl29{mso-style-parent:style0;font-size:10.0pt;text-align:center;width:54pt;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;}.xl30{mso-style-parent:style0;font-size:10.0pt;text-align:center;width:96pt;border-top:none;border-right:.5pt solid windowtext;border-bottom:.5pt solid windowtext;border-left:none;white-space:normal;} </style></head><body><table>{table}</table></body></html>', base64 = function(s) {
return window.btoa(unescape(encodeURIComponent(s)))
}, format = function(s, c) {
return s.replace(/{(\w+)}/g, function(m, p) {
return c[p];
})
}
return function(table, name) {
if (!table.nodeType) table = document.getElementById(table)
var ctx = {
worksheet: name || 'Worksheet', table: table.innerHTML
}
window.location.href = uri + base64(format(template, ctx))
}
})()
</script>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
<tr>
<td bgcolor="#EBEBEB">　按查询导出</td>
</tr>
<tr>
<td bgcolor="#FFFFFF">
<form id="form1" name="form1" method="post" action="">
收支选择：
<select name="classid" id="classid" style="height:26px;">
<option value="quan">全部</option>
<!-- <option value="sr">收入--</option> -->
                    <?php
                    $sqlshouru = "select * from ".$prename."account_class where ufid='$_SESSION[uid]' and classtype='1'";
					
                    $queryshouru = mysqli_query($conn,$sqlshouru);
                    while ($rowshouru = mysqli_fetch_array($queryshouru)) {
                        echo "<option value='$rowshouru[classid]'>$rowshouru[classname]</option>";
                    }
                    ?>
                    <!-- <option value="zc">支出--</option> -->
                    <?php
                    $sqlzhichu = "select * from ".$prename."account_class where ufid='$_SESSION[uid]' and classtype='2'";
                    $queryzhichu = mysqli_query($conn,$sqlzhichu);
                    while ($rowzhichu = mysqli_fetch_array($queryzhichu)) {
                        echo "<option value='$rowzhichu[classid]'>$rowzhichu[classname]</option>";
                    }
                    ?>
</select><br /><br />
日期：从 <input type="date" name="time1" id="time1" style="height:26px;width:115px;" /> 到 <input type="date" name="time2" id="time2" style="height:23px;width:115px;" />
<br /><br />
备注：<input type="text" name="beizhu" id="beizhu" /> 留空则输出全部，或输入金额范围格式：1-100，支持小数点。 <br /><br />

<input type="submit" name="Submit" value="查询" class="btn btn-default" /><br /><br />

<input type="submit" name="Submitfanwei" value="点这里查询金额范围" class="btn btn-default" /><br /><br />


</form>
</td>
</tr>

</table>


<?php if ($_POST['Submit']) {
$a = "%";
$b = $_POST['beizhu'];
$c = $a.$b.$a;
//只查询备注
if ($_POST['classid'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {

$sql = "select * from ".$prename."account where acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
//什么都没填
if ($_POST['classid'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
$sql = "select * from ".$prename."account where acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
//只查询分类
if ($_POST['classid']<>"quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
$sqlclassid = "acclassid=".$_POST['classid'];
$sql = "select * from ".$prename."account where ".$sqlclassid." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}

//只查询分类收
if ($_POST['classid'] == "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {

$sql = "select * from ".$prename."account where actype='2' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
if ($_POST['classid'] == "sr" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {

$sql = "select * from ".$prename."account where actype='1' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
//只查询分类支

//只查询日期
if ($_POST['classid'] == "quan" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");
$sql = "select * from ".$prename."account where ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "quan" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");
$sql = "select * from ".$prename."account where ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//------------------------------
//查询分类，日期，备注
if ($_POST['classid']<>"" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {

$sqlclassid = "acclassid=".$_POST['classid'];
$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where ".$sqlclassid." and ".$sqltime." and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//----------------------------------------
//查询收支，备注
if ($_POST['classid'] == "sr" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {
$type = "1";
$sql = "select * from ".$prename."account where actype='$type' and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
if ($_POST['classid'] == "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {
$type = "2";



$sql = "select * from ".$prename."account where actype='$type' and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}

//查询收支，日期
if ($_POST['classid'] == "sr" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {
$type = "1";

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "zc" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {
$type = "2";

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//查询收支，日期，备注
if ($_POST['classid'] == "sr" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {
$type = "1";


$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "zc" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {
$type = "2";


$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}

//查询日期，备注
if ($_POST['classid'] == "quan" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where ".$sqltime." and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}


//--------------------------------------
//查询分类，备注
if ($_POST['classid']<>"quan" && $_POST['classid']<>"sr" && $_POST['classid']<>"zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {

$sqlclassid = "acclassid=".$_POST['classid'];

$sql = "select * from ".$prename."account where ".$sqlclassid." and acremark like '$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}

//查询分类，日期
if ($_POST['classid']<>"quan" && $_POST['classid']<>"sr" && $_POST['classid']<>"zc" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {

$sqlclassid = "acclassid=".$_POST['classid'];
$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where ".$sqlclassid." and ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}


echo "
				<table align='left' width='100%' height='20' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
  <tr>
  <td align='left' bgcolor='#EBEBEB'>　查询结果&nbsp;<font id='stat'></font>　　<input type='button' onclick='daochu(excel)' value='导出搜索结果为xls excel文件' class='btn btn-default'></td>
  </tr>
</table>

 <table id='excel' class='table table-striped' width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
                <tr>
                <th width='120' class=xl24 bgcolor='#EBEBEB'>时间</th>
                <th width='50' class=xl25 bgcolor='#EBEBEB'>交易对象</th>
                <th width='90' class=xl25 bgcolor='#EBEBEB'>分类</th>
                <th width='150' class=xl25 bgcolor='#EBEBEB'>交易类型</th>
                <th width='60' class=xl25 bgcolor='#EBEBEB'>备注</th>
                <th width='60' class=xl25 bgcolor='#EBEBEB'>位置</th>
				<th width='60' class=xl25 bgcolor='#EBEBEB'>支付方式</th>
				<th width='60' class=xl25 bgcolor='#EBEBEB'>金额</th>
				</tr>                                                                 
				";                                                                        
                                                                                          
                                                                                          
$query = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query)) {
$sql = "select * from ".$prename."account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
$classquery = mysqli_query($conn,$sql);
$classinfo = mysqli_fetch_array($classquery);
$sqlpay = "select * from ".$prename."account_payway where payid=$row[acpayway] and ufid='$_SESSION[uid]'";
$payquery = mysqli_query($conn,$sqlpay);
$payinfo = mysqli_fetch_array($payquery);
$sqlcategory = "select * from ".$prename."category where categoryid=$row[actype] and ufid='$_SESSION[uid]'";
$categoryquery = mysqli_query($conn,$sqlcategory);
$categoryinfo = mysqli_fetch_array($categoryquery);
echo "<tr>";
if ($classinfo['classtype'] == 1) {
echo "<td align='left' class='xl26' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".date("Y-m-d",$row['actime'])."</font></td>";
echo "<td align='left' class='xl29' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acname'] . "</font></td>";
echo "<td align='left' class='xl27' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $categoryinfo['categoryname'] . "</font></td>";
echo "<td align='left' class='xl30' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $classinfo['classname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acremark'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acplace'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $payinfo['paywayname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acamount'] . "</font></td>";
$income = $income+$row['acamount'];
} else {
echo "<td align='left' class='xl26' bgcolor='#FFFFFF'><font color='red'>".date("Y-m-d",$row['actime'])."</font></td>";
echo "<td align='left' class='xl29' bgcolor='#FFFFFF'><font color='red'>" . $row['acname'] . "</font></td>";
echo "<td align='left' class='xl27' bgcolor='#FFFFFF'><font color='red'>" . $categoryinfo['categoryname'] . "</font></td>";
echo "<td align='left' class='xl30' bgcolor='#FFFFFF'><font color='red'>" . $classinfo['classname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $row['acremark'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $row['acplace'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $payinfo['paywayname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $row['acamount'] . "</font></td>";

$spending = $spending+$row['acamount'];
}
echo "</tr>";
}
echo "</table>";





}
?>


<!--以上是查询备注 -->




<?php if ($_POST['Submitfanwei']) {
if ($_POST['beizhu']<>"") {
$b = $_POST['beizhu'];
$str = trim($b);
if (empty($str)) {
return '';
}
$temp = array('1','2','3','4','5','6','7','8','9','0','.');
$mumList = array();
$result = '';
$maxNum = 0;
for ($i = 0;$i < strlen($str);$i++) {
if (in_array($str[$i],$temp)) {

if (is_numeric($str[$i])) {
$result.= $str[$i];
}
if ($str[$i] == '.' && is_numeric($str[$i-1]) && is_numeric($str[$i-1])) {
$result.= $str[$i];
}
if (($i+1) == strlen($str)) {

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
//只查询金额
if ($_POST['classid'] == "quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {

$sql = "select * from ".$prename."account where acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
//查询分类，日期，金额
if ($_POST['classid']<>"" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {

$sqlclassid = "acclassid=".$_POST['classid'];
$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where ".$sqlclassid." and ".$sqltime." and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//----------------------------------------
//查询收支，金额
if ($_POST['classid'] == "sr" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {
$type = "1";



$sql = "select * from ".$prename."account where actype='$type' and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {
$type = "2";



$sql = "select * from ".$prename."account where actype='$type' and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//查询收支，日期，金额
if ($_POST['classid'] == "sr" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {
$type = "1";

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "zc" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {
$type = "2";

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}

//查询日期，金额
if ($_POST['classid'] == "quan" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu']<>"") {

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where ".$sqltime." and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}


//--------------------------------------
//查询分类，金额
if ($_POST['classid']<>"quan" && $_POST['classid']<>"sr" && $_POST['classid']<>"zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu']<>"") {

$sqlclassid = "acclassid=".$_POST['classid'];

$sql = "select * from ".$prename."account where ".$sqlclassid." and acamount>'$a' and acamount<'$c' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//只查询分类
if ($_POST['classid']<>"quan" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {
$sqlclassid = "acclassid=".$_POST['classid'];
$sql = "select * from ".$prename."account where ".$sqlclassid." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}

//只查询分类收
if ($_POST['classid'] == "zc" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {

$sql = "select * from ".$prename."account where actype='2' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
if ($_POST['classid'] == "sr" && $_POST['time1'] == "" && $_POST['time2'] == "" && $_POST['beizhu'] == "") {

$sql = "select * from ".$prename."account where actype='1' and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
}
//只查询分类支

//只查询日期
if ($_POST['classid'] == "quan" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");
$sql = "select * from ".$prename."account where ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "quan" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");
$sql = "select * from ".$prename."account where ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
//------------------------------

//查询收支，日期
if ($_POST['classid'] == "sr" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {
$type = "1";

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}
if ($_POST['classid'] == "zc" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {
$type = "2";

$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where actype='$type' and ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}

//查询分类，日期
if ($_POST['classid']<>"quan" && $_POST['classid']<>"sr" && $_POST['classid']<>"zc" && $_POST['time1']<>"" && $_POST['time2']<>"" && $_POST['beizhu'] == "") {

$sqlclassid = "acclassid=".$_POST['classid'];
$sqltime = " actime >".strtotime($_POST['time1']." 0:0:0")." and actime <".strtotime($_POST['time2']." 23:59:59");

$sql = "select * from ".$prename."account where ".$sqlclassid." and ".$sqltime." and acuserid='$_SESSION[uid]' ORDER BY actime ASC";

}


echo "
				<table align='left' width='100%' height='20' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' class='table table-striped table-bordered'>
  <tr>
  <td align='left' bgcolor='#EBEBEB'>　查询结果&nbsp;<font id='stat'></font>　　<input type='button' onclick='daochu(excel)' value='导出搜索结果为xls excel文件' class='btn btn-default'></td>
  </tr>
</table>

 <table id='excel' class='table table-striped' width='100%' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
                <tr>
                <th width='120' class=xl24 bgcolor='#EBEBEB'>时间</th>
                <th width='50' class=xl25 bgcolor='#EBEBEB'>交易对象</th>
                <th width='90' class=xl25 bgcolor='#EBEBEB'>分类</th>
                <th width='150' class=xl25 bgcolor='#EBEBEB'>交易类型</th>
                <th width='60' class=xl25 bgcolor='#EBEBEB'>备注</th>
                <th width='60' class=xl25 bgcolor='#EBEBEB'>位置</th>
				<th width='60' class=xl25 bgcolor='#EBEBEB'>支付方式</th>
				<th width='60' class=xl25 bgcolor='#EBEBEB'>金额</th>
				<th width='60' class=xl25 bgcolor='#EBEBEB'>操作</th>
                </tr>
				";


$query = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query)) {
$sql = "select * from ".$prename."account_class where classid= $row[acclassid] and ufid='$_SESSION[uid]'";
$classquery = mysqli_query($conn,$sql);
$classinfo = mysqli_fetch_array($classquery);
echo "<tr>";
if ($classinfo['classtype'] == 1) {
echo "<td align='left' class='xl26' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>".date("Y-m-d",$row['actime'])."</font></td>";
echo "<td align='left' class='xl29' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acname'] . "</font></td>";
echo "<td align='left' class='xl27' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $categoryinfo['categoryname'] . "</font></td>";
echo "<td align='left' class='xl30' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $classinfo['classname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acremark'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acplace'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $payinfo['paywayname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['acamount'] . "</font></td>";
$income = $income+$row['acamount'];
} else {
echo "<td align='left' class='xl26' bgcolor='#FFFFFF'><font color='red'>".date("Y-m-d",$row['actime'])."</font></td>";
echo "<td align='left' class='xl29' bgcolor='#FFFFFF'><font color='red'>" . $row['acname'] . "</font></td>";
echo "<td align='left' class='xl27' bgcolor='#FFFFFF'><font color='red'>" . $categoryinfo['categoryname'] . "</font></td>";
echo "<td align='left' class='xl30' bgcolor='#FFFFFF'><font color='red'>" . $classinfo['classname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $row['acremark'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $row['acplace'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $payinfo['paywayname'] . "</font></td>";
echo "<td align='left' class='xl28' bgcolor='#FFFFFF'><font color='red'>" . $row['acamount'] . "</font></td>";
$spending = $spending+$row['acamount'];
}
echo "</tr>";
}
echo "</table>";




}
}
?>
</div>
<script language="javascript">
document.getElementById("stat").innerHTML = "<?='总共收入<font color=blue> '.$income.'</font> 总共支出 <font color=red>'.$spending.'</font>' ?>"
</script>

<?php
include_once("footer.php");
?>