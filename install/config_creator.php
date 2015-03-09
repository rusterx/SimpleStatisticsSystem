<?php
if(count($_GET['message'])>4){
$fields = $_GET["message"];
$index = $fields[1];
$note = $fields[3];
$keywords = "";
$default_value = "";
for($i=4;$i<count($fields);$i+=2){
$keywords.='"'.$fields[$i].'",';
$default_value.='"'.$fields[$i+1].'",';
}
$keywords = substr($keywords,0,-1);
$default_value=substr($default_value,0,-1);
$content = "";
$content.='<?php'."\r\n\r\n";
    $content.='$fields = array('.$keywords.");\r\n\r\n";
    $content.='$default_value = array('.$default_value.");\r\n\r\n";
    $content.='$kw = '.$index.';'."\r\n\r\n";
    $content.='$note = "'.$note.'";'."\r\n\r\n";
    $content.='?>'."\r\n";
file_put_contents('../info_config.php',$content);
echo "OK";
}

?>
