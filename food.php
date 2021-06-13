<?php
include_once("header.php");
?>
<script language="JavaScript">
    function checkpost() {
        if (myform.ingredient.value == "") {
            alert("请输入食材名称");
            window.location = 'add.php';
            return false;
        }
    }
</script>
<script language="JavaScript">
    function checkpost() {
        if (myform3.recipe.value == "") {
            alert("请输入菜谱名称");
            window.location = 'add.php';
            return false;
        }
    }
</script>

<?php
if ($_GET["Submit"]) {
    $sql = "select * from " . $prename . "ingredients where ingredientname='$_GET[ingredient]' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn, $sql);
    $attitle = is_array($row = mysqli_fetch_array($query));
    if ($attitle) {
        $status_text = "食材已存在！";
    } else {
        $sql = "insert into " . $prename . "ingredients (ingredientname, ufid, ingredientunit, ingredientprice, ingredientquantity, ingredientstype) values ('$_GET[ingredient]', $_SESSION[uid], '$_GET[unit]', '$_GET[price]', '$_GET[quantity]', '$_GET[ingredientstype]')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $status_text = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        } else {
            $status_text = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        }
    }
}
?>
<?php

$thisweek = date('W', time());
$weektime = date("Y") . $thisweek;
if ($_GET["Submitplan"]) {
    $sql = "select * from " . $prename . "weekmeal where weektime='" . $weektime . "' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn, $sql);
    $attitle = is_array($rowplan = mysqli_fetch_array($query));
    if ($attitle) {

        $status_meal = "当周菜谱已更新！";
        $sqlplan = "update " . $prename . "weekmeal set monf='$_GET[monf]', monm='$_GET[monm]', mona='$_GET[mona]', tuef='$_GET[tuef]', tuem='$_GET[tuem]', tuea='$_GET[tuea]', wedf='$_GET[wedf]', wedm='$_GET[wedm]', weda='$_GET[weda]', thuf='$_GET[thuf]', thum='$_GET[thum]', thua='$_GET[thua]', frif='$_GET[frif]', frim='$_GET[frim]', fria='$_GET[fria]', satf='$_GET[satf]', satm='$_GET[satm]', sata='$_GET[sata]', sunf='$_GET[sunf]', sunm='$_GET[sunm]', suna='$_GET[suna]' where weektime='" . $weektime . "' and ufid='$_SESSION[uid]'";
        $query = mysqli_query($conn, $sqlplan);
        if ($query) {
            $status_meal = "<font color=#00CC00>更新成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        } else {
            $status_meal = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        }
    } else {

        $sqlplan = "insert into " . $prename . "weekmeal (ufid, weektime, monf, monm, mona, tuef, tuem, tuea, wedf, wedm, weda, thuf, thum, thua, frif, frim, fria, satf, satm, sata, sunf, sunm, suna) values ('$_SESSION[uid]','" . $weektime . "', '$_GET[monf]', '$_GET[monm]','$_GET[mona]','$_GET[tuef]', '$_GET[tuem]','$_GET[tuea]','$_GET[wedf]', '$_GET[wedm]','$_GET[weda]','$_GET[thuf]', '$_GET[thum]','$_GET[thua]','$_GET[frif]', '$_GET[frim]','$_GET[fria]','$_GET[satf]', '$_GET[satm]','$_GET[sata]','$_GET[sunf]', '$_GET[sunm]','$_GET[suna]')";
        $query = mysqli_query($conn, $sqlplan);
        if ($query) {
            $status_meal = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        } else {
            $status_meal = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        }
    }
}
?>

<?php
$suggestpw = $_SESSION['suggestpw'];
$foodindex = 0.8;
$breakfastindex = 0.3;
$foodperday = round((($foodindex * $suggestpw) / 7), 2);
$breakfast = $breakfastindex * $foodperday;
$dinner = ($foodperday - $breakfast) / 2;
// 一些参数

?>
<!--
开发中……
*为已完成

默认显示存在的食谱*

显示周数*

周数计算保存*

测试多用户可用性*

添加食材删除功能*

添加食谱更改功能*

食材统计*

食材统计输出*

食材统计输出对比原料购买量

购物清单输出*

食材剩余量

菜谱时间段改为勾选框*

食材价格输出



