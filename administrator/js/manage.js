$(function(){
  $("#overlay").hide();

  $('#menu-map').click(function(){ window.location = './'; });

  $('#overlayForm').submit(function(){

    $('#btnSubmitoverlay').blur();
    $check = 0;
    $('.form-control').removeClass('has-error');

    if($('#txtOvelayname').val()==''){
      $check++;
      $('#r1').addClass('has-error');
    }

    if($('#txtOvelayicon').val()==''){
      $check++;
      $('#r2').addClass('has-error');
    }

    if($check!=0){
      return false;
    }
  });
});
