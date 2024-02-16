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
    <main class="main-content  mt-0">
        <section>
                <div class="container">
					<form id="hhd_home_form" action="{{ ROUTE('hhd_home') }}" method="post">
						{{ csrf_field() }}
						<input type="hidden" name="login_date" id="login_date" value="{{$login_date}}">
						<input type="hidden" name="txt_wh_code" id="txt_wh_code" value="{{$txt_wh_code}}">
						<input type="hidden" name="txt_location" id="txt_location" value="{{$txt_location}}">
						<input type="hidden" name="txt_username" id="txt_username" value="{{$txt_username}}">
					</form>
                    <form id="form_picking" action="" method="" onsubmit="return picking_submit()">
                    <div id="tab-picking" class="row" style="">


                        <div class="col-xl-4 col-lg-5 col-md-7 mx-lg-0 mt-3">
                          <div class="card card-plain">
							<div class="d-flex align-items-center ps-2 ">
                                <div class="icon icon-sm" onclick="hhd_home_back()">
									<img src="/img/house-icon.png" alt="profile_image" class="w-100 pt-1">
								</div>
                                <h3 class="text-primary mt-5" style="position: absolute;top: 5px;left: 50%;transform: translate(-50%, 0);">PICKING</h3>
                                <p class="ms-auto">
									<div id="btn_logout" class="icon icon-sm text-end">
										<img src="/img/logout-icon.png" alt="profile_image" class="w-70 mt-2">
									</div>
									<a id="btn_logout" class="text-secondary text-xs mt-2" href="javascript::;" style="margin-right: -8px;">Logout</a>
								</p>

                            </div>
							<span class="text-xs" style=" margin-top: 8px;">
								<i class="ni ni-single-02 text-secondary text-xs"> {{$txt_username}}</i>
							</span>
                              <div class="card-body p-0 mt-5">
                                <table>
                                  <tr>
                                    <td class="input-sm" align="right">Ticket:</td>
                                    <td style="position: relative">
                                      <input type="text" name="ticket" id="ticket" class="input-sm" required>
                                      <input type="hidden" name="ticket_scan_date" id="ticket_scan_date">
                                      <span id="label-st" style="font-weight: bold;display: none"> (S/T)</span>
                                      <p id="ticket_error" class="input-sm error" style="display:none">error</p>
                                      <span id="ticket_clear" style="position: absolute; top: 5px; left: 85%;">
                                        <img src="/img/edit.png" alt="profile_image" class="" style="width: 16px;">
                                      </span>
                                    </td>

                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Position: </td>
                                    <td>
                                        <input type="text" name="position" id="position" class="input-sm" required style="background-color: gainsboro; border-color: gainsboro;" disabled>
                                        <input type="hidden" name="position_scan_date" id="position_scan_date">
										<p id="position_error" class="input-sm  error" style="display:none">error</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item/G1/G2: </td>
                                    <td>
										<input type="text" name="itemg1g2" id="itemg1g2" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;">
									</td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item Desc: </td>
                                    <td><input type="text" name="item_desc" id="item_desc" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Batch/Serial:</td>
                                    <td>
                                      <input type="text" name="serial" id="serial" class="input-sm" style="width: 75%;background-color: gainsboro; border-color: gainsboro;" required disabled>
                                      <select class="input-sm" id="select_serial_all" style="width: 20px; display:none;">

                                      </select>
                                      <p id="serial_error" class="input-sm error" style="display:none">error</p>
                                    </td>
                                  </tr>
                                  <tr id="serial_all" style="display: none">
                                    <td></td>
                                    <td>

                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Pack Code: </td>
                                    <td><input type="text" name="pack_code" id="pack_code" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Pack Qty.: </td>
                                    <td>
                                      <input type="text" name="pack_qty1" id="pack_qty1" class="input-sm" size="5" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                      <input type="text" name="pack_qty2" id="pack_qty2" class="input-sm" size="5" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Base Qty.: </td>
                                    <td>
                                      <input type="text" name="base_qty_1" id="base_qty_1" class="input-sm" size="5" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                      <input type="text" name="base_qty_2" id="base_qty_2" class="input-sm" size="5" readonly style="background-color: gainsboro; border-color: gainsboro;">

                                    </td>
                                  </tr>
                                </table>

                                <div class="text-center">
                                    <button id="btn-save" type="submit" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0" disabled>Save</button>
                                </div>
                              </div>
                              <span class="mt-5" id="loader_data"></span>
                          </div>
                        </div>
                    </div>
                    </form>
                </div>
                <input type="hidden" name="grade_code_1" id="grade_code_1" value="">
                <input type="hidden" name="grade_code_2" id="grade_code_2" value="">

                <!-- Modal Success -->
                <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                      </div>
                      <div class="modal-body">
                        Save successfully
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="close-modal" class="btn btn-primary">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

				<!-- Modal Position error-->
                <div class="modal fade" id="position-error-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                      </div>
                      <div class="modal-body">
                        Invalid Position
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="close-position-error" class="btn btn-primary">Close</button>
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
        </section>
    </main>

    <script type="text/javascript">

    function loader(){
      $(':input[type="submit"]').prop('disabled', true);
      $('#loader_data').addClass('loader');

    }

    function close_loader(){
      $(':input[type="submit"]').prop('disabled', false);
      $('#loader_data').removeClass('loader');

    }

	function hhd_home_back(){
		$('#loader_data').addClass('loader');
		$('#hhd_home_form').submit();
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
        $('#tab-login').css('display','none');
        $('#tab-picking').css('display','');
        $('.moving-tab').css('width','35%');
        $('#txt_username').html('( '+$('#username').val()+' ) | ');
        $('#ticket').focus();
      }else{
        //$('#error-modal').modal('show');
        $('#location').val('');
        showErrorModal($('#wh_code'),'Invalid Warehouse code and location');
      }


    }

      return false;
    }

    function picking_submit(){

		if( $('#position').val() != '' ){

		  $.ajax({
			method: "GET",
			url: "{{route('save_picking')}}",
			data: {
			  ticket: $('#ticket').val(),
			  position: $('#position').val(),
			  item_code: $('#itemg1g2').val(),
			  serial_no: $('#serial').val(),
			  //batch_no: $('#batch_no').val(),
			  pack_qty_1: $('#pack_qty1').val(),
			  pack_qty_2: $('#pack_qty2').val(),
			  username: $('#txt_username').val(),
			  ticket_scan_date: $('#ticket_scan_date').val(),
			  position_scan_date: $('#position_scan_date').val(),
			  login_date: $('#login_date').val(),
			}
		  }).done(function( res ) {
			  $('#position').css('background-color','gainsboro');
				$('#position').css('border-color','gainsboro');
				$('#position').attr('disabled', true);
			  $('#loader_data').removeClass('loader');
			$('#success-modal').modal('show');
			setTimeout(function(){
				//$('#btn-save').attr('disabled',true);
				$('#ticket').attr('disabled', false);
				$('#serial').css('background-color','gainsboro');
				$('#serial').css('border-color','gainsboro');
				$('#serial').attr('disabled', true);
				$('#success-modal').modal("hide");
				$('#form_picking')[0].reset();
				$('#ticket').focus();
			  }, 800);
			if(!res['status']){
			  alert('Save error');
			}
			
			//$('#loader_data').removeClass('loader');
			//$('#position').val('');
			//$('.error').html('');
			
			
			
			

		  });

		}

      return false;
    }

    function curr_datetime(){
      var d = new Date();
      var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

      return strDate;
    }

    function showErrorModal(ids,msg){
      $('#error-modal').modal('show');
      $('.modal-error').html(msg);
      ids.addClass('focus');
      ids.val('');

    }

    function closeErrorModal(){
      $('#error-modal').modal('hide');
      $('.focus').focus();
      $('#ticket').removeClass('focus');
      $('#position').removeClass('focus');
      $('#wh_code').removeClass('focus');
    }

    $(function(){
	  //$('#error-modal').modal('show');

      $( "#close-error-modal" ).on( "click", function() {
        closeErrorModal($('#ticket'));
      } );

      $('#ticket').focus();

      $('#close-modal').on('click', function(){
        $('#success-modal').modal('hide');
        $('#ticket').focus();
      });

	    $('#close-position-error').on('click', function(){
        $('#position-error-modal').modal('hide');
        $('#position').focus();
      });
      //LOGOUT
      $('#btn_logout').on('click', function(){
        $('#loader_data').addClass('loader');
        window.location.href = "{{ROUTE('hhd_login')}}";
      });
	  
	  $('#ticket_clear').on('click', function(){
        $('#position').css('background-color','gainsboro');
		$('#position').css('border-color','gainsboro');
		$('#position').attr('disabled', true);
		$('#ticket').attr('disabled', false);
		$('#serial').css('background-color','gainsboro');
		$('#serial').css('border-color','gainsboro');
		$('#serial').attr('disabled', true);
		$('#form_picking')[0].reset();
		$('#ticket').focus();
      });

      // TICKET
      $('#ticket').on('keyup', function(){

		if( $(this).val() != '' ){
			$('#ticket').attr('disabled', true);
			let ticket = $(this).val();
			
			if(ticket == ''){
			  return false;
			}
			
			$('#loader_data').addClass('loader');
			
			$.ajax({
			  method: "GET",
			  url: "{{route('search_ticket')}}",
			  data: {
				ticket: ticket,
				wh_code: $('#txt_wh_code').val(),
				location: $('#txt_location').val(),
			  }
			}).done(function( res ) {

			  //console.log(res);
			  $('#ticket_scan_date').val(curr_datetime());

			  if(res['status'] == false){

				//$('#ticket_error').css('display','revert').html('Ticket not found');
				$('#ticket').attr('disabled', false);
				$('#loader_data').removeClass('loader');
				showErrorModal($('#ticket'),'Invalid Ticket scanned');

				$('#label-st').css('display','none');

					$('#position').css('background-color','gainsboro');
					$('#position').css('border-color','gainsboro');
					$('#position').attr('disabled', true);
					$('#position').val('');
					$('#position_error').html('');

					$('#serial').css('background-color','gainsboro');
					$('#serial').css('border-color','gainsboro');
					$('#serial').attr('disabled', true);
					$('#serial').val('');
					$('#serial_error').html('');

					//$('#btn-save').attr('disabled',true);
					$('#select_serial_all').css('display','none');

				$('#itemg1g2').val('');
				$('#item_desc').val('');
				$('#pack_code').val('');
				$('#pack_qty1').val('');
				$('#pack_qty2').val('');
				$('#base_qty_1').val('');
				$('#base_qty_2').val('');
				$('#ticket').focus();

				return false;

			  }else{
				$('#loader_data').removeClass('loader');
				//$('#btn-save').attr('disabled',true);
				$('#ticket_error').css('display','none').html('');
				  $('#position').css('background-color','unset');
				  $('#position').css('border-color','unset');
				  $('#position').attr('disabled', false);
				if(res['data']['HPC_IN_STK_TAKE_YN'] == 'Y'){
				  $('#label-st').css('display','revert');
				}else{
				  $('#label-st').css('display','none');
				}

				let pack_code = res['data']['HPC_IN_PACK_CODE']+'('+res['data']['HPC_IN_STK_UOM_CONV']+' '+res['data']['HPC_IN_BASE_UOM']+')';

				$('#itemg1g2').val(res['data']['HPC_IN_ITEM_CODE']);
				$('#item_desc').val(res['data']['HPC_IN_ITEM_DESC']);
				$('#pack_code').val(pack_code);
				$('#pack_qty1').val(res['data']['HPC_IN_QTY']);
				$('#pack_qty2').val(res['data']['HPC_IN_QTY_LS']);
				$('#base_qty_1').val(res['BASE_QTY']['BASE_QTY']);
				$('#base_qty_2').val(res['data']['HPC_IN_UOM_CODE']);
				$('#grade_code_1').val(res['data']['HPC_IN_GRADE_CODE_1']);
				$('#grade_code_2').val(res['data']['HPC_IN_GRADE_CODE_2']);

				$('#position').val('');
				  $('#select_serial_all').css('display','none');
				  $('#serial').css('background-color','gainsboro');
				  $('#serial').css('border-color','gainsboro');
				  $('#serial').attr('disabled', true);
				$('#position').focus();
			  }

			});
		
		}

      });

      $('#position').on('keyup', function(){
		
		    if($(this).val() != ''){
				$('#position').attr('disabled', true);
				$('#loader_data').addClass('loader');
				$('#position_scan_date').val(curr_datetime());
				$('#select_serial_all').find('option').remove();
				$.ajax({
				  method: "GET",
				  url: "{{route('search_serial')}}",
				  data: {
					ticket: $('#ticket').val(),
					wh_code: $('#txt_wh_code').val(),
					location: $('#txt_location').val(),
					serial: '',
					position: $('#position').val(),
					item_code: $('#itemg1g2').val(),
					grade_code_1: $('#grade_code_1').val(),
					grade_code_2: $('#grade_code_2').val(),
				  }
				}).done(function( res ) {
				  //console.log(res);
				  if(res['status'] == true){
					  //$('#position_error').css('display','none').html('');
					  //$('#serial').css('background-color','unset');
						//$('#serial').css('border-color','unset');
						//$('#serial').attr('disabled', false);
						//$('#serial').focus();
					  //(res['cnt_serial'] > 0) ? $('#serial').focus() : $('#pack_qty1').focus();
					  if(res['serial_flg'] == false){ // ถ้าไม่เจอ serial ให้แสดง serial ทั้งหมด
						if(res['data'].length > 0){
						  $('#select_serial_all').css('display','revert');
						  $('#select_serial_all').find('option').remove();
						  $('#select_serial_all').append($('<option>', {
							  hidden: true,
							  text: 'Option 1'
						  }));
						  $.each(res['data'], function(key, value) {
							   $('#select_serial_all').append($("<option></option>").attr("value", value).text(value));
						  });
						  $('#serial').attr('required','true');
						}else{
						  $('#serial').css('background-color','gainsboro');
						  $('#serial').css('border-color','gainsboro');
						  $('#serial').attr('disabled', true);
						  //$('#btn-save').attr('disabled',false);
						  picking_submit();
						}
						$('#serial').val('');
					  }else{
						$('#select_serial_all').css('display','none');
						$('#serial_error').css('display','none').html('');
					  }
				  }else{
					$('#position').attr('disabled', false);
					$('#loader_data').removeClass('loader');
					$('#serial').val('');
					$('#position').val('');
					$('#position-error-modal').modal('show');
					
					//$('#position_error').css('display','revert').html('Position not found');
					$('#select_serial_all').css('display','none');
					
					$('#serial').css('background-color','gainsboro');
					$('#serial').css('border-color','gainsboro');
					$('#serial').attr('disabled', true);
					$('#serial_error').html('');
					//$('#btn-save').attr('disabled',true);
					$('#select_serial_all').css('display','none');
				  }
				});
				
			}
      });

      $('#serial').on('keyup', function(){

        let serial = $(this).val();
        if( serial != '' ){
          $.ajax({
            method: "GET",
            url: "{{route('search_serial')}}",
            data: {
              serial: serial,
              position: $('#position').val(),
              item_code: $('#itemg1g2').val(),
              grade_code_1: $('#grade_code_1').val(),
              grade_code_2: $('#grade_code_2').val(),
            }
          }).done(function( res ) {

            //console.log(res);
            if(res['serial_flg'] == false){ // ถ้าไม่เจอ serial ให้แสดง serial ทั้งหมด
              if(res['data'].length > 0){
                //$('#serial_error').css('display','revert').html('Serial mismatch');
                showErrorModal($('#serial'),'Invalid Serial/Batch Number');
				        //$('#btn-save').attr('disabled',true);
              }else{
                $('#serial_error').css('display','revert').html('Serial not found');
                $('#pack_qty1').focus();
              }
              //$('#serial').val('');
            }else{
              $('#select_serial_all').css('display','none')
              $('#serial_error').css('display','none').html('');
			  $('#btn-save').attr('disabled',false);
            }
          });
        }

      });

      $('#select_serial_all').on('change', function() {
        let serial_val = this.value;
        $('#serial').val(serial_val);
        $('#serial_error').css('display','none').html('');
        $("#serial").focus();
		$('#btn-save').attr('disabled',false);
      });

    });

    window.addEventListener('keydown',e => {
      var code = e.keyCode || e.which;
      //alert(code);

    });

    </script>
@endsection
