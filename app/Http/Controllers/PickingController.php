<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PickingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
		public function conn_orion(){

			$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.3.6)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))" ;
			$conn = oci_connect('HTH','HTH090866',$db);
			return $conn;

		}

		public function index(Request $request)
		{
				$login_date = $request->login_date ?? '';
				$txt_username = $request->txt_username ?? '';
				$txt_wh_code = $request->txt_wh_code ?? '';
				$txt_location = $request->txt_location ?? '';

				return view('pages.handheld.index',['txt_username' => $txt_username, 'login_date' => $login_date, 'txt_wh_code' => $txt_wh_code, 'txt_location' => $txt_location]);
		}

		public function login()
		{
				return view('pages.handheld.login');
		}

		public function picking(Request $request)
		{
				$login_date = $request->login_date ?? '';
				$txt_username = $request->txt_username ?? '';
				$txt_wh_code = $request->txt_wh_code ?? '';
				$txt_location = $request->txt_location ?? '';

				return view('pages.handheld.picking',['txt_username' => $txt_username, 'login_date' => $login_date, 'txt_wh_code' => $txt_wh_code, 'txt_location' => $txt_location]);
		}

		public function pigeonhole(Request $request)
		{
				$login_date = $request->login_date ?? '';
				$txt_username = $request->txt_username ?? '';
				$txt_wh_code = $request->txt_wh_code ?? '';
				$txt_location = $request->txt_location ?? '';

				return view('pages.handheld.pigeonhole',['txt_username' => $txt_username, 'login_date' => $login_date, 'txt_wh_code' => $txt_wh_code, 'txt_location' => $txt_location]);
		}

		public function putaway(Request $request)
		{
				$login_date = $request->login_date ?? '';
				$txt_username = $request->txt_username ?? '';
				$txt_wh_code = $request->txt_wh_code ?? '';
				$txt_location = $request->txt_location ?? '';

				return view('pages.handheld.putaway',['txt_username' => $txt_username, 'login_date' => $login_date, 'txt_wh_code' => $txt_wh_code, 'txt_location' => $txt_location]);
		}

		public function search_putaway(Request $request){
			if($request->ticket == ''){
				//return response()->json([ 'status' => false, 'message' => 'no data', ]);
			}

			$query = "SELECT * FROM OT_WMS_SYNC_HHD_PAWAY_IN_TEST WHERE HPC_IN_TICKET_NO = '" . $request->ticket ."'";

			if($request->pa_type != ''){
				if($request->pa_type == 'P'){
					$query = "SELECT * FROM OT_WMS_SYNC_HHD_PAWAY_IN_TEST WHERE HPC_IN_PALLET_NO = '" . $request->ticket ."'";
				}
				if($request->pa_type == 'G'){
					$query = "SELECT * FROM OT_WMS_SYNC_HHD_PAWAY_IN_TEST WHERE HPC_IN_TICKET_NO = '" . $request->ticket ."'";
				}
			}

			if($request->position != ''){
				$query .= " AND HPC_IN_SUGG_POSN = '".$request->position."'";
			}
			if($request->serial != ''){
				$query .= " AND HPC_IN_SRNO = '".$request->serial."'";
			}

			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query);
			oci_execute($stid);
			$res = oci_fetch_assoc($stid);

			$base_aty_data = '';

			if(isset($res['HPC_IN_ITEM_CODE'])){
				$query_base_qty = "
					SELECT
						ROUND(((NVL(HPC_IN_QTY_BU, 0) / HPC_IN_BASE_UOM_LOOSE_1) / NVL(HPC_IN_BASE_UOM_CONV, 1)), 7) as BASE_QTY
					FROM
						OT_WMS_SYNC_HHD_PICK_IN_TEST
					WHERE
						hpc_in_ticket_no='".$request->ticket."'
					AND
						HPC_IN_ITEM_CODE='".$res['HPC_IN_ITEM_CODE']."'";
				$stid2 = oci_parse($conn, $query_base_qty);
				oci_execute($stid2);
				$base_aty_data = oci_fetch_assoc($stid2);

			}

			if($res){
				return response()->json([ 'status' => true, 'data' => $res, 'BASE_QTY' => $base_aty_data]);
			}else{
				return response()->json([ 'status' => false, 'message' => 'no data', ]);
			}

		}

		public function search_ticket(Request $request){

			if($request->ticket == ''){
				return response()->json([ 'status' => false, 'message' => 'no data', ]);
			}

			$query_ticket = "select
			hpc_in_comp_code, hpc_in_wh_code, hpc_in_locn_code, hpc_in_wave_dt, hpc_in_wave_id, hpc_in_posn_pick_seq_no, hpc_in_sugg_posn, hpc_in_pallet_no, hpc_in_item_code,
hpc_in_item_desc, hpc_in_grade_code_1, hpc_in_grade_code_2, hpc_in_pack_code, hpc_in_uom_code, hpc_in_qty, hpc_in_qty_ls, hpc_in_qty_bu, hpc_in_batch_no, hpc_in_srno,
hpc_in_work_order_id, hpc_in_work_order_dt, hpc_in_ticket_no, hpc_in_assigned_user, hpc_in_wave_alphabet, hpc_in_wwod_sys_id, hpc_in_sugg_sys_id, hpc_in_pick_text,
hpc_in_base_uom, hpc_in_base_max_ls, hpc_in_pgn_hole_posn_code, hpc_in_pgn_hole_posn_no, hpc_in_ref_opr_type, hpc_in_pgn_hole_line, hpc_in_flex_01, hpc_in_flex_02,
hpc_in_flex_03, hpc_in_flex_04, hpc_in_flex_05, hpc_in_flex_06, hpc_in_flex_07, hpc_in_flex_08, hpc_in_flex_09, hpc_in_flex_10, hpc_in_flex_11, hpc_in_flex_12,
hpc_in_flex_13, hpc_in_flex_14, hpc_in_flex_15, hpc_in_flex_16, hpc_in_flex_17, hpc_in_flex_18, hpc_in_flex_19, hpc_in_flex_20, hpc_in_sugg_posn_no, hpc_in_base_qty,
hpc_in_base_qty_ls, hpc_in_base_qty_bu, hpc_in_stk_take_yn, hpc_in_out_flag, hpc_in_dflt_pack_code, hpc_dflt_qty, hpc_dflt_qty_ls, hpc_dflt_qty_bu, hpc_in_conv_fact,
hpc_in_base_uom_conv, hpc_in_stk_uom_conv, hpc_in_stk_uom_loose, hpc_in_stk_uom_loose_1, hpc_in_base_uom_loose, hpc_in_base_uom_loose_1
								from
									OT_WMS_SYNC_HHD_PICK_IN_TEST
								WHERE
									hpc_in_ticket_no = '" . $request->ticket ."'
								AND
									hpc_in_wh_code = '".$request->wh_code."'
								AND
									hpc_in_locn_code = '".$request->location."'
									";
//dd($query_ticket);
			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query_ticket);
			oci_execute($stid);
			$ticket_data = oci_fetch_assoc($stid);

			$base_aty_data = '';

			if(isset($ticket_data['HPC_IN_ITEM_CODE'])){
				$query_base_qty = "
					SELECT
						ROUND(((NVL(HPC_IN_QTY_BU, 0) / HPC_IN_BASE_UOM_LOOSE_1) / NVL(HPC_IN_BASE_UOM_CONV, 1)), 7) as BASE_QTY
					FROM
						OT_WMS_SYNC_HHD_PICK_IN_TEST
					WHERE
						hpc_in_ticket_no='".$request->ticket."'
					AND
						HPC_IN_ITEM_CODE='".$ticket_data['HPC_IN_ITEM_CODE']."'";

				$stid2 = oci_parse($conn, $query_base_qty);
				oci_execute($stid2);
				$base_aty_data = oci_fetch_assoc($stid2);

			}
			if($ticket_data){
				return response()->json([ 'status' => true, 'data' => $ticket_data, 'BASE_QTY' => $base_aty_data]);
			}else{
				return response()->json([ 'status' => false, 'message' => 'no data', ]);
			}
		}

		public function search_pgh(Request $request){

			if($request->ticket == ''){
				return response()->json([ 'status' => false, 'message' => 'no data', ]);
			}

			$query = "SELECT * FROM OT_WMS_HHD_PGH_IN_TEST WHERE WHP_IN_TICKET_NO ='".$request->ticket."'";
			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query);
			oci_execute($stid);
			$ticket_data = oci_fetch_assoc($stid);

			$query = "SELECT Count(*) as remaining FROM (
  SELECT * FROM  OT_WMS_HHD_PGH_IN_TEST  WHERE  (WWP_IN_REF_TXN_CODE,wwp_in_ref_no) IN(
    SELECT WWP_IN_REF_TXN_CODE,WWP_IN_REF_NO FROM OT_WMS_HHD_PGH_IN_TEST  WHERE   WHP_IN_TICKET_NO ='".$request->ticket."')
    AND WHP_IN_WWOD_SYS_ID  NOT IN (SELECT WHP_OUT_WWOD_SYS_ID FROM OT_WMS_HHD_PGH_OUT_TEST  WHERE WWP_IN_REF_TXN_CODE=WWP_OUT_REF_TXN_CODE AND WWP_IN_REF_NO=WWP_OUT_REF_NO)
    MINUS
    SELECT * FROM  OT_WMS_HHD_PGH_IN_TEST WHERE   WHP_IN_TICKET_NO ='".$request->ticket."')";
			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query);
			oci_execute($stid);
			$remaining = oci_fetch_assoc($stid);

			if($ticket_data){
				return response()->json([ 'status' => true, 'data' => $ticket_data, 'remaining' => $remaining]);
			}else{
				return response()->json([ 'status' => false, 'message' => 'no data', ]);
			}
		}

		public function chk_wh_locn(Request $request){

			$wh = $request->wh ?? '';
			$locn = $request->locn ?? '';
			$query = "SELECT WL_WH_CODE, WL_LOCN_CODE FROM OM_WAREHOUSE_LOCN WHERE WL_WH_CODE = '".$wh."' AND WL_LOCN_CODE = '".$locn."'";
			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query);
			oci_execute($stid);
			$chk_wh_locn = oci_fetch_assoc($stid);
			if($chk_wh_locn){
				return response()->json([
					'status' => true,
				]);
			}else{
				return response()->json([
					'status' => false,
				]);
			}
		}

		public function search_serial(Request $request){

			$query_chk_position = "select HPC_IN_SUGG_POSN from OT_WMS_SYNC_HHD_PICK_IN_TEST
								WHERE
									hpc_in_ticket_no = '" . $request->ticket ."'
								AND
									hpc_in_wh_code = '".$request->wh_code."'
								AND
									hpc_in_locn_code = '".$request->location."'
								AND
									HPC_IN_SUGG_POSN = '".$request->position."'";

			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query_chk_position);
			oci_execute($stid);
			$chk_position = oci_fetch_assoc($stid);

			$position_status = false;
			if($chk_position){
				$position_status = true;
			}
			$query = "
				SELECT
					HPC_BS_SRNO,
					HPC_BS_BATCH_NO,
					HPC_BS_PALLET_NO
				FROM
					OT_WMS_SYNC_HHD_PICK_BTSR_TEST
				WHERE
					HPC_BS_POSN_CODE='".$request->position."'
				AND
					HPC_BS_ITEM_CODE='".$request->item_code."'
				AND
					HPC_BS_GRADE_CODE_1='".$request->grade_code_1."'
				AND
					HPC_BS_GRADE_CODE_2='".$request->grade_code_2."'
				";

			$serial_all = [];
			$serial_flg = false;
			$conn = $this->conn_orion();
			$stid = oci_parse($conn, $query);
			oci_execute($stid);

			while($res = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
					if($res['HPC_BS_SRNO'] != ''){
						$serial_all[] = $res['HPC_BS_SRNO'];
					}
					if($res['HPC_BS_BATCH_NO'] != ''){
						$serial_all[] = $res['HPC_BS_BATCH_NO'];
					}

			}
			if (in_array($request->serial, $serial_all)) {
				$serial_flg = true;
			}

			$cnt_serial = count($serial_all);

			return response()->json([ 'status' => $position_status, 'data' => $serial_all, 'serial_flg' => $serial_flg, 'cnt_serial' => $cnt_serial, ]);

		}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

	public function save_putaway(Request $request){

		$ticket = $request->ticket ?? '';
		$ticket_scan_date = $request->ticket_scan_date ?? '';
		$position_scan_date = $request->ticket_scan_date ?? '';
		$putaway_scan_date = $request->pgh_scan_date ?? '';
		$username = $request->username ?? '';
		$login_date = $request->login_date ?? '';
		$putaway_type = $request->putaway_type ?? '';

		$hpc_in_flex_20 = 'hpc_in_flex_20';
		$where = 'HPC_IN_TICKET_NO';

		if($putaway_type != ''){
			$hpc_in_flex_20 = "'".$putaway_type."'";

			if($putaway_type == 'P'){
				$where = 'HPC_IN_PALLET_NO';
			}
			if($putaway_type == 'G'){
				$where = 'HPC_IN_FLEX_01';

				$query_g = "SELECT HPC_IN_FLEX_01 FROM OT_WMS_SYNC_HHD_PAWAY_IN_TEST WHERE HPC_IN_TICKET_NO = '" . $ticket . "'";
				$conn = $this->conn_orion();
				$stid = oci_parse($conn, $query_g);
				oci_execute($stid);
				$group_id = oci_fetch_assoc($stid);
				$ticket = $group_id['HPC_IN_FLEX_01'];
			}
		}
		$query = "
		INSERT INTO OT_WMS_SYNC_HHD_PAWAY_OUT_TEST
			SELECT
				hpc_in_comp_code,
				hpc_in_wh_code,
				hpc_in_locn_code,
				hpc_in_rcv_dt,
				hpc_in_rcv_id,
				hpc_in_posn_rcv_seq_no,
				hpc_in_sugg_posn,
				hpc_in_pallet_no,
				hpc_in_item_code,
				'9',
				hpc_in_grade_code_1,
				hpc_in_grade_code_2,
				hpc_in_pack_code,
				hpc_in_uom_code,
				hpc_in_qty,
				hpc_in_qty_ls,
				hpc_in_qty_bu,
				hpc_in_batch_no,
				hpc_in_srno,
				hpc_in_work_order_id,
				hpc_in_work_order_dt,
				hpc_in_ticket_no,
				hpc_in_assigned_user,
				hpc_in_wwod_sys_id,
				hpc_in_sugg_sys_id,
				hpc_in_ref_opr_type,
				hpc_in_flex_01,
				hpc_in_flex_02,
				hpc_in_flex_03,
				hpc_in_flex_04,
				hpc_in_flex_05,
				hpc_in_flex_06,
				hpc_in_flex_07,
				hpc_in_flex_08,
				hpc_in_flex_09,
				hpc_in_flex_10,
				hpc_in_flex_11,
				hpc_in_flex_12,
				hpc_in_flex_13,
				hpc_in_flex_14,
				hpc_in_flex_15,
				hpc_in_flex_16,
				hpc_in_flex_17,
				hpc_in_flex_18,
				hpc_in_flex_19,
				$hpc_in_flex_20,
				hpc_in_sugg_posn_no,
				hpc_in_base_uom,
				hpc_in_base_max_ls,
				hpc_in_base_qty,
				hpc_in_base_qty_ls,
				hpc_in_base_qty_bu,
				hpc_in_out_flag,
				hpc_in_dflt_pack_code,
				hpc_dflt_qty,
				hpc_dflt_qty_ls,
				hpc_dflt_qty_bu,
				hpc_in_dflt_conv_fact,
				hpc_in_base_uom_conv,
				hpc_in_stk_uom_conv,
				hpc_in_stk_uom_loose,
				hpc_in_stk_uom_loose_1,
				hpc_in_base_uom_loose,
				hpc_in_base_uom_loose_1,
				hpc_in_sugg_posn,
				hpc_in_pack_code,
				hpc_in_qty,
				hpc_in_qty_ls,
				hpc_in_qty_bu,
				'".$username."' as hpc_out_act_user_id,
				TO_DATE('".$putaway_scan_date."', 'DD/MM/YYYY HH24:MI:SS') as hpc_out_act_putaway_conf_dt,
				TO_DATE('".$putaway_scan_date."', 'DD/MM/YYYY HH24:MI:SS') as hpc_out_act_sync_dt,
				'orionadmin' as hpc_out_device_id,
				'hthbkkapp113' as hpc_out_device_name,
				'',
				TO_DATE('".$ticket_scan_date."', 'DD/MM/YYYY HH24:MI:SS') as hpc_out_ticket_scan_dt,
				TO_DATE('".$position_scan_date."', 'DD/MM/YYYY HH24:MI:SS') as hpc_out_posn_scan_dt,
				'".$username."' as hpc_out_cr_uid,
				TO_DATE('".$login_date."', 'DD/MM/YYYY HH24:MI:SS') as hpc_out_cr_dt
			FROM
				OT_WMS_SYNC_HHD_PAWAY_IN_TEST
			WHERE
				$where = '".$ticket."'
		";

		$conn = $this->conn_orion();
		$stid = oci_parse($conn, $query);
		$exc = oci_execute($stid);

		if($exc){
			return response()->json([
				'status' => true,
				'message' => 'insert Successfuly',
			]);
		}else{
			return response()->json([
				'status' => false,
				'message' => 'insert error'
			]);
		}
	}

	public function save_pgh(Request $request){

		$ticket = $request->ticket ?? '';
		$ticket_scan_date = $request->ticket_scan_date ?? '';
		$pgh_scan_date = $request->pgh_scan_date ?? '';
		$username = $request->username ?? '';
		$login_date = $request->login_date ?? '';

		$query = "
		INSERT INTO OT_WMS_HHD_PGH_OUT_TEST
			SELECT
				whp_in_comp_code,
				whp_in_wh_code,
				whp_in_locn_code,
				whp_in_wave_dt,
				whp_in_wave_id,
				wwp_in_ref_txn_code,
				wwp_in_ref_no,
				whp_in_sugg_posn,
				whp_in_pallet_no,
				whp_in_item_code,
				whp_in_item_desc,
				whp_in_grade_code_1,
				whp_in_grade_code_2,
				whp_in_pack_code,
				whp_in_uom_code,
				whp_in_qty,
				whp_in_qty_ls,
				whp_in_qty_bu,
				whp_in_batch_no,
				whp_in_srno,
				whp_in_work_order_id,
				whp_in_work_order_dt,
				whp_in_ticket_no,
				whp_in_assigned_user,
				whp_in_wave_alphabet,
				whp_in_wwod_sys_id,
				whp_in_pgn_hole_posn_code,
				whp_in_pgn_hole_posn_no,
				whp_in_pgn_hole_line,
				whp_in_sugg_posn_no,
				whp_in_bar_code,
				'orionadmin' as whp_out_device_id,
				'hthbkkapp113' as whp_out_device_name,
				TO_DATE('".$ticket_scan_date."', 'DD/MM/YYYY HH24:MI:SS') as whp_out_ticket_scan_dt,
				TO_DATE('".$pgh_scan_date."', 'DD/MM/YYYY HH24:MI:SS') as whp_out_pgh_scan_dt,
				'".$username."' as whp_out_cr_uid,
				TO_DATE('".$login_date."', 'DD/MM/YYYY HH24:MI:SS') as whp_out_cr_dt,
				whp_in_base_uom_qty,
				whp_in_base_uom_qty_ls,
				whp_in_base_uom_qty_bu
			FROM
				OT_WMS_HHD_PGH_IN_TEST
			WHERE
				WHP_IN_TICKET_NO = '".$ticket."'
		";

		/*echo "<pre>";
					echo $query;
					dd(0);*/

		$conn = $this->conn_orion();
		$stid = oci_parse($conn, $query);
		$exc = oci_execute($stid);

		if($exc){
			return response()->json([
				'status' => true,
				'message' => 'insert Successfuly',
			]);
		}else{
			return response()->json([
				'status' => false,
				'message' => 'insert error'
			]);
		}
	}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
				$ticket = $request->ticket ?? '';
				$position = $request->position ?? '';
				$item_code = $request->item_code ?? '';
				$serial_no = $request->serial_no ?? '';
				//$batch_no = $request->batch_no ?? '';
				$pack_qty_1 = $request->pack_qty_1 ?? '';
				$pack_qty_2 = $request->pack_qty_2 ?? '';
				$username = $request->username ?? '';
				$ticket_scan_date = $request->ticket_scan_date ?? '';
				$position_scan_date = $request->position_scan_date ?? '';
				$login_date = $request->login_date ?? '';

				if($ticket != ''){

					$query = "
						insert into OT_WMS_SYNC_HHD_PICK_OUT_TEST
							select
								hpc_in_comp_code,
								hpc_in_wh_code,
								hpc_in_locn_code,
								hpc_in_wave_dt,
								hpc_in_wave_id,
								hpc_in_posn_pick_seq_no,
								hpc_in_sugg_posn,
								hpc_in_pallet_no,
								hpc_in_item_code,
								hpc_in_item_desc,
								hpc_in_grade_code_1,
								hpc_in_grade_code_2,
								hpc_in_pack_code,
								hpc_in_uom_code,
								hpc_in_qty,
								hpc_in_qty_ls,
								hpc_in_qty_bu,
								hpc_in_batch_no,
								hpc_in_srno,
								hpc_in_work_order_id,
								hpc_in_work_order_dt,
								hpc_in_ticket_no,
								hpc_in_assigned_user,
								hpc_in_wave_alphabet,
								hpc_in_wwod_sys_id,
								hpc_in_sugg_sys_id,
								hpc_in_pick_text,
								hpc_in_base_uom,
								hpc_in_base_max_ls,
								case
									when hpc_in_srno is null and hpc_in_batch_no is null then hpc_in_pallet_no
									when hpc_in_srno is not null then (
										SELECT HPC_BS_PALLET_NO FROM OT_WMS_SYNC_HHD_PICK_BTSR_TEST
										WHERE hpc_bs_posn_code = '".$position."' AND hpc_bs_item_code = '".$item_code."' AND hpc_bs_srno = '".$serial_no."')
									else (
										SELECT HPC_BS_PALLET_NO FROM OT_WMS_SYNC_HHD_PICK_BTSR_TEST
										WHERE hpc_bs_posn_code = '".$position."' AND hpc_bs_item_code = '".$item_code."' AND HPC_BS_BATCH_NO = '".$serial_no."')
						 		end,
						 		case
									when hpc_in_batch_no is not null then '".$serial_no."' else null
								end,
						 		case
									when hpc_in_srno is not null then '".$serial_no."' else null end,
						 		'".$pack_qty_1."', /* pack qty 1 */
						 		'".$pack_qty_2."', /* pack qty 2 */
							 	'".$username."', /* user login */
							 	sysdate,
							 	sysdate,
							 	'50006f00-6300-6b00-6500-7400500043000000434b33522d3735583137303032343600', /*device id*/
							 	'CK3R075X1700246', /*device name*/
							 	'Y',
							 	TO_DATE('".$ticket_scan_date."', 'DD/MM/YY HH24:MI:SS'), /* ticket scan date */
							 	TO_DATE('".$position_scan_date."', 'DD/MM/YY HH24:MI:SS'), /* position scan date */
							 	hpc_in_pgn_hole_posn_code,hpc_in_pgn_hole_posn_no,null,
							 	'".$username."', /* user */
							 	TO_DATE('".$login_date."', 'DD/MM/YY HH24:MI:SS'), /* login date 20/06/2023 */
							 	hpc_in_pgn_hole_line,
								hpc_in_flex_01,
								hpc_in_flex_02,
								hpc_in_flex_03,
								hpc_in_flex_04,
								hpc_in_flex_05,
								hpc_in_flex_06,
								hpc_in_flex_07,
								hpc_in_flex_08,
								hpc_in_flex_09,
								hpc_in_flex_10,
								hpc_in_flex_11,
								hpc_in_flex_12,
								hpc_in_flex_13,
								hpc_in_flex_14,
								hpc_in_flex_15,
								hpc_in_flex_16,
								hpc_in_flex_17,
								hpc_in_flex_18,
								hpc_in_flex_19,
								hpc_in_flex_20,
								'Y',
							 	'',
								( ROUND(((NVL(hpc_in_qty, 0) + (NVL(HPC_IN_QTY_LS, 0) / HPC_IN_STK_UOM_LOOSE_1)) * HPC_IN_STK_UOM_CONV) * HPC_IN_BASE_UOM_LOOSE_1))
							FROM
								ot_wms_sync_hhd_pick_in_test
							where
								hpc_in_ticket_no = '".$ticket."'
					";
					/*echo "<pre>";
					echo $query;
					dd(0);*/
					$conn = $this->conn_orion();
					$stid = oci_parse($conn, $query);
					$exc = oci_execute($stid);

					if($exc){
						return response()->json([
							'status' => true,
							'message' => 'insert Successfuly',
						]);
					}else{
						return response()->json([
							'status' => false,
							'message' => 'insert error'
						]);
					}
				}

				return response()->json([
					'status' => false,
					'message' => 'insert error'
				]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
