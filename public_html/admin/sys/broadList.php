<?php
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
    include "../dbconn/dbconn.php";
    if(mysqli_num_rows(mysqli_query($conn,"SELECT 1 FROM SW1D_HUB.USERS WHERE USER_PASS = '".@$_REQUEST['key']."' LIMIT 1"))<1){die;} //보안 검증
    //갯수 카운트 쿼리
    $rowCntSql = "SELECT COUNT(*) AS ROW_CNT FROM SW1D_HUB.BROADCAST";
    //기본 쿼리
    $sql = "SELECT BRD_CD,BRD_TITLE,
    CASE 
    WHEN DAY_OF_WEEK='0' THEN '일요일' 
    WHEN DAY_OF_WEEK='1' THEN '월요일' 
    WHEN DAY_OF_WEEK='2' THEN '화요일' 
    WHEN DAY_OF_WEEK='3' THEN '수요일' 
    WHEN DAY_OF_WEEK='4' THEN '목요일' 
    WHEN DAY_OF_WEEK='5' THEN '금요일' 
    WHEN DAY_OF_WEEK='6' THEN '토요일' 
    WHEN DAY_OF_WEEK='7' THEN '주말' 
    WHEN DAY_OF_WEEK='8' THEN '평일' 
    WHEN DAY_OF_WEEK='9' THEN '매일' END AS DAY_OF_WEEK,
    BRD_TIME,BRD_FILE_PATH,MEMO,
    CASE 
    WHEN USE_YN='0' THEN '미사용' 
    WHEN USE_YN='1' THEN '사용' END AS USE_YN,    
    REG_DT
    FROM SW1D_HUB.BROADCAST";
    //조건문 지정
    $whereSql = " WHERE 1=1 ";
    if(@$_REQUEST['BRD_TITLE']){
        $whereSql=$whereSql." AND BRD_TITLE LIKE '%".$_REQUEST['BRD_TITLE']."%'";
    }
    if(@$_REQUEST['DAY_OF_WEEK']=="9"){
        //value가 없으면 전체를 선택한것으로 건너뛰기한다.
    }else{
        $whereSql=$whereSql." AND DAY_OF_WEEK LIKE '%".@$_REQUEST['DAY_OF_WEEK']."%'";
    }
    if(@$_REQUEST['BRD_TIME']){
        $whereSql=$whereSql." AND BRD_TIME LIKE '%".$_REQUEST['BRD_TIME']."%'";
    }
    if(@$_REQUEST['BRD_FILE_NM']){
        $whereSql=$whereSql." AND BRD_FILE_NM LIKE '%".$_REQUEST['BRD_FILE_NM']."%'";
    }
    if(@$_REQUEST['MEMO']){
        $whereSql=$whereSql." AND MEMO LIKE '%".$_REQUEST['MEMO']."%'";
    }
    if(@strlen(@$_REQUEST['USE_YN']) > 0){
        if(@$_REQUEST['USE_YN']>1){}else{
            $whereSql=$whereSql." AND USE_YN = ".@$_REQUEST['USE_YN'];
        }
    }else{}
    //정렬 기준 지정
    $orderSql = "";
    if(@$_REQUEST['ORDER']){
        $orderSql = $orderSql." ORDER BY ".$_REQUEST['ORDER'];
    }
    //리미트 지정
    $limitSql = "";
    if(@$_REQUEST['LIMIT']){
        $limitSql = $limitSql." LIMIT ".$_REQUEST['LIMIT'];
    }
    
    $totalCnt = mysqli_fetch_assoc(mysqli_query($conn,$rowCntSql));
    $filterCnt = mysqli_fetch_assoc(mysqli_query($conn,$rowCntSql.$whereSql));

    $result = mysqli_query($conn,$sql.$whereSql.$orderSql.$limitSql);
    mysqli_close($conn);

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    $datas = array(
       "data" => @$data
       ,"date" => "2021-99-99"
       ,"totalCnt" => $totalCnt["ROW_CNT"]
       ,"filterCnt" => $filterCnt["ROW_CNT"]
    ); 

    echo json_encode($datas, JSON_UNESCAPED_UNICODE);

?>