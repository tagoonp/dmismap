var map;
var geocoder;
var maxRad = 50;
var redpin = [];
var yellowpin = [];
var greenpin = [];
var bluepin = [];
var my_marker = [];


function initMap(){

  var usRoadMapType = new google.maps.StyledMapType([
						{
							"featureType": "landscape.natural",
							"elementType": "geometry.fill",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"color": "#e0efef"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "geometry.fill",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"hue": "#1900ff"
								},
								{
									"color": "#c0e8e8"
								}
							]
						},
						{
							"featureType": "road",
							"elementType": "geometry",
							"stylers": [
								{
									"lightness": 100
								},
								{
									"visibility": "simplified"
								}
							]
						},
						{
							"featureType": "road",
							"elementType": "labels",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "transit",
							"elementType": "labels",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "transit.line",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"lightness": 700
								}
							]
						},
						{
							"featureType": "water",
							"elementType": "all",
							"stylers": [
								{
									"color": "#7dcdcd"
								}
							]
						}
					], {name: 'Custom'});

  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map(document.getElementById('map-canvas'), {
      center: {lat: 7.0086113, lng: 100.4730843},
      scrollwheel: true,
      mapTypeControl: true,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        mapTypeIds: [
          google.maps.MapTypeId.ROADMAP,
          'usroadatlas',
          google.maps.MapTypeId.TERRAIN,
          google.maps.MapTypeId.SATELLITE,
          google.maps.MapTypeId.HYBRID
        ],
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      streetViewControl: false,
      zoom: 14
    });

    map.mapTypes.set('usroadatlas', usRoadMapType);
    map.setMapTypeId('usroadatlas');

  setTimeout(function(){
    fetchMarker();
    fetchNumMarker();
  },1000);
}

function fetchNumMarker(){
  $.post("core/fetch-markernumber.php" ,function(data) {
    for (var i = 0; i < data.length; i++) {
      if(data[i].alt_stage == 1){
        $('#r1').text(data[i].numberOfStg);
      }else if(data[i].alt_stage == 2){
        $('#r2').text(data[i].numberOfStg);
      }else if(data[i].alt_stage == 3){
        $('#r3').text(data[i].numberOfStg);
      }else if(data[i].alt_stage == 4){
        $('#r4').text(data[i].numberOfStg);
      }
    }
  }, "json");
}

function fetchMarker(){
  var caseArray = [];

  // caseArray.push(0);
  caseArray.push(1);
  caseArray.push(2);
  caseArray.push(3);
  // if($("#chkStage0").is(':checked')){
  //     caseArray.push(0);
  // }else{
  //     if($("#chkStage1").is(':checked')){
  //       caseArray.push(1);
  //     }
  //
  //     if($("#chkStage2").is(':checked')){
  //       caseArray.push(2);
  //     }
  //
  //     if($("#chkStage3").is(':checked')){
  //       caseArray.push(3);
  //     }
  //
  //     if($("#chkStage4").is(':checked')){
  //       caseArray.push(4);
  //     }
  // }

  $.post( "core/fetch-marker.php", { markerData : caseArray } ,  function() {

  },"json")
  .always(function(data) {

    var marker_color = 'images/marker/redMarker.png';
    for (var i = 0; i < data.length; i++) {
      if(data[i].alt_stage == 1){
        marker_color = 'images/marker/redMarker.png';
      }else if(data[i].alt_stage == 2){
        marker_color = 'images/marker/yellowMarker.png';
      }else if(data[i].alt_stage == 3){
        marker_color = 'images/marker/greenMarker.png';
      }else if(data[i].alt_stage == 4){
        marker_color = 'images/marker/blueMarker.png';
      }

      my_marker[i] = new google.maps.Marker({
        position: {lat: Number(data[i].alt_lat), lng: Number(data[i].alt_lng)},
        map: map,
        icon: marker_color
      });

      if(data[i].alt_stage==1){
        redpin.push(i);
      }else if(data[i].alt_stage==2){
        yellowpin.push(i);
      }else if(data[i].alt_stage==3){
        greenpin.push(i);
      }else if(data[i].alt_stage==4){
        bluepin.push(i);
      }
    }

    setTimeout(function(){
      $("#overlay").fadeToggle("fast",function(){
        $(".loadingDiv").fadeToggle("fast",function(){ });
      });
    }, 500);

    setMapOnCase(null, 3);

  });
}

$(function(){
  $('#chkStage0').click(function(){
    if($('#chkStage0').is(':checked')){
      $('.cbAll').prop('checked', true);
    }

    if($("#chkStage1").is(':checked')){
      setMapOnCase(map, 1);
    }else{
      setMapOnCase(null, 1);
    }

    if($("#chkStage2").is(':checked')){
      setMapOnCase(map, 2);
    }else{
      setMapOnCase(null, 2);
    }

    if($("#chkStage3").is(':checked')){
      setMapOnCase(map, 3);
    }else{
      setMapOnCase(null, 3);
    }

    // $("#overlay").fadeToggle("",function(){
    //   $('body').css('overflow-y','hidden');
    //   $(".loadingDiv").fadeToggle("",function(){ // แสดงส่วนของ เนื้อหา popup
    //     setTimeout(function(){
    //
    //     },1000);
    //   });
    // });
  });

  // $('.cbAll').click(function(){
  //   $("#overlay").fadeToggle("",function(){
  //     $('body').css('overflow-y','hidden');
  //     $(".loadingDiv").fadeToggle("",function(){ // แสดงส่วนของ เนื้อหา popup
  //       setTimeout(function(){
  //         initMap();
  //       },1000);
  //     });
  //   });
  // });

  $('#chkStage1').click(function(){
    if($("#chkStage1").is(':checked')){
      setMapOnCase(map, 1);
    }else{
      setMapOnCase(null, 1);
    }
    checkbox0unset();
  });

  $('#chkStage2').click(function(){
    if($("#chkStage2").is(':checked')){
      setMapOnCase(map, 2);
    }else{
      setMapOnCase(null, 2);
    }
    checkbox0unset();
  });

  $('#chkStage3').click(function(){
    if($("#chkStage3").is(':checked')){
      setMapOnCase(map, 3);
    }else{
      setMapOnCase(null, 3);
    }
    checkbox0unset();
  });

  $('#chkStage4').click(function(){
    if($("#chkStage4").is(':checked')){
      setMapOnCase(map, 4);
    }else{
      setMapOnCase(null, 4);
    }
    checkbox0unset();
  });
});

function setMapOnCase(map, stage){
  if (stage==1) {
    for (var i = 0; i < redpin.length; i++) {
      my_marker[redpin[i]].setMap(map);
    }
  }else if(stage==2){
    for (var i = 0; i < yellowpin.length; i++) {
      my_marker[yellowpin[i]].setMap(map);
    }
  }else if(stage==3){
    for (var i = 0; i < greenpin.length; i++) {
      my_marker[greenpin[i]].setMap(map);
    }
  }else if(stage==4){
    for (var i = 0; i < bluepin.length; i++) {
      my_marker[bluepin[i]].setMap(map);
    }
  }
}

function checkbox0unset(){
  $('#chkStage0').prop('checked', false);
}
