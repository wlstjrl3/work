<?php include('./components/header.php'); ?>
<div class="modalForm">
    <div class="modalBg"></div>
    <div class="modalWindow">
        <div class="modalHeader">
            <b>방송 정보관리 </b>
            <button></button>
        </div>
        <div class="modalBody">
            <div class="modalGrp">
                <div class="modalHd">일련번호</div>
                <div class="modalBd"><input readonly style="background:#EEE;" autocomplete='off'></div>
            </div>            
            <div class="modalGrp">
                <div class="modalHd">방송제목</div>
                <div class="modalBd"><input autocomplete='off'></div>
            </div>
            <div class="modalGrp">
                <div class="modalHd">방송요일</div>
                <div class="modalBd"><select>
                    <option value="9">매일</option>
                    <option value="8" selected>평일</option>
                    <option value="7">주말</option>
                    <option value="0">일요일</option>
                    <option value="1">월요일</option>
                    <option value="2">화요일</option>
                    <option value="3">수요일</option>
                    <option value="4">목요일</option>
                    <option value="5">금요일</option>
                    <option value="6">토요일</option>
                </select></div>
            </div>
            <div class="modalGrp">
                <div class="modalHd">방송시간</div>
                <div class="modalBd"><input type="time" autocomplete='off'></div>
            </div>
            <div class="modalGrp">
                <div class="modalHd">mp3업로드</div>
                <div class="modalBd">
                    <form id="upload_form" action="upload.php" method="POST" enctype="multipart/form-data">
                        
                        <input style="float:left;width:calc(70% - 20px);padding:3px 0;" type="file" id="upload_file" name="upload_file">
                        <button id="uploadBtn" style="float:left;width:30%;padding:6px 0;">파일 업로드</button>
                    </form>
                </div>
            </div>
            <div class="modalGrp">
                <div class="modalHd">방송파일경로</div>
                <div class="modalBd"><input readonly style="background:#EEE;" id="fileName" autocomplete='off'></div>
            </div>
            <div class="modalGrp">
                <div class="modalHd">메모</div>
                <div class="modalBd"><input autocomplete='off'></div>
            </div>
            <div class="modalGrp">
                <div class="modalHd">활성여부</div>
                <div class="modalBd"><select>
                    <option value="0">미사용</option>
                    <option value="1" selected>사용</option>
                </select></div>
            </div>            
            <div style="clear:both;"></div>
        </div>
        <div class="modalFooter">
            <button id="modalDownBtn" style="padding:5px 9px;">파일받기</button>
            <button id="modalPlayBtn" style="padding:5px 9px;">즉시재생</button>
            <button id="modalEdtBtn" style="padding:5px 9px;">저장</button>
            <button id="modalDelBtn" style="padding:5px 9px;">삭제</button>
        </div>
    </div>
</div>
<br><!--이 위로는 모달 팝업영역, 아래로는 페이지 코드-->
<div class="container">

    <h4 class="cl3 pddS">
        방송정보 관리
    </h4>

    <div class="searchArea">
        <div class="colGrp">
            <div class="colHd clBg5 cl2"><span><b>방송제목</b></span></div>
            <div class="colBd"><input id="BRD_TITLE" class="filter"></div>
        </div>
        <div class="colGrp">
            <div class="colHd clBg5 cl2"><span><b>방송요일</b></span></div>
            <div class="colBd"><select id="DAY_OF_WEEK" class="filter">
            <option value="9">전체</option><option value="8">평일</option><option value="7">주말</option>
            <option value="0">일요일</option><option value="1">월요일</option><option value="2">화요일</option>
            <option value="3">수요일</option><option value="4">목요일</option><option value="5">금요일</option><option value="6">토요일</option>
            </select></div>
        </div>
        <div class="colGrp">
            <div class="colHd clBg5 cl2"><span><b>방송시간</b></span></div>
            <div class="colBd"><input id="BRD_TIME" class="filter" type="time"></div>
        </div>
        <div class="colGrp">
            <div class="colHd clBg5 cl2"><span><b>메모</b></span></div>
            <div class="colBd"><input id="MEMO" class="filter"></div>
        </div>
        <div class="colGrp">
            <div class="colHd clBg5 cl2"><span><b>활성여부</b></span></div>
            <div class="colBd"><select id="USE_YN" class="filter">
            <option value="2">전체</option><option value="0">미사용</option><option value="1">사용</option>
            </select></div>
        </div>        
    </div>
    <div class="clearB"></div>

    <br>
    <div class="tableOutFrm">
        <div class="pddS floatL">
            <a id="newCol" class="pddS clBg3 clW rndCorner pointer">신규</a>
            <a id="xport" class="pddS clBg3 clW rndCorner pointer">엑셀 다운로드</a>
        </div>
        <div class="pddS floatR">
            <span>페이지당</span>
            <select class="tblLimit fs7 pddSS rndCorner clBrC">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select> 
            <span>개씩 보기</span>
        </div>
        <table id="myTbl"></table>
        <div id="tblPagination"></div>
    </div>
    <br>
</div>

<link href="/admin/assets/css/hr_tbl.css?ver=0" rel="stylesheet" />
<link href="/admin/assets/css/modal.css?ver=0" rel="stylesheet" />
<link href="/admin/assets/css/searchArea.css?ver=0" rel="stylesheet" />
<script type='text/javascript' src='/admin/assets/js/hr_tbl.js'></script>
<script type='text/javascript' src='/admin/assets/js/modal.js'></script>
<script type='text/javascript' src='/admin/assets/js/library/xlsx.mini.min.js'></script>
<script type='text/javascript' src='/admin/assets/js/broadcast.js'></script>

<script type='text/javascript' src='/assets/js/dateForm.js'></script>

<?php include('components/footer.php'); ?>

<script>

</script>