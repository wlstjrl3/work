<?php
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
    include "../dbconn/dbconn.php";
    if(mysqli_num_rows(mysqli_query($conn,"SELECT 1 FROM SW1D_HUB.USERS WHERE USER_PASS = '".@$_REQUEST['key']."' LIMIT 1"))<1){die;} //보안 검증
    
    if($_REQUEST['CRUD']=='C'){
        if($_REQUEST['BRD_CD']==""){ //신규 작성
            $sql = "INSERT INTO SW1D_HUB.BROADCAST(BRD_TITLE,DAY_OF_WEEK,BRD_TIME,BRD_FILE_PATH,REG_DT,MEMO,USE_YN) VALUES ('";
            $sql = $sql.$_REQUEST['BRD_TITLE']."','".$_REQUEST['DAY_OF_WEEK'];
            $sql = $sql."','".$_REQUEST['BRD_TIME']."','".$_REQUEST['BRD_FILE_PATH']."','".date("Y-m-d h:m:s")."','".$_REQUEST['MEMO'];
            $sql = $sql."','".$_REQUEST['USE_YN']."')";
            echo $sql; //오류 점검용 쿼리
        }else{ //기존 데이터 UPDATE
            $sql = "UPDATE SW1D_HUB.BROADCAST SET 
                BRD_TITLE='".$_REQUEST['BRD_TITLE']."'
                ,DAY_OF_WEEK='".$_REQUEST['DAY_OF_WEEK']."'
                ,BRD_TIME='".$_REQUEST['BRD_TIME']."'
                ,BRD_FILE_PATH='".$_REQUEST['BRD_FILE_PATH']."'
                ,MEMO='".$_REQUEST['MEMO']."'
                ,USE_YN='".$_REQUEST['USE_YN']."'
                WHERE BRD_CD = '".$_REQUEST['BRD_CD']."'";
        }
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }else if($_REQUEST['CRUD']=='R'){
        //기본 쿼리
        $sql = "SELECT * FROM SW1D_HUB.BROADCAST";
        //조건문 지정
        $whereSql = " WHERE 1=1 ";
        if(@$_REQUEST['BRD_CD']){
            $whereSql=$whereSql." AND BRD_CD = '".$_REQUEST['BRD_CD']."'";
        }
        //리미트 지정
        $limitSql = " LIMIT 1";
        $result = mysqli_query($conn,$sql.$whereSql.$limitSql);
        mysqli_close($conn);

        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        $datas = array(
        "data" => @$data,
        "date" => "2021-99-99"
        );
        echo json_encode($datas, JSON_UNESCAPED_UNICODE);
    }else if($_REQUEST['CRUD']=='D'){
        //기본 쿼리
        $sql = "DELETE FROM SW1D_HUB.BROADCAST WHERE BRD_CD = '".$_REQUEST['BRD_CD']."'";
        echo $sql; //오류 점검용 쿼리
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }else{
        echo 'broadcastConfig 잘못된 접근방식입니다.';
    }

?>