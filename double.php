<?php
include_once("header.php");
?>


<div style="width:auto;height:100vh;">
<div style="width:100%;float:left;margin-left: 0%;position:relative;">
<div style="min-width:825px;">
<table  align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left;border:solid 1px;" class='table table-striped table-bordered'>
<tr>
            <td colspan='16' align='center' bgcolor='#FFFFFF'>
                <font>复式记账 Double Entry Bookkeeping</font>
            </td>
</tr>
<tr>
            <td colspan='6' align='center' bgcolor='#FFFFFF'>
                <font>资产 Assets</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>负债 Liabilities</font>
            <td colspan='6'align='center' bgcolor='#FFFFFF'>
                <font>所有者权益 Owner's Equity</font>
            </td>
 </tr>
 <tr>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>现金</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>设备</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>贷款</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>所有者资本</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>收入</font>
            </td>
 </tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
 <tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font>欧元</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>
                <?php
//cash debit
        $sql = "select sum(acamount) as total,ac2 from " . $prename . "account where " . $prename . "account.ac2 =1 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac2";
        $query = mysqli_query($conn, $sql);
        $c1 = mysqli_fetch_array($query);
        $total1 = $c1['total'];
        if (isset($total1)) {
            $eurecashdebit = $total1;
        } else {
        }
echo $eurecashdebit;
?>
                </font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>

                <?php
//cash credit
        $sql = "select sum(acamount) as total,ac2 from " . $prename . "account where " . $prename . "account.ac2 =2 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac2";
        $query = mysqli_query($conn, $sql);
        $c2 = mysqli_fetch_array($query);
        $total2 = $c2['total'];
        if (isset($total2)) {
            $eurecashcredit = $total2;
        } else {
            $eurecashcredit = "0";
        }
echo $eurecashcredit;
?>
                </font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>器材</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
 </tr>
 <tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font>人民币</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>

  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>


 </tr>  
 <tr>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>非现金</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>投资</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>应付账款</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>支出</font>
            </td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>撤资</font>
            </td>
 </tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
 <tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font>Sparkasse</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>BTC</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>生活开销</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
 </tr>
 <tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font>工行</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>FLOW</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>娱乐</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
 </tr>
 <tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font>微信</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>API3
                </font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>其他</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
 </tr>
 <tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font>其他</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>其他</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
 </tr>
 <tr>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>预付租金</font>
            </td>
            <td colspan='3'>
</td>

</td>
            <td colspan='3' align='center' bgcolor='#FFFFFF'>
                <font>预付账款</font>
            </td>
            <td colspan='6' align='center' bgcolor='#FFFFFF'>
</td>
 </tr>
 <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>

  <td colspan='3' bgcolor='#FFFFFF'>  <font></font></td>

  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Debit</font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>Credit</font>
  </td>
  <td colspan='6' bgcolor='#FFFFFF'></td>

 <tr>
            <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
            </td>
            <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td colspan='3'>
</td>
  <td align='center' bgcolor='#FFFFFF'>
                <font>暂无</font>
            </td>
            <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td align='center' bgcolor='#FFFFFF'>
                <font></font>
  </td>
  <td colspan='6' bgcolor='#FFFFFF'></td>
 </tr>
</table>




    </div>
</div>
<div style="float:left;position:relative;">
    <table border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left; width:80px;" class='table table-striped table-bordered'>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>剩余资金</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>活动资金</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>当前日期</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>计划日期</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>计划预算</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>已经存活</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>预计存活</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>距离计划</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>计划剩余</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>固定开销</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>常务开销</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>推荐每月</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>推荐周常</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>本周实际</font>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#FFFFFF'>
                <font>饮食系数</font>
            </td>
        </tr>
    </table>
</div>

