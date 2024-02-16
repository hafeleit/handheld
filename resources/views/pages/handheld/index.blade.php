@extends('layouts.app')

@section('content')
<style media="screen">

  .input-sm{
    font-size: 0.75rem;
  }
  table td, table td * {
      vertical-align: top;
  }
  p {
    margin-bottom: 0px;
  }
  .error {
    color: red;
  }

  .loader{
    display: block;
    position: relative;
    height: 12px;
    width: 100%;
    border: 1px solid #fff;
    border-radius: 10px;
    overflow: hidden;
  }
  .loader::after {
    content: '';
    width: 40%;
    height: 100%;
    background: #FF3D00;
    position: absolute;
    top: 0;
    left: 0;
    box-sizing: border-box;
    animation: animloader 2s linear infinite;
  }

  @keyframes animloader {
    0% {
      left: 0;
      transform: translateX(-100%);
    }
    100% {
      left: 100%;
      transform: translateX(0%);
    }
  }

</style>
<div class="container">

    <div class="row" id="icon_box">
        <div class="col-xl-4 mt-3" style="position: relative;">
            <div class="row">

					<div class="d-flex align-items-center ps-2 mb-6">

						<h3 class="text-primary mt-5" style="position: absolute;top: 5px;left: 50%;transform: translate(-50%, 0);">HOME</h3>
						<p class="ms-auto">
							<div id="btn_logout" class="icon icon-sm text-end" onclick="hhd_home_back()">
								<img src="/img/logout-icon.png" alt="profile_image" class="w-70 mt-2">
							</div>
							<a id="btn_logout" class="text-secondary text-xs mt-2" href="javascript::;" style="margin-right: -8px;">Logout</a>
						</p>

					</div>

				  <form id="select_module_form" action="" method="post" >
					{{ csrf_field() }}
					<input type="hidden" name="login_date" id="login_date" value="{{$login_date}}" />
					<input type="hidden" name="txt_username" id="txt_username" value="{{$txt_username}}" />
					<input type="hidden" name="txt_wh_code" id="txt_wh_code" value="{{$txt_wh_code}}" />
					<input type="hidden" name="txt_location" id="txt_location" value="{{$txt_location}}" />
				  </form>
                  <div class="col-4" style="text-align:center" onclick="picking_submit('picking')">
                    <a href="javascript::;">
                      <div class="avatar avatar-xl position-relative">
                        <img src="/img/picking.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="padding: 10px;">
                      </div>
                      <div class="text-uppercase text-center text-xs">
                        Picking
                      </div>
                    </a>
                  </div>
				  <div class="col-4" style="text-align:center" onclick="picking_submit('pigeonhole')">
                    <a href="javascript::;">
                      <div class="avatar avatar-xl position-relative">
                        <img src="/img/pigronhole.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                      </div>
                      <div class="text-uppercase text-center text-xs">
                        PigeonHole
                      </div>
                    </a>
                  </div>
                  <div class="col-4" style="text-align:center" onclick="picking_submit('putaway')">
                    <a href="javascript::;">
                      <div class="avatar avatar-xl position-relative">
                        <img src="/img/putaway.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="padding: 10px;">
                      </div>
                      <div class="text-uppercase text-center text-xs">
                        PutAway
                      </div>
                  </div>
                  <div class="col-4 mt-3" style="text-align:center" onclick="picking_submit('receiving')">
                    <a href="javascript::;">
                      <div class="avatar avatar-xl position-relative">
                        <img src="/img/receiving.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="padding: 10px;">
                      </div>
                      <div class="text-uppercase text-center text-xs">
                        Receiving
                      </div>
                  </div>
                  <span class="mt-5 " id="loader_data"></span>
            </div>
        </div>
    </div>
</div>
<!-- Modal error-->
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Error</h5>
      </div>
      <div class="modal-body modal-error">
        Error

      </div>
      <div class="modal-footer">
        <button type="button" id="close-error-modal" class="btn btn-primary">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(function(){
      $('#username').focus();
      $( "#close-error-modal" ).on( "click", function() {
        closeErrorModal($('#ticket'));
      } );
	  $('#btn_logout').on('click', function(){
        $('#loader_data').addClass('loader');
        window.location.href = "{{ROUTE('hhd_login')}}";
      });
    });

	function picking_submit(act){
    $('#loader_data').addClass('loader');
		let url = "";
		if(act == 'picking'){
			url = '{{ ROUTE("picking") }}';
		}
		if(act == 'pigeonhole'){
			url = '{{ ROUTE("pigeonhole") }}';
		}
		if(act == 'putaway'){
			url = '{{ ROUTE("putaway") }}';
		}
    if(act == 'receiving'){
			url = '{{ ROUTE("receiving") }}';
		}
		$('#select_module_form').attr('action', url).submit();

	}

    function login_submit(){

  	  $('#username_error').css('display','none').html('');
  	  $('#wh_code_error').css('display','none').html('');
  	  $('#location_error').css('display','none').html('');

      if( $('#username').val() == '' ){

        $('#username_error').css('display','revert').html('Username not found');
        $('#username').focus();

      }else if( $('#wh_code').val() == '' ){
        $('#wh_code_error').css('display','revert').html('WH Code not found');
        $('#wh_code').focus();
      }else if( $('#location').val() == '' ){
        $('#location_error').css('display','revert').html('Location not found');
        $('#location').focus();
      }else{

        let check_wh = chk_wh_locn($('#wh_code').val(), $('#location').val());
        if(check_wh){
          $('#login_date').val(curr_datetime());
		  $('#txt_username').val($('#username').val());
		  $('#txt_wh_code').val($('#wh_code').val());
		  $('#txt_location').val($('#location').val());
          $('#tab-login').css('display','none');
          $('#icon_box').css('display','');
        }else{
          //$('#error-modal').modal('show');
          $('#location').val('');
          showErrorModal($('#wh_code'),'Invalid Warehouse code and location');
        }
      }

        return false;
    }

    function chk_wh_locn(wh, locn){

      let chk_status = false;
      $.ajax({
        method: "GET",
        url: "{{route('chk_wh_locn')}}",
        async: false,
        data: {
          wh: wh,
          locn: locn,
        }
      }).done(function(res){
        chk_status = res['status'];
      });

      return chk_status;
    }

    function showErrorModal(ids,msg){
      $('#error-modal').modal('show');
      $('.modal-error').html(msg);
      ids.addClass('focus');
      ids.val('');

    }

    function curr_datetime(){
      var d = new Date();
      var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

      return strDate;
    }

    function closeErrorModal(){
      $('#error-modal').modal('hide');
      $('.focus').focus();
      $('#ticket').removeClass('focus');
      $('#position').removeClass('focus');
      $('#wh_code').removeClass('focus');
    }
</script>
@endsection
