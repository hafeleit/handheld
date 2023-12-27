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
</style>
<div class="container">
    <div class="row">

        <div id="tab-login" class="col-xl-5 col-lg-5 col-md-7 mx-lg-0" style="">
            <div class="card card-plain">

                <div class="d-flex align-items-center" style="padding-bottom: 50px;">

					<p class="mb-0"><h3 class="text-primary" style="position: absolute;top: 14px;left: 50%;transform: translate(-50%, 0);">LOGIN</h3></p>

				</div>

                <div class="card-body">
                  <form id="login_form" action="{{ROUTE('hhd_home')}}" method="post" onsubmit="return login_submit()">
				  {{ csrf_field() }}
				  <input type="hidden" name="login_date" id="login_date" />
                  <table>
                    <tr>
                      <td class="input-sm" align="right">Username:</td>
                      <td>
                        <input type="text" name="txt_username" id="txt_username" class="input-sm"  value="{{ $data['HPC_IN_COMP_CODE'] ?? '' }}">
                        <p id="username_error" class="input-sm error" style="display:none">error</p>
                      </td>
                    </tr>
                    <tr>
                      <td class="input-sm" align="right">Password:</td>
                      <td><input type="password" name="password" class="input-sm" ></td>
                    </tr>
                    <tr>
                      <td class="input-sm" align="right">WH Code:</td>
                      <td>
                        <input type="text" name="txt_wh_code" id="txt_wh_code" class="input-sm" >
                        <p id="wh_code_error" class="input-sm error" style="display:none">error</p>
                      </td>

                    </tr>
                    <tr>
                      <td class="input-sm" align="right">Location:</td>
                      <td>
                        <input type="text" name="txt_location" id="txt_location" class="input-sm" >
                        <p id="location_error" class="input-sm error" style="display:none">error</p>
                      </td>

                    </tr>
                  </table>

                  <div class="text-center">
                      <button id="login_btn" type="submit" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0">Login</button>
                  </div>
                  </form>
                </div>
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
      $('#txt_username').focus();
      $( "#close-error-modal" ).on( "click", function() {
        closeErrorModal($('#ticket'));
      } );
    });

	function picking_submit(act){

		let url = "";
		if(act == 'picking'){
			url = '{{ ROUTE("picking") }}';
		}
		if(act == 'pigeonhole'){
			url = '{{ ROUTE("pigeonhole") }}';
		}
		$('#select_module_form').attr('action', url).submit();

	}

    function login_submit(){

  	  $('#username_error').css('display','none').html('');
  	  $('#wh_code_error').css('display','none').html('');
  	  $('#location_error').css('display','none').html('');

      if( $('#txt_username').val() == '' ){

        $('#username_error').css('display','revert').html('Username not found');
        $('#txt_username').focus();

      }else if( $('#txt_wh_code').val() == '' ){
        $('#wh_code_error').css('display','revert').html('WH Code not found');
        $('#txt_wh_code').focus();
      }else if( $('#txt_location').val() == '' ){
        $('#location_error').css('display','revert').html('Location not found');
        $('#txt_location').focus();
      }else{

        let check_wh = chk_wh_locn($('#txt_wh_code').val(), $('#txt_location').val());
        if(check_wh){
          $('#login_date').val(curr_datetime());

		  return true;
        }else{
          //$('#error-modal').modal('show');
          $('#txt_location').val('');
          showErrorModal($('#txt_wh_code'),'Invalid Warehouse code and location');
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
      $('#txt_wh_code').removeClass('focus');
    }
</script>
@endsection