<div style="width:auto;float:left;margin-left: -1px;position:relative;">
    <table width='60px' border='0' align='left' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>

        <?php

        if ($_GET['enddate'] == "") {
            $enddate = date("Y-8-31");
        } else {
            $enddate = $_GET['enddate'];
        }

        $now = date('Y-m-d');
        $sqltime = " " . $prename . "account.actime <" . strtotime($now . " 23:59:59");

        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        $s1 = array();
        while ($ac1 = mysqli_fetch_array($query)) {
            $total1 = $ac1['total'];
            $s1[$ac1['ac1']] = $total;
        }
        $ns = $total1;

        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account  where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $s2 = array();
        $query = mysqli_query($conn, $sql);
        while ($ac1 = mysqli_fetch_array($query)) {
            $total2 = $ac1['total'];
        }

        $nf = $total2;

        if ($ns == "") {
            $ns = "0";
        }
        if ($nf == "") {
            $nf = "0";
        }

        $yz = $ns - $nf;


        //上周支出

        $lastmon =  date('Y-m-d', strtotime('-1 monday', time())); //无论今天几号,-1 monday为上一个有效周未
        $sqlweek = " " . $prename . "account.actime >=" . strtotime($lastmon . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($now . "23:59:59");
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqlweek . " and acuserid='$_SESSION[uid]' and ac0='0' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        while ($rowwf = mysqli_fetch_array($query)) {
            $total = $rowwf['total'];
        }

        $wf = $total;

        if ($wf == "") {
            $wf = "0";
        }


        //计划支出
        $sqlplan = "select sum(planamount) as total FROM " . $prename . "plan where ufid='$_SESSION[uid]' ";

        $planquery = mysqli_query($conn, $sqlplan);
        while ($planamount = mysqli_fetch_array($planquery)) {
            $plantotal = $planamount['total'];
        }
        if ($plantotal == 0) {
            $plantotal == "0";
        }else{
            $plantotal = $plantotal;
        }
        $usable = $yz - $plantotal;

        //基础支出
        $sqlbase = "select sum(baseamount) as total FROM " . $prename . "base where ufid='$_SESSION[uid]' ";

        $basequery = mysqli_query($conn, $sqlbase);
        while ($baseamount = mysqli_fetch_array($basequery)) {
            $basetotal = $baseamount['total'];
        }

        $base = $basetotal;
        if ($base == 0) {
            $base == "0";
        }
        //常务
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1=2 and " . $sqltime . " and acuserid='$_SESSION[uid]' and ac0='0' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        while ($rowgnf = mysqli_fetch_array($query)) {
            $total = $rowgnf['total'];
        }
        $gnf = $total;

        //本月已支付固定开销

        $monthstart =  date('Y-m-01');
        $sqlmon = " " . $prename . "account.actime >=" . strtotime($monthstart . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($now . " 23:59:59");
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqlmon . " and acuserid='$_SESSION[uid]' and ac0='1' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        while ($rowmgf = mysqli_fetch_array($query)) {
            $totaled = $rowmgf['total'];
        }

        $mgf = $totaled;

        if ($mgf == "") {
            $mgf = "0";
        }



        $datesql = "select * from " . $prename . "date where ufid='" . $_SESSION['uid'] . "'and datetype='0'";
        $dateresult = mysqli_query($conn, $datesql);
        $dateinfo = mysqli_fetch_array($dateresult);
        $getdate = $dateinfo['date'];
        $enddate = date('Y-m-d', $getdate);


        $datebacksql = "select * from " . $prename . "date where ufid='" . $_SESSION['uid'] . "'and datetype='1'";
        $datebackresult = mysqli_query($conn, $datebacksql);
        $datebackinfo = mysqli_fetch_array($datebackresult);
        $dateback = $datebackinfo['date'];


        $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
        $first = mysqli_fetch_array($firstquery);
        $firsttime = $first['actime'];
        $firstdate = date("Y-m-d", $firsttime);

        $mknow = time();
        $verpass = (round(($mknow - $firsttime) / '3600' / '24'));

        $toplan = round(($getdate - $mknow) / '3600' / '24');
        $toplanmonth =  round($toplan / '30');
        $basemonth = (($toplanmonth + '1') * ($base) - ($mgf));

        if ($verpass - $dateback == 0) {
            $nomalpday = 0;
        } else {
            $nomalpday = round(($gnf / ($verpass - $dateback)), 2);
        }

        $remain = round((($usable - ($basemonth))) - (($toplan) * $nomalpday), 2);

        if ((($base / '30') + $nomalpday) == 0) {
            $canbealive = 0;
        } else {
            $canbealive = round(($usable) / (($base / '30') + $nomalpday));
        }
        if ($toplan > "0") {
            $planpday = ($plantotal / $toplan);
        } else {
            $planpday = "0";
        }
        $suggest = round((('30' * ($nomalpday)) + $base), 2);
        $suggestpw = round(('7' * ($nomalpday)), 2);

        if ($remain < "0") {
            $remaincolor =  "'#FF4542'";
        } elseif ($remain < "300") {
            $remaincolor =  "'#5398F7'";
        } else {
            $remaincolor =  "'MediumSeaGreen'";
        }


        if ($canbealive < ($toplan + '15')) {
            $alivecolor =  "'#FF4542'";
        } else {
            $alivecolor =  "'MediumSeaGreen'";
        }


        if ($wf < ($suggestpw)) {
            $weekcolor =  "'MediumSeaGreen'";
            $weektext =  " (良好)";
        } elseif ($wf < ($suggestpw + '15')) {
            $weekcolor =  "'#ECB930'";
            $weektext =  " (注意)";
        } else {
            $weekcolor =  "'#FF4542'";
            $weektext =  " (超标)";
        }

        $sql = "select * from " . $prename . "account where ac1=2 and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $spending = $spending + $row['acamount'];
        }

        //多用户适配！！
        $sql = "select * from " . $prename . "account where accategory=2 and ac1=2 and acuserid='$_SESSION[uid]' ORDER BY actime ASC";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $foodspending = $foodspending + $row['acamount'];
        }
        
        if ($spending > "0") {
            $foodpct = 100 * round(($foodspending / $spending), 5);
        } else {
            $foodpct = 0;
        }


        if($toplan < 0){
            $disptoplan = "0";
            $disptoplanmonth = "0";
        }else{
            $disptoplan = $toplan;
            $disptoplanmonth = $toplanmonth;
        }
       
        echo "
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $yz . "</font><font>  " . $Currency . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $usable . "</font><font>  " . $Currency . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $now . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $enddate . "</font><font><a href='plan.php'>  修改</a></font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $plantotal . " </font><font>" . $Currency . "<a href='plan.php'>  修改</a></font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $verpass . "</font><font>  天</font><font>(离开" . $dateback . " 天)</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFf'><font color=" . $alivecolor . ">" . $canbealive . "</font><font>  天</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $disptoplan . "</font><font>  天（</font><font>" . $disptoplanmonth . "</font><font>  个月）</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color=" . $remaincolor . ">" . $remain . "</font><font>  " . $Currency . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font >" . $base . "</font><font>  " . $Currency . "/月</font><font><a href='plan.php'>  修改</a></font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $nomalpday . "</font><font>  " . $Currency . "/日</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $suggest . "</font><font>  " . $Currency . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $suggestpw . "</font><font>  " . $Currency . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color=" . $weekcolor . ">" . $wf . "  " . $Currency . "<font color=" . $weekcolor . ">" . $weektext . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $foodpct . "</font><font>% </font></td></tr>
";

        session_start();
        $_SESSION['suggestpw'] = $suggestpw;
        ?>
</table>
</div>

</div>


<?php
include_once("footer.php");
?>