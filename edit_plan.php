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
            //查询当前预算信息
            $sql = "select * from ".$prename."plan where planid='$_GET[planid]' and ufid='$_SESSION[uid]'";
            $query = mysqli_query($conn,$sql);
            $cuclass = mysqli_fetch_array($query);
            //执行操作--修改预算名称
            if ($_GET['Submit']) {
                $sql = "update ".$prename."plan set plan= '". $_GET['plan2'] ."', planamount= '". $_GET['planamount2'] ."', where planid= '". $_GET['planid'] ."', and ufid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($query) {
                    echo "预算名称修改成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
                    exit();
                } else {
                    echo "修改预算名称，执行数据库操作时失败！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
                    exit();
                }
            }
         
            //执行操作--删除预算
            if ($_GET['Submit3']) {
                    $sql = "delete from ".$prename."plan where planid=".$_GET['planid'];
                    if (mysqli_query($conn,$sql))
                        echo "预算删除成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
                    else
                        echo "<font color='red'>删除失败！从数据库中删除时返回失败！</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
                    exit();

            }
            //根据操作判断要显示内容
            if ($_GET['type'] == "1") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><form id="form1" name="form1" method="get" action="">
                            <label>将预算名称[<font color="red"><?php echo $cuclass['plan'];
                                ?></font>]修改为
                                <input name="plan2" type="text" id="plan2" value="<?php echo $cuclass['plan'];
                                ?>" />
                            </label>
                            <br>
                            <br>
                            <label>将预算[<font color="red"><?php echo $cuclass['planamount'];
                                ?></font>]修改为
                                <input name="planamount2" type="text" id="planamount2" value="<?php echo $cuclass['planamount'];
                                ?>" />
                            </label>
                            <label>
                                <input type="submit" name="Submit" value="修改" />
                            </label>
                            <input name="planid" type="hidden" id="planid" value="<?php echo $_GET['planid'];
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
                            将[<font color="red"><?=$cuclass['plan'] ?></font>]
                            <label>转移到
                                <select name="toplanid" id="toplanid">
                                    <?php
                                    $sql = "select * from ".$prename."plan where planid and ufid='$_SESSION[uid]'";
                                    $query = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo "<option value='$row[planid]'>$row[plan]</option>";
                                    }
                                    ?>
                                </select>
                            </label>
                            <label>
                                <input type="submit" name="Submit2" value="转移" />
                            </label>
                            <input name="planid" type="hidden" id="planid" value="<?=$_GET['planid'] ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($_GET['type'] == "3") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>确认删除该预算？</td>
                    </tr>
                    <tr>
                        <td><form id="form3" name="form3" method="get" action="">
                            <label>
                                <input type="submit" name="Submit3" value="删除" />
                            </label>
                            <input name="planid" type="hidden" id="planid" value="<?=$_GET['planid'] ?>" />
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