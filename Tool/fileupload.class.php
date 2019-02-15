<?php
/**
 * Created by PhpStorm.
 * User: F1333922
 * Date: 2019/2/9
 * Time: 9:54
 */

class fileupload
{
    private $path = "./uploads";
    private $allowtype = array('jpg', 'gif', 'png');
    private $maxsize = 1000000;
    private $israndname = true;

    private $originName;
    private $tmpFileName;
    private $fileType;
    private $fileSize;
    private $newFileName;
    private $errorNum = 0;
    private $errorMess = "";
function __construct($path)
{

    $this->path=$path;
}

    function set($key, $val)
    {
        $key = strtolower($key);
        if (array_key_exists($key, get_class_vars(get_class($this)))) {

            $this->setOption($key, $val);
        }
        return $this;

    }

    function upload($fileFiled)
    {
        $return = true;
        if (!$this->checkFilePath()) {
            $this->errorMess = $this->getError();
            return false;
        }
        $name = $_FILES[$fileFiled]['name'];
        $tmp_name = $_FILES[$fileFiled]['tmp_name'];
        $size = $_FILES[$fileFiled]['size'];
        $error = $_FILES[$fileFiled]['error'];

        if (is_array($name)) {
            $errors = array();
            for ($i = 0; $i < count($name); $i++) {
                if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {
                    if (!$this->checkFileSize() || !$this->checkFileType()) {
                        $errors[] = $this->getError();
                        $return = false;
                    }
                } else {
                    $errors[] = $this->getError();
                    $return = false;
                }

                if (!$return)
                    $this->setFiles();

            }

            if ($return) {
                $fileNames = array();
                for ($i = 0; $i < count($name); $i++) {
                    if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i])) {
                        $this->setNewFileName();
                        if (!$this->copyFile()) {
                            $errors[] = $this->getError();
                            $return = false;
                        }
                        $fileNames[] = $this->newFileName;
                    }
                }
                $this->newFileName = $fileNames;
            }
            $this->errorMess = $errors;
            return $return;
        } else {

            if ($this->setFiles($name, $tmp_name, $size, $error)) {
                if ($this->checkFileSize() || !$this->checkFileType()) {
                    $this->setNewFileName();

                    if ($this->copyFile()) {
                        return true;
                    } else {
                        $return = false;
                    }
                } else {

                    $return = false;
                }
            } else {
                $return = false;
            }

            if (!$return)
                $this->errorMess = $this->getError();
            return $return;

        }

    }


    public function getFileName()
    {

        return $this->newFileName;
    }

    public function getErrorMsg()
    {
        return $this->errorMess;
    }

    private function getError()
    {
        $str = "上传文件<font color='red'>{$this->originName}</font>时出错：";

        switch ($this->errorNum) {
            case 4:
                $str .= "没有文件被上传";
                break;
            case 3:
                $str .= "文件只有部分被上传";
                break;
            case 2:
                $str .= "上传的文件大小超过了HTML表单中MAX_FILE_SIZE选项指定的值";
                break;
            case 1:
                $str .= "上传的文件大小超过了php.ini中upload_max_filesize选项限定的值";
                break;
            case -1:
                $str .= "未允许类型";
                break;
            case -2:
                $str .= "文件过大，上传的文件不能超过{$this->maxsize}个字节";
                break;
            case -3:
                $str .= "上传失败";
                break;
            case -4:
                $str .= "建立存放上传文件目录失败，请重新指定上传目录";
                break;
            case -5:
                $str .= "必须指定上传文件的路径";
                break;
            default:
                $str .= "未知错误";
        }

        return $str . '<br>';
    }

    private function setFiles($name = "", $tmp_name = "", $size = "", $error = 0)
    {
        $this->setOption('errorNum', $error);
        if ($error)
            return false;
        $this->setOption('originName', $name);
        $this->setOption('tmpFileName', $tmp_name);
        $arrStr = explode(".", $name);
        $this->setOption('fileType', strtolower($arrStr[count($arrStr) - 1]));
        $this->setOption('fileSize', $size);
        return true;
    }


    //为单个成员属性设置值
    private function setOption($key, $val)
    {
        $this->$key = $val;

    }

    private function setNewFileName()
    {
        if ($this->israndname) {
            $this->setOption('newFileName', $this->proRandName());
        } else {
            $this->setOption('newFileName', $this->originName);
        }
    }

    private function checkFileType()
    {
        if (in_array(strtolower($this->fileType), $this->allowtype)) {
            return true;
        } else {
            $this->setOption('errorNum', -1);
            return false;
        }

    }

    private function checkFileSize()
    {
        if ($this->fileSize > $this->maxsize) {
            $this->setOption('errorNum', -2);
            return false;
        } else {
            return true;
        }
    }

    //检查是否存放上传文件的目录
    private function checkFilePath()
    {
        if (empty($this->path)) {
            $this->setOption('errorNum', -5);
            return false;
        }

        if (!file_exists($this->path) || !is_writable($this->path)) {
            if (!@mkdir($this->path, 0755)) {
                $this->setOption('errorNum', -4);
                return false;
            }

        }
        return true;
    }

    //设置随机文件名
    private function proRandName()
    {
        //$fileName = date('YmdHis') . "_" . rand(100, 999);
        $fileName=$_POST["faultid"]."_".$_POST["probtype"]."_".date("Ymd");
        return $fileName . '.' . $this->fileType;
    }

    //复制上传文件到指定位置
    private function copyFile()
    {
        if (!$this->errorNum) {
            $path = rtrim($this->path, '/') . '/';
            $path .= $this->newFileName;
            if (@move_uploaded_file($this->tmpFileName, $path)) {
                return true;
            } else {
                $this->setOption('errorNum', -3);
                return false;
            }
        } else {
            return false;
        }
    }

}