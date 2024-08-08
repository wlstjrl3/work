var mapContainer = document.getElementById('kakaoMap');
var mapOptions = {
    center: new daum.maps.LatLng(37.311444, 126.985382),
    level: 3
};

var map = new daum.maps.Map(mapContainer, mapOptions);
iwPosition = new daum.maps.LatLng(37.311444, 126.985382), //인포윈도우 표시 위치입니다
iwRemoveable = true; // removeable 속성을 ture 로 설정하면 인포윈도우를 닫을 수 있는 x버튼이 표시됩니다

// 인포윈도우를 생성하고 지도에 표시합니다
var infowindow = new daum.maps.InfoWindow({
    map: map, // 인포윈도우가 표시될 지도
    position : iwPosition, 
    content : '<div class="customoverlay"><b>천주교 수원교구청</b><p>경기도 수원시 장안구 이목로 39</p></div>',
    removable : iwRemoveable
});