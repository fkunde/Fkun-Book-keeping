<?php
include_once("header.php");
?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
?>
<head>
    <script src="./js/echarts.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
</head>

<body>
    <div style="width:7%;float:left;">
        <table id="excel" width='60%' border='0' align='left' cellpadding='3' bgcolor='#B3B3B3' style="float:left;" class='table table-striped table-bordered' position="absolute">
            <tr>
                <th bgcolor='#EBEBEB'>
                    <form id="form" name="form1" method="post" action="">
                        <select name="year" id="year" onchange="window.location.href='annual_stat.php?year='+this.value;options[selectedIndex].value;onchange=save()">

                            <?php
                            $sql = "SELECT * FROM " . $prename . "account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
                            $query = mysqli_query($conn, $sql);
                            $first = mysqli_fetch_array($query);
                            $acyear = $first[actime];
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
            $shouru = array();
            $sqlshouru = "select * from " . $prename . "account_class where ufid='$_SESSION[uid]' and classtype='1'";
            $queryshouru = mysqli_query($conn, $sqlshouru);
            while ($rowshouru = mysqli_fetch_array($queryshouru)) {
                $cid = $rowshouru['classid'];
                $shouru["$cid"] = $rowshouru['classid'];
            }
            $zhichu = array();
            $sqlshouru = "select * from " . $prename . "account_class where ufid='$_SESSION[uid]' and classtype='2'";
            $queryshouru = mysqli_query($conn, $sqlshouru);
            while ($rowshouru = mysqli_fetch_array($queryshouru)) {
                $cid = $rowshouru['classid'];
                $zhichu["$cid"] = $rowshouru['classid'];
            }
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

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>JAN</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-01-31";
            $k = "$thisyear-01-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys1 = $ys1 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf1 = $total;
            if ($ys1 == "") {
                $ys1 = "0";
            }
            if ($yf1 == "") {
                $yf1 = "0";
            }
            $yz = $ys1 - $yf1;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf1 = $total;
            if ($ns1 == "") {
                $ns1 = "0";
            }
            if ($nf1 == "") {
                $nf1 = "0";
            }
            $sf1 = $yf1 - $nf1;


            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse1 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa1 = $total;
                } else {
                }
            }

            $gs1 = ($gse1 - $gsa1);



            if ($gse1 == "") {
                $gse1 = "0";
            }
            if ($gsa1 == "") {
                $gsa1 = "0";
            }
            if ($gs1 == "") {
                $gs1 = "0";
            }

            $npd1 = round($nf1 / '31', 2);
            $mpd1 = round($yf1 / '31', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa1 = "-";
                $gse1 = "-";
                $gs1 = "-";
                $yz = "-";
                $yf1 = "-";
                $ys1 = "-";
                $nf1 = "-";
                $sf1 = "-";
                $npd1 = "-";
                $mpd1 = "-";
            }


            echo "
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd1 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd1 . "</font></td></tr>
            ";
            ?>
        </table>
    </div>



    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>FEB</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-02-29";
            $k = "$thisyear-02-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys2 = $ys2 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf2 = $total;
            if ($ys2 == "") {
                $ys2 = "0";
            }
            if ($yf2 == "") {
                $yf2 = "0";
            }
            $yz = $ys2 - $yf2;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf2 = $total;
            if ($ns2 == "") {
                $ns2 = "0";
            }
            if ($nf2 == "") {
                $nf2 = "0";
            }
            $sf2 = $yf2 - $nf2;


            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse2 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa2 = $total;
                } else {
                }
            }
            $gs2 = ($gse2 - $gsa2);
            if ($gse2 == "") {
                $gse2 = "0";
            }
            if ($gsa2 == "") {
                $gsa2 = "0";
            }
            if ($gs2 == "") {
                $gs2 = "0";
            }

            $npd2 = round($nf2 / '28', 2);
            $mpd2 = round($yf2 / '28', 2);


            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa2 = "-";
                $gse2 = "-";
                $gs2 = "-";
                $yz = "-";
                $yf2 = "-";
                $ys2 = "-";
                $nf2 = "-";
                $sf2 = "-";
                $npd2 = "-";
                $mpd2 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd2 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd2 . "</font></td></tr>
            ";
            ?>
        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>MAR</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-03-31";
            $k = "$thisyear-03-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys3 = $ys3 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf3 = $total;
            if ($ys3 == "") {
                $ys3 = "0";
            }
            if ($yf3 == "") {
                $yf3 = "0";
            }
            $yz = $ys3 - $yf3;


            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }
            $nf3 = $total;
            if ($ns3 == "") {
                $ns3 = "0";
            }
            if ($nf3 == "") {
                $nf3 = "0";
            }
            $sf3 = $yf3 - $nf3;



            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse3 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa3 = $total;
                } else {
                }
            }
            $gs3 = ($gse3 - $gsa3);
            if ($gse3 == "") {
                $gse3 = "0";
            }
            if ($gsa3 == "") {
                $gsa3 = "0";
            }
            if ($gs3 == "") {
                $gs3 = "0";
            }

            $npd3 = round($nf3 / '31', 2);
            $mpd3 = round($yf3 / '31', 2);


            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa3 = "-";
                $gse3 = "-";
                $gs3 = "-";
                $yz = "-";
                $yf3 = "-";
                $ys3 = "-";
                $nf3 = "-";
                $sf3 = "-";
                $npd3 = "-";
                $mpd3 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd3 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd3 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>APR</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-04-30";
            $k = "$thisyear-04-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys4 = $ys4 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }
            $yf4 = $total;
            if ($ys4 == "") {
                $ys4 = "0";
            }
            if ($yf4 == "") {
                $yf4 = "0";
            }
            $yz = $ys4 - $yf4;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf4 = $total;
            if ($ns4 == "") {
                $ns4 = "0";
            }
            if ($nf4 == "") {
                $nf4 = "0";
            }
            $sf4 = $yf4 - $nf4;


            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse4 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa4 = $total;
                } else {
                }
            }
            $gs4 = ($gse4 - $gsa4);
            if ($gse4 == "") {
                $gse4 = "0";
            }
            if ($gsa4 == "") {
                $gsa4 = "0";
            }
            if ($gs4 == "") {
                $gs4 = "0";
            }
            $npd4 = round($nf4 / '30', 2);
            $mpd4 = round($yf4 / '30', 2);

            $thismonth = date("Y-m-d");

            if ($j > $thismonth) {
                $gsa4 = "-";
                $gse4 = "-";
                $gs4 = "-";
                $yz = "-";
                $yf4 = "-";
                $ys4 = "-";
                $nf4 = "-";
                $sf4 = "-";
                $npd4 = "-";
                $mpd4 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd4 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd4 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>MAI</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-05-31";
            $k = "$thisyear-05-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys5 = $ys5 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf5 = $total;
            if ($ys5 == "") {
                $ys5 = "0";
            }
            if ($yf5 == "") {
                $yf5 = "0";
            }
            $yz = $ys5 - $yf5;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf5 = $total;
            if ($ns5 == "") {
                $ns5 = "0";
            }
            if ($nf5 == "") {
                $nf5 = "0";
            }
            $sf5 = $yf5 - $nf5;


            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse5 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa5 = $total;
                } else {
                }
            }
            $gs5 = ($gse5 - $gsa5);
            if ($gse5 == "") {
                $gse5 = "0";
            }
            if ($gsa5 == "") {
                $gsa5 = "0";
            }
            if ($gs5 == "") {
                $gs5 = "0";
            }
            $npd5 = round($nf5 / '31', 2);
            $mpd5 = round($yf5 / '31', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa5 = "-";
                $gse5 = "-";
                $gs5 = "-";
                $yz = "-";
                $yf5 = "-";
                $ys5 = "-";
                $nf5 = "-";
                $sf5 = "-";
                $npd5 = "-";
                $mpd5 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd5 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd5 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>JUN</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-06-30";
            $k = "$thisyear-06-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys6 = $ys6 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }
            $yf6 = $total;
            if ($ys6 == "") {
                $ys6 = "0";
            }
            if ($yf6 == "") {
                $yf6 = "0";
            }
            $yz = $ys6 - $yf6;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf6 = $total;
            if ($ns6 == "") {
                $ns6 = "0";
            }
            if ($nf6 == "") {
                $nf6 = "0";
            }
            $sf6 = $yf6 - $nf6;


            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse6 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa6 = $total;
                } else {
                }
            }
            $gs6 = ($gse6 - $gsa6);
            if ($gse6 == "") {
                $gse6 = "0";
            }
            if ($gsa6 == "") {
                $gsa6 = "0";
            }
            if ($gs6 == "") {
                $gs6 = "0";
            }
            $npd6 = round($nf6 / '30', 2);
            $mpd6 = round($yf6 / '30', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa6 = "-";
                $gse6 = "-";
                $gs6 = "-";
                $yz = "-";
                $yf6 = "-";
                $ys6 = "-";
                $nf6 = "-";
                $sf6 = "-";
                $npd6 = "-";
                $mpd6 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd6 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd6 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>JUL</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-07-31";
            $k = "$thisyear-07-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys7 = $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
                $s2[$ac1['2']] = $total;
            }
            $yf7 = $total;
            if ($ys7 == "") {
                $ys7 = "0";
            }
            if ($yf7 == "") {
                $yf7 = "0";
            }
            $yz = $ys7 - $yf7;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf7 = $total;

            if ($ns7 == "") {
                $ns7 = "0";
            }
            if ($nf7 == "") {
                $nf7 = "0";
            }
            $sf7 = $yf7 - $nf7;


            // 总和
            $timebefore = " " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse7 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa7 = $total;
                } else {
                }
            }
            $gs7 = ($gse7 - $gsa7);
            if ($gse7 == "") {
                $gse7 = "0";
            }
            if ($gsa7 == "") {
                $gsa7 = "0";
            }
            if ($gs7 == "") {
                $gs7 = "0";
            }
            $npd7 = round($nf7 / '31', 2);
            $mpd7 = round($yf7 / '31', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa7 = "-";
                $gse7 = "-";
                $gs7 = "-";
                $yz = "-";
                $yf7 = "-";
                $ys7 = "-";
                $nf7 = "-";
                $sf7 = "-";
                $npd7 = "-";
                $mpd7 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd7 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd7 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>AUG</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-08-31";
            $k = "$thisyear-08-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys8 = $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }
            $yf8 = $total;
            if ($ys8 == "") {
                $ys8 = "0";
            }
            if ($yf8 == "") {
                $yf8 = "0";
            }
            $yz = $ys8 - $yf8;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf8 = $total;
            if ($ns8 == "") {
                $ns8 = "0";
            }
            if ($nf8 == "") {
                $nf8 = "0";
            }


            $sf8 = $yf8 - $nf8;

            // 总和
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse8 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa8 = $total;
                } else {
                }
            }
            $gs8 = ($gse8 - $gsa8);
            if ($gse8 == "") {
                $gse8 = "0";
            }
            if ($gsa8 == "") {
                $gsa8 = "0";
            }
            if ($gs8 == "") {
                $gs8 = "0";
            }
            $npd8 = round($nf8 / '31', 2);
            $mpd8 = round($yf8 / '31', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa8 = "-";
                $gse8 = "-";
                $gs8 = "-";
                $yz = "-";
                $yf8 = "-";
                $ys8 = "-";
                $nf8 = "-";
                $sf8 = "-";
                $npd8 = "-";
                $mpd8 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd8 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd8 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>
    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>SEP</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-09-30";
            $k = "$thisyear-09-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys9 = $ys9 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf9 = $total;
            if ($ys9 == "") {
                $ys9 = "0";
            }
            if ($yf9 == "") {
                $yf9 = "0";
            }
            $yz = $ys9 - $yf9;

            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }
            $nf9 = $total;
            if ($ns9 == "") {
                $ns9 = "0";
            }
            if ($nf9 == "") {
                $nf9 = "0";
            }
            $sf9 = $yf9 - $nf9;


            // 总和
            $timebefore = "  " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse9 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa9 = $total;
                } else {
                }
            }
            $gs9 = ($gse9 - $gsa9);
            if ($gse9 == "") {
                $gse9 = "0";
            }
            if ($gsa9 == "") {
                $gsa9 = "0";
            }
            if ($gs9 == "") {
                $gs9 = "0";
            }
            $npd9 = round($nf9 / '30', 2);
            $mpd9 = round($yf9 / '30', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa9 = "-";
                $gse9 = "-";
                $gs9 = "-";
                $yz = "-";
                $yf9 = "-";
                $ys9 = "-";
                $nf9 = "-";
                $sf9 = "-";
                $npd9 = "-";
                $mpd9 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd9 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd9 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>OCT</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-10-31";
            $k = "$thisyear-10-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys10 = $ys10 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf10 = $total;
            if ($ys10 == "") {
                $ys10 = "0";
            }
            if ($yf10 == "") {
                $yf10 = "0";
            }
            $yz = $ys10 - $yf10;
            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf10 = $total;
            if ($ns10 == "") {
                $ns10 = "0";
            }
            if ($nf10 == "") {
                $nf10 = "0";
            }
            $sf10 = $yf10 - $nf10;

            // 总和
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse10 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa10 = $total;
                } else {
                }
            }
            $gs10 = ($gse10 - $gsa10);
            if ($gse10 == "") {
                $gse10 = "0";
            }
            if ($gsa10 == "") {
                $gsa10 = "0";
            }
            if ($gs10 == "") {
                $gs10 = "0";
            }
            $npd10 = round($nf10 / '31', 2);
            $mpd10 = round($yf10 / '31', 2);

            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa10 = "-";
                $gse10 = "-";
                $gs10 = "-";
                $yz = "-";
                $yf10 = "-";
                $ys10 = "-";
                $nf10 = "-";
                $sf10 = "-";
                $npd10 = "-";
                $mpd10 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd10 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd10 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>NOV</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-11-30";
            $k = "$thisyear-11-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys11 = $ys11 + $s1[$k];
                } else {
                }
            }
            //支出分类

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $yf11 = $total;
            if ($ys11 == "") {
                $ys11 = "0";
            }
            if ($yf11 == "") {
                $yf11 = "0";
            }
            $yz = $ys11 - $yf11;
            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf11 = $total;
            if ($ns11 == "") {
                $ns11 = "0";
            }
            if ($nf11 == "") {
                $nf11 = "0";
            }
            $sf11 = $yf11 - $nf11;

            // 总和
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse11 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa11 = $total;
                } else {
                }
            }
            $gs11 = ($gse11 - $gsa11);
            if ($gse11 == "") {
                $gse11 = "0";
            }
            if ($gsa11 == "") {
                $gsa11 = "0";
            }
            if ($gs11 == "") {
                $gs11 = "0";
            }
            $npd11 = round($nf11 / '30', 2);
            $mpd11 = round($yf11 / '30', 2);
            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa11 = "-";
                $gse11 = "-";
                $gs11 = "-";
                $yz = "-";
                $yf11 = "-";
                $ys11 = "-";
                $nf11 = "-";
                $sf11 = "-";
                $npd11 = "-";
                $mpd11 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd11 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd11 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>

    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>DEC</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-12-31";
            $k = "$thisyear-12-01";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {
                if (isset($s1[$k])) {
                    $ys12 = $ys12 + $s1[$k];
                } else {
                }
            }
            //支出分类
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }
            $yf12 = $total;
            if ($ys12 == "") {
                $ys12 = "0";
            }
            if ($yf12 == "") {
                $yf12 = "0";
            }
            $yz = $ys12 - $yf12;
            //常规支出	
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $n2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $n2[$acclass['acclassid']] = $total;
            }

            $nf12 = $total;
            if ($ns12 == "") {
                $ns12 = "0";
            }
            if ($nf12 == "") {
                $nf12 = "0";
            }
            $sf12 = $yf12 - $nf12;
            // 总和
            $timebefore = " " . $prename . "account.actime<" . strtotime($j . " 23:59:59");
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $timebefore . " and " . $prename . "account_class.classtype =1  and acuserid='$_SESSION[uid]' ";
            $query = mysqli_query($conn, $sql);
            $g1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $g1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $n => $m) {
                if (isset($g1[$n])) {
                    $gse12 = $g1[$n];
                } else {
                }
            }
            $sql = "select sum(acamount) as total from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $timebefore . " and acuserid='$_SESSION[uid]' group by ac1";
            $g2 = array();
            $query = mysqli_query($conn, $sql);
            while ($ac1 = mysqli_fetch_array($query)) {
                $total = $ac1['total'];
            }

            foreach ($zhichu as $n => $m) {
                if (isset($total)) {
                    $gsa12 = $total;
                } else {
                }
            }
            $gs12 = ($gse12 - $gsa12);
            if ($gse12 == "") {
                $gse12 = "0";
            }
            if ($gsa12 == "") {
                $gsa12 = "0";
            }
            if ($gs12 == "") {
                $gs12 = "0";
            }
            $npd12 = round($nf12 / '31', 2);
            $mpd12 = round($yf12 / '31', 2);
            $thismonth = date("Y-m-d");
            if ($j > $thismonth) {
                $gsa12 = "-";
                $gse12 = "-";
                $gs12 = "-";
                $yz = "-";
                $yf12 = "-";
                $ys12 = "-";
                $nf12 = "-";
                $sf12 = "-";
                $npd12 = "-";
                $mpd12 = "-";
            }


            echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ys12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $yf12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gs12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsa12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $sf12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $nf12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npd12 . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpd12 . "</font></td></tr>
            ";
            ?>


        </table>
    </div>


    <div style="width:7%;float:left;">
        <table id="excel" width='60px' border='0' align='left' bgcolor='#B3B3B3' style="float:left" class='table table-striped table-bordered'>
            <tr>
                <th bgcolor='#EBEBEB'>年度统计</th>
            </tr>
            <?php
            if ($_GET['year'] == "") {
                $thisyear = date("Y");
            } else {
                $thisyear = $_GET['year'];
            }
            $j = "$thisyear-12-31";
            $k = "$thisyear-1-1";
            $sqltime = " " . $prename . "account.actime >=" . strtotime($k . " 0:0:0") . " and " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            $sqltimebefore = " " . $prename . "account.actime <" . strtotime($j . " 23:59:59");
            //收入分类
            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =1 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $query = mysqli_query($conn, $sql);
            $s1 = array();
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s1[$acclass['acclassid']] = $total;
            }
            foreach ($shouru as $k => $v) {

                if (isset($s1[$k])) {

                    $ns = $ns + $s1[$k];
                } else {
                }
            }

            //年支出
            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            $nf =  $total;

            if ($ns == "") {
                $ns = "0";
            }
            if ($nf == "") {
                $nf = "0";
            }
            $yz = $ns - $nf;

            //年 常务

            $sql = "select sum(acamount) as total,ac1 from " . $prename . "account where " . $prename . "account.ac1 =2 and " . $sqltime . " and ac0=0 and acuserid='$_SESSION[uid]' group by " . $prename . "account.ac1";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }
            $gnf = $total;

            if ($gns == "") {
                $gns = "0";
            }
            if ($gnf == "") {
                $gnf = "0";
            }
            $gsf = $nf - $gnf;

            $sql = "select sum(acamount) as total,acclassid," . $prename . "account_class.classname from " . $prename . "account left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =2 and " . $sqltimebefore . " and acuserid='$_SESSION[uid]' group by " . $prename . "account.acclassid";
            $s2 = array();
            $query = mysqli_query($conn, $sql);
            while ($acclass = mysqli_fetch_array($query)) {
                $total = $acclass['total'];
                $s2[$acclass['acclassid']] = $total;
            }

            foreach ($zhichu as $k => $v) {
                if (isset($s2[$k])) {
                    $gf = -$s2[$k];
                } else {
                }
            }

            if ($gs == "") {
                $gs = "0";
            }
            if ($gf == "") {
                $gf = "0";
            }

            $npdy = round($gnf / '365', 2);
            $mpdy = round($nf / '365', 2);
            $gz = $gs - $gf;
            $nowyear = date('Y-m-d');
            if ($j > $nowyear) {
                $ns = "-";
                $nf = "-";
                $yz = "-";
                $gz = "-";
                $gsf = "-";
                $gnf = "-";
                $npdy = "-";
                $mpdy = "-";
            }


            echo "
