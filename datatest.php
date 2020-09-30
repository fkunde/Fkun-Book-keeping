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
    $arr = user_shell($_SESSION['uid'],$_SESSION['user_shell']);
    //对权限进行判断
    ?>
	

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
    <script src="./js/echarts.js"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
</head>
<body>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 100%;height:100%;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));
        // 指定图表的配置项和数据
        var option = {
    xAxis: {
        type: 'category',
        data: [
	//time	
		<?php
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
		$first = mysqli_fetch_array($firstquery);
		$firsttime = $first['actime'];
		$firstdate = date('Y-m',$firsttime);
		$now = date('Y-m',strtotime("last month"));				

$sql = "select ".$prename."month.mon as month from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon and acuserid='$_SESSION[uid]'  where ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";
$query = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_array($query)) {
                $month= $row['month'];
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
        data: [
		//sum
<?php

$sqlmin = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon left join ".$prename."account_class on ".$prename."account.acclassid =".$prename."account_class.classid and acuserid='$_SESSION[uid]' where  ".$prename."month.mon='".$firstdate."' group by month";
$querymin = mysqli_query($conn,$sqlmin);
$rowmin = mysqli_fetch_array($querymin);	
$firstmonth= $rowmin['month'];	

$sqlminout = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon left join ".$prename."account_class on ".$prename."account.acclassid =".$prename."account_class.classid and acuserid='$_SESSION[uid]' where ".$prename."account_class.classtype =2 and ".$prename."month.mon='".$firstdate."' group by month";
$queryminout = mysqli_query($conn,$sqlminout);
$rowminout = mysqli_fetch_array($queryminout);	
$firstmonthout= $rowminout['month'];	

if($firstmonthout==$firstmonth){			
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
$firstquery = mysqli_query($conn, $firstsql);
$first = mysqli_fetch_array($firstquery);
$firsttime = $first['actime'];
$firstdate = date('Y-m',$firsttime);
$now = date('Y-m');					
$sql = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum ,acclassid,".$prename."account_class.classname from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon left join ".$prename."account_class on ".$prename."account.acclassid =".$prename."account_class.classid and acuserid='$_SESSION[uid]' where  ".$prename."account_class.classtype =2 and ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";
$query = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_array($query)) {
				if($row['sum']=='0'){
				 $total = '0.00';
				}else{
				 $total = $row['sum'];
				}
                echo "'$total',";
			}	
}else{
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
		$first = mysqli_fetch_array($firstquery);
		$firsttime = $first['actime'];
		$firstdate = date('Y-m',$firsttime);
		$now = date('Y-m');					
$sql = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum ,acclassid,".$prename."account_class.classname from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon left join ".$prename."account_class on ".$prename."account.acclassid =".$prename."account_class.classid and acuserid='$_SESSION[uid]' where  ".$prename."account_class.classtype =2 and ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";
$query = mysqli_query($conn,$sql);
echo "'0',";
            while ($row = mysqli_fetch_array($query)) {
				if($row['sum']=='0'){
				 $total = '0.00';
				}else{
				 $total = $row['sum'];
				}
                echo "'$total',";
			}	


}	
?>
		],
        type: 'line',
        smooth: true
    },
    {
        data: [
		//生活开销
<?php
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
		$first = mysqli_fetch_array($firstquery);
		$firsttime = $first['actime'];
		$firstdate = date('Y-m',$firsttime);
		$now = date('Y-m');				
		
		
$sql = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon and ac0=0 and acuserid='$_SESSION[uid]' and ac1=2 where ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";


			
$query = mysqli_query($conn,$sql);

			while ($row = mysqli_fetch_array($query)) {
			
				if($row['sum']=='0'){
				$smonth= '0.00';
				}else{
				$smonth= $row['sum'];	
				}
                echo "'$smonth',";
			}

?>	
],
        type: 'line',
        smooth: true
    },
    {
        data: [
		<?php
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
		$first = mysqli_fetch_array($firstquery);
		$firsttime = $first['actime'];
		$firstdate = date('Y-m',$firsttime);
		$now = date('Y-m');				
		
		
$sql = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon and ac0=1 and acuserid='$_SESSION[uid]'  where ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";
$query = mysqli_query($conn,$sql);

			while ($row = mysqli_fetch_array($query)) {
			
				if($row['sum']=='0'){
				$smonth= '0.00';
				}else{
				$smonth= $row['sum'];	
				}
                echo "'$smonth',";
			}

?>	

],
        type: 'line',
        smooth: true
    },
    {
        data: [
<?php
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
		$first = mysqli_fetch_array($firstquery);
		$firsttime = $first['actime'];
		$firstdate = date('Y-m',$firsttime);
		$now = date('Y-m');				
		
		
$sql = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon and ac0=2 and acuserid='$_SESSION[uid]'  where ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";
$query = mysqli_query($conn,$sql);

			while ($row = mysqli_fetch_array($query)) {
			
				if($row['sum']=='0'){
				$smonth= '0.00';
				}else{
				$smonth= $row['sum'];	
				}
                echo "'$smonth',";
			}

?>	
		
		],
        type: 'line',
        smooth: true
    }
    
    
    
    ]
};


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
<?php
$firstsql= "SELECT * FROM ".$prename."account where acuserid='$_SESSION[uid]' order by actime LIMIT 1 ";
        $firstquery = mysqli_query($conn, $firstsql);
		$first = mysqli_fetch_array($firstquery);
		$firsttime = $first['actime'];
		$firstdate = date('Y-m',$firsttime);
		$now = date('Y-m');				
		
		
$sql = "select ".$prename."month.mon as month, sum(case when ".$prename."account.acamount is null then 0 else ".$prename."account.acamount end) as sum from ".$prename."month left join ".$prename."account on date_format(FROM_UNIXTIME(".$prename."account.actime),'%Y-%m') = ".$prename."month.mon and ac0=0 and acuserid='$_SESSION[uid]' and ac1=2 where ".$prename."month.mon>='".$firstdate."' and ".$prename."month.mon<='".$now."' group by month";


			
$query = mysqli_query($conn,$sql);

			while ($row = mysqli_fetch_array($query)) {
			
				if($row['sum']=='0'){
				$smonth= '0.00';
				}else{
				$smonth= $row['sum'];	
				}
                echo "'$smonth',";
			}

?>	
</body>
</html>