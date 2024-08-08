resName.focus();

let resNumber = document.querySelector("#resNumber");
resNumber.onkeyup = function(event){
    event = event || window.event;
    var _val = this.value.trim();
    this.value = autoHypenPhone(_val) ;
}
function enterChk(e){
    if(e.keyCode == 13){
        if(e.target.id=="resName"){
            resNumber.focus();
        }else{
            xhrSend();
        }
    }
}
reqSend.addEventListener("click",()=>{
    xhrSend();
});
function xhrSend(){
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/dbconn/res_ok.php?name="+resName.value+"&telNo="+resNumber.value); xhr.send();
    xhr.onload = () => {
        if (xhr.status === 200) { //XHR 응답이 존재한다면
            var res = JSON.parse(xhr.response); //응답 받은 JSON데이터를 파싱한다.
            if(res==null){
                alert(resName.value+"님의 신청정보가 없습니다.");
            }else{
                //console.log(res);
                const resCf = confirm(res.M_NAME+"♡"+res.F_NAME+" 님의\n혼인강좌 신청 날짜는\n"+res.EDU_DT+"입니다.\n상세 내역을 확인 또는 수정하시겠습니까?");
                if(resCf){
                    //location.href="/req.php?NAME="+res.M_NAME+"&TEL_NO="+res.M_TEL_NO;
                    var form = document.createElement('form');
                    const keys = Object.keys(res);
                    const values = Object.values(res);
                    for($i=0;$i<keys.length;$i++){
                        var objs;
                        objs = document.createElement('input');
                        objs.setAttribute('type','text');
                        objs.setAttribute('name',keys[$i]);
                        objs.setAttribute('value',values[$i]);
                        form.appendChild(objs);
                    }
                    form.setAttribute('method','post');
                    form.setAttribute('action','/req.php');
                    document.body.appendChild(form);
                    //debugger;
                    form.submit();
                }else{

                }
            }
        }else{
            console.log("에러!!!");
        }
    }
}