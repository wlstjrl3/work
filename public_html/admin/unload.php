<?php
// 파일 경로 선언
$upload_path = $_SERVER['DOCUMENT_ROOT']."/admin/assets/upload/";
echo $upload_path.$_REQUEST['BRD_FILE_PATH'];
// 파일이 위치한 디렉토리 열기
if ( opendir($upload_path) ) {
    @unlink($upload_path.$_REQUEST['BRD_FILE_PATH']);
}
?>
