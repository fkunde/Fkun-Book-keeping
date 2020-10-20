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
            $sql = "select * from ".$prename."recipe where recipeid='$_GET[recipeid]' and ufid='$_SESSION[uid]'";
            $query = mysqli_query($conn,$sql);
            $cuclass = mysqli_fetch_array($query);
            //执行操作--修改基础开销名称
            if ($_GET['Submit']) {
                $sql = "update ".$prename."recipe set recipename= '$_GET[recipename2]' where recipeid='$_GET[recipeid]' and ufid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($query) {
                    echo "食谱修改成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=food.php'>";
                    exit();
                } else {
                    echo "执行数据库操作时失败！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=food.php'>";
                    exit();
                }
            }
         
            //执行操作--删除基础开销
            if ($_GET['Submit3']) {
                    $sql = "delete from ".$prename."recipe where recipeid=".$_GET['recipeid'];
                    if (mysqli_query($conn,$sql))
                        echo "删除成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=food.php'>";
                    else
                        echo "<font color='red'>删除失败！从数据库中删除时返回失败！</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=food.php'>";
                    exit();

            }
            //根据操作判断要显示内容
            if ($_GET['type'] == "1") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><form id="form1" name="form1" method="get" action="">
                            <label>将[<font color="red"><?php echo $cuclass['recipename'];
                                ?></font>]修改为
                                <input name="recipename2" type="text" id="recipename2" value="<?php echo $cuclass['recipename'];
                                ?>" />
                            </label>
                            <label>
                                <input type="submit" name="Submit" value="修改" />
                            </label>
                            <input name="ingredinetid" type="hidden" id="recipeid" value="<?php echo $_GET['recipeid'];
                            ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($_GET['type'] == "3") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>确认删除食谱？</td>
                    </tr>
                    <tr>
                        <td><form id="form3" name="form3" method="get" action="">
                            <label>
                                <input type="submit" name="Submit3" value="删除" />
                            </label>
                            <input name="recipeid" type="hidden" id="recipeid" value="<?=$_GET['recipeid'] ?>" />
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