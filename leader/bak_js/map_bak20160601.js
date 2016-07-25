var map;
var geocoder;
var maxRad = 50;
var infowindow = [];
var infowindowTmp;
var cityCircle = [];
function initMap(){
  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map($('#map-canvas')[0], {
  // map = new google.maps.Map(document.getElementById('map-canvas'), {
      center: {lat: 7.0035633, lng: 100.4640939},
      scrollwheel: true,
      mapTypeControl: true,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        mapTypeIds: [
          google.maps.MapTypeId.ROADMAP,
          google.maps.MapTypeId.TERRAIN
        ],
        position: google.maps.ControlPosition.TOP_RIGHT
      },
      streetViewControl: false,
      zoom: 14
    });

  setTimeout(function(){
    fetchMarker();
    fetchNumMarker();
  },1000);
}

function fetchNumMarker(){
  $.post("../core/fetch-markernumber.php" ,function(data) {
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
  if($("#chkStage0").is(':checked')){
    caseArray.push(0);
  }else{
    if($("#chkStage1").is(':checked')){
      caseArray.push(1);
    }

    if($("#chkStage2").is(':checked')){
      caseArray.push(2);
    }

    if($("#chkStage3").is(':checked')){
      caseArray.push(3);
    }

    if($("#chkStage4").is(':checked')){
      caseArray.push(4);
    }
  }

  $.post("../core/fetch-marker.php" , { markerData : caseArray },function(data) {
    var marker_color = 'red';

    for (var i = 0; i < data.length; i++) {
      if(data[i].alt_stage == 1){
        marker_color = 'red';
      }else if(data[i].alt_stage == 2){
        marker_color = '#FFC000';
      }else if(data[i].alt_stage == 3){
        marker_color = '#54A100';
      }else if(data[i].alt_stage == 4){
        marker_color = '#0064C4';
      }
      cityCircle[i] = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0,
        strokeWeight: 0,
        fillColor: marker_color,
        fillOpacity: 1,
        map: map,
        center: {lat: Number(data[i].alt_lat), lng: Number(data[i].alt_lng)},
        radius: maxRad
      });

      showEvent(cityCircle[i],data[i].alt_id,data[i].alt_lat, data[i].alt_lng);

    } //End for
  }, "json");
}

function showEvent(circleMarker, eid, lat, lng){
    google.maps.event.addListener(circleMarker, 'click', function(ev){
      var latLng = new google.maps.LatLng(lat, lng); //Makes a latlng
      map.panTo(latLng); //Make map global
      $('#rightContent').show('slide', {direction: 'right'}, 300);
      $.post("../core/fetch-servicearea.php" , function(data) {
        $.each(data,function(i,k){
                $('#txtInstitute').append($('<option>', {
                    value: data[i].inst_id,
                    text: data[i].inst_name
                }));
        });
      }, "json");

      if($('#listpn').css('display') != 'none'){
          $('#listpn').hide('slide', {direction: 'left'}, 300);
      }

      $.post("../core/fetch-stagement.php" , { placeID : eid },function(data) {
        // console.log(data);
        $('#stageList').html(data);
      });

      $.post("../core/fetch-marker-info.php" , { placeID : eid },function(result) {
        // console.log(JSON.stringify(result));
        $('#markerPhone').text(result[0].alt_phone);
        $('#markerUser').text(result[0].alt_name);
        $('#markerOther').text(result[0].alt_other_msg);
        $('#markerAddress3').text(result[0].alt_place);
        $('#markerAddress').html("พิกัด " + result[0].alt_lat + ", " +  result[0].alt_lng);
        $('#markerID').text(result[0].alt_id);
        // <i class="fa fa-photo" id="hideManagePanel"></i>
        // markerChanel

        if(result[0].alt_image!=''){
          $('#markerImg').html('<i class="fa fa-photo" id="hideManagePanel"></i>');
        }else{
          $('#markerImg').html('');
        }

        if(result[0].alt_chanal=='Phone'){
          $('#markerChanel').text('แจ้งผ่านศูนย์ประสานงาน');
        }else if(result[0].alt_chanal=='Application'){
          $('#markerChanel').text('Mobile application');
        }else{
          $('#markerChanel').text('ไม่ทราบแหล่งที่มา');
        }

        cllAddress(result[0].alt_lat, result[0].alt_lng);
        setMinimap(result[0].alt_lat, result[0].alt_lng);

        if(result[0].alt_stage==1){
          $('#txtNextstate').val(2);
        }else if(result[0].alt_stage==2){
          $('#txtNextstate').val(3);
        }else if(result[0].alt_stage==4){
          $('.nst').hide();
        }else{
          $('.nst').hide();
        }

        if(result[0].alt_food=='Yes'){
          $('#markerFood').html('<i class="fa fa-check"></i>');
        }else{
          $('#markerFood').html('<i class="fa fa-close"></i>');
        }

        if(result[0].alt_drug=='Yes'){
          $('#markerDrug').html('<i class="fa fa-check"></i>');
        }else{
          $('#markerDrug').html('<i class="fa fa-close"></i>');
        }

        if(result[0].alt_level=='common'){
          $('#markerLevel').html('<span style="color: #377AAD;">ทั่วไป</span>');
        }else if(result[0].alt_level=='urgen'){
          $('#markerLevel').html('<span style="color: #FD3116;">ด่วน</span>');
        }else{
          $('#markerLevel').html('<span style="color: red;">เร่งด่วน</span>');
        }

      }, "json");
    });
}

