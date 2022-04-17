<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
    include("config.php");
    $arr = user_shell($_SESSION['uid'], $_SESSION['user_shell']);
    //对权限进行判断

$ctype= $_GET["ctype"];
if(isset($ctype)){
    $sql = "select * from " . $prename . "category where `type` =$ctype and `ufid`='$_SESSION[uid]'";
                    $query = mysqli_query($conn, $sql);
                    while ($accategory = mysqli_fetch_array($query)) {
                        $select[] = array("categoryid"=>$accategory['categoryid'],"categoryname"=>$accategory['categoryname']);
                    }
                    echo urldecode(json_encode($select));
                }

