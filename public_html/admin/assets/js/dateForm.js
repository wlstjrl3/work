function autoHypenDate(str){
    str = str.replace(/[^0-9]/g, '');
    if (str.length>8){ //숫자의 수가 8자리를 초과하면
        str = str.substr(0,8);
    }
    var tmp = '';
    if( str.length < 5){
        return str;
    }else if(str.length < 7){
        tmp += str.substr(0, 4);
        tmp += '-';
        tmp += str.substr(4);
        return tmp;
    }else{              
        tmp += str.substr(0, 4);
        tmp += '-';
        tmp += str.substr(4, 2);
        tmp += '-';
        tmp += str.substr(6);
        return tmp;
    }
    return str;
}