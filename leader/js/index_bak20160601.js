$(document).ready(function(){
  var height = $('.leftcontainer').height();
  var displayPanelHeight = (height - 230);

  $('.displayPanel').css('height', displayPanelHeight + 'px');
  var width = $('#map-canvas').width();
  var displayPanelHeight = (height - 270);

  // $('#rightContent').css('width', (width-292) + 'px');
  $('#rightContent').css('width', (width) + 'px');
  $('.displayPanel').css('height', displayPanelHeight + 'px');
  $('.alertList').css('height', ($('#map-canvas').height() * 0.4) + 'px');
  // console.log($('#map_canvas').height());

  $('.listContent').css('height', (($('#map-canvas').height() * 0.4) - 75) + 'px');

  setTimeout(function(){
    initMap();
    loadAlertListContent(0);
  },1000);
});

$(function(){
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
    // console.log(result);
  });
}

function assignStaff(stfID){
  $("#overlay").fadeToggle();
  $(".doctor_show").slideToggle();
  $('#txtBAID').val(stfID);
  $('body').css('overflow-y','scroll');
}

function assignCoordination(sftUsername){
  alert(sftUsername);
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
            initMap();
          });
      });
    } // End if
  });
}
