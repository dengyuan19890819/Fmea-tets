<?php
/**
 * Created by PhpStorm.
 * User: F1333922
 * Date: 2019/2/9
 * Time: 8:43
 */

//global $link;
$link=mysqli_connect('localhost','root','123456');

if(!$link){

    die("连接数据库失败".mysqli_error());
}else{

   // echo "数据库连接成功";
}

mysqli_select_db($link,'fmea_test') or die('数据库选择失败: '.mysqli_error($link));