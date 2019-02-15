<?php
/**
 * Created by PhpStorm.
 * User: F1333922
 * Date: 2019/2/9
 * Time: 18:30
 */

class Page
{
    private $total;
    private $listRows;
    private $limit;
    private $uri;
    private $pageNum;
    private $page;
    private $config = array(
        'head' => "条记录",
        'prev' => "上一页",
        'next' => "下一页",
        'first' => "首页",
        'last' => "末页",
    );
   // private $listNum = 10;
      private $listNum = 10;

    /**
     * Page constructor.
     * @param $total
     * @param $listRows
     */
    public function __construct($total, $listRows = 25, $query = "", $ord = true)
    {
        $this->total = $total;
        $this->listRows = $listRows;
        $this->uri = $this->getUri($query);
        $this->pageNum = ceil($this->total / $this->listRows);

        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            if ($ord)
                $page = 1;
            else
                $page = $this->pageNum;
        }

        if ($total > 0) {
            if (preg_match('/\D/', $page)) {
                $this->page = 1;
            } else {
                $this->page = $page;
            }
        } else {
            $this->page = 0;
        }
        $this->limit = "LIMIT " . $this->setLimit();
    }

    function set($param, $value)
    {
        if (array_key_exists($param, $this->config)) {
            $this->config[$param] = $value;
        }
        return $this;

    }

    function __get($args)
    {
        // TODO: Implement __get() method.

        if ($args == "limit" || $args == "page")
            return $this->$args;
        else
            return null;
    }

    function fpage()
    {
        $arr=func_get_args();

        $html[0]="&nbsp;共<b>{$this->total}</b>{$this->config["head"]}&nbsp";
        $html[1]="&nbsp;本页<b>".$this->disnum()."</b>条&nbsp";
        $html[2]="&nbsp;本页从<b>{$this->start()}-{$this->end()}</b>条&nbsp";
        $html[3]="&nbsp;<b>{$this->page}/{$this->pageNum}</b>页&nbsp";
        $html[4]=$this->firstprev();
        $html[5]=$this->pagelist();
        $html[6]=$this->nextlast();
        $html[7]=$this->goPage();

        $fpage='<div style="font:12px \'\5B8B\4F53\',sans-serif;">';
        if(count($arr)<1)
            $arr=array(0,1,2,3,4,5,6,7);
        for($i=0;$i<count($arr);$i++)
            $fpage.=$html[$arr[$i]];

        $fpage.='</div>';
        return $fpage;

    }

    /**
     * @param mixed $limit
     */
    public function setLimit()
    {
        if ($this->page > 0)
            return ($this->page - 1) * $this->listRows . ",{$this->listRows}";
        else
            return 0;
    }

    /**
     * @return mixed
     */
    public function getUri($query)
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        $url = strstr($request_uri, '?') ? $request_uri : $request_uri . '?';
        if (is_array($query))
            $url .= http_build_query($query);
        else if ($query != "")
            $url .= "&" . trim($query, "?&");

        $arr = parse_url($url);

        if (isset($arr["query"])) {
            parse_str($arr["query"], $arrs);
            unset($arrs["page"]);
            $url = $arr["path"] . '?' . http_build_query($arrs);
        }

        if (strstr($url, '?')) {
            if (substr($url, -1) != '?')
                $url = $url . '&';
        } else {
            $url = $url . '?';
        }
        return $url;
    }

    private function start()
    {
        if ($this->total == 0)
            return 0;
        else
            return ($this->page - 1) * $this->listRows + 1;
    }

    private function end()
    {
        return min($this->page * $this->listRows, $this->total);
    }

    private function firstprev()
    {
        if ($this->page > 1) {
            $str = "&nbsp;<a href='{$this->uri}page=1'>{$this->config["first"]}</a>&nbsp";
            $str .= "&nbsp;<a href='{$this->uri}page=" . ($this->page - 1) . "'>{$this->config["prev"]}
            </a>&nbsp";
            return $str;
        }
    }

    private function pagelist()
    {
        $linkpage = "&nbsp;<b>";

        $inum = floor($this->listNum / 2);
        for ($i = $inum; $i >= 1; $i--) {
            $page = $this->page - $i;
            if ($page >= 1)
                $linkpage .= "<a href='{$this->uri}page={$page}'>{$page}</a>&nbsp;";
        }
        if ($this->pageNum > 1)
            $linkpage .= "<span style='padding: 1px 2px;background:#BBB;color:white'>{$this->page}</span>&nbsp;";

        for ($i = 1; $i <= $inum; $i++) {
            $page = $this->page + $i;
            if ($page <= $this->pageNum)
                $linkpage .= "<a href='{$this->uri}page={$page}'>{$page}</a>&nbsp;";
            else
                break;
        }

        $linkpage .= '</b>';
        return $linkpage;


    }

    private function nextlast()
    {
        if ($this->page != $this->pageNum) {
            $str = "&nbsp;<a href='{$this->uri}page=" . ($this->page + 1) . "'>{$this->config["next"]}</a>&nbsp;";
            $str .= "&nbsp;<a href='{$this->uri}page=" . ($this->pageNum) . "'>{$this->config["last"]}</a>&nbsp;";
            return $str;
        }

    }

    private function goPage()
    {
        if ($this->pageNum > 1) {
            return '&nbsp;<input style="width:20px;height: 17px !important;height: 18px;border: 1px
                    solid #cccccc;" type="text" onkeydown="javascript:if(event.keyCode==13){var 
                    page=(this.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.value;location=\'' . $this
                    ->uri . 'page=\'+page+\'\'}" value="' . $this->page . '">
                    <input style="cursor: pointer;width: 35px;height: 18px;border: 1px solid #cccccc;" type="button"
                    value="GO" onclick="javascript:var page=(this.previousSibling.value>' . $this->pageNum .
                ')?' . $this->pageNum . ':this.previousSibling.value;location=\'' . $this->uri .
                'page=\'+page+\'\'">&nbsp';
        }

    }

    private function disnum()
    {

        if ($this->total > 0) {
            return $this->end() - $this->start() + 1;
        } else {
            return 0;
        }
    }


}