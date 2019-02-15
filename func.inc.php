<?php
/**
 * Created by PhpStorm.
 * User: F1333922
 * Date: 2019/2/9
 * Time: 8:43
 */

include "Tool/fileupload.class.php";
//include "Tool/image.class.php";

function upload(){

    $path="./uploads/";
    $up=new fileupload($path);

    if($up->upload('testlog')){
        $filename=$up->getFileName();

      //  $img=new Image($path);
      //  $img->thumb($filename,300,300,"");
       // $img->thumb($filename,80,80,"icon_");
        //$img->watermark($filename,"logo.gif",5,"");
       // $img->watermark($filename,"logo1.jpg",5,"");

//        $hz=array_pop(explode('/',$filename));
//        $newfileName=$_POST["faultid"]."_".$_POST["probtype"]."_".date("Ymd").$hz;
        return array(true,$filename);
      //  return array(true,$newfileName);
    }else{

        return array(false,$up->getErrorMsg());
    }


}

function dellog($testlogname){
        $path="./uploads/";

@unlink($path.$testlogname);
@unlink($path.'icon_'.$testlogname);
}