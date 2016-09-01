var numOfRecord = 0;
$(document).ready(function(){
  var height = $('.leftcontainer').height();
  var displayPanelHeight = (height - 230);

  $('.displayPanel').css('height', displayPanelHeight + 'px');
  var width = $('#map-canvas').width();
  var displayPanelHeight = (height - 270);

  $('#rightContent').css('width', (width) + 'px');
  $('.displayPanel').css('height', displayPanelHeight + 'px');
  $('.alertList').css('height', ($('#map-canvas').height() * 0.4) + 'px');

  $('.listContent').css('height', (($('#map-canvas').height() * 0.4) - 75) + 'px');

  $("#overlay").fadeToggle("",function(){
    $('body').css('overflow-y','hidden');
    $(".loadingDiv").fadeToggle("",function(){ // แสดงส่วนของ เนื้อหา popup
      setTimeout(function(){
        initMap();
        loadAlertListContent(1);
      },1000);
    });
  });

  $.post("../core/check-record-num.php",{},function(result){
    numOfRecord = result;
  });
  setTimeout("doLoop();",15000);

  // var cWidth = $('.map-canvas2').width();
  // // $('.map-canvas2').width((cWidth - 3) + 'px');
  // console.log(cWidth);

});

function doLoop()
{
	bodyOnload();
}

function bodyOnload(){
  $.post("../core/check-record-num.php",{},function(result){
    if(numOfRecord != result){
      loadAlertListContent(0);
      $('#txtStageList').val(0);
      $("#overlay").fadeToggle("fast",function(){
        $(".loadingDiv").fadeToggle("fast",function(){ });
      });
      initMap2();
      numOfRecord = result;
    }
  });
  setTimeout("doLoop();", 5000);
}

