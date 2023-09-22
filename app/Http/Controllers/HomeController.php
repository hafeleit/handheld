<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
		

		$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.3.6)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))" ;
		$conn = oci_connect('HTH','HTH090866',$db);
		
		$stid = oci_parse($conn, "select hpc_in_comp_code,hpc_in_wh_code,hpc_in_locn_code,hpc_in_wave_dt,hpc_in_wave_id,hpc_in_posn_pick_seq_no,hpc_in_sugg_posn,hpc_in_pallet_no,hpc_in_item_code,hpc_in_item_desc,hpc_in_grade_code_1,hpc_in_grade_code_2,hpc_in_pack_code,hpc_in_uom_code,hpc_in_qty,hpc_in_qty_ls,hpc_in_qty_bu,hpc_in_batch_no,hpc_in_srno,hpc_in_work_order_id,hpc_in_work_order_dt,hpc_in_ticket_no,hpc_in_assigned_user,hpc_in_wave_alphabet,hpc_in_wwod_sys_id,hpc_in_sugg_sys_id,hpc_in_pick_text,hpc_in_base_uom,hpc_in_base_max_ls,case when hpc_in_srno is null then hpc_in_pallet_no else 0 end,'','',0,1,'HTH8202',sysdate,sysdate,'50006f00-6300-6b00-6500-7400500043000000434b3352303632583135303037363000','CK3R062X1500760','',sysdate,sysdate,hpc_in_pgn_hole_posn_code,hpc_in_pgn_hole_posn_no,null,null,null,hpc_in_pgn_hole_line,hpc_in_flex_01,hpc_in_flex_02,hpc_in_flex_03,hpc_in_flex_04,hpc_in_flex_05,hpc_in_flex_06,hpc_in_flex_07,hpc_in_flex_08,hpc_in_flex_09,hpc_in_flex_10,hpc_in_flex_11,hpc_in_flex_12,hpc_in_flex_13,hpc_in_flex_14,hpc_in_flex_15,hpc_in_flex_16,hpc_in_flex_17,hpc_in_flex_18,hpc_in_flex_19,hpc_in_flex_20,'N','',1 from OT_WMS_SYNC_HHD_PICK_IN_TEST where hpc_in_ticket_no = '06539689'");
		oci_execute($stid);
		
		$row = oci_fetch_assoc($stid);
		dd($row);
		/*$i = 1;
		while (($row = oci_fetch_assoc($stid)) != false) {
			echo $i++ . ' ';
			echo $row['USER_DESC'] . "<br>\n";
		}*/

		dd(1);

		return view('auth.picking');
		

    }
}
