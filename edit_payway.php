<?php
include_once("header.php");
?>
<table align="center" width="640" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="40" height="25">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="40" height="85">&nbsp;</td>
        <td align="left" valign="top">
            <?php
            //查询当前交易方式信息
            $sql = "select * from ".$prename."account_payway where payid='$_GET[payid]' and ufid='$_SESSION[uid]'";
            $query = mysqli_query($conn,$sql);
            $cuclass = mysqli_fetch_array($query);
            //执行操作--修改交易方式名称
            if ($_GET['Submit']) {
                $sql = "update ".$prename."account_payway set paywayname= '$_GET[paywayname2]' where payid='$_GET[payid]' and ufid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($query) {
                    echo "交易方式名称修改成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=classify.php'>";
                    exit();
                } else {
                    echo "修改交易方式名称，执行数据库操作时失败！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=payway.php'>";
                    exit();
                }
            }
            //执行操作--转移交易方式
            if ($_GET['Submit2']) {
                $sql = "select * from ".$prename."account where acpayway= '$_GET[payid]' and acuserid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_array($query)) {
                    $sql = "update ".$prename."account set acpayway= '$_GET[topayid]' where acid= '$row[acid]' and acuserid='$_SESSION[uid]'";
                    mysqli_query($conn,$sql);
                }
                echo "转移完成，你可以查询此交易方式下是否还有记录，已确认是否全部转移成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=payway.php'>";
                exit();
            }
            //执行操作--删除交易方式
            if ($_GET['Submit3']) {
                $sql = "select * from ".$prename."account where acpayway='$_GET[payid]' and acuserid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($row = mysqli_fetch_array($query)) {
                    echo "<font color='red'>无法删除！在此交易方式下有账目，请将账目转移到其他交易方式。</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=payway.php'>";
                    exit();
                } else {
                    $sql = "delete from ".$prename."account_payway where payid=".$_GET['payid'];
                    if (mysqli_query($conn,$sql))
                        echo "交易方式删除成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=payway.php'>";
                    else
                        echo "<font color='red'>删除失败！从数据库中删除时返回失败！</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=payway.php'>";
                    exit();
                }
            }
            //根据操作判断要显示内容
            if ($_GET['type'] == "1") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><form id="form1" name="form1" method="get" action="">
                            <label>将[<font color="red"><?php echo $cuclass['paywayname'];
                                ?></font>]修改为
                                <input name="paywayname2" type="text" id="paywayname2" value="<?php echo $cuclass['paywayname'];
                                ?>" />
                            </label>
                            <label>
                                <input type="submit" name="Submit" value="修改" />
                            </label>
                            <input name="payid" type="hidden" id="payid" value="<?php echo $_GET['payid'];
                            ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($_GET['type'] == "2") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><form id="form2" name="form2" method="get" action="">
                            将[<font color="red"><?=$cuclass['paywayname'] ?></font>]
                            <label>转移到
                                <select name="topayid" id="topayid">
                                    <?php
                                    $sql = "select * from ".$prename."account_payway where payid and ufid='$_SESSION[uid]'";
                                    $query = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo "<option value='$row[payid]'>$row[paywayname]</option>";
                                    }
                                    ?>
                                </select>
                            </label>
                            <label>
                                <input type="submit" name="Submit2" value="转移" />
                            </label>
                            <input name="payid" type="hidden" id="payid" value="<?=$_GET['payid'] ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($_GET['type'] == "3") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>删除前请将此交易方式转移到其他交易方式，否则无法删除</td>
                    </tr>
                    <tr>
                        <td><form id="form3" name="form3" method="get" action="">
                            <label>
                                <input type="submit" name="Submit3" value="删除" />
                            </label>
                            <input name="payid" type="hidden" id="payid" value="<?=$_GET['payid'] ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } else {
                echo "参数错误！";
            }
            ?>
        </td>
    </tr>
</table>
<?php
include_once("footer.php");
?>