-->

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">食谱&nbsp;（
            <?php
            echo date('Y');
            echo " 年 第 ";
            echo $thisweek = date('W', time());
            echo " 周）";
            ?>

        </td>
    </tr>
    <form id="myform" name="form3" method="get" onsubmit="return checkpost();">
        <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
            <tr>
                <th align="left" bgcolor="#EBEBEB"> </th>

                <th align="left" bgcolor="#EBEBEB">MON</th>

                <th align="left" bgcolor="#EBEBEB">TUE</th>

                <th align="left" bgcolor="#EBEBEB">WED</th>

                <th align="left" bgcolor="#EBEBEB">THU</th>

                <th align="left" bgcolor="#EBEBEB">FRI</th>

                <th align="left" bgcolor="#EBEBEB">SAT</th>

                <th align="left" bgcolor="#EBEBEB">SUN</th>

            </tr>
            <tr>


                <th align="left" bgcolor="#EBEBEB">Frühstück (早餐)</th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="monf" id="monf" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['monf'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['monf'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3 or foodtime=5 or  foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }

                        ?>
                    </select>


                </th>


                <th align="left" bgcolor="#EBEBEB">
                    <select name="tuef" id="tuef" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['tuef'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['tuef'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3  or foodtime=5 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="wedf" id="wedf" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['wedf'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['wedf'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3  or foodtime=5 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="thuf" id="thuf" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['thuf'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['thuf'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3  or foodtime=5 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="frif" id="frif" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['frif'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['frif'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3  or foodtime=5 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="satf" id="satf" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['satf'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['satf'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3  or foodtime=5 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="sunf" id="sunf" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['sunf'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['sunf'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=1 or foodtime=3  or foodtime=5 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

            </tr>
            <tr>
                <th align="left" bgcolor="#EBEBEB">Mittagessen (中餐)</th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="monm" id="monm" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['monm'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['monm'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="tuem" id="tuem" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['tuem'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['tuem'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="wedm" id="wedm" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['wedm'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['wedm'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="thum" id="thum" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['thum'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['thum'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="frim" id="frim" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['frim'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['frim'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="satm" id="satm" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['satm'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['satm'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select> </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="sunm" id="sunm" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['sunm'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['sunm'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=2 or foodtime=3 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

            </tr>
            <tr>
                <th align="left" bgcolor="#EBEBEB">Abendessen (晚餐)</th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="mona" id="mona" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['mona'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['mona'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select> </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="tuea" id="tuea" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['tuea'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['tuea'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="weda" id="weda" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['weda'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['weda'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";

                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="thua" id="thua" style="height:26px;">

                        <?php

                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['thua'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['thua'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";

                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select> </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="fria" id="fria" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['fria'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['fria'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";

                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="sata" id="sata" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['sata'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['sata'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

                <th align="left" bgcolor="#EBEBEB">
                    <select name="suna" id="suna" style="height:26px;">

                        <?php
                        $sqlold = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
                        $queryold = mysqli_query($conn, $sqlold);
                        $rowold = mysqli_fetch_array($queryold);
                        $sqlrecipename = "select * from " . $prename . "recipe where recipeid = '" . $rowold['suna'] . "' and ufid='$_SESSION[uid]'";
                        $queryrecipename = mysqli_query($conn, $sqlrecipename);
                        $rowrecipename = mysqli_fetch_array($queryrecipename);
                        echo "<option value=" . $rowold['suna'] . ">" . $rowrecipename['recipename'] . "</option>";
                        echo "<option value=''>留空</option>";
                        $sql = "select * from " . $prename . "recipe where (foodtime=4 or foodtime=5 or foodtime=6 or foodtime=7) and ufid='$_SESSION[uid]'";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<option value='$row[recipeid]'>$row[recipename]</option>";
                        }
                        ?>
                    </select>
                </th>

            </tr>
        </table>
        <br>



        <input type="submit" name="Submitplan" value="添加/更新" class="btn btn-default" />
        <?php echo $status_meal;
        ?>
        <br>
    </form>
</table>
<br>

<?php
$sqling = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
$querying = mysqli_query($conn, $sqling);
$rowing = mysqli_fetch_array($querying);
$sqlrecnum = "select * from " . $prename . "weekmeal where weektime = '" . $weektime . "' and ufid='$_SESSION[uid]'";
$queryrecnum = mysqli_query($conn, $sqlrecnum);
$rowrecnum = mysqli_fetch_array($queryrecnum);
$ingarray = array();

for ($i = 0; $i <= 20; $i++) {
    $allrecipe = $rowrecnum[$i];
    $sqlall = "select * from " . $prename . "recipe where recipeid=" . $allrecipe . " and ufid='$_SESSION[uid]'";
    $queryall = mysqli_query($conn, $sqlall);
    if ($queryall) {
        $rowall = mysqli_fetch_array($queryall);
        $liststat = '';
    } else {
        $liststat = '(暂无)';
        break;
    }

    for ($zufor = 1; $zufor <= 7; $zufor++) {
        $zunum = strval($zufor);

        if ($rowall['zu' . $zunum]) {
            // echo $rowall['zu' . $zunum];
            // echo "<br>";
            $sqlingredient = "select * from " . $prename . "ingredients where ingredientid = '" . $rowall['zu' . $zunum] . "' and ufid='$_SESSION[uid]'";
            $queryingredient = mysqli_query($conn, $sqlingredient);
            $rowingredient = mysqli_fetch_array($queryingredient);
            $zuamount = $rowall['am' . $zunum];
            $zumaxamount = $rowingredient['ingredientquantity'];
            $ingneedbuy = ($zuamount / $zumaxamount);
            $oneingarray = array(
                array($rowingredient['ingredientname'], $zuamount, $rowingredient['ingredientunit'], $ingneedbuy)
            );
            $ingarray = array_merge_recursive($ingarray, $oneingarray);


            // echo "<br>";

        }
    }
}
// print_r($ingarray);
$item = array();
foreach ($ingarray as $k => $v) {
    if (!isset($item[$v[0]])) {
        $item[$v[0]] = $v;
    } else {
        $item[$v[0]][3] += $v[3];
        $item[$v[0]][1] += $v[1];
    }
}

$itemnum = array();
foreach ($item as $k => $v) {
    $itemnum[$v[0]][0] = $v[0];
    $itemnum[$v[0]][1] = $v[1];
    $itemnum[$v[0]][2] = $v[2];
    $itemnum[$v[0]][3] = round($v[3], 2);
}



?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <?php
        echo '<td bgcolor="#EBEBEB">购物清单' . $liststat . '</td>';
        ?>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

                <?php
                // 菜谱列表获取


                echo '<tr bgcolor="#dddddd">';
                echo '<th>食材名称</th><th>数量</th><th>单位</th><th>所需购买量</th>';
                echo '</tr>';
                foreach ($itemnum as $key => $value) {
                    echo '<tr>';

                    foreach ($value as $mn) {
                        echo "<td>{$mn}</td>";
                    }
                    echo '</tr>';
                }
                ?>

            </table>

        </td>
    </tr>
    <tr>
        <td bgcolor="#EBEBEB">录入食材</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">

        </td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="myform" name="form2" method="get" onsubmit="return checkpost();">
                食材名称：<input name="ingredient" type="text" id="ingredient" />
                <br /><br />
                食材价格：<input name="price" type="text" id="price" />
                <br /><br />
                拆分单位：<input name="unit" type="text" id="unit" />
                <br /><br />
                拆分总数：<input name="quantity" type="text" id="quantity" />
                <br /><br />
                食材分类：<select name="ingredientstype" type="text" id="ingredientstype">
                    <option value='1'>蔬菜</option>
                    <option value='2'>肉类</option>
                    <option value='3'>糖水混合物</option>
                    <option value='4'>饮料</option>
                </select>
                <br /><br />



                <input type="submit" name="Submit" value="添加" class="btn btn-default" />

                <?php echo $status_text;
                ?>
            </form>
        </td>
    </tr>
</table>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">食材管理</td>
    </tr>
</table>

<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

    <tr>
        <th align="left" bgcolor="#EBEBEB">食材名称</th>

        <th align="left" bgcolor="#EBEBEB">食材价格</th>

        <th align="left" bgcolor="#EBEBEB">拆分总数</th>

        <th align="left" bgcolor="#EBEBEB">拆分单位</th>

        <th align="left" bgcolor="#EBEBEB">食材分类</th>

        <th align="left" bgcolor="#EBEBEB">操作</th>
    </tr>
    <?php
    $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['ingredientname'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['ingredientprice'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['ingredientquantity'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['ingredientunit'] . "</font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>";
        if ($row['ingredientstype'] == 1) {
            echo "蔬菜";
        }
        if ($row['ingredientstype'] == 2) {
            echo "肉类";
        }
        if ($row['ingredientstype'] == 3) {
            echo "糖水混合物";
        }
        if ($row['ingredientstype'] == 4) {
            echo "饮料";
        }
        echo "
		 </font></td>
		 ";
        echo "<td align='left' bgcolor='#FFFFFF'><a href='edit_ingredient.php?type=3&ingredientid=" . $row['ingredientid'] . "'>删除</a></td></tr>";
    }
    echo "</tr>";
    ?>
</table>


<?php
if ($_GET["Submit2"]) {
    $sql = "select * from " . $prename . "recipe where recipename='$_GET[recipename]' and ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn, $sql);
    $attitle = is_array($row = mysqli_fetch_array($query));
    if ($attitle) {
        $status_text2 = "食谱已存在！";
    } else {
        $foodtime = $_GET['fru'] + $_GET['mit'] + $_GET['abe'];
        $sql = "insert into " . $prename . "recipe (recipename, ufid, zu1, am1, zu2, am2, zu3, am3, zu4,  am4, zu5, am5, zu6, am6, zu7, am7, satiety, foodtime, difficulty) values ('$_GET[recipename]', $_SESSION[uid], '$_GET[zu1]', '$_GET[am1]', '$_GET[zu2]', '$_GET[am2]', '$_GET[zu3]', '$_GET[am3]', '$_GET[zu4]', '$_GET[am4]', '$_GET[zu5]', '$_GET[am5]', '$_GET[zu6]', '$_GET[am6]', '$_GET[zu7]', '$_GET[am7]', '$_GET[satiety]', '" . $foodtime . "', '$_GET[difficulty]')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $status_text2 = "<font color=#00CC00>添加成功！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        } else {
            $status_text2 = "<font color=#FF0000>添加失败,写入数据库时发生错误！</font>";
            echo "<meta http-equiv=refresh content='0; url=food.php'>";
        }
    }
}
?>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">添加食谱</td>
    </tr>
    <tr>
        <td bgcolor="#FFFFFF">
            <form id="myform2" name="form3" method="get" onsubmit="return checkpost();">
                食谱名称：<input name="recipename" type="text" id="recipename" />
                <br /><br />
                食谱能量：<input name="satiety" type="text" id="satiety" />
                <br /><br />
                制作时间：<input name="difficulty" type="text" id="difficulty" />
                <br /><br />
                食谱时段：
                <input type="checkbox" name="fru" value="1" checked="checked">早餐</input>&nbsp
                <input type="checkbox" name="mit" value="2" checked="checked">中餐</input>&nbsp
                <input type="checkbox" name="abe" value="4" checked="checked">晚餐</input>&nbsp
                <br><br>

                <table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
                    <tr>
                        原料选择：
                        <br>
                        <th>
                            <br />
                            食材名称/单位
                        <th>
                            <select name="zu1" id="zu1" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                            <select name="zu2" id="zu2" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                            <select name="zu3" id="zu3" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                            <select name="zu4" id="zu4" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                            <select name="zu5" id="zu5" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                            <select name="zu6" id="zu6" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                            <select name="zu7" id="zu7" style="height:26px;">
                                <option value="0"></option>
                                <?php
                                $sql = "select * from " . $prename . "ingredients where ufid='$_SESSION[uid]'";
                                $query = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='$row[ingredientid]'>$row[ingredientname]/$row[ingredientunit]</option>";
                                }
                                ?>
                            </select>
                        </th>
                    </tr>
                    <td> 数量</td>
                    <td><input name="am1" type="text" id="am1" value="0" /></td>
                    <td><input name="am2" type="text" id="am2" value="0" /></td>
                    <td><input name="am3" type="text" id="am3" value="0" /></td>
                    <td><input name="am4" type="text" id="am4" value="0" /></td>
                    <td><input name="am5" type="text" id="am5" value="0" /></td>
                    <td><input name="am6" type="text" id="am6" value="0" /></td>
                    <td><input name="am7" type="text" id="am7" value="0" /></td>
                </table>



                <br /><br />
                <input type="submit" name="Submit2" value="添加" class="btn" />
                <?php echo $status_text2;
                ?>
            </form>
        </td>
    </tr>
</table>

<table align="left" width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>
    <tr>
        <td bgcolor="#EBEBEB">食谱管理</td>
    </tr>
</table>

<table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" bgcolor='#B3B3B3' class='table table-striped table-bordered'>

    <tr>
        <th align="left" bgcolor="#EBEBEB">食谱名称</th>

        <th align="left" bgcolor="#EBEBEB">食谱时段</th>

        <th align="left" bgcolor="#EBEBEB">食谱原材料</th>

        <th align="left" bgcolor="#EBEBEB">食谱价格</th>

        <th align="left" bgcolor="#EBEBEB">食谱饱食度</th>

        <th align="left" bgcolor="#EBEBEB">食谱难易度</th>

        <th align="left" bgcolor="#EBEBEB">操作</th>
    </tr>
    <?php
    $sql = "select * from " . $prename . "recipe where ufid='$_SESSION[uid]'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu1] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu1 = mysqli_fetch_array($classquery);

        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu2] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu2 = mysqli_fetch_array($classquery);

        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu3] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu3 = mysqli_fetch_array($classquery);

        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu4] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu4 = mysqli_fetch_array($classquery);

        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu5] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu5 = mysqli_fetch_array($classquery);

        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu6] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu6 = mysqli_fetch_array($classquery);

        $sql = "select * from " . $prename . "ingredients where ingredientid=$row[zu7] and ufid='$_SESSION[uid]'";
        $classquery = mysqli_query($conn, $sql);
        $zu7 = mysqli_fetch_array($classquery);

        echo "<tr><td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>" . $row['recipename'] . "</font></td>";

        echo "<td align='left' bgcolor='#FFFFFF'><font color='MediumSeaGreen'>";
        if ($row['foodtime'] == 1) {
            echo "早";
        } elseif ($row['foodtime'] == 2) {
            echo "中";
        } elseif ($row['foodtime'] == 4) {
            echo "晚";
        } elseif ($row['foodtime'] == 3) {
            echo "早/中";
        } elseif ($row['foodtime'] == 6) {
            echo "中/晚";
        } elseif ($row['foodtime'] == 7) {
            echo "早/中/晚";
        } else {
            echo "早/晚";
        }



        echo "
		 </font></td>
		 ";
        echo "<td align='left' bgcolor='#FFFFFF'>";

        if ($row['am1'] != 0) {
            echo "
         " . $zu1['ingredientname'] . " " . $row['am1'] . " " . $zu1['ingredientunit'] . " 
	   ";
        }
        if ($row['am2'] != 0) {
            echo "
         " . $zu2['ingredientname'] . " " . $row['am2'] . " " . $zu2['ingredientunit'] . " 
	   ";
        }
        if ($row['am3'] != 0) {
            echo "
      " . $zu3['ingredientname'] . " " . $row['am3'] . " " . $zu3['ingredientunit'] . " 
	   ";
        }
        if ($row['am4'] != 0) {
            echo "
     " . $zu4['ingredientname'] . " " . $row['am4'] . " " . $zu4['ingredientunit'] . " 
	   ";
        }
        if ($row['am5'] != 0) {
            echo "
       " . $zu5['ingredientname'] . " " . $row['am5'] . " " . $zu5['ingredientunit'] . " 
	   ";
        }
        if ($row['am6'] != 0) {
            echo "
     " . $zu6['ingredientname'] . " " . $row['am6'] . " " . $zu6['ingredientunit'] . " 
	   ";
        }
        if ($row['am7'] != 0) {
            echo "
       " . $zu7['ingredientname'] . " " . $row['am6'] . " " . $zu7['ingredientunit'] . " 
	   ";
        }

        if ($row['am1'] != 0) {
            $sum1 = (($zu1['ingredientprice'] / $zu1['ingredientquantity']) * $row['am1']);
        } else {
            $sum1 = 0;
        }
        if ($row['am2'] != 0) {
            $sum2 = (($zu2['ingredientprice'] / $zu2['ingredientquantity']) * $row['am2']);
        } else {
            $sum2 = 0;
        }
        if ($row['am3'] != 0) {
            $sum3 = (($zu3['ingredientprice'] / $zu3['ingredientquantity']) * $row['am3']);
        } else {
            $sum3 = 0;
        }
        if ($row['am4'] != 0) {
            $sum4 = (($zu4['ingredientprice'] / $zu4['ingredientquantity']) * $row['am4']);
        } else {
            $sum4 = 0;
        }
        if ($$row['am5'] != 0) {
            $sum5 = (($zu5['ingredientprice'] / $zu5['ingredientquantity']) * $row['am5']);
        } else {
            $sum5 = 0;
        }
        if ($row['am6'] != 0) {
            $sum6 = (($zu6['ingredientprice'] / $zu6['ingredientquantity']) * $row['am6']);
        } else {
            $sum6 = 0;
        }
        if ($row['am7'] != 0) {
            $sum7 = (($zu7['ingredientprice'] / $zu7['ingredientquantity']) * $row['am7']);
        } else {
            $sum7 = 0;
        }
        $sumprice = round(($sum1 + $sum2 + $sum3 + $sum4 + $sum5 + $sum6 + $sum7), 2);

        echo "<td font color='MediumSeaGreen'bgcolor='#FFFFFF'> " . $sumprice . " </font></td>";
        echo "<td font color='MediumSeaGreen'bgcolor='#FFFFFF'> " . $row['satiety'] . " </font></td>";
        echo "<td font color='MediumSeaGreen'bgcolor='#FFFFFF'> " . $row['difficulty'] . " </font></td>";
        echo "<td align='left' bgcolor='#FFFFFF'><a href='edit_recipe.php?type=3&recipeid=" . $row['recipeid'] . "'>删除</a></td></tr>";
    }
    echo "</tr>";
    ?>
</table>

<?php
include_once("footer.php");
?>