$(function(){
  $('.add_alert_form').submit(function(){

    $check = 0;
    $('.form-input').removeClass('has-error');
    if($('#txt-alt-name').val()==''){
      $('#req1input').addClass('has-error');
      $check++;
    }

    if($('#txt-alt-phone').val()==''){
      $('#req2input').addClass('has-error');
      $check++;
    }

    if($check==0){
      // $("#overlay2").fadeToggle();
      $(".add-record-panel").slideToggle();
      $(".loadingDiv").fadeToggle("fast",function(){ });
      var drug = 0;
      var food = 0;

      if($("#cb1").is(':checked')){
        drug = 1;
      }

      if($("#cb2").is(':checked')){
        food = 1;
      }

      var xpht = $.post("../core/add-alert.php",{ fname: $("#txt-alt-name").val(), phone: $('#txt-alt-phone').val(), drug_status: drug, food_status: food, other: $('#txt-other').val(), place: $('#txt-placedetail').val(), lat: $('#txt-lat').val(), lng: $('#txt-lng').val() },function(){});

      xpht.always(function(result) {
        setTimeout(function(){
          $.post("../core/check-record-num.php",{},function(result){
            numOfRecord = result;
          });

          $(".loadingDiv").fadeToggle("fast",function(){ });
          if(result=='Y'){
            swal("บันทึกเรียบร้อย!", "รายการแจ้งร้องขอดังกล่าวถูกบันทึกเรียบร้อย!", "success");
            $("#overlay2").fadeToggle();
          }else{
            swal("บันทึกล้มเหลว!", result, "warning");
            $("#overlay2").fadeToggle();
            // console.log(result);
          }
        },2000);
      });
    }
  });

  $('#overlay2, #btnclose-add-panel').click(function(){
    $("#overlay2").fadeToggle();
    $(".add-record-panel").slideToggle();
  });

  $('#menu-add-toggle').click(function(){
    $("#overlay2").fadeToggle();
    $(".add-record-panel").slideToggle();
    initSubMap();
  });

  $('#btnSearchplace').click(function(){
    // Use function in map.js
    searchPlace();
  });

  $('#txtInstitute').change(function(){
    $.post("../core/fetch-staff.php" , { instituteID : $('#txtInstitute').val() },function(data) {
      $('#coList').html(data);
    });
  });

  $('#hdManager').click(function(){
    $('#rightContent').hide('slide', {direction: 'right'}, 300);
    $('#txtInstitute')
    .find('option')
    .remove()
    .end()
    .append('<option value="" selected="">-- เลือกศูนย์ประสานงาน --</option>')
    ;

    $.post("../core/fetch-staff.php" , { instituteID : '' },function(data) {
      $('#coList').html(data);
    });

    $.post("../core/fetch-stagement.php" , { placeID : '' },function(data) {
      $('#stageList').html(data);
    });

    $('.nst').show();
  });

  $('#btnCloseList').click(function(){
    $('#listpn').hide('slide', {direction: 'left'}, 300);
  });

  $('#req1Btn').click(function(){
    if($('.rightcontainer').css('display') != 'none'){
        $('.rightcontainer').hide('slide', {direction: 'right'}, 300);
    }

    $('#panelListContent').html('<font color="red" style="font-size: 1.3em;">รายการร้องขอ</font>');
    $('#listpn').show('slide', {direction: 'left'}, 300);
    $.post("../core/fetch-stagement-list.php" , { stage : 1 },function(data) {
      $('#listContent').html(data);
    });
  });

  $('#req2Btn').click(function(){
    if($('.rightcontainer').css('display') != 'none'){
        $('.rightcontainer').hide('slide', {direction: 'right'}, 300);
    }

    $('#panelListContent').html('<font color="#FE9600" style="font-size: 1.3em;">กำลังดำเนินการ</font>');
    $('#listpn').show('slide', {direction: 'left'}, 300);
    $.post("../core/fetch-stagement-list.php" , { stage : 2 },function(data) {
      $('#listContent').html(data);
    });
  });

  $('#req3Btn').click(function(){
    if($('.rightcontainer').css('display') != 'none'){
        $('.rightcontainer').hide('slide', {direction: 'right'}, 300);
    }

    $('#panelListContent').html('<font color="#3BD900" style="font-size: 1.3em;">ช่วยเหลือแล้ว</font>');
    $('#listpn').show('slide', {direction: 'left'}, 300);
    $.post("../core/fetch-stagement-list.php" , { stage : 3 },function(data) {
      $('#listContent').html(data);
    });
  });

  $('#map_canvas').click(function (e) { //Default mouse Position
    alert('asd');
        alert(e.pageX + ' , ' + e.pageY);
  });


  $('#login').click(function(){
    swal({
      title: "ยืนยันการออกจากระบบ?",
      text: "ต้องการออกจากระบบหรือไม่?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
      closeOnConfirm: false,
      closeOnCancel: true
    }, function(isConfirm){
      if (isConfirm) {
        window.location = '../signout.php';
      } else {
        // swal("Cancelled", "Your imaginary file is safe :)", "error");
        // $('#login').blur();
        // $('nav').trigger('click');
      }
    });
  });

  $('#about').click(function(){

  });

  $('#menu-list-toggle').click(function(){
    $('.alertList').slideToggle();
  });

  $('#minimizeList').click(function(){
    $('.alertList').slideToggle();
  });

  $('#txtStageList').change(function(){
    loadAlertListContent($('#txtStageList').val());
  });
});


function loadAlertListContent(stage){
  $.post('../core/alertListContent.php', {alertStage: stage }, function(result){
    $('.alertListContent').html(result);
  });
}

function assignStaff(stfID){
  $("#overlay").fadeToggle();
  $(".doctor_show").slideToggle();
  $('#txtBAID').val(stfID);
  $('body').css('overflow-y','scroll');
}

function assignCoordination(sftUsername){
  // alert(sftUsername);
  swal({
    title: "ยืนยันการมอบหมายงาน?",
    text: "คุณต้องการมอบหมายการช่วยเหลือให้ผู้ประสานท่านนี้?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#5B95C1",
    confirmButtonText: "ตกลง",
    cancelButtonText: "ยกเลิก",
    closeOnConfirm: false,
    closeOnCancel: true
  }, function(isConfirm){
    if (isConfirm) {
      var jqxhr = $.post( "../core/updatestagement.php", {staff : sftUsername, alt_id : $('#markerID').text(), toStage : $('#txtNextstate').val()  }, function() {
        //Load progress loading
      })
        // .done(function() {
        //
        // })
        // .fail(function() {
        //   alert( "error" );
        // })
        .always(function() {
          swal({
            title: "ประสานงานเรียบร้อย",
            text: "ระบบได้ทำการแก้ไขสถานะการประสานงานแล้ว",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ตกลง",
            closeOnConfirm: true
          }, function(){
            $('#hdManager').trigger('click');
            $("#overlay").fadeToggle("fast",function(){
              $(".loadingDiv").fadeToggle("fast",function(){ });
            });
            initMap2();
          });
      });
    } // End if
  });
}
