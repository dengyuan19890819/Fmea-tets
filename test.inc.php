<head>

    <!--    <title>这是第一个例子 hello world</title>-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <style type="text/css">

        .wraper {
            height: 100%;
            display: flex;
        }

        #left {

            flex: 3;
            border: 1px solid #000000;

            /*margin: 40px;*/
            /*box-sizing: border-box;*/

        }


        #middle {

            flex: 5;
            border: 1px solid #000000;
            /*padding: 20px;*/
            /*margin: 40px;*/
            /*box-sizing: border-box;*/

        }

        /*#middle_top {*/
        /*height:30%;*/
        /*width:100%;*/
        /*!*border: 1px solid #000000;*!*/
        /*!*padding: 20px;*!*/
        /*!*margin: 40px;*!*/
        /*!*box-sizing: border-box;*!*/

        /*}*/

        /*#middle_down {*/
        /*height:70%;*/
        /*width:100%;*/
        /*!*border: 1px solid #000000;*!*/
        /*!*padding: 20px;*!*/
        /*!*margin: 40px;*!*/
        /*box-sizing: border-box;*/

        /*}*/

        #right {

            flex: 2.5;
            border: 1px solid #000000;
            padding: 10px;
            /*margin: 40px;*/
            box-sizing: border-box;

        }

        #h2_send{

        float: left;
        }

       #btn_send{

            float: right;
           margin: 15px;
        }

        /*#top_head, #bottom_head {*/
            /*margin-top: 0px;*/
            /*background: #0f0f0f;*/
            /*height: 50px;*/
        /*}*/
    </style>


    <script type="text/javascript">
        /**
         * utils function:
         */
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        /* example */
        async function log_wait_log() {
            console.log("start sleep");
            await sleep(3000);
            console.log("finish sleep");
        }
        /* run for test */
        log_wait_log();
    </script>


</head>

<body>

<div class="wraper">


    <div id="left">
        <?php

        $ser = !empty($_POST) ? $_POST : $_GET;

        $where = array();
        $param = "";
        $title = "";

        if (!empty($ser["faultid"])) {
            $where[] = "faultid like '%{$ser["faultid"]}%'";
            $param .= "&faultid={$ser["faultid"]}";
            $title .= '测试点名字中包含"' . $ser["faultid"] . '"的';
        }

        if (!empty($ser["netname"])) {
            $where[] = "netname like '%{$ser["netname"]}%'";
            $param .= "&netname={$ser["netname"]}";
            $title .= '信号名称中包含"' . $ser["netname"] . '"的';
        }

        if (!empty($ser["testitem"])) {
            $where[] = "testitem like '%{$ser["testitem"]}%'";
            $param .= "&testitem={$ser["testitem"]}";
            $title .= '测试项名称中包含"' . $ser["testitem"] . '"的';
        }

        if (!empty($ser["teststatus"])) {
            $where[] = "teststatus like '%{$ser["teststatus"]}%'";
            $param .= "&teststatus={$ser["teststatus"]}";
            $title .= '测试项状态中包含"' . $ser["teststatus"] . '"的';
        }


        //
        //    if (!empty($where)) {
        //        $where = "where " . implode("and", $where);
        //        $title .= "搜索：" . $title;
        //    } else {
        //        $where = "";
        //        $title = "测试列表";
        //    }
        //    echo '<h3>' . $title . '</h3>';
        //    ?>

        <table class="table">

            <thead>
            <tr align="left" bgcolor="#cccccc">
                <th>ID</th>
                <th>编号</th>
                <th>信号名称</th>
                <th>测试项</th>
                <th>测试状态</th>
                <th>操作</th>
            </tr>

            </thead>

            <tbody>


            <?php
            include "conn.inc.php";
            include "Tool/page.class.php";
            $sql = "select count(*) from fmea {$where}";
            $result = mysqli_query($link, $sql);
            List($total) = mysqli_fetch_row($result);

            //  $page = new Page($total, 10, $param);
            $page = new Page($total, 13, $param);
            $sql = "select id,faultid,netname,testitem,teststatus from fmea {$where} order by id desc {$page->limit}";
            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $i = 0;
                while (list($id, $faultid, $netname, $testitem, $teststatus) = mysqli_fetch_row($result)) {
                    if ($i++ % 2 == 0)
                        echo '<tr bgcolor="#eeeeee">';
                    else
                        echo '<tr>';
                    echo '<td>' . $id . '</td>';
                    echo '<td>' . $faultid . '</td>';
                    echo '<td>' . $netname . '</td>';
                    echo '<td>' . $testitem . '</td>';

                    echo '<td>' . $teststatus . '</td>';

//                echo '<td><a href="index.php?action=mod&id=' . $id . '">修改</a>/<a onclick="return
//            confirm(\'你确定要删除图书' . $faultid . '吗？\')" href="index.php?action=del&id=' . $id .
//                    '&testlog=' . $testlog . '">删除</a> </td>';


                    echo '<td> <div class="checkbox">
                                <label>
                <input  name="startselect" type="checkbox" align=""/>
                        </label>
                             </div></td> ';

//                echo '<td><a href="index.php?action=mod&id=' . $id . '">□</a>/<a onclick="return
//            confirm(\'你确定要删除图书' . $faultid . '吗？\')" href="index.php?action=del&id=' . $id .
//                    '&testlog=' . $testlog . '">删除</a> </td>';
                    echo '</tr>';

                }

                echo '<tr><td colspan="6">' . $page->fpage() . '</td>';

            } else {
                echo '<tr><td colspan="6" align="center">没有测试点被找到</td></tr>';
            }

            mysqli_free_result($result);
            mysqli_close($link);


            ?>

            </tbody>
        </table>


    </div>


    <div id="middle">

