<?php
header("Content-Type:text/html;Charset=utf-8");
require_once('../info_config.php');
ob_start();
?>

<!--代码生成模板开始-->
<!DOCTYPE html >
<html >
<head>
    <meta charset="utf-8" />
    <title>信息登记表</title>
    <style type="text/css">
        body{
            width:800px;margin:5px auto;font-family:"SimSun";
        }
        h2{
            text-align:center;
        }
        .info-table{
            border-collapse:collapse;width:800px;
        }
        td{
            border:1px solid silver;
        }
        .info-opt{
            color:silver;
        }
        .info-opt-title{
            width:150px;
        }
        .submit{
            float:right;
        }
        .dialog-message{
            border:1px solid orange;height:25px;background-color:#e0e0e0;width:400px;z-index: 12;
            top:50px;position: absolute;
        }
        .copy-right{
            color:silver;
        }
        strong{
            color:red;
        }
    </style>
    <script type="text/javascript" src="./javascript/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".submit").click(function(){
                if(window.confirm("确定提交信息吗?")){
                    var info = new Array();
                    $(".info-opt").each(function(){
                        info.push($(this).text());
                    });
                    $.get('./info_process.php',{message:info},function(data){
                        if(data=="OK"){
                            dialog("信息提交成功！");
                        }else{
                            dialog("信息提交失败！");
                        }
                    });
                }else{
                    dialog("信息提交失败！");
                }
            });
            //show dialog message
            function dialog(message){
                $(".status").html(message);
                $(".status").show();
                $(".status").addClass("dialog-message");
                $(".status").hide(5000);
            }
        });
    </script>
<body>
<h2>信息登记表</h2><br/>
<table class="info-table">
    <thead>
    <span><strong>注明：</strong><?php echo $note;?></span>
    </thead>
    <tbody>
    <?php
    for($i=0;$i<count($fields);$i++){
        echo '<tr><td class="info-opt-title">'.$fields[$i].'</td><td><div class="info-opt" contenteditable="true">'.
            $default_value[$i].'</div></td></tr>'."\r\n";
    }
    ?>
    </tbody>
</table><br/>
<button class="submit">提交</button><br/><br/>
<span class="status"></span><br/><br/>
<hr/>
<span class="copy-right">Copyright &copy 2015 Xing Tingyang</span>
</body>
</html>
<!--代码生成模板结束-->


<?php
$template = ob_get_contents();
ob_end_clean();
?>

<?php

//生成表单信息
$fp = fopen('../info_register.html','w+');
fwrite($fp,$template);
fclose($fp);

//生成csv文件的表头
$fid = fopen("../info_register.csv",'wb');
//加入BOM头，否则用excel打开乱码，如果要生成utf8文件，
//那么php代码的格式最好是utf-8的。但是不论包含不包含BOM，生成的文件都没有BOM。
fwrite($fid,chr(0xEF).chr(0xBB).chr(0xBF));
$headerlines = implode(',',$fields)."\r\n";
fputs($fid,$headerlines);
fclose($fid);

echo "OK";


?>
