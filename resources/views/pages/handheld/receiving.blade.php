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

  select {
    padding: 4px;
    border: 1px solid #ccc;
    border-radius: 4px;
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
                    <form id="form_picking" action="" method="" onsubmit="return receiving_submit()">
                      <input type="hidden" name="ghi_in_gi_sys_id" id="ghi_in_gi_sys_id">
                      <input type="hidden" name="ghi_in_gi_gh_sys_id" id="ghi_in_gi_gh_sys_id">
                      <input type="hidden" name="ghi_in_comp_code" id="ghi_in_comp_code">
                      <input type="hidden" name="ghi_in_locn_code" id="ghi_in_locn_code">
                      <input type="hidden" name="ghi_in_gh_dt" id="ghi_in_gh_dt">
                      <input type="hidden" name="ghi_in_grade_code_1" id="ghi_in_grade_code_1">
                      <input type="hidden" name="ghi_in_grade_code_2" id="ghi_in_grade_code_2">
                      <input type="hidden" name="ghi_in_uom_code" id="ghi_in_uom_code">
                      <input type="hidden" name="ghi_in_qty" id="ghi_in_qty">
                      <input type="hidden" name="ghi_in_qty_ls" id="ghi_in_qty_ls">
                      <input type="hidden" name="ghi_in_qty_bu" id="ghi_in_qty_bu">
                      <input type="hidden" name="ghi_in_out_qty_bu" id="ghi_in_out_qty_bu">
                    <div id="tab-picking" class="row" style="">

                        <div class="col-xl-4 col-lg-5 col-md-7 mx-lg-0">
                          <div class="card card-plain">

							<div class="d-flex align-items-center ps-2 ">
                                <div class="icon icon-sm" onclick="hhd_home_back()">
									<img src="/img/house-icon.png" alt="profile_image" class="w-80 pt-1">
								</div>
                                <h3 class="text-primary" style="position: absolute;top: 5px;left: 50%;transform: translate(-50%, 0);">RECEIVING</h3>
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

                              <div class="card-body p-0">
								  <div class="row">
									<div class="col-6">
										<div class="custom-control custom-checkbox text-end">

										</div>
									</div>
									<div class="col-6">
										<div class="custom-control custom-checkbox">
										  <input type="checkbox" class="custom-control-input putaway_type" id="customCheck2" name="putaway_type" value="G">
										  <label class="custom-control-label" for="customCheck2">By GRN</label>
										</div>
									</div>
								  </div>
								<script>
									$(document).on('click', 'input[type="checkbox"]', function() {
										$('input[type="checkbox"]').not(this).prop('checked', false);
									});
								</script>
                                <table>
                                  <tr>
                                    <td class="input-sm" align="right">Ship ID:</td>
                                    <td>
                                      <input type="text" name="ship_id" id="ship_id" class="input-sm" required>
                                      <input type="hidden" name="ship_id_scan_date" id="ship_id_scan_date">
                                      <span id="label-st" style="font-weight: bold;display: none"> (S/T)</span>
                                      <p id="ship_id_error" class="input-sm error" style="display:none">error</p>
                                    </td>

                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item: </td>
                                    <td>
                                        <input type="text" name="item" id="item" class="input-sm" size="9" readonly style="background-color: gainsboro; border-color: gainsboro;">
										                    <select class="input-sm" id="items" style="width: 20px; display: none"></select>
										                    <label id="seq_items_count"></label><label id="items_count"></label>
									                  </td>
                                  </tr>
								                  <tr>
                                    <td class="input-sm" align="right">IG Doc: </td>
                                    <td>
                                      <input type="text" name="TXN_CODE" id="TXN_CODE" class="input-sm" size="5" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                      <input type="text" name="DOC_NO" id="DOC_NO" class="input-sm" size="8" readonly style="background-color: gainsboro; border-color: gainsboro;">
									                    <select class="input-sm" id="TXN_CODE_DOC_NO" style="width: 20px; display: none"></select>
									                   </td>
                                  </tr>
								                  <tr>
                                    <td class="input-sm" align="right">Pallet ID: </td>
                                    <td><input type="text" name="pallet_id" id="pallet_id" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;"></td>
                                  </tr>
								                  <tr>
                                    <td class="input-sm" align="right">Grade: </td>
                                    <td><input type="text" name="grade" id="grade" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item Desc: </td>
                                    <td><input type="text" name="item_desc" id="item_desc" class="input-sm" readonly style="background-color: gainsboro; border-color: gainsboro;"></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Batch/Serial:</td>
                                    <td>
                                      <input type="text" name="serial" id="serial" class="input-sm" style="width: 60%;" autocomplete="off">
                                      <label id="qty1"></label><label id="qty2"></label>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Qty.: </td>
                                    <td>
                                      <input type="text" name="pack_qty1" id="pack_qty1" class="input-sm" size="5" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                      <input type="text" name="pack_qty2" id="pack_qty2" class="input-sm" size="4" readonly style="background-color: gainsboro; border-color: gainsboro;">
                                      <label id="qty3"></label>
                                      <select class="input-sm" id="serials" name="serials" style="width: 20px; display: none">
                                      </select>
                                      <i class="ni ni-bullet-list-67" id="btn_show_serials" style="display: none"></i>
                                    </td>
                                  </tr>
                                </table>

                                <div class="text-center">
                                    <button id="btn-save" type="submit" class="btn btn-sm btn-primary btn-sm w-50 mt-1 mb-0" disabled>Close Pallet</button>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    </form>
                </div>
                <input type="hidden" name="grade_code_1" id="grade_code_1" value="">
                <input type="hidden" name="grade_code_2" id="grade_code_2" value="">

                <!-- Modal serials -->
                <div class="modal fade" id="modal-serials" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                  <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">All serial numbers</h6>
                        <button type="button" class="btn-close btn-close-serials"  data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" class="text-secondary">×</span>
                        </button>
                      </div>
                      <div class="modal-body-serials">
                        <p class="p-1 px-3"> <span id="seq_serial">1.</span> 12331312312</p>
                        <p class="p-1 px-3"> <span id="seq_serial">2.</span> 12331312312</p>
                        <p class="p-1 px-3"> <span id="seq_serial">3.</span> 12331312312</p>
                        <p class="p-1 px-3"> <span id="seq_serial">4.</span> 12331312312</p>
                        <p class="p-1 px-3"> <span id="seq_serial">5.</span> 12331312312</p>
                        <p class="p-1 px-3"> <span id="seq_serial">6.</span> 12331312312</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-link ml-auto btn-close-serials" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
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

    function receiving_submit(){
      var serials_list = [];
      $('#serials option').each(function() {
          serials_list.push($(this).val());

      });
      $.ajax({
        method: "GET",
        url: "{{route('save_receiving')}}",
        data: {
          ghi_in_gi_sys_id: $('#ghi_in_gi_sys_id').val(),
          ghi_in_gi_gh_sys_id: $('#ghi_in_gi_gh_sys_id').val(),
          ghi_in_comp_code: $('#ghi_in_comp_code').val(),
          ghi_in_locn_code: $('#ghi_in_locn_code').val(),
          ghi_in_grn_txn_code: $('#TXN_CODE').val(),
          ghi_in_grn_no: $('#DOC_NO').val(),

          ghi_in_gh_dt: $('#ghi_in_gh_dt').val(),
          ghi_in_item_code: $('#item').val(),
          ghi_in_grade_code_1: $('#ghi_in_grade_code_1').val(),
          ghi_in_grade_code_2: $('#ghi_in_grade_code_2').val(),
          ghi_in_uom_code: $('#ghi_in_uom_code').val(),
          ghi_in_qty: $('#ghi_in_qty').val(),
          ghi_in_qty_ls: $('#ghi_in_qty_ls').val(),
          ghi_in_qty_bu: $('#ghi_in_qty_bu').val(),
          ghi_in_out_qty_bu: $('#ghi_in_out_qty_bu').val(),
          ghi_in_ship_id: $('#ship_id').val(),

          ghi_in_pallet_no: $('#pallet_id').val(),
          ghi_in_sr_no: serials_list,
          ghi_in_user_id: $('#txt_username').val(),

          ghi_in_gi_sys_id: $('#ghi_in_gi_sys_id').val(),
          ghi_in_gi_sys_id: $('#ghi_in_gi_sys_id').val(),
          ghi_in_gi_sys_id: $('#ghi_in_gi_sys_id').val(),

        }
      }).done(function( res ) {
        console.log(res);
        if(res['status']){
          hide_fields($('#TXN_CODE'));
          hide_fields($('#DOC_NO'));
          show_fields($('#ship_id'));
          $('#success-modal').modal('show');
          setTimeout(function(){
      			$('#success-modal').modal("hide");
      			$('#ship_id').focus();
      		}, 1000);
          $('#items').hide();
          $('#seq_items_count').hide();
          $('#items_count').hide();
          $('#qty1').hide();
          $('#qty2').hide();
          $('#qty3').hide();
          $('#TXN_CODE_DOC_NO').hide();
          $('#serials').hide();
          $('#form_picking')[0].reset();
          $('#serials').find('option').remove();



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
      $('#ship_id').removeClass('focus');
      $('#position').removeClass('focus');
      $('#wh_code').removeClass('focus');
    }

    function hide_fields(id){
      id.css('background-color','gainsboro');
      id.css('border-color','gainsboro');
      id.attr('disabled', true);
      id.attr("readonly", true);
      id.val('');
    }

    function show_fields(id){
      id.css('background-color','unset');
      id.css('border-color','unset');
      id.attr('disabled', false);
      id.attr("readonly", false);
      id.val('');
    }

    $(function(){

    //  $('#modal-serials').modal('show');


      $('.btn-close-serials').on('click', function(){
        $('#serial').focus();
      });

      $( "#close-error-modal" ).on( "click", function() {
        closeErrorModal($('#ship_id'));
      } );

      $('#ship_id').focus();

      $('#close-modal').on('click', function(){
        $('#success-modal').modal('hide');
        $('#ship_id').focus();
      });

	    $('#close-position-error').on('click', function(){
        $('#position-error-modal').modal('hide');
        $('#position').focus();
      });

      $('#btn_logout').on('click', function(){

        window.location.href = "{{ROUTE('hhd_login')}}";
      });

  	  $('input[name="putaway_type"]').on('click', function(){

        $('#btn-save').attr('disabled',true);

    		$('#ship_id').val('');
    		$('#item').val('');
    		$('#TXN_CODE').val('');
    		$('#DOC_NO').val('');
    		$('#pallet_id').val('');
    		$('#grade').val('');
    		$('#item_desc').val('');
    		$('#pack_qty1').val('');
    		$('#serial').val('');
    		$('#seq_items_count').html('');
    		$('#items_count').html('');
    		$('#qty1').html('');
    		$('#qty2').html('');
    		$('#qty3').html('');
    		$('#items').hide('');
        $('#items').find('option').remove();
    		$('#TXN_CODE_DOC_NO').hide('');
        $('#TXN_CODE_DOC_NO').find('option').remove();
    		$('#serials').hide('');
        $('#serials').find('option').remove();
    		//$('#serial').css('background-color','gainsboro');
    		//$('#serial').css('border-color','gainsboro');

    		$('#btn-save').attr('disabled',true);
        if ($('input.putaway_type').is(':checked')) {

          show_fields($('#TXN_CODE'));
          show_fields($('#DOC_NO'));
          hide_fields($('#ship_id'));
          hide_fields($('#item'));
          $('#TXN_CODE').focus();
        }else{

          show_fields($('#ship_id'));
          hide_fields($('#item'));
          hide_fields($('#TXN_CODE'));
          hide_fields($('#DOC_NO'));
          $('#ship_id').focus();
        }

  	  });

      $('#TXN_CODE').on('keyup', function(){
        if($(this).val() != ''){
          $('#DOC_NO').focus();
        }
      });

      $('#serial').on('keyup', function(){

        let serial_number = $(this).val();
        $('#serial').val('');

        if(serial_number != ''){
          let max_seq_serial = $( ".serial_list" ).length + 1;
          let sys_id = $('#ghi_in_gi_sys_id').val();
          let user_id = $('#txt_username').val();
          //let serial_number = $(this).val();
          $.ajax({
            method: "GET",
            url: "{{route('temp_receiving')}}",
            data: {
              sys_id: sys_id,
              serial_number: serial_number,
              user_id: user_id,
            }
          }).done(function( res ){
            $('#serial').val('');
            console.log(res);
            if(res['status']){
              let count_qty = parseInt($('#qty1').html()) - 1;
              let sum_qty = parseInt($('#qty3').html()) + 1;
              $('#qty1').html(count_qty + ' /');
              $('#qty3').html(sum_qty);

              $('#serials').append($("<option></option>").attr("value", serial_number).text( serial_number ));
              $('.modal-body-serials').append('<p class="p-1 px-3 serial_list">'+max_seq_serial+'. '+serial_number+'</p>');
              //$('#serials').show();
              $('#btn_show_serials').show();
              $('#serials_list').val(serial_number);
              $('#btn-save').attr('disabled',false);

              $('#serial').focus();
            }else{
              showErrorModal($('#serial'),res['msg']);
            }

          });

        }

      });

      $('#DOC_NO').on('keyup', function(){
        if($(this).val() != ''){
          let txn_code = $('#TXN_CODE').val();
          let doc_no = $('#DOC_NO').val();
          let user_id = $('#txt_username').val();
          $.ajax({
            method: "GET",
            url: "{{route('search_receiving')}}",
            data: {
              txn_code: txn_code,
              doc_no: doc_no,
              user_id: user_id,
            }
          }).done(function( res ) {
            console.log(res);
            if(res['status'] == true){
              load_data(res);
              $('#serial').focus();
            }
          });
        }
      });

      $('#ship_id').on('keyup', function(){
        if($(this).val() != ''){
          let ship_id = $(this).val();
          let user_id = $('#txt_username').val();
          $.ajax({
            method: "GET",
            url: "{{route('search_receiving')}}",
            data: {
              ship_id: ship_id,
              user_id: user_id,
            }
          }).done(function( res ) {

            console.log(res);
            $('#ship_id_scan_date').val(curr_datetime());
            if(res['status'] == false){

              showErrorModal($('#ship_id'),'Invalid ship id scanned');
              $('#ship_id').focus();

              return false;

            }else{

              load_data(res);
              $('#serial').focus();
            }

          });
        }

      });

      $('#items').on('change', function() {

        $('#btn-save').attr('disabled',true);
        $('#serials').find('option').remove();
        $('#qty3').html('0');
        var idx = this.selectedIndex;
        $('#seq_items_count').html(idx+' /');
        let serial_val = $(this).find("option:selected").text();
        $('#item').val(serial_val);
        let user_id = $('#txt_username').val();
        let sys_id = $(this).val();

        $.ajax({
          method: "GET",
          url: "{{route('search_receiving')}}",
          data: {
            sys_id: sys_id,
            user_id: user_id,
          }
        }).done(function( res ) {
          console.log(res);
          load_data(res, 'item_select');
          $('#serial').focus();
        });

      });

      $('#TXN_CODE_DOC_NO').on('change', function() {
        $('#btn-save').attr('disabled',true);
        $('#serials').find('option').remove();
        $('#qty3').html('0');
        let ig_doc = $(this).find("option:selected").text().split('-');
        let txn_code = ig_doc[0];
        let doc_no = ig_doc[1];
        $('#TXN_CODE').val(txn_code);
        $('#DOC_NO').val(doc_no);
        let sys_id = $(this).val();
        let user_id = $('#txt_username').val();

        $.ajax({
          method: "GET",
          url: "{{route('search_receiving')}}",
          data: {
            sys_id: sys_id,
            user_id: user_id,
          }
        }).done(function( res ) {
          console.log(res);
          if(res['status'] == true){
            load_data(res, 'item_select');
            $('#serial').focus();
          }
        });

      });

      $('#btn_show_serials').on('click', function(){
        $('#modal-serials').modal('show');
      });
    });

    function load_data(res, type){

      //hidden fields
      $('#ghi_in_gi_sys_id').val(res['data']['GHI_IN_GI_SYS_ID']);
      $('#ghi_in_gi_gh_sys_id').val(res['data']['GHI_IN_GI_GH_SYS_ID']);
      $('#ghi_in_comp_code').val(res['data']['GHI_IN_COMP_CODE']);
      $('#ghi_in_locn_code').val(res['data']['GHI_IN_LOCN_CODE']);
      $('#ghi_in_gh_dt').val(res['data']['GHI_IN_GH_DT']);
      $('#ghi_in_grade_code_1').val(res['data']['GHI_IN_GRADE_CODE_1']);
      $('#ghi_in_grade_code_2').val(res['data']['GHI_IN_GRADE_CODE_2']);
      $('#ghi_in_uom_code').val(res['data']['GHI_IN_UOM_CODE']);
      $('#ghi_in_qty').val(res['data']['GHI_IN_QTY']);
      $('#ghi_in_qty_ls').val(res['data']['GHI_IN_QTY_LS']);
      $('#ghi_in_qty_bu').val(res['data']['GHI_IN_QTY_BU']);
      $('#ghi_in_out_qty_bu').val(res['data']['GHI_IN_OUT_QTY_BU']);


      //form
      $('#ship_id').val(res['data']['GHI_IN_SHIP_ID']);
      $('#item').val(res['data']['GHI_IN_ITEM_CODE']);
      $('#TXN_CODE').val(res['data']['GHI_IN_TXN_CODE']);
      $('#DOC_NO').val(res['data']['GHI_IN_DOC_NO']);
      $('#pallet_id').val(res['pallet_no']);
      $('#grade').val(res['data']['GHI_IN_GRADE_CODE_1']+'/'+res['data']['GHI_IN_GRADE_CODE_2']);
      $('#item_desc').val(res['data']['GHI_IN_ITEM_DESC']);
      let serial_total = res['total_serial'] - res['cnt_temp'];
      $('#qty1').html( serial_total + ' /' ).show();
      $('#qty2').html(res['total_serial']).show();
      $('#pack_qty1').val(1);
      $('#qty3').html(res['cnt_temp']).show();

      $('.modal-body-serials').html('');
      $('#serials').find('option').remove();
      $.each(res['serial_temp'], function(key, value) {
        $('#serials').append($("<option></option>").attr("value", value).text(value));
        $('.modal-body-serials').append('<p class="p-1 px-3 serial_list"> '+(key+1)+'. '+value+'</p>');
      });

      if(res['cnt_temp'] > 0){
        //$('#serials').show();
        $('#btn_show_serials').show();
        $('#btn-save').attr('disabled',false);
      }else{
        //$('#serials').hide();
        $('#btn_show_serials').hide();
        $('#btn-save').attr('disabled',true);
      }


      //item
      if(type != 'item_select'){

        $('#items').find('option').remove();
        $('#items').append($('<option>', { hidden: true, text: 'Option 1' }));
        $.each(res['items'], function(key, value) {
          $('#items').append($("<option></option>").attr("value", res['SYS_ID'][key]).text(value));
        });
        $('#seq_items_count').html('1 /');
        $('#items_count').html(res['items_count']);
        if(res['items_count'] > 1){
          $('#items').show();
          $('#seq_items_count').show();
          $('#items_count').show();
        }

      }


      //IG DOC
      if(type != 'item_select'){

        $('#TXN_CODE_DOC_NO').find('option').remove();
        $('#TXN_CODE_DOC_NO').append($('<option>', { hidden: true, text: 'Option 1' }));
        $.each(res['TXN_CODE'], function(key, value) {
          let im_ig_doc = value + '-' + res['DOC_NO'][key];
          $('#TXN_CODE_DOC_NO').append($("<option></option>").attr("value", res['SYS_ID'][key]).text(im_ig_doc));
        });
        if(res['DOC_NO'].length > 1){ $('#TXN_CODE_DOC_NO').show(); }
      }


      /*$( ".serial_list" ).each(function( index ) {
          console.log( index + ": " + $( this ).text() );
        });

          console.log($( ".serial_list" ).length);*/
    }

    /*window.addEventListener('keydown',e => {
      var code = e.keyCode || e.which;
      $('#seq_items_count').append(' - '+code);
    //  alert(code);

  });*/
    </script>
@endsection
