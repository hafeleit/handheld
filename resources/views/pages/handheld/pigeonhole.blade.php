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
						
						
                        <div class="col-xl-4 col-lg-5 col-md-7 mx-lg-0">
                          <div class="card card-plain">
						  
							<div class="d-flex align-items-center ps-2 ">
                                <div class="icon icon-sm" onclick="hhd_home_back()">
									<img src="/img/house-icon.png" alt="profile_image" class="w-80 pt-1">
								</div>
                                <h3 class="text-primary" style="position: absolute;top: 5px;left: 50%;transform: translate(-50%, 0);">PIGEONHOLE</h3>
                                <p class="ms-auto">
									<div class="icon icon-sm text-end" onclick="hhd_home_back()">
										<img src="/img/logout-icon.png" alt="profile_image" class="w-50">
									</div>
									<a id="btn_logout" class="text-secondary text-xs" href="javascript::;" style="margin-right: -15px;">Logout</a>
								</p>
								
                            </div>
							<span class="text-xs" style="margin-left: -11px; margin-top: -4px;">
								<i class="ni ni-single-02 text-secondary text-xs"> {{$txt_username}}</i>
							</span>
							
                              <div class="card-body p-0 mt-3">
                                <table>
                                  <tr>
                                    <td class="input-sm" align="right">Ticket:</td>
                                    <td>
                                      <input type="text" name="ticket" id="ticket" class="input-sm" required>
                                      <input type="hidden" name="ticket_scan_date" id="ticket_scan_date">
                                      <span id="label-st" style="font-weight: bold;display: none"> (S/T)</span>
                                      <p id="ticket_error" class="input-sm error" style="display:none">error</p>
                                    </td>

                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item: </td>
                                    <td>
                                        <input type="text" name="item" id="item" class="input-sm" required style="background-color: gainsboro; border-color: gainsboro;" disabled>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">G1/G2: </td>
                                    <td>
										<input type="text" name="itemg1g2" id="itemg1g2" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;">
									</td>
                                  </tr>
                                  
                                  <tr>
                                    <td class="input-sm" align="right">QTY: </td>
                                    <td>
                                      <input type="text" name="qty" id="qty" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                      
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">PGH: </td>
                                    <td>
                                      <input type="text" name="pgh" id="pgh" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                    </td>
                                  </tr>
								  <tr>
                                    <td class="input-sm" align="right"></td>
                                    <td class="text-end">
                                      <span class="text-xs">Remaining Ticket: <span id="remaining">0</span></span>
                                    </td>
                                  </tr>
								  <tr>
                                    <td class="input-sm" align="right">Scan PGH:</td>
                                    <td>
                                      <input type="text" name="scan_pgh" id="scan_pgh" class="input-sm" disabled style="background-color: gainsboro; border-color: gainsboro;">
									  <input type="hidden" name="pgh_scan_date" id="pgh_scan_date">
                                    </td>

                                  </tr>
                                </table>

                                <div class="text-center">
                                    <button id="btn-save" type="submit" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0" disabled>Save</button>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    </form>
                </div>

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
	
	function hhd_home_back(){
		$('#hhd_home_form').submit();
	}

    function picking_submit(){

      $.ajax({
        method: "GET",
        url: "{{route('save_pgh')}}",
        data: {
          ticket: $('#ticket').val(),
          ticket_scan_date: $('#ticket_scan_date').val(),
          pgh_scan_date: $('#pgh_scan_date').val(),
		  username: $('#txt_username').val(),
          login_date: $('#login_date').val(),
        }
      }).done(function( res ) {

		console.log(res);
		$('.error').html('');
		$('#btn-save').attr('disabled',true);
        $('#success-modal').modal('show');

		//$('#success-modal').delay(1000).fadeOut(450);
		setTimeout(function(){
			$('#success-modal').modal("hide");
			$('#ticket').focus();
		  }, 1000);

        if(res['status']){
          $('#form_picking')[0].reset();
		  $('#remaining').html('0');
        }else{
          alert('Save error');
        }

      });

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

      

      $('#ticket').focus();
	  
	  $( "#close-error-modal" ).on( "click", function() {
        closeErrorModal($('#ticket'));
      } );

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

        window.location.href = "{{ROUTE('hhd_login')}}";
      });

      // TICKET
      $('#ticket').on('keyup', function(){

        let ticket = $(this).val();
        if(ticket == ''){
          return false;
        }
		
        $.ajax({
          method: "GET",
          url: "{{route('search_pgh')}}",
          data: {
            ticket: ticket,
          }
        }).done(function( res ) {

          console.log(res);
          $('#ticket_scan_date').val(curr_datetime());

          if(res['status'] == false){

            showErrorModal($('#ticket'),'Invalid Ticket scanned');

      		$('#btn-save').attr('disabled',true);

            $('#item').val('');
            $('#itemg1g2').val('');
            $('#qty').val('');
            $('#pgh').val('');
            $('#remaining').html('0');

            $('#ticket').focus();

            return false;

          }else{
			  
			$('#item').val(res['data']['WHP_IN_ITEM_CODE']);
            $('#itemg1g2').val(res['data']['WHP_IN_GRADE_CODE_1']+ '/' + res['data']['WHP_IN_GRADE_CODE_2']);
            $('#qty').val(res['data']['WHP_IN_QTY']);
            $('#pgh').val(res['data']['WHP_IN_BAR_CODE']);
            $('#remaining').html(res['remaining']['REMAINING']);
            
			$('#scan_pgh').css('background-color','unset');
      		$('#scan_pgh').css('border-color','unset');
      		$('#scan_pgh').attr('disabled', false);
      		$('#scan_pgh').focus();

          }

        });

      });
	  
		$('#scan_pgh').on('keyup', function(){
			if($(this).val() == $('#pgh').val()){
				$('#pgh_scan_date').val(curr_datetime());
				$('#btn-save').attr('disabled',false);
				picking_submit();
			}else{
				$('#btn-save').attr('disabled',true);
				showErrorModal($('#scan_pgh'),'Scan PGH not match');
				$('#scan_pgh').val('');
				$('#scan_pgh').focus();
			}
		});

    });

    window.addEventListener('keydown',e => {
      var code = e.keyCode || e.which;
      //alert(code);

    });

    </script>
@endsection
