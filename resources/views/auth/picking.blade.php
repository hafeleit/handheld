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

                    <div class="row">
                        <div id="tab-login" class="col-xl-5 col-lg-5 col-md-7 mx-lg-0" style="">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h5 class="font-weight-bolder">LOGIN</h5>
                                </div>
                                <div class="card-body">
                                  <form class="" action="" method="post" onsubmit="return login_submit()">
                                  <table>
                                    <tr>
                                      <td class="input-sm" align="right">Username:</td>
                                      <td>
                                        <input type="text" name="username" id="username" class="input-sm"  value="{{ $data['HPC_IN_COMP_CODE'] ?? '' }}">
                                        <p id="username_error" class="input-sm error" style="display:none">error</p>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Password:</td>
                                      <td><input type="password" name="password" class="input-sm" ></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">WH Code:</td>
                                      <td><input type="text" name="wh_code" class="input-sm" ></td>
                                    </tr>
                                    <tr>
                                      <td class="input-sm" align="right">Location:</td>
                                      <td><input type="text" name="location" class="input-sm" ></td>
                                    </tr>
                                  </table>

                                  <div class="text-center">
                                      <button id="btn-next" type="submit" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0">Next</button>
                                  </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="form_picking" action="" method="" onsubmit="return picking_submit()">
                    <div id="tab-picking" class="row" style="display: none;">
                        <div class="col-xl-4 col-lg-5 col-md-7 mx-lg-0">
							              <div class="nav-wrapper position-relative end-0">
                              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                  <li class="nav-item">
                                      <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                                          data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                          <span class="ms-2">PICKING</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                          data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                          <span class="ms-2">SYNC</span>
                                      </a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                          data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                          <span class="ms-2">POWER</span>
                                      </a>
                                  </li>
                              </ul>
                          </div>
                          <div class="card card-plain">
                              <div class="card-body">
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
                                    <td class="input-sm" align="right">Position: </td>
                                    <td>
                                        <input type="text" name="position" id="position" class="input-sm" required>
                                        <input type="hidden" name="position_scan_date" id="position_scan_date">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item/G1/G2: </td>
                                    <td><input type="text" name="itemg1g2" id="itemg1g2" class="input-sm" readonly></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Item Desc: </td>
                                    <td><input type="text" name="item_desc" id="item_desc" class="input-sm" readonly></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Batch/Serial:</td>
                                    <td>
                                      <input type="text" name="serial" id="serial" class="input-sm"><select class="input-sm" id="select_serial_all" style="width: 20px; display:none;"></select>
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
                                    <td><input type="text" name="pack_code" id="pack_code" class="input-sm" readonly></td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Pack Qty.: </td>
                                    <td>
                                      <input type="text" name="pack_qty1" id="pack_qty1" class="input-sm" size="8" >
                                      <input type="text" name="pack_qty2" id="pack_qty2" class="input-sm" size="8" readonly>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="input-sm" align="right">Base Qty.: </td>
                                    <td>
                                      <input type="text" name="base_qty_1" id="base_qty_1" class="input-sm" size="8" readonly>
                                      <input type="text" name="base_qty_2" id="base_qty_2" class="input-sm" size="8" readonly>
                                      <input type="hidden" name="login_date" id="login_date">
                                    </td>
                                  </tr>
                                </table>

                                <div class="text-center">
                                    <button id="btn-save" type="submit" class="btn btn-sm btn-primary btn-sm w-50 mt-4 mb-0">Save</button>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    </form>
                </div>
                <input type="hidden" name="grade_code_1" id="grade_code_1" value="">
                <input type="hidden" name="grade_code_2" id="grade_code_2" value="">
        </section>
    </main>

    <script type="text/javascript">

    function login_submit(){
      if($('#username').val() == ''){
        $('#username_error').css('display','revert').html('Username not found');
        $('#username').focus();
      }else{
        $('#login_date').val(curr_datetime());
        $('#tab-login').css('display','none');
        $('#tab-picking').css('display','');
        $('.moving-tab').css('width','35%');
        $('#ticket').focus();
      }

      return false;
    }

    function picking_submit(){

      $.ajax({
        method: "GET",
        url: "{{route('save_picking')}}",
        data: {
          ticket: $('#ticket').val(),
          position: $('#position').val(),
          item_code: $('#item_code').val(),
          serial_no: $('#serial_no').val(),
          batch_no: $('#batch_no').val(),
          pack_qty_1: $('#pack_qty_1').val(),
          pack_qty_2: $('#pack_qty_2').val(),
          username: $('#username').val(),
          ticket_scan_date: $('#ticket_scan_date').val(),
          position_scan_date: $('#position_scan_date').val(),
          login_date: $('#login_date').val(),
        }
      }).done(function( res ) {

        console.log(res);
        alert('Save successfully');
        if(res['status']){
          $('#form_picking')[0].reset();
          $('.error').html('');
          $('#ticket').focus();
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

    $(function(){

      $('#username').focus();

      // TICKET
      $('#ticket').on('keyup', function(){

        let ticket = $(this).val();
        if(ticket == ''){
          return false;
        }
        $.ajax({
          method: "GET",
          url: "{{route('search_ticket')}}",
          data: {
            ticket: ticket,
          }
        }).done(function( res ) {

          console.log(res);
          $('#ticket_scan_date').val(curr_datetime());

          if(res['status'] == false){
            $('#ticket_error').css('display','revert').html('Ticket not found');
            $('#label-st').css('display','none');

            $('#itemg1g2').val('');
            $('#item_desc').val('');
            $('#pack_code').val('');
            $('#pack_qty1').val('');
            $('#pack_qty2').val('');
            $('#base_qty_1').val('');
            $('#base_qty_2').val('');
            return 0;
          }
          $('#ticket_error').css('display','none').html('');

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

          $('#position').focus();
        });

      });

      $('#position').on('keyup', function(){
        $('#position_scan_date').val(curr_datetime());
        $('#serial').focus();
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

            console.log(res);
            if(res['serial_flg'] == false){ // ถ้าไม่เจอ serial ให้แสดง serial ทั้งหมด
              if(res['data'].length > 0){
                $('#select_serial_all').css('display','revert')
                $('#serial_error').css('display','revert').html('Serial mismatch');
                $.each(res['data'], function(key, value) {
                     $('#select_serial_all').append($("<option></option>").attr("value", value).text(value));
                });
              }else{
                $('#serial_error').css('display','revert').html('Serial not found');
                $('#pack_qty1').focus();
              }
              $('#serial').val('');
            }else{
              $('#select_serial_all').css('display','none')
              $('#serial_error').css('display','none').html('');
            }
          });
        }

      });

      $('#select_serial_all').on('change', function() {
        let serial_val = this.value;
        $('#serial').val(serial_val);
        $('#serial_error').css('display','none').html('');
        $("#serial").focus();
      });

    });

    window.addEventListener('keydown',e => {
      var code = e.keyCode || e.which;
      //alert(code);

    });

    </script>
@endsection
