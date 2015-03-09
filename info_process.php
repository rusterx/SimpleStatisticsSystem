<?php
header("Content-Type:text/html;Charset=utf-8");
require_once("./info_config.php");
if($info=$_GET['message']){
    $keyfields = $info[$kw];
    $line = implode(',', $info)."\r\n";
    $keywords_array = array();
    $content_array = array();

    //取得csv文件的第一列
    $fpx = fopen('./info_register.csv','r');
    while(!feof($fpx)){
        $tmp = rtrim(fgets($fpx),"\r\n");
        $tmp_array = explode(',',$tmp);
        array_push($keywords_array,$tmp_array[$kw]);
    }

    //根据关键字的序号，查看是否出现重复，重复则删除重复的行，再将新行添加到末尾
    //否则直接将新行添加到末尾。
    $final_content = "";
    if(in_array($keyfields,array_values($keywords_array))){
        $index = array_search($keyfields,$keywords_array);
        $fp = fopen('./info_register.csv','r');
        while(!feof($fp)){
            array_push($content_array,fgets($fp,4096));
        }
        unset($content_array[$index]);
        $final_content = implode('',$content_array).$line;
    }else{
        $content = file_get_contents('./info_register.csv');
        $final_content = $content.$line;
    }

    //更新内容
    file_put_contents('./info_register.csv',$final_content);
    echo "OK";
}
?>