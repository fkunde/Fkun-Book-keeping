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
            //查询当前分类信息
            $sql = "select * from ".$prename."category where categoryid='$_GET[categoryid]' and ufid='$_SESSION[uid]'";
            $query = mysqli_query($conn,$sql);
            $cuclass = mysqli_fetch_array($query);
            //执行操作--修改分类名称
            if ($_GET['Submit']) {
                $sql = "update ".$prename."category set categoryname= '$_GET[categoryname2]' where categoryid='$_GET[categoryid]' and ufid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($query) {
                    echo "分类名称修改成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=category.php'>";
                    exit();
                } else {
                    echo "修改分类名称，执行数据库操作时失败！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=category.php'>";
                    exit();
                }
            }
            //执行操作--转移分类
            if ($_GET['Submit2']) {
                $sql = "select * from ".$prename."account where accategory= '$_GET[categoryid]' and acuserid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_array($query)) {
                    $sql = "update ".$prename."account set accategory= '$_GET[tocategoryid]' where acid= '$row[acid]' and acuserid='$_SESSION[uid]'";
                    mysqli_query($conn,$sql);
                }
                echo "转移完成，你可以查询此分类下是否还有记录，已确认是否全部转移成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=category.php'>";
                exit();
            }
            //执行操作--删除分类
            if ($_GET['Submit3']) {
                $sql = "select * from ".$prename."account where accategory='$_GET[categoryid]' and acuserid='$_SESSION[uid]'";
                $query = mysqli_query($conn,$sql);
                if ($row = mysqli_fetch_array($query)) {
                    echo "<font color='red'>无法删除！在此分类下有账目，请将账目转移到其他分类。</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=category.php'>";
                    exit();
                } else {
                    $sql = "delete from ".$prename."category where categoryid=".$_GET['categoryid'];
                    if (mysqli_query($conn,$sql))
                        echo "分类删除成功！</td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=category.php'>";
                    else
                        echo "<font color='red'>删除失败！从数据库中删除时返回失败！</font></td></tr></table> 2秒后自动返回<meta http-equiv=refresh content='2; url=category.php'>";
                    exit();
                }
            }
            //根据操作判断要显示内容
            if ($_GET['type'] == "1") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><form id="form1" name="form1" method="get" action="">
                            <label>将[<font color="red"><?php echo $cuclass['categoryname'];
                                ?></font>]修改为
                                <input name="categoryname2" type="text" id="categoryname2" value="<?php echo $cuclass['categoryname'];
                                ?>" />
                            </label>
                            <label>
                                <input type="submit" name="Submit" value="修改" />
                            </label>
                            <input name="categoryid" type="hidden" id="categoryid" value="<?php echo $_GET['categoryid'];
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
                            将[<font color="red"><?=$cuclass['categoryname'] ?></font>]
                            <label>转移到
                                <select name="tocategoryid" id="tocategoryid">
                                    <?php
                                    $sql = "select * from ".$prename."category where categoryid and ufid='$_SESSION[uid]'";
                                    $query = mysqli_query($conn,$sql);
                                    while ($row = mysqli_fetch_array($query)) {
                                        echo "<option value='$row[categoryid]'>$row[categoryname]</option>";
                                    }
                                    ?>
                                </select>
                            </label>
                            <label>
                                <input type="submit" name="Submit2" value="转移" />
                            </label>
                            <input name="categoryid" type="hidden" id="categoryid" value="<?=$_GET['categoryid'] ?>" />
                        </form>
                        </td>
                    </tr>
                </table>
                <?php
            } elseif ($_GET['type'] == "3") {
                ?>
                <table align="center" width="600" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>删除前请将此分类转移到其他分类，否则无法删除</td>
                    </tr>
                    <tr>
                        <td><form id="form3" name="form3" method="get" action="">
                            <label>
                                <input type="submit" name="Submit3" value="删除" />
                            </label>
                            <input name="categoryid" type="hidden" id="categoryid" value="<?=$_GET['categoryid'] ?>" />
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