function showEvent2(eid, lat, lng){
  $('#txtInstitute')
  .find('option')
  .remove()
  .end()
  .append('<option value="" selected="">-- เลือกศูนย์ประสานงาน --</option>')
  ;

    var latLng = new google.maps.LatLng(lat, lng); //Makes a latlng
    map.panTo(latLng); //Make map global
    $('#rightContent').show('slide', {direction: 'right'}, 300);

    setTimeout(function(){
      $.post("../core/fetch-servicearea.php" , function(data) {
        $.each(data,function(i,k){
                $('#txtInstitute').append($('<option>', {
                    value: data[i].inst_id,
                    text: data[i].inst_name
                }));
        });
      }, "json");
    }, 3000);


    if($('#listpn').css('display') != 'none'){
        $('#listpn').hide('slide', {direction: 'left'}, 300);
    }

    setTimeout(function(){
      $.post("../core/fetch-stagement.php" , { placeID : eid },function(data) {
        $('#stageList').html(data);
      });
    }, 3000);


    // var jqxhr = $.post( "../core/fetch-stagement.php", { placeID : eid } , function(data) {
    //
    // })
    //   .always(function(data) {
    //     $('#stageList').html(data);
    // });

    $.post("../core/fetch-marker-info.php" , { placeID : eid },function(result) {
      $('#markerPhone').text(result[0].alt_phone);
      $('#markerUser').text(result[0].alt_name);
      $('#markerOther').text(result[0].alt_other_msg);
      $('#markerAddress3').text(result[0].alt_place);
      $('#markerAddress').html("พิกัด " + result[0].alt_lat + ", " +  result[0].alt_lng);
      $('#markerID').text(result[0].alt_id);
      // <i class="fa fa-photo" id="hideManagePanel"></i>
      // markerChanel

      if(result[0].alt_image!=''){
        $('#markerImg').html('<i class="fa fa-photo" id="hideManagePanel"></i>');
      }else{
        $('#markerImg').html('');
      }

      if(result[0].alt_chanal=='Phone'){
        $('#markerChanel').text('แจ้งผ่านศูนย์ประสานงาน');
      }else if(result[0].alt_chanal=='Application'){
        $('#markerChanel').text('Mobile application');
      }else{
        $('#markerChanel').text('ไม่ทราบแหล่งที่มา');
      }

      cllAddress(result[0].alt_lat, result[0].alt_lng);
      setMinimap(result[0].alt_lat, result[0].alt_lng);

      if(result[0].alt_stage==1){
        $('#txtNextstate').val(2);
      }else if(result[0].alt_stage==2){
        $('#txtNextstate').val(3);
      }else if(result[0].alt_stage==4){
        $('.nst').hide();
      }else{
        $('.nst').hide();
      }

      if(result[0].alt_food=='Yes'){
        $('#markerFood').html('<i class="fa fa-check"></i>');
      }else{
        $('#markerFood').html('<i class="fa fa-close"></i>');
      }

      if(result[0].alt_drug=='Yes'){
        $('#markerDrug').html('<i class="fa fa-check"></i>');
      }else{
        $('#markerDrug').html('<i class="fa fa-close"></i>');
      }

      if(result[0].alt_level=='common'){
        $('#markerLevel').html('<span style="color: #377AAD;">ทั่วไป</span>');
      }else if(result[0].alt_level=='urgen'){
        $('#markerLevel').html('<span style="color: #FD3116;">ด่วน</span>');
      }else{
        $('#markerLevel').html('<span style="color: red;">เร่งด่วน</span>');
      }
    }, "json");
}

$(function(){

  $('#chkStage0').click(function(){
    if($('#chkStage0').is(':checked')){
      $('.cbAll').prop('checked', true);
    }
    initMap();
  });

  $('.cbAll').click(function(){
    initMap();
  });
});

function cllAddress(lat,lng){
  // เรียกขอข้อมูลสถานที่จาก Google Map
    var my_Point = new google.maps.LatLng(lat,lng);
		geocoder.geocode({'latLng': my_Point}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
			if (results[1]) {
				// แสดงข้อมูลสถานที่ใน textarea ที่มี id เท่ากับ place_value
			  $("#markerAddress2").text(results[0].formatted_address); //
			}
		  } else {
			  // กรณีไม่มีข้อมูล
			alert("Geocoder failed due to: " + status);
		  }
		});
}



function setMinimap(lat,lng){
  var my_Point = new google.maps.LatLng(lat,lng);
  var map2 = new google.maps.Map($('.imgpanel')[0], {
    center: my_Point,
    scrollwheel: true,
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
      mapTypeIds: [
        google.maps.MapTypeId.ROADMAP,
        google.maps.MapTypeId.TERRAIN,
        google.maps.MapTypeId.SATELLITE,
        google.maps.MapTypeId.HYBRID
      ],
      position: google.maps.ControlPosition.TOP_RIGHT
    },
    streetViewControl: false,
    zoom: 16
  });

  var marker = new google.maps.Marker({
    position: my_Point,
    map: map2,
    title: 'ตำแหน่งที่แจ้ง'
  });
}
