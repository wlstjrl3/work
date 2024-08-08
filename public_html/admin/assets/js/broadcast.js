//데이터테이블을 지정한다.
var mytbl = new hr_tbl({
    xhr:{
        url:'/admin/sys/broadList.php',
        columXHR: '',
        key : psnlKey.value, //api 호출할 보안 개인인증키
        where: {
            nothing : '', //filter의 값 변동이 생기면 여기에 즉시 추가 값을 더하고 xhr을 호출한다.
        },
        order: {
            column : '0',
            direction : 'desc',
        },
        page : 0, //표시되는 페이지에서 1이 빠진 값이다 즉 page:0 = 1페이지
        limit : 10, //만약 리미트가 0이라면 리미트 없이 전체 조회하는 것으로 처리 excel down등에서 0 처리해야 함!
    },
    columns: [
        //반드시 첫열이 key값이되는 열이 와야한다. 숨김여부는 class로 추가 지정
        {title: "idx", data: "BRD_CD", className: "colUserCd hidden"}
        ,{title: "방송제목", data: "BRD_TITLE", className: "colUserId"}
        ,{title: "방송요일", data: "DAY_OF_WEEK", className: "colUserAuth"}
        ,{title: "방송시간", data: "BRD_TIME", className: "colEmail"}
        ,{title: "파일경로", data: "BRD_FILE_PATH", className: "colPosition"}
        ,{title: "메모", data: "MEMO", className: "colMemo"}
        ,{title: "활성여부", data: "USE_YN", className: "colMemo"}
        ,{title: "등록일", data: "REG_DT", className: "colMemo"}
    ],
});
mytbl.show('myTbl'); //테이블의 아이디에 렌더링 한다(갱신도 가능)
mytbl.xportBind();

