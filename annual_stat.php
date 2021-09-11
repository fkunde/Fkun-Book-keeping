<?php
include_once("header.php");
?>

<head>
    <script src="./js/echarts.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
</head>

<body>
    <div style="width:7vw;float:left;margin-left:0.5vw;margin-top:0.5vw;">
        <table id="excel" width='60%' border='0' align='left' cellpadding='3' bgcolor='#B3B3B3' style="float:left;" class='table table-striped table-bordered' position="absolute">
            <tr>
                <th bgcolor='#EBEBEB'>
                    <form id="form" name="form1" method="post" action="">
                        <select name="year" id="year" onchange="window.location.href='annual_stat.php?year='+this.value;options[selectedIndex].value;onchange=save()">

                            <?php
                            $sql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                            $query = mysqli_query($conn, $sql);
                            $first = mysqli_fetch_array($query);
                            $acyear = $first['actime'];
                            $billyear = date("Y", $acyear);
                            $thisyear = date("Y");
                            echo "<option value='$thisyear'>" . date('Y') . "</option>";
                            for ($billyear; $billyear < $thisyear; $billyear++) {
                                echo "<option value='$billyear'>$billyear</option>";
                            }
                            ?>
                        </select>
                    </form>
                </th>
            </tr>


            <?php

            echo "
			<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>月收入</font></td></tr>
            <tr><td align='left' bgcolor='#FFFFFF'><font color='red'>月支出</font></td></tr>
            <tr><td align='left' bgcolor='#FFFFFF'><font>结余</font></td></tr>
			<tr><td align='left' bgcolor='#FFFFFF'><font>累计支出</font></td></tr>
			<tr><td align='left' bgcolor='#FFFFFF'><font>特殊支出</font></td></tr>
			<tr><td align='left' bgcolor='#FFFFFF'><font>常规支出</font></td></tr>
			<tr><td align='left' bgcolor='#FFFFFF'><font>常务日均</font></td></tr>
			<tr><td align='left' bgcolor='#FFFFFF'><font>综合日均</font></td></tr>
			";
            ?>
        </table>
    </div>

    <?php
    if ($_GET['year'] == "") {
        $thisyear = date("Y");
    } else {
        $thisyear = $_GET['year'];
    }

    $startdate1 = "$thisyear-01-01";
    $enddate1 = "$thisyear-01-31";
    $daysinmonth1 = 31;
    $gatsuname1 = 'JAN';

    $startdate2 = "$thisyear-02-01";
    $enddate2 = "$thisyear-02-28";
    $daysinmonth2 = 28;
    $gatsuname2 = 'FEB';

    $startdate3 = "$thisyear-03-01";
    $enddate3 = "$thisyear-03-31";
    $daysinmonth3 = 31;
    $gatsuname3 = 'MAR';

    $startdate4 = "$thisyear-04-01";
    $enddate4 = "$thisyear-04-30";
    $daysinmonth4 = 30;
    $gatsuname4 = 'APR';

    $startdate5 = "$thisyear-05-01";
    $enddate5 = "$thisyear-05-31";
    $daysinmonth5 = 31;
    $gatsuname5 = 'MAY';

    $startdate6 = "$thisyear-06-01";
    $enddate6 = "$thisyear-06-30";
    $daysinmonth6 = 30;
    $gatsuname6 = 'JUN';

    $startdate7 = "$thisyear-07-01";
    $enddate7 = "$thisyear-07-31";
    $daysinmonth7 = 31;
    $gatsuname7 = 'JUL';

    $startdate8 = "$thisyear-08-01";
    $enddate8 = "$thisyear-08-31";
    $daysinmonth8 = 31;
    $gatsuname8 = 'AUG';

    $startdate9 = "$thisyear-09-01";
    $enddate9 = "$thisyear-09-30";
    $daysinmonth9 = 30;
    $gatsuname9 = 'SEP';

    $startdate10 = "$thisyear-10-01";
    $enddate10 = "$thisyear-10-31";
    $daysinmonth10 = 31;
    $gatsuname10 = 'OTC';

    $startdate11 = "$thisyear-11-01";
    $enddate11 = "$thisyear-11-30";
    $daysinmonth11 = 30;
    $gatsuname11 = 'NOV';

    $startdate12 = "$thisyear-12-01";
    $enddate12 = "$thisyear-12-31";
    $daysinmonth12 = 31;
    $gatsuname12 = 'DEC';


    for ($monthnum = 1; $monthnum <= 12; $monthnum++) {

        $monthstart = strval('startdate' . $monthnum);
        $monthend = strval('enddate' . $monthnum);

        $ys = strval("ys" . $monthnum);
        $yz = strval("yz" . $monthnum);
        $yf = strval("yf" . $monthnum);
        $nf = strval("nf" . $monthnum);
        $sf = strval("sf" . $monthnum);
        $gse = strval("gse" . $monthnum);
        $gsa = strval("gsa" . $monthnum);
        $gs = strval("gs" . $monthnum);
        $npd = strval("npd" . $monthnum);
        $mpd = strval("mpd" . $monthnum);
        $days = strval("daysinmonth" . $monthnum);
        $sqltime = " " . $prename . "account.actime >=" . strtotime($$monthstart . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($$monthend . " 23:59:59");
        //月收入
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =1 and " . $prename . "account.ac0 !=3 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        $acincome = mysqli_fetch_array($query);
        $total = $acincome['total'];
        if (isset($total)) {
            $$ys = $total;
        } else {
        }
        //月支出
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        $acspend = mysqli_fetch_array($query);
        $total = $acspend['total'];
        if (isset($total)) {
            $$yf = $total;
        } else {
        }
        if ($$ys == "") {
            $$ys = "0";
        }
        if ($$yf == "") {
            $$yf = "0";
        }
        $$yz = $$ys - $$yf;
        //常规支出	
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        $acspendn = mysqli_fetch_array($query);
        $total = $acspendn['total'];
        if (isset($total)) {
            $$nf = $total;
        } else {
        }
        if ($$nf == "") {
            $$nf = "0";
        }
        $$sf = $$yf - $$nf;
        // 总和
        $timebefore = "  " . $prename . "account.actime <" . strtotime($$monthend . " 23:59:59");
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =1 and " . $prename . "account.ac0 !=3 and " . $timebefore . "  and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        $acincmomeg = mysqli_fetch_array($query);
        $total = $acincmomeg['total'];
        if (isset($total)) {
            $$gse = $total;
        } else {
        }
        $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $timebefore . "  and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
        $query = mysqli_query($conn, $sql);
        $acspendg = mysqli_fetch_array($query);
        $total = $acspendg['total'];
        if (isset($total)) {
            $$gsa = $total;
        } else {
        }
        $$gs = ($$gse - $$gsa);
        if ($$gse == "") {
            $$gse = "0";
        }
        if ($$gsa == "") {
            $$gsa = "0";
        }
        if ($$gs == "") {
            $$gs = "0";
        }
        $$npd = round($$nf / $$days, 2);
        $$mpd = round($$yf / $$days, 2);
        $thismonth = date("Y-m-d");
        if ($$monthend > $thismonth) {
            $$gsa = "-";
            $$gse = "-";
            $$gs = "-";
            $$yz = "-";
            $$yf = "-";
            $$ys = "-";
            $$nf = "-";
            $$sf = "-";
            $$npd = "-";
            $$mpd = "-";
        }
        $monthname = strval("gatsuname" . $monthnum);

        echo '<div style="width:7vw;float:left;margin-top:0.5vw;">';
        echo '<table id="excel" width="60px" border="0" align="left" bgcolor="#B3B3B3" style="float:left" class="table table-striped table-bordered">';
        echo '<tr><th bgcolor="#EBEBEB">';
        echo $$monthname;     
        echo '</th></tr>';

            echo "
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $$ys . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $$yf . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $$gs . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $$gsa . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $$sf . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $$nf . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $$npd . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $$mpd . "</font></td></tr>
           </table>
           </div> ";

    }
    //年度统计
    $sqltime = " " . $prename . "account.actime >=" . strtotime($startdate1 . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($enddate12 . " 23:59:59");
    $sqltimebefore = " " . $prename . "account.actime <" . strtotime($enddate12 . " 23:59:59");
    //收入分类
    $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =1 and " . $prename . "account.ac0 !=3 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
    $query = mysqli_query($conn, $sql);
    $acyearincome = mysqli_fetch_array($query);
    $total = $acyearincome['total'];
    if (isset($total)) {
        $yearincome = $total;
    } else {
    }
    //年支出
    $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
    $query = mysqli_query($conn, $sql);
    $acyearspend = mysqli_fetch_array($query);
    $total = $acyearspend['total'];
    if (isset($total)) {
        $yearspend = $total;
    } else {
    }

    $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =1 and " . $prename . "account.ac0 !=3 and " . $sqltimebefore . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
    $query = mysqli_query($conn, $sql);
    $acbefore = mysqli_fetch_array($query);
    $totalbefore = $acbefore['total'];
    if (isset($totalbefore)) {
        $allbeforeincome = $totalbefore;
    } else {
    }

    $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $sqltimebefore . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
    $query = mysqli_query($conn, $sql);
    $acbeforesp = mysqli_fetch_array($query);
    $totalbeforesp = $acbeforesp['total'];
    if (isset($totalbeforesp)) {
        $allbeforesp = $totalbeforesp;
    } else {
    }
    if ($allbeforesp == "") {
        $allbeforesp = "0";
    }
    if ($allbeforeincome == "") {
        $allbeforeincome = "0";
    }
    if ($yearincome == "") {
        $yearincome = "0";
    }
    if ($yearspend == "") {
        $yearspend = "0";
    }
    $yearflow = $allbeforeincome - $allbeforesp;
    //年 常务
    $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
    $query = mysqli_query($conn, $sql);
    $acclass = mysqli_fetch_array($query);
    $total = $acclass['total'];
    if (isset($total)) {
        $yearspendn = $total;
    } else {
    }

    if ($yearspendn == "") {
        $yearspendn = "0";
    }

    $yearspends = $yearspend - $yearspendn;

    $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $sqltimebefore . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
    $query = mysqli_query($conn, $sql);
    $acallspend = mysqli_fetch_array($query);
    $total = $acallspend['total'];
    if (isset($total)) {
        $allspend = $total;
    } else {
    }

    if ($allspend == "") {
        $allspend = "0";
    }

    $npdy = round($yearspendn / '365', 2);
    $evepdy = round($yearspend / '365', 2);
    $nowyear = date('Y-m-d');
    if ($enddate12 > $nowyear) {
        $yearincome = "-";
        $yearspend = "-";
        $yearflow = "-";
        $allspend = "-";
        $yearspends = "-";
        $yearspendn = "-";
        $npdy = "-";
        $evepdy = "-";
    }


    ?>
    


    <div style="width:7%;float:left;margin-top:0.5vw;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>年度统计</th>
            </tr>
            <?php



            echo "
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $yearincome . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yearspend . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $yearflow . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $allspend . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $yearspends . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $yearspendn . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npdy . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $evepdy . "</font></td></tr>
            ";
            ?>
        </table>
    </div>


    <table>

        <div id="main1" style="width: 100%;height:50%; position:absolute;top:50%; z-index:-1;">
            <tr>
                <script type="text/javascript">
                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('main1'));
                    // 指定图表的配置项和数据
                    var option = {
                        title: {
                            text: '月支出变化'
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['总支出', '生活净支出', '周期支出', '偶然支出']
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        toolbox: {
                            feature: {
                                saveAsImage: {}
                            }
                        },
                        xAxis: {
                            type: 'category',
                            data: [
                                //time	
                                <?php
                                $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                                $firstquery = mysqli_query($conn, $firstsql);
                                $first = mysqli_fetch_array($firstquery);
                                $firsttime = $first['actime'];
                                $firstdate = date('Y-m', $firsttime);
                                $now = date('Y-m', strtotime("last month"));

                                $sql = "select " . $prename . "month.mon as month from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and acuserid='$_SESSION[uid]'  where " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    $month = $row['month'];
                                    echo "'$month',";
                                }

                                ?>

                            ]
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [

                            {
                                name: '总支出',
                                data: [
                                    //sum
                                    <?php

                                    $sqlmin = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid and acuserid='$_SESSION[uid]' where " . $prename . "account.ac0 !=3 and " . $prename . "month.mon='" . $firstdate . "' group by month";
                                    $querymin = mysqli_query($conn, $sqlmin);
                                    $rowmin = mysqli_fetch_array($querymin);
                                    $firstmonth = $rowmin['month'];

                                    $sqlminout = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid and acuserid='$_SESSION[uid]' where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $prename . "month.mon='" . $firstdate . "' group by month";
                                    $queryminout = mysqli_query($conn, $sqlminout);
                                    $rowminout = mysqli_fetch_array($queryminout);
                                    $firstmonthout = $rowminout['month'];

                                    if ($firstmonthout == $firstmonth) {
                                        $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                                        $firstquery = mysqli_query($conn, $firstsql);
                                        $first = mysqli_fetch_array($firstquery);
                                        $firsttime = $first['actime'];
                                        $firstdate = date('Y-m', $firsttime);
                                        $now = date('Y-m');
                                        $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum ,ac1 from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and acuserid='$_SESSION[uid]' where  " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
                                        $query = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($query)) {
                                            if ($row['sum'] == '0') {
                                                $total = '0.00';
                                            } else {
                                                $total = $row['sum'];
                                            }
                                            echo "'$total',";
                                        }
                                    } else {
                                        $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                                        $firstquery = mysqli_query($conn, $firstsql);
                                        $first = mysqli_fetch_array($firstquery);
                                        $firsttime = $first['actime'];
                                        $firstdate = date('Y-m', $firsttime);
                                        $now = date('Y-m');
                                        $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum ,ac1 from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and acuserid='$_SESSION[uid]' where  " . $prename . "account.ac1 = 2 and " . $prename . "account.ac0 !=3 and " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
                                        $query = mysqli_query($conn, $sql);
                                        echo "'0',";
                                        while ($row = mysqli_fetch_array($query)) {
                                            if ($row['sum'] == '0') {
                                                $total = '0.00';
                                            } else {
                                                $total = $row['sum'];
                                            }
                                            echo "'$total',";
                                        }
                                    }
                                    ?>
                                ],
                                type: 'line',
                                smooth: false
                            },
                            {
                                name: '生活净支出',
                                data: [
                                    //生活开销
                                    <?php
                                    $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                                    $firstquery = mysqli_query($conn, $firstsql);
                                    $first = mysqli_fetch_array($firstquery);
                                    $firsttime = $first['actime'];
                                    $firstdate = date('Y-m', $firsttime);
                                    $now = date('Y-m');


                                    $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and ac0=0 and acuserid='$_SESSION[uid]' and ac1=2 where " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";



                                    $query = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($query)) {

                                        if ($row['sum'] == '0') {
                                            $smonth = '0.00';
                                        } else {
                                            $smonth = $row['sum'];
                                        }
                                        echo "'$smonth',";
                                    }

                                    ?>
                                ],
                                type: 'line',
                                smooth: false
                            },
                            {
                                name: '周期支出',
                                data: [
                                    <?php
                                    $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                                    $firstquery = mysqli_query($conn, $firstsql);
                                    $first = mysqli_fetch_array($firstquery);
                                    $firsttime = $first['actime'];
                                    $firstdate = date('Y-m', $firsttime);
                                    $now = date('Y-m');


                                    $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and ac0=1 and acuserid='$_SESSION[uid]'  where " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
                                    $query = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($query)) {

                                        if ($row['sum'] == '0') {
                                            $smonth = '0.00';
                                        } else {
                                            $smonth = $row['sum'];
                                        }
                                        echo "'$smonth',";
                                    }

                                    ?>

                                ],
                                type: 'line',
                                smooth: false
                            },
                            {
                                name: '偶然支出',
                                data: [
                                    <?php
                                    $firstsql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                                    $firstquery = mysqli_query($conn, $firstsql);
                                    $first = mysqli_fetch_array($firstquery);
                                    $firsttime = $first['actime'];
                                    $firstdate = date('Y-m', $firsttime);
                                    $now = date('Y-m');


                                    $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and ac0=2 and acuserid='$_SESSION[uid]'  where " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
                                    $query = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($query)) {

                                        if ($row['sum'] == '0') {
                                            $smonth = '0.00';
                                        } else {
                                            $smonth = $row['sum'];
                                        }
                                        echo "'$smonth',";
                                    }

                                    ?>

                                ],
                                type: 'line',
                                smooth: false
                            }



                        ]
                    };


                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                </script>
            </tr>
        </div>

        <table />
        <table>

            <div id="main" style="width: 50%;height:80%; position:absolute;left:25%;top:100%;">
                <tr>
                    <script type="text/javascript">
                        var myChart = echarts.init(document.getElementById('main'));
                        myChart.setOption(option = {});
                        option = {
                            title: {
                                text: '分类统计',
                                subtext: '',
                                left: 'center'
                            },
                            tooltip: {

                            },

                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {
                                        show: true
                                    },
                                    dataView: {
                                        show: true,
                                        readOnly: false
                                    },
                                    magicType: {
                                        show: true,
                                        type: ['pie', 'funnel']
                                    },
                                    restore: {
                                        show: true
                                    },
                                    saveAsImage: {
                                        show: true
                                    }
                                }
                            },
                            series: [{
                                name: '分类',
                                type: 'pie',
                                radius: [50, 200],
                                center: ['50%', '50%'],
                                roseType: 'radius',
                                data: [

                                    <?php

                                    $sql = "select sum(acamount) as total ," . $prename . "category.categoryname from " . $prename . "account left join " . $prename . "category on " . $prename . "account.accategory =" . $prename . "category.categoryid left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account.ac1 =2 and " . $prename . "account.ac0 !=3 and acuserid='$_SESSION[uid]' group by " . $prename . "account.accategory";
                                    $s2 = array();
                                    $query = mysqli_query($conn, $sql);
                                    while ($accategory = mysqli_fetch_array($query)) {

                                        echo "{value: '" . $accategory['total'] . "', name: '" . $accategory['categoryname'] . "'},";
                                    }

                                    ?>

                                ]
                            }]
                        };
                        myChart.setOption(option);
                    </script>
                </tr>
            </div>

        </table>
</body>

<script language="javascript" type="text/javascript">
    function save() {
        selectIndex = document.getElementById("year").selectedIndex;
        document.cookie = 'selectIndex =' + selectIndex;
    }
    window.onload = function() {
        var cooki = document.cookie;
        if (cooki != "") {
            cooki = "{\"" + cooki + "\"}";
            cooki = cooki.replace(/\s*/g, "").replace(/=/g, '":"').replace(/;/g, '","');
            var json = eval("(" + cooki + ")"); //将coolies转成json对象
            document.getElementById("year").options[json.selectIndex].selected = true;
        } else
            save();
    }
</script>