<div id="h2_send">
    <h2 >发送cmd

    </h2>
</div>
        <div id="btn_send">
            <button  class="btn btn-default" type="button">发送</button>

        </div>






        <div>
            <form role="form">
                <div class="form-group">
                    <label for="name"></label>
                    <textarea class="form-control" rows="9"></textarea>
                </div>
            </form>


        </div>


        <h2>接收log

        </h2>

        <div>
            <form role="form">
                <div class="form-group">
                    <label for="name"></label>
                    <textarea class="form-control" rows="27"></textarea>
                </div>
            </form>


        </div>


    </div>


    <div id="right">
        <h3>FIT参数设定</h3>


        <!--    <form role="form">-->
        <!--        <div class="form-group">-->
        <!--            <label for="name">选择列表</label>-->
        <!--            <select class="form-control">-->
        <!--                <option>1</option>-->
        <!--                <option>2</option>-->
        <!--                <option>3</option>-->
        <!--                <option>4</option>-->
        <!--                <option>5</option>-->
        <!--            </select>-->
        <!--            <label for="name">可多选的选择列表</label>-->
        <!--            <select multiple class="form-control">-->
        <!--                <option>1</option>-->
        <!--                <option>2</option>-->
        <!--                <option>3</option>-->
        <!--                <option>4</option>-->
        <!--                <option>5</option>-->
        <!--            </select>-->
        <!--        </div>-->
        <!--    </form>-->


<!--        <form enctype="multipart/form-data" action="index.php?action=parame" method="POST" role="form">-->
<!--            <div class="form-group">-->
<!--                <label for="name">产品型号：</label>-->
<!--                <select name="product" class="form-control">-->
<!--                    <option value="Sureshot">Sureshot</option>-->
<!--                    <option value="RSP4">RSP4</option>-->
<!--                    <option value="RSP5">RSP5</option>-->
<!--                    <option value="RP3">RP3</option>-->
<!--                    <option value="powerglide">powerglide</option>-->
<!--                </select><br>-->
<!--                <label for="name">测试机台：</label>-->
<!--                <select name="chassis" class="form-control">-->
<!--                    <option value="Megotron">Megotron</option>-->
<!--                    <option value="Shockwave">Shockwave</option>-->
<!--                </select><br>-->
<!--                <label for="name">测试类型：</label>-->
<!--                <select name="testType" class="form-control">-->
<!--                    <option value="XR">XR</option>-->
<!--                    <option value="DIAG">DIAG</option>-->
<!--                </select><br>-->
<!--                <label for="name">探针类型：</label>-->
<!--                <select name="probeType" class="form-control">-->
<!--                    <option value="PD">PD</option>-->
<!--                    <option value="PU">PU</option>-->
<!--                    <option value="DP">DP</option>-->
<!--                    <option value="SHORT">SHORT</option>-->
<!--                </select><br>-->
<!--                <label for="name">注入时机：</label>-->
<!--                <select name="insertTime" class="form-control">-->
<!--                    <option value="Megotron">before power on</option>-->
<!--                    <option value="Shockwave">after enter diag/xr</option>-->
<!--                </select><br>-->
<!---->
<!--                <!--    板子 S/N：<input type="text" name="netname" value="" width="100"/><br>-->-->
<!---->
<!---->
<!--                <label for="name">板子 S/N：</label>-->
<!--                <input type="text" class="form-control" id="name" name="netname"-->
<!--                       placeholder="请输入板子S/N">-->
<!--              -->
<!--                <button type="submit" class="btn btn-default" onclick="javascript:alert(" 开始测试！-->
<!--                ")">开始</button>-->
<!--            -->
<!---->
<!--            </div>-->
<!---->
<!--        </form>-->


        <h1>{{ serailcomindex.h1 }}</h1>

        <select>
            <option>select one device:</option>
            <option>COM1</option>
            <option>COM4</option>
            <option>COM9</option>
            <option>COM10</option>
        </select>

        <label>Baud: </label>
        <input type="text" name="baud" value="9600"/>

        <br/>
        <input type="checkbox" name="advance"
               value="advance">Advance
        <input type="button" name="connect" id="connect"
               value="Connect" onclick="connect_serial()" />
        <script>

                async function waitBack2ConnectText() {
                    await sleep(3000);
                    document.getElementById("connect").value = "Connect";
                }

                function connect_serial(){
                    document.getElementById("connect").value = "FAIL connect!";
                    waitBack2ConnectText();
                }

        </script>


        <div>
    <textarea name="serial_recv" id="serial_recv"
              rows="10" cols="30" readonly=True>
    </textarea>
            <script>
                document.getElementById("serial_recv").value = "";
                function test(){
                    document.getElementById("serial_recv").value += "heheda\n";
                }
                test();
            </script>


            <br/>
            <input type="text" name="ser_tx" id="ser_tx">
            <input type="button" name="tx_send" value="SEND"/>
        </div>









    </div>

</div>
</body>

