<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <title>Install</title>


    <p align="center">
        <?php
        include("config.php");
        echo "创建数据库.....";
        if (indatabase($db_dbname, $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $query = mysqli_query($conn, "create database " . $db_dbname . " default character SET utf8 COLLATE utf8_general_ci");
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br />";
            }
        }
        echo "创建表 " . $prename . "account .....";
        if (intable($db_dbname, $prename . "account", $conn)) {
            echo "<br />已存在<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "account` (`acid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `acamount` DECIMAL(10,2) NOT NULL, `acclassid` INT(8) NOT NULL, `actime` INT(11) NOT NULL, `acremark` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `accategory` INT(8) NOT NULL, `acuserid` INT(8) NOT NULL, `acplace` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `acpayway` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `acname` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `ac0` INT(8) NOT NULL, `ac1` INT(8) NOT NULL  , `ac2` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL )   ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo $sql;
                echo "<br />失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }
        }

        echo "<br />创建表 " . $prename . "account_payway .....";
        if (intable($db_dbname, $prename . "account_payway", $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "account_payway` (`payid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `paywayname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }

            echo "<br />加入默认支付方式数据";
            $query = mysqli_query($conn, "select * from " . $prename . "account_payway where paywayname='BAR'");
            $attitle = is_array($row = mysqli_fetch_array($query));
            if ($attitle) {
                echo "<br />已存在!<br />";
            } else {
                $sql = "insert into " . $prename . "account_payway (paywayname,ufid) values ('现金','1'),('刷卡','1'),('支付宝','1'),('微信','1')";
                $query = mysqli_query($conn, $sql);
                echo "成功！<br />";
            }
        }

        echo "<br />创建表 " . $prename . "category .....";
        if (intable($db_dbname, $prename . "category", $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "category` (`categoryid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `categoryname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }
            echo "<br />默认分类加入";
            $query = mysqli_query($conn, "select * from " . $prename . "category where categoryname='STANDARD'");
            $attitle = is_array($row = mysqli_fetch_array($query));
            if ($attitle) {
                echo "<br />已存在!<br />";
            } else {
                $sql = "insert into " . $prename . "category (categoryname,ufid) values ('食物','1'),('生活用品','1'),('娱乐','1')";
                $query = mysqli_query($conn, $sql);
                echo "成功！<br />";
            }
        }

        echo "<br />创建表 " . $prename . "date .....";
        if (intable($db_dbname, $prename . "date", $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "date` (`dateid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `date` INT(11) NOT NULL, `datetype` INT(5) NOT NULL, `ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }

            echo "<br />默认日期加入";
            $query = mysqli_query($conn, "select * from " . $prename . "date where dateid='1'");
            $attitle = is_array($row = mysqli_fetch_array($query));
            if ($attitle) {
                echo "<br />已存在!<br />";
            } else {
                $sql = "insert into " . $prename . "date (date,ufid,datetype) values ('1704038400','1','0'),('10','1',1)";
                $query = mysqli_query($conn, $sql);
                echo "成功！<br />";
            }
        }


        echo "<br />创建表 " . $prename . "plan .....";
        if (intable($db_dbname, $prename . "plan", $conn)) {
            echo "<br />已存在<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "plan` (`planid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `plan` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`planamount` DECIMAL(10,2) NOT NULL, `ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }
        }


        echo "<br />创建表 " . $prename . "base .....";
        if (intable($db_dbname, $prename . "base", $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "base` (`baseid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `base` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`baseamount` DECIMAL(10,2) NOT NULL, `ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败啦，请检查config.php相关配置。</font></body></html>";
            }
        }



        echo "<br />创建表 " . $prename . "month .....";
        if (intable($db_dbname, $prename . "month", $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "month` (id int auto_increment primary key,mon char(7))ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败啦，请检查config.php相关配置。</font></body></html>";
            }

            echo "<br />时间模版加入";
            $query = mysqli_query($conn, "select * from " . $prename . "month where mon='2010-1'");
            $attitle = is_array($row = mysqli_fetch_array($query));
            if ($attitle) {
                echo "<br />已存在!<br />";
            } else {
                $sql = "insert into " . $prename . "month (mon) values ('2010-01'),('2010-02'),('2010-03'),('2010-04'),('2010-05'),('2010-06'),('2010-07'),('2010-08'),('2010-09'),('2010-10'),('2010-11'),('2010-12'),('2011-01'),('2011-02'),('2011-03'),('2011-04'),('2011-05'),('2011-06'),('2011-07'),('2011-08'),('2011-09'),('2011-10'),('2011-11'),('2011-12'),('2012-01'),('2012-02'),('2012-03'),('2012-04'),('2012-05'),('2012-06'),('2012-07'),('2012-08'),('2012-09'),('2012-10'),('2012-11'),('2012-12'),('2013-01'),('2013-02'),('2013-03'),('2013-04'),('2013-05'),('2013-06'),('2013-07'),('2013-08'),('2013-09'),('2013-10'),('2013-11'),('2013-12'),('2014-01'),('2014-02'),('2014-03'),('2014-04'),('2014-05'),('2014-06'),('2014-07'),('2014-08'),('2014-09'),('2014-10'),('2014-11'),('2014-12'),('2015-01'),('2015-02'),('2015-03'),('2015-04'),('2015-05'),('2015-06'),('2015-07'),('2015-08'),('2015-09'),('2015-10'),('2015-11'),('2015-12'),('2016-01'),('2016-02'),('2016-03'),('2016-04'),('2016-05'),('2016-06'),('2016-07'),('2016-08'),('2016-09'),('2016-10'),('2016-11'),('2016-12'),('2017-01'),('2017-02'),('2017-03'),('2017-04'),('2017-05'),('2017-06'),('2017-07'),('2017-08'),('2017-09'),('2017-10'),('2017-11'),('2017-12'),('2018-01'),('2018-02'),('2018-03'),('2018-04'),('2018-05'),('2018-06'),('2018-07'),('2018-08'),('2018-09'),('2018-10'),('2018-11'),('2018-12'),('2019-01'),('2019-02'),('2019-03'),('2019-04'),('2019-05'),('2019-06'),('2019-07'),('2019-08'),('2019-09'),('2019-10'),('2019-11'),('2019-12'),('2020-01'),('2020-02'),('2020-03'),('2020-04'),('2020-05'),('2020-06'),('2020-07'),('2020-08'),('2020-09'),('2020-10'),('2020-11'),('2020-12'),('2021-01'),('2021-02'),('2021-03'),('2021-04'),('2021-05'),('2021-06'),('2021-07'),('2021-08'),('2021-09'),('2021-10'),('2021-11'),('2021-12'),('2022-01'),('2022-02'),('2022-03'),('2022-04'),('2022-05'),('2022-06'),('2022-07'),('2022-08'),('2022-09'),('2022-10'),('2022-11'),('2022-12'),('2023-01'),('2023-02'),('2023-03'),('2023-04'),('2023-05'),('2023-06'),('2023-07'),('2023-08'),('2023-09'),('2023-10'),('2023-11'),('2023-12'),('2024-01'),('2024-02'),('2024-03'),('2024-04'),('2024-05'),('2024-06'),('2024-07'),('2024-08'),('2024-09'),('2024-10'),('2024-11'),('2024-12'),('2025-01'),('2025-02'),('2025-03'),('2025-04'),('2025-05'),('2025-06'),('2025-07'),('2025-08'),('2025-09'),('2025-10'),('2025-11'),('2025-12'),('2026-01'),('2026-02'),('2026-03'),('2026-04'),('2026-05'),('2026-06'),('2026-07'),('2026-08'),('2026-09'),('2026-10'),('2026-11'),('2026-12'),('2027-01'),('2027-02'),('2027-03'),('2027-04'),('2027-05'),('2027-06'),('2027-07'),('2027-08'),('2027-09'),('2027-10'),('2027-11'),('2027-12'),('2028-01'),('2028-02'),('2028-03'),('2028-04'),('2028-05'),('2028-06'),('2028-07'),('2028-08'),('2028-09'),('2028-10'),('2028-11'),('2028-12'),('2029-01'),('2029-02'),('2029-03'),('2029-04'),('2029-05'),('2029-06'),('2029-07'),('2029-08'),('2029-09'),('2029-10'),('2029-11'),('2029-12'),('2030-01'),('2030-02'),('2030-03'),('2030-04'),('2030-05'),('2030-06'),('2030-07'),('2030-08'),('2030-09'),('2030-10'),('2030-11'),('2030-12')";
                $query = mysqli_query($conn, $sql);
                echo "成功！<br />";
            }
        }
        echo "<br />创建表 " . $prename . "zutaten .....";
        if (intable($db_dbname, $prename . "ingredients", $conn)) {
            echo "<br />已存在!<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "ingredients` (`ingredientid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `ingredientname` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`ingredientunit` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`ingredientprice` DECIMAL(10,2) NOT NULL, `ingredientquantity` DECIMAL(10,2) NOT NULL, `ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo $sql;
                echo "<br />失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }
        }

        echo "<br />创建表 " . $prename . "Rezept .....";
        if (intable($db_dbname, $prename . "recipe", $conn)) {
            echo "<br />已存在<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "recipe` (`recipeid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `recipename` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,`zu1` INT(5),`am1` DECIMAL(10,2),`zu2` INT(5),`am2` DECIMAL(10,2) ,`zu3` INT(5),`am3` DECIMAL(10,2),`zu4` INT(5),`am4` DECIMAL(10,2),`zu5` INT(5),`am5` DECIMAL(10,2),`zu6` INT(5) ,`am6` DECIMAL(10,2),`zu7` INT(5),`am7` DECIMAL(10,2), `satiety` DECIMAL(10,2),`difficulty` DECIMAL(10,2),`foodtime` INT(5),`ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo $sql;
                echo "<br />失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }
        }

        echo "<br />创建表 " . $prename . "Weekmeal .....";
        if (intable($db_dbname, $prename . "weekmeal", $conn)) {
            echo "<br />已存在<br />";
        } else {
            $sql = "CREATE TABLE `$db_dbname`.`" . $prename . "weekmeal` (`monf` INT(15),`monm` INT(15),`mona` INT(15),`tuef` INT(15),`tuem` INT(15),`tuea` INT(15),`wedf` INT(15),`wedm` INT(15),`weda` INT(15),`thuf` INT(15),`thum` INT(15),`thua` INT(15),`frif` INT(15),`frim` INT(15),`fria` INT(15),`satf` INT(15),`satm` INT(15),`sata` INT(15),`sunf` INT(15),`sunm` INT(15),`suna` INT(15),`weekplanid` INT(15) NOT NULL AUTO_INCREMENT PRIMARY KEY,`weektime` INT(15),`ufid` INT(8) NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo "成功<br />";
            } else {
                echo $sql;
                echo "<br />失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }

            echo "<br />默认食谱加入";
            $query = mysqli_query($conn, "select * from " . $prename . "weekmeal where weekplanid='1'");
            $attitle = is_array($row = mysqli_fetch_array($query));
            if ($attitle) {
                echo "<br />已存在!<br />";
            } else {
                $sql = "insert into Finance_weekmeal (ufid, weektime, monf, monm, mona, tuef, tuem, tuea, wedf, wedm, weda, thuf, thum, thua, frif, frim, fria, satf, satm, sata, sunf, sunm, suna) values ('1', '1', '', '','','', '','','', '','','', '','','', '','','', '','','', '','')";
                $query = mysqli_query($conn, $sql);
                echo "成功！<br />";
            }
        }
        echo "<br />创建表 " . $prename . "user .....";
        if (intable($db_dbname, $prename . "user", $conn)) {
            echo "<br />已存在<br />";
        } else {
            $query = mysqli_query($conn, "CREATE TABLE `$db_dbname`.`" . $prename . "user` (`uid` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `username` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `password` VARCHAR(35) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `email` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,  `utime` INT(11) NOT NULL, `currency` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;");
            if ($query) {
                echo "成功<br />";
            } else {
                echo "失败<br /><font color='red'>安装失败，请检查config.php相关配置。</font></body></html>";
            }
            echo "<br />加入默认用户.....";
            $query = mysqli_query($conn, "select * from " . $prename . "user where username='admin'");
            $attitle = is_array($row = mysqli_fetch_array($query));
            if ($attitle) {
                echo "<br />默认用户已存在！<br /><a href='login.php'>点这里立即登录</a>";
                exit();
            } else {
                $nowdate = date("Y-m-d H:i:s");
                $utime = strtotime($nowdate);
                $query = mysqli_query($conn, "insert into " . $prename . "user (uid, username, password,email,utime,currency) values ('1', 'test', '098f6bcd4621d373cade4e832627b4f6','admin@fkun.tech','$utime','¥')");
                if ($query) {
                    echo "成功<br />";
                    echo "<br />安装完成！请再主页注册新账号开始使用！";
                } else {
                    echo "失败<br />";
                }
            }
        }
        ?>
        <br /><a href="login.php">回到主页</a>
    </p>

    </body>

</html>