<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $ns . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font color='red'>" . $nf . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $yz . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gz . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gsf . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $gnf . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $npdy . "</font></td></tr>
<tr><td align='left' bgcolor='#FFFFFF'><font>" . $mpdy . "</font></td></tr>
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

                                    $sqlmin = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid and acuserid='$_SESSION[uid]' where  " . $prename . "month.mon='" . $firstdate . "' group by month";
                                    $querymin = mysqli_query($conn, $sqlmin);
                                    $rowmin = mysqli_fetch_array($querymin);
                                    $firstmonth = $rowmin['month'];

                                    $sqlminout = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid and acuserid='$_SESSION[uid]' where " . $prename . "account_class.classtype =2 and " . $prename . "month.mon='" . $firstdate . "' group by month";
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
                                        $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum ,ac1 from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and acuserid='$_SESSION[uid]' where  " . $prename . "account.ac1 =2 and " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
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
                                        $sql = "select " . $prename . "month.mon as month, sum(case when " . $prename . "account.acamount is null then 0 else " . $prename . "account.acamount end) as sum ,ac1 from " . $prename . "month left join " . $prename . "account on date_format(FROM_UNIXTIME(" . $prename . "account.actime),'%Y-%m') = " . $prename . "month.mon and acuserid='$_SESSION[uid]' where  " . $prename . "account.ac1 = 2 and " . $prename . "month.mon>='" . $firstdate . "' and " . $prename . "month.mon<='" . $now . "' group by month";
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

            <div id="main" style="width: 50%;height:50%; position:absolute;left:25%;top:100%; z-index:-1;">
                <tr>
                    <script type="text/javascript">
                        var myChart = echarts.init(document.getElementById('main'));
                        myChart.setOption(option = {});
                        option = {
                            title: {
                                text: '南丁格尔玫瑰图',
                                subtext: '分类统计',
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

                                    $sql = "select sum(acamount) as total ," . $prename . "category.categoryname from " . $prename . "account left join " . $prename . "category on " . $prename . "account.actype =" . $prename . "category.categoryid left join " . $prename . "account_class on " . $prename . "account.acclassid =" . $prename . "account_class.classid where " . $prename . "account_class.classtype =2 and acuserid='$_SESSION[uid]' group by " . $prename . "account.actype";
                                    $s2 = array();
                                    $query = mysqli_query($conn, $sql);
                                    while ($actype = mysqli_fetch_array($query)) {

                                        echo "{value: '" . $actype['total'] . "', name: '" . $actype['categoryname'] . "'},";
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