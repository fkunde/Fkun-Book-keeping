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
            //查询当前基础开销信息
            $sql = "select * from ".$prename."base where baseid='$_GET[baseid]' and ufid='$_SESSION[uid]'";
            $query = mysqli_query($conn,$sql);
            $cuclass = mysqli_fetch_array($query);
            //执行操作--修改基础开销名称
            if ($_GET['Submit']) {
                $sql = "update ".$prename."base set base= '$_GET[base2]' where baseid='$_GET[baseid]' and ufid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($query) {
                    echo "基础开销名称修改成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
                    exit();
                } else {
                    echo "修改基础开销名称，执行数据库操作时失败！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
                    exit();
                }
            }
         
            //执行操作--删除基础开销
            if ($_GET['Submit3']) {
                    $sql = "delete from ".$prename."base where baseid=".$_GET['baseid'];
                    if (mysqli_query($conn,$sql))
                        echo "基础开销删除成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=plan.php'>";
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
                            <label>将[<font color="red"><?php echo $cuclass['base'];
                                ?></font>]修改为
                                <input name="base2" type="text" id="base2" value="<?php echo $cuclass['base'];
                                ?>" />
                            </label>
                            <label>
                                <input type="submit" name="Submit" value="修改" />
                            </label>
                            <input name="baseid" type="hidden" id="baseid" value="<?php echo $_GET['baseid'];
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
                            将[<font color="red"><?=$cuclass['base'] ?></font>]
                            <label>转移到
                                <select name="tobaseid" id="tobaseid">
                                    <?php
                                    $sql = "select * from ".$prename."base where baseid and ufid='$_SESSION[uid]'";
                                    $query = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo "<option value='$row[baseid]'>$row[base]</option>";
                                    }
                                    ?>
                                </select>
                            </label>
                            <label>
                                <input type="submit" name="Submit2" value="转移" />
                            </label>
                            <input name="baseid" type="hidden" id="baseid" value="<?=$_GET['baseid'] ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($_GET['type'] == "3") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>确认删除该基础开销？</td>
                    </tr>
                    <tr>
                        <td><form id="form3" name="form3" method="get" action="">
                            <label>
                                <input type="submit" name="Submit3" value="删除" />
                            </label>
                            <input name="baseid" type="hidden" id="baseid" value="<?=$_GET['baseid'] ?>" />
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