//이 아래로는 페이지 개별 모달창 이벤트를 지정
//신규버튼을 눌렀을때
newCol.addEventListener("click",()=>{
    document.querySelector(".modalForm").style.visibility="visible"; //모달창이 나타나게 한다.
    document.querySelector(".modalForm").style.opacity="1";     //투명도 애니메이션 적용을 위해 opacity가 0에서 1로 변경된다.
    document.querySelector(".modalForm").querySelectorAll("input").forEach((input,key)=>{
        input.value="";
        if(key!=0&&key!=4){
            input.readOnly = false;
            input.style.background = "#FFF";
        }
    });
});
//행을 클릭했을때 xhr로 다시 끌어올 데이터는 각 페이지마다 다르기에 여기에서 지정
function trDataXHR(idx){ 
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/admin/sys/broadConfig.php?key="+psnlKey.value+"&BRD_CD="+idx+"&CRUD=R"); xhr.send(); //XHR을 즉시 호출한다. psnlKey는 추후 암호화 하여 재적용 예정
    console.log("/admin/sys/broadConfig.php?key="+psnlKey.value+"&BRD_CD="+idx+"&CRUD=R");
    xhr.onload = () => {
        if (xhr.status === 200) { //XHR 응답이 존재한다면
            var res = JSON.parse(xhr.response)['data']; //응답 받은 JSON데이터를 파싱한다.
            if(res!=null){
                document.querySelector(".modalBody").querySelectorAll("input").forEach((input,key)=>{
                    switch(key){
                        case 0 :
                            input.value=res[0].BRD_CD
                            input.readOnly = true;
                            input.style.background="#EEE";
                            break;
                        case 1 :
                            input.value=res[0].BRD_TITLE;
                            break;
                        case 2 :
                            input.value=res[0].BRD_TIME
                            break;
                        case 3 :
                            //input/file 요소에 value 속성을 설정할 수 없습니다
                            //input.value="C:\\fakepath\\"+res[0].BRD_FILE_NM
                            break;
                        case 4 :
                            input.value=res[0].BRD_FILE_PATH
                            break;
                        case 5 :
                            input.value=res[0].MEMO
                            break;
                    }
                });
                document.querySelector(".modalBody").querySelectorAll("select").forEach((sel,key)=>{
                    switch(key){
                        case 0 :
                            sel.value=res[0].DAY_OF_WEEK;
                            break;
                        case 1 :
                            sel.value=res[0].USE_YN;
                            break;
                    }
                });
            }
        }else{
            console.log("broadConfigXhr 정보 로드 에러");
        }
    }
}
//저장을 클릭했을때 xhr로 데이터를 기록
modalEdtBtn.addEventListener("click",(evt)=>{
    //필수값 정합성 검증
    let writeUrl='';
    try{
        document.querySelector(".modalForm").querySelectorAll("input").forEach((input,key)=>{
            if(key==0){writeUrl+="&BRD_CD="+input.value}
            else if(key==1){
                if(input.value.length<1){alert("제목은 필수값입니다");throw new Error("stop loop");}
                writeUrl+="&BRD_TITLE="+input.value
            }
            else if(key==2){
                if(input.value.length<5){alert("방송시간은 필수값입니다");throw new Error("stop loop");}
                writeUrl+="&BRD_TIME="+input.value
            }
            else if(key==3){/*파일관련 업로드 폼*/}
            else if(key==4){
                if(input.value.length<5){alert("파일경로는 필수값입니다");throw new Error("stop loop");}
                writeUrl+="&BRD_FILE_PATH="+input.value
            }
            else if(key==5){writeUrl+="&MEMO="+input.value}
        });
    }catch(e){
        console.log("필수값 체크"); return false;
    }
    document.querySelector(".modalForm").querySelectorAll("select").forEach((sel,key)=>{
        if(key==0){
            writeUrl+="&DAY_OF_WEEK="+sel.value;
        }else{
            writeUrl+="&USE_YN="+sel.value;
        }
    });
    
    let xhr = new XMLHttpRequest();
    console.log("/admin/sys/broadConfig.php?key="+psnlKey.value+writeUrl+"&CRUD=C");
    xhr.open("GET", "/admin/sys/broadConfig.php?key="+psnlKey.value+writeUrl+"&CRUD=C"); xhr.send(); //XHR을 즉시 호출한다. psnlKey는 추후 암호화 하여 재적용 예정
    xhr.onload = () => {
        if (xhr.status === 200) { //XHR 응답이 존재한다면
            var res = xhr.response; //응답 받은 JSON데이터를 파싱한다.
            console.log("broadConfig 정보 기록 완료");
            mytbl.show('myTbl'); //테이블의 아이디
            modalClose();

        }else{
            console.log("broadConfig 정보 기록 에러!!!");
        }
    }    
});
//삭제를 클릭했을때 xhr로 데이터를 제거
modalDelBtn.addEventListener("click",()=>{
    if (!confirm("삭제 하시겠습니까?")) {
        return false;
    }
    let xhrFile = new XMLHttpRequest();
    let deleteFileUrl='';
    document.querySelector(".modalForm").querySelectorAll("input").forEach((input,key)=>{
        if(key==4){deleteFileUrl+="BRD_FILE_PATH="+input.value}
    });
    console.log("/admin/unload.php?"+deleteFileUrl);
    xhrFile.open("GET", "/admin/unload.php?"+deleteFileUrl); xhrFile.send();
    xhrFile.onload = () => {
        if (xhrFile.status === 200) { //XHR 응답이 존재한다면
            console.log("연동 파일 삭제 완료");
        }else{
            console.log("연동 파일 삭제 에러!!!");
        }
    }                        
    let xhr = new XMLHttpRequest();
    let deleteUrl='';
    document.querySelector(".modalForm").querySelectorAll("input").forEach((input,key)=>{
        if(key==0){deleteUrl+="&BRD_CD="+input.value}
    });
    console.log("/admin/sys/broadConfig.php?key="+psnlKey.value+deleteUrl+"&CRUD=D");
    xhr.open("GET", "/admin/sys/broadConfig.php?key="+psnlKey.value+deleteUrl+"&CRUD=D"); xhr.send(); //XHR을 즉시 호출한다. psnlKey는 추후 암호화 하여 재적용 예정
    xhr.onload = () => {
        if (xhr.status === 200) { //XHR 응답이 존재한다면
            //var res = JSON.parse(xhr.response)['data']; //응답 받은 JSON데이터를 파싱한다.
            console.log("BRD_CD 정보 삭제 완료");
            mytbl.show('myTbl'); //테이블의 아이디
            modalClose();
        }else{
            console.log("psnl 정보 제거 에러!!!");
        }
    }    
});
//즉시재생을 클릭했을때 xhr로 파일 재생 기능 활성화
modalPlayBtn.addEventListener("click",()=>{
    console.log("즉시재생 기능 개발 시작");
    var xhr = new XMLHttpRequest();


    let fileUrl='';
    document.querySelector(".modalForm").querySelectorAll("input").forEach((input,key)=>{
        if(key==4){fileUrl+="BRD_FILE_PATH="+input.value}
    });

    xhr.open("GET", "/schedule/sound.php?DIRECT=TRUE&"+fileUrl ,true);
    xhr.send();
    xhr.onload = () => {
        if (xhr.status === 200) { //XHR 응답이 존재한다면
            console.log(xhr.response);
        }
    }    
});
//파일받기를 클릭했을때 다운로드 시작
modalDownBtn.addEventListener("click",()=>{
    let fileName='';
    let filePath='';
    document.querySelector(".modalForm").querySelectorAll("input").forEach((input,key)=>{
        if(key==4){fileName=input.value;}
    });
    filePath+="/admin/assets/upload/"+encodeURIComponent(fileName);

	let element = document.createElement('a');
    element.setAttribute('type', 'application/octet-stream;charset=urf-8');
	element.setAttribute('href', filePath);
	element.setAttribute('download', fileName);
	element.style.display = 'none'; //하이퍼링크 요소가 보이지 않도록 처리
	document.body.appendChild(element); //DOM body요소에 하이퍼링크 부착
	element.click(); //클릭 이벤트 트리거 - 이 시점에 다운로드 발생
	document.body.removeChild(element); //하이퍼링크 제거
});
//검색 필터링을 위한 코드
document.querySelectorAll(".filter").forEach((f,key)=>{
    f.addEventListener("change",() => {
        mytbl.hrDt.xhr.where[f.id]=f.value;
        mytbl.hrDt.xhr.page=0; //필터가 바뀌면 페이지 수도 바뀌므로 첫장으로 돌려보낸다.
        mytbl.show("myTbl");
    });
});

//날짜 형식 자동 하이픈 추가를 위한 코드
document.querySelectorAll(".dateBox").forEach(dtBox => {
    dtBox.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = autoHypenDate(_val) ;
    }
});

//파일 업로드를 xhr로 구현한다
var form=document.getElementById("upload_form");
form.onsubmit=function(){
    var formData = new FormData(form);
    formData.append('upload_file' , upload_file);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", form.getAttribute("action") ,true);
    xhr.send(formData);
    xhr.onload = () => {
        if (xhr.status === 200) { //XHR 응답이 존재한다면
            console.log(xhr.response);
            document.querySelector("#fileName").value=xhr.response;
        }
    }

    return false;    //중요! false를 리턴해야 버튼으로 인한 submit이 안된다.
}