<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/*
$path = '/home/jsyang/mp3/';
$file = $path.'01.mp3';
echo '경로 ', (file_exists($path) ? 'O' : 'X'), '<br>';
echo '읽기권한 ', (is_readable($path) ? 'O' : 'X'), '<br>';
echo '쓰기권한 ', (is_writable($path) ? 'O' : 'X'), '<br>';
echo '파일 : ', (file_exists($file) ? 'O' : 'X'), '<br>';
*/
if(@$_REQUEST['DIRECT']=="TRUE"){
    exec("DISPLAY=:0 && /usr/bin/play /var/www/work.sw1d.com/public_html/admin/assets/upload/".$_REQUEST['BRD_FILE_PATH']);
    echo '즉시재생 완료';
}else{
    include "../admin/dbconn/dbconn.php";
    //기본 쿼리
    $sql = "SELECT * FROM SW1D_HUB.BROADCAST";
    //조건문 지정
    $whereSql = " WHERE USE_YN=1 ";
    $result = mysqli_query($conn,$sql.$whereSql);
    mysqli_close($conn);

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
        if($row['DAY_OF_WEEK']==9 || ($row['DAY_OF_WEEK']==8 && (date("w")>0 && date("w")<6)) || ($row['DAY_OF_WEEK']==7 && (date("w")==0 || date("w")==6)) || $row['DAY_OF_WEEK']==date("w")){
            echo "해당";
            if(date("H:i")==substr($row['BRD_TIME'],0,5)){
                //exec("bash /var/www/work.sw1d.com/public_html/schedule/01.sh");
                exec("DISPLAY=:0 && /usr/bin/play /var/www/work.sw1d.com/public_html/admin/assets/upload/".$row['BRD_FILE_PATH']);
            }
        }
        //echo substr($row['BRD_TIME'],0,5)."<br>";
        echo $row['DAY_OF_WEEK']."<br>";
    }
    //$datas = array(
    //"data" => @$data,
    //);
    //echo json_encode($datas, JSON_UNESCAPED_UNICODE);
}
?>
