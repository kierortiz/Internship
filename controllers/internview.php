<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Internview extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('internview_mod');
		$this->load->library('session');
		$this->load->helper('form');
		if ($this->session->userdata('USER_ID') == '') {
			redirect('login');
		}
	}
	public function index()
	{
		$data = ['title' => '******* | Intern'];
		$this->load->view('intern_view/home', $data);
	}

	public function profile($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		} else {
			if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
				redirect('intern/' . $id);
			}
			if ($checkStatus['account_type'] == 'ADMIN') {
				redirect('admin/dashboard/' . $id);
			} else {
				$login_id = $this->session->userdata('USER_ID');
				if ($id == $login_id) {
					$info = [
						'title' => '******* | Profile',
						'user_id' => $this->session->userdata('USER_ID'),
						'page' => 'My Profile',
						'USER_DATA' => $this->internview_mod->GET_INFO($id),
						'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
					];
					$this->load->view('layout/header', $info);
					$this->load->view('intern_view/profile', $info);
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function attendance($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);

		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		}
		if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
			redirect('intern/' . $id);
		}
		if ($checkStatus['account_type'] == 'ADMIN') {
			redirect('admin/dashboard/' . $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******* | Attendance',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'My Attendance',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
				];

				$this->load->view('layout/header', $info);
				$this->load->view('intern_view/attendance', $info);
				$this->load->view('layout/footer');
				
			}
		}
	}


	public function overtime($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);

		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		}
		if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
			redirect('intern/' . $id);
		}
		if ($checkStatus['account_type'] == 'ADMIN') {
			redirect('admin/dashboard/' . $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******* | Overtime',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Overtime',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
				];

				$this->load->view('layout/header', $info);
				$this->load->view('intern_view/overtime', $info);
				$this->load->view('layout/footer');
				
			}
		}
	}

	public function OT_TIME_IN_OUT($id){
		if ($this->input->is_ajax_request()) {
			$data = $this->internview_mod->OVERTIME_TIME_IN_OUT($id);
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function request_overtime(){
		if ($this->input->is_ajax_request()) {
			$name = $this->input->post('intern_name');
			$id   = $this->input->post('intern_id');
			$dept = $this->input->post('intern_dept');
			$proj = $this->input->post('intern_proj');
			$stat = $this->input->post('req_stat');
			$date = $this->input->post('req_date');
			$reas = $this->input->post('req_reas');

			$config['upload_path'] = './intern_request/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '5000';
			$config['overwrite'] = TRUE;
			$fileExtension = strrchr($_FILES['letter']['name'], '.');
			$this->load->library('upload',$config);

			$getReturn = $this->internview_mod->GET_OVERTIME($id);
			if (!$getReturn) {//INSERT
				$_FILES['letter']['name'] = $id.' '.$name.' '.$date.$fileExtension;
				$file=str_replace(' ', '_', $_FILES['letter']['name']);
				$this->upload->do_upload('letter');
				$this->internview_mod->INTSERT_REQUEST_OVERTIME($name, $id, $dept, $proj, $stat, $date, $reas, $file);
			} else {//UPDATE
				$_FILES['letter']['name'] = $id.' '.$name.' '.$date.$fileExtension;
				$file=str_replace(' ', '_', $_FILES['letter']['name']);
				$this->upload->do_upload('letter');
				$this->internview_mod->UPDATE_REQUEST_OVERTIME($name, $id, $dept, $proj, $stat, $date, $reas, $file);
			}
			
		} else {
			echo "No direct script access allowed";
		}
	}

	public function request_overtime_time_in(){
		if ($this->input->is_ajax_request()) {
			$id   	  = $this->input->post('OTid');
		
			$timeIn   = $this->input->post('OTtime');

			$getReturn = $this->internview_mod->GET_OVERTIME($id);
			$getTimeOut = $getReturn->col_ot_tout;
			$getTimeIn = $getReturn->col_ot_tin;
			if (!$getTimeIn && !$getTimeOut) {
				$this->internview_mod->UPDATE_REQUEST_OVERTIME_TIME_IN($id, $timeIn);
				$response = ['OTstatus' => 'VALID', 'time' => $timeIn];
			} else {
				$response = ['OTstatus' => 'INVALID', 'time' => $getReturn->col_ot_tin];
			}
			echo json_encode($response);
		} else {
			echo "No direct script access allowed";
		}
	}

	
	public function request_overtime_time_out(){
		if ($this->input->is_ajax_request()) {
			$id   	  = $this->input->post('OTid');
			
			$timeOut   = $this->input->post('OTtime');

			$getReturn = $this->internview_mod->GET_OVERTIME($id);
			$getTimeOut = $getReturn->col_ot_tout;
			$getTimeIn = $getReturn->col_ot_tin;
			if ($getTimeIn && !$getTimeOut) {
				$this->internview_mod->UPDATE_REQUEST_OVERTIME_TIME_OUT($id, $timeOut);
				$response = ['OTstatus' => 'VALID', 'time' => $timeOut];
			} else {
				$response = ['OTstatus' => 'INVALID', 'time' => $getReturn->col_ot_tout];
			}
			echo json_encode($response);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function display_overtime($id){
		$display_overtime = $this->internview_mod->DISPLAY_OVERTIME($id);
		echo json_encode($display_overtime);
	}

	public function request($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		} else {
			if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
				redirect('intern/' . $id);
			}
			if ($checkStatus['account_type'] == 'ADMIN') {
				redirect('admin/dashboard/' . $id);
			} else {
				$login_id = $this->session->userdata('USER_ID');
				if ($id == $login_id) {
					$info = [
						'title' => '******* | Request',
						'user_id' => $this->session->userdata('USER_ID'),
						'page' => 'Requests',
						'USER_DATA' => $this->internview_mod->GET_INFO($id),
						'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
					];
					$this->load->view('layout/header', $info);
					$this->load->view('intern_view/request', $info);
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function req_schedule()
	{
		$id = $this->input->post('id');
		$email = $this->input->post('email');
		$Monday = $this->input->post('Monday');
		$Tuesday = $this->input->post('Tuesday');
		$Wednesday = $this->input->post('Wednesday');
		$Thursday = $this->input->post('Thursday');
		$Friday = $this->input->post('Friday');
		$Saturday = $this->input->post('Saturday');
		$work_hour = $this->input->post('work_hour');
		$req_comment = $this->input->post('req_comment');
		$schedule = array($Monday .   $Tuesday .   $Wednesday .   $Thursday .   $Friday .   $Saturday);
		$this->internview_mod->REQ_SCHEDULE($id, $schedule, $work_hour, $req_comment, $email);
		$this->internview_mod->REQ_COUNT($id);

	}

	public function alumni($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		} else {
			if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
				redirect('intern/' . $id);
			}
			if ($checkStatus['account_type'] == 'ADMIN') {
				redirect('admin/dashboard/' . $id);
			} else {
				$login_id = $this->session->userdata('USER_ID');
				if ($id == $login_id) {
					$info = [
						'title' => '******* | Profile',
						'user_id' => $this->session->userdata('USER_ID'),
						'page' => 'Alumni',
						'USER_DATA' => $this->internview_mod->GET_INFO($id),
						'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
					];
					$this->load->view('layout/header', $info);
					$this->load->view('intern_view/alumni', $info);
					$this->load->view('layout/footer');
				}
			}
		}
	}
	// //-----------------------------------------------------------------------------------------
	//SUBMIT request EVAL
	public function sub_req_Eval()
	{	
		$id = $this->input->post('INF_USER_ID_INTR');
		$email = $this->input->post('INF_USER_EMAIL_INTR');
		$name = $this->input->post('INF_USER_NAME');
		$dt = date("Y-M-d h:m:s a");

		$config['upload_path'] = './alumni_request/';
		$config['allowed_types'] = 'pdf';
		$config['max_size'] = '5000';
		$fileExtension=$_FILES['reply_attach']['name'];
		$this->load->library('upload',$config);
		$this->upload->do_upload('reply_attach');
		$this->internview_mod->SUBMIT_EVAL($id,$email,$name,$dt,$fileExtension);
	}

	public function events($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);

		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		}
		if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
			redirect('intern/' . $id);
		}
		if ($checkStatus['account_type'] == 'ADMIN') {
			redirect('admin/dashboard/' . $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******* | Events',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Events',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
				];
				$this->load->view('layout/header', $info);
				$this->load->view('intern_view/events', $info);
				$this->load->view('layout/footer');
			}
		}
	}

	public function announcements($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);

		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		}
		if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
			redirect('intern/' . $id);
		}
		if ($checkStatus['account_type'] == 'ADMIN') {
			redirect('admin/dashboard/' . $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******* | Announcements',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Announcements',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
				];
				$this->load->view('layout/header', $info);
				$this->load->view('intern_view/announcements', $info);
				$this->load->view('layout/footer');
			}
		}
	}

	public function department($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);

		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		}
		if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
			redirect('intern/' . $id);
		}
		if ($checkStatus['account_type'] == 'ADMIN') {
			redirect('admin/dashboard/' . $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******* | Department',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Department',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
					'USER_DETAILS_DATA' => $this->internview_mod->GET_DEPARTMENT_DETAILS(),
				];
				$this->load->view('layout/header', $info);
				$this->load->view('intern_view/department', $info);
				$this->load->view('layout/footer');
			}
		}
	}

	public function project($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);

		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		}
		if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
			redirect('intern/' . $id);
		}
		if ($checkStatus['account_type'] == 'ADMIN') {
			redirect('admin/dashboard/' . $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******* | Project',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Project',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
					'USER_DETAILS_DATA' => $this->internview_mod->GET_DEPARTMENT_DETAILS(),
				];
				$this->load->view('layout/header', $info);
				$this->load->view('intern_view/project', $info);
				$this->load->view('layout/footer');
			}
		}
	}

	public function GET_DEPARTMENT_DETAILS() {
		if ($this->input->is_ajax_request()) {
			$get_member = $this->internview_mod->GET_USER_DATA();
			
			echo json_encode($get_member);
		} else {
			echo "'No direct script access allowed'";
		}
	}












	public function intern_page($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		} else {
			if ($checkStatus['account_type'] == 'ADMIN' OR $checkStatus['account_type'] == 'HR') {
				redirect('admin/recruitment/' . $id);
			}
			if ($checkStatus['status'] == 'ACCEPTED') {
				redirect('profile/' . $id);
			} else {
				$login_id = $this->session->userdata('USER_ID');
				if ($id == $login_id) {
					$info = [
						'title' => '******* | Intern',
						'user_id' => $this->session->userdata('USER_ID'),
						'page' => 'My Application',
						'USER_DATA' => $this->internview_mod->GET_INFO($id),
					];
					$this->load->view('layout/header_step', $info);
					$this->load->view('intern_view/progress', $info);
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function progress($id)
	{
		$login_id = $this->session->userdata('USER_ID');
		if ($id == $login_id) {
			$info['USER_DATA'] = $this->internview_mod->GET_INFO($id);
			if ($info['USER_DATA']['account_type'] == 'ADVISER') {
				redirect('adviser/' . $id);
			}
			if ($info['USER_DATA']['account_type'] == 'HR') {
				redirect('admin/recruitment/' . $id);
			}
			if ($info['USER_DATA']['step'] == 0 and $info['USER_DATA']['account_type'] == 'INTERN') {
				redirect('intern/' . $id);
			}
			if ($info['USER_DATA']['step'] == 1 and $info['USER_DATA']['account_type'] == 'INTERN') {
				redirect('intern/' . $id);
			}
			if ($info['USER_DATA']['step'] == 2 and $info['USER_DATA']['account_type'] == 'INTERN') {
				redirect('intern/' . $id);
			}
			if ($info['USER_DATA']['step'] == 3 and $info['USER_DATA']['account_type'] == 'INTERN') {
				redirect('intern/' . $id);
			}
			if ($info['USER_DATA']['step'] == 4 and $info['USER_DATA']['account_type'] == 'INTERN') {
				redirect('profile/' . $id);
			}
		}
	}

	public function display_attendance($id)
	{
		if ($this->input->is_ajax_request()) {
			$displayAttendance = $this->internview_mod->GET_ATTENDANCE($id);
			echo json_encode($displayAttendance);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function insert_attendance()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$name = $this->input->post('intern_name');
			$time = $this->input->post('time');
			$date = $this->input->post('date_today');
			$phase = $this->input->post('phase');

			$getReturn = $this->internview_mod->GET_CURR_DATE($id);
			
			if (!$getReturn) {
				$this->internview_mod->INSERT_ATTENDANCE($id, $name, $date, $time . ' ' . $phase );
				$TimeIn = ['status' => 'VALID', 'time' => $time . ' ' . $phase];
			} else {
				$TimeIn = ['status' => 'INVALID', 'time' => $getReturn->col_time_in];
			}
			echo json_encode($TimeIn);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function update_attendance($id)
	{
		if ($this->input->is_ajax_request()) {
			$time = $this->input->post('time');
			$phase = $this->input->post('phase');

			$getReturn = $this->internview_mod->GET_CURR_DATE($id);
			$getTimeOut = $getReturn->col_time_out;
			$getTimeIn = $getReturn->col_time_in;

			if ($getTimeIn && !$getTimeOut) {
				$getID = $this->internview_mod->GET_ATTENDANCE_LAST($id);
				$this->internview_mod->UPDATE_ATTENDANCE($getID, $time . ' ' . $phase);
				$TimeOut = ['status' => 'VALID', 'time' => $time . ' ' . $phase];
			} else {
				$TimeOut = ['status' => 'INVALID', 'time' => $getTimeOut];
			}
			echo json_encode($TimeOut);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function update_personal()
	{
		$img = $this->input->post('image');
		$id = $this->input->post('id');
		$last = $this->input->post('lastname');
		$first = $this->input->post('fistname');
		$middle = $this->input->post('middlename');
		$address = $this->input->post('address');
		$email = $this->input->post('email');
		$contact = $this->input->post('contact');
		$birthday = $this->input->post('birthday');
		$gender = $this->input->post('gender');
		$skill = $this->input->post('skills');
		$this->internview_mod->UPDATE_PERSONAL_INFO(
			$id,
			$last,
			$first,
			$middle,
			$address,
			$email,
			$contact,
			$birthday,
			$gender,
			$skill,
			$img
		);
	}

	public function update_internship()
	{
		$id = $this->input->post('id');
		$schl_name = $this->input->post('schl_name');
		$schl_cont = $this->input->post('schl_cont');
		$advs_name = $this->input->post('advs_name');
		$advs_cont = $this->input->post('advs_cont');
		$intn_cour = $this->input->post('intn_cour');
		$intn_hour = $this->input->post('intn_hour');
		$this->internview_mod->UPDATE_INTERNSHIP_DETAILS(
			$id,
			$schl_name,
			$schl_cont,
			$advs_name,
			$advs_cont,
			$intn_cour,
			$intn_hour
		);
	}

	public function update_schedule()
	{
		$id = $this->input->post('id');
		$Monday = $this->input->post('Monday');
		$Tuesday = $this->input->post('Tuesday');
		$Wednesday = $this->input->post('Wednesday');
		$Thursday = $this->input->post('Thursday');
		$Friday = $this->input->post('Friday');
		$Saturday = $this->input->post('Saturday');
		$work_hour = $this->input->post('work_hour');
		$schedule = array($Monday .   $Tuesday .   $Wednesday .   $Thursday .   $Friday .   $Saturday);
		$this->internview_mod->UPDATE_SCHEDULE($id, $schedule, $work_hour);
	}

	public function update_essay()
	{
		$id = $this->input->post('id');
		$essay = $this->input->post('essay');
		$this->internview_mod->UPDATE_ESSAY($id, $essay);
	}


	public function update_photo()
	{
		$config['upload_path'] = './intern_photo/';
		$config['allowed_types'] = 'jpeg|png|gif|jpg|pdf';
		$this->load->library('upload', $config);
		$this->upload->do_upload('img');
	}

/*

	public function download_company_profile()
	{
		$this->load->helper('download');
		force_download('./*******_pdf/2021_Company_Profile_v2.pdf', NULL);
	}
	public function download_internship_program()
	{
		$this->load->helper('download');
		force_download('./*******_pdf/Internship_Program_2021.pdf', NULL);
	}
	public function download_agreement()
	{
		$this->load->helper('download');
		force_download('./*******_pdf/1002_Non_Disclosure_Agreement.pdf', NULL);
	}
*/

	//NEW FUNCTION INTERN CRUD UPDATING INFORMATION
	public function update_intr_info()
	{
		$intr_db_id = $this->input->post('intr_db_id');
		$intr_last_name = $this->input->post('intr_last_name');
		$intr_frst_name = $this->input->post('intr_frst_name');
		$intr_mddl_name = $this->input->post('intr_mddl_name');
		$intr_emai_addr = $this->input->post('intr_emai_addr');
		$intr_curr_addr = $this->input->post('intr_curr_addr');
		$intr_cntc_nmbr = $this->input->post('intr_cntc_nmbr');
		$intr_brth_date = $this->input->post('intr_brth_date');

		$this->internview_mod->UPDATE_EMAIL($intr_last_name,$intr_frst_name,$intr_mddl_name,$intr_emai_addr,$intr_curr_addr,$intr_cntc_nmbr,$intr_brth_date,$intr_db_id);
		redirect('profile/' . $intr_db_id);
	}

	// ============================================================ EDIT IMAGE ====================================================================
    function edit_image(){
		$get_image_name = $_FILES['update_image']['name'];
        $userID = $this->input->post('intr_updt_img');
     
        $config['upload_path'] = './intern_photo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '5000';
        $config['file_name'] = $userID.$get_image_name;
        $config['overwrite'] = 'TRUE';

        $this->load->library('upload', $config);

        if($_FILES['update_image']['size'] != 0){
            if ($this->upload->do_upload('update_image'))
            {
                $data_upload = array('update_image' => $this->upload->data());
                $user_img = $data_upload['update_image']['file_name'];

                $this->internview_mod->update_intr_image($user_img, $userID);
				$this->session->set_userdata('SESS_SUCC_IMAGE', 'Image uploaded!');
				redirect('profile/' . $userID);
            }
        } else {
			$this->session->set_userdata('SESS_ERR_IMAGE', 'No image selected!');
			redirect('profile/' . $userID);

        }
	}
	 // -------------------------------------------------------------------------------------[ UPDATE WAIVER ]
	function update_intern_waiver(){

        $userID = $this->input->post('intr_updt_fil_id');
        $intern_name = $this->input->post('intr_updt_fil_name');

        $config['upload_path'] = './intern_requirements/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '5000';
        $config['overwrite'] = TRUE;
		$_FILES['update_waiver_attachment']['name'] =  $userID . '_'.$intern_name . '_WAIVER.pdf';
        $_FILES['update_resume_attachment']['name'] =  $userID .  '_'.$intern_name . '_RESUME.pdf';
		$_FILES['update_endorsement_attachment']['name'] =  $userID . '_'.$intern_name . '_ENDORSEMENT.pdf';
        $_FILES['update_agreement_attachment']['name'] =  $userID .  '_'.$intern_name . '_AGREEMENT.pdf';

		$waiver_name = $_FILES['update_waiver_attachment']['name'];
		$resume_name = $_FILES['update_resume_attachment']['name'];
		$agreement_name = $_FILES['update_agreement_attachment']['name'];
		$endorsement_name = $_FILES['update_endorsement_attachment']['name'];


		$this->load->library('upload', $config);
		$this->upload->do_upload('update_waiver_attachment');
		$this->upload->do_upload('update_resume_attachment');
		$this->upload->do_upload('update_endorsement_attachment');
		$this->upload->do_upload('update_agreement_attachment');
		$this->internview_mod->update_intr_waiver($waiver_name, $userID);
		$this->internview_mod->update_intr_resume($resume_name, $userID);
		$this->internview_mod->update_intr_agreement($agreement_name, $userID);
		$this->internview_mod->update_intr_recommendation($endorsement_name, $userID);

		redirect('profile/' . $userID);
	}
	// ====================================================[ INTERN FILE UPLOAD ]====================================================
	function update_intern_requirm(){

      

        $userID = $this->input->post('intr_updt_fil_id');
   
		$checkStatus = $this->internview_mod->GET_INFO($userID);
		$intern_name = $checkStatus['lastname'] . '_' . $checkStatus['firstname'];
		str_replace(' ', '_', $intern_name);

        $config['upload_path'] = './intern_requirements/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = '5000';
        $config['overwrite'] = TRUE;
		$_FILES['waiver_attachment']['name'] = $userID . '_'.$intern_name . '_WAIVER.pdf';
        $_FILES['resume_attachment']['name'] = $userID .  '_'.$intern_name . '_RESUME.pdf';
		$_FILES['endorsement_attachment']['name'] = $userID . '_'.$intern_name . '_ENDORSEMENT.pdf';
        $_FILES['agreement_attachment']['name'] = $userID . '_'.$intern_name . '_AGREEMENT.pdf';

		$waiver_name = $_FILES['waiver_attachment']['name'];
		$resume_name = $_FILES['resume_attachment']['name'];
		$endorsement_name = $_FILES['endorsement_attachment']['name'];
		$agreement_name = $_FILES['agreement_attachment']['name'];

		$this->load->library('upload', $config);
		$this->upload->do_upload('waiver_attachment');
		$this->upload->do_upload('resume_attachment');
		$this->upload->do_upload('endorsement_attachment');
		$this->upload->do_upload('agreement_attachment');
		$this->internview_mod->update_intr_waiver($waiver_name, $userID);
		$this->internview_mod->update_intr_resume($resume_name, $userID);
		$this->internview_mod->update_intr_agreement($agreement_name, $userID);
		$this->internview_mod->update_intr_recommendation($endorsement_name, $userID);

		$this->internview_mod->update_intr_stepstat($userID, 1, 'PENDING');
	}

	//Intern Submit Concern
	public function concern($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		} else {
			if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
				redirect('intern/' . $id);
			}
			if ($checkStatus['account_type'] == 'ADMIN') {
				redirect('admin/dashboard/' . $id);
			} else {
				$login_id = $this->session->userdata('USER_ID');
				if ($id == $login_id) {
					$info = [
						'title' => '******* | Profile',
						'user_id' => $this->session->userdata('USER_ID'),
						'page' => 'Concerns',
						'USER_DATA' => $this->internview_mod->GET_INFO($id),
					];
					$this->load->view('layout/header', $info);
					$this->load->view('intern_view/concern', $info);
					$this->load->view('layout/footer');
				}
			}
		}
	}

	//SUBMIT CONCERN
	public function sub_concern()
	{
		$id = $this->input->post('INF_USER_ID_INTR');
		$email = $this->input->post('INF_USER_EMAIL_INTR');
		$title = $this->input->post('conTitle');
		$concern = $this->input->post('concern');
		$dt = date("Y-M-d h:m:s a");
		$dat = date("Y-M-d");
		$name = $this->input->post('INF_USER_NAME');
		

		$config['upload_path'] = './intern_concerns_attachments/';
        $config['allowed_types'] = 'pdf|gif|jpg|png';
        $config['max_size'] = '5000';
	

		$fileExtension = strrchr($_FILES['concern_attach']['name'], '.');
		$_FILES['concern_attach']['name'] = $id.'_'.$title.'_'.$dat.$fileExtension;
		$concern_attach = $_FILES['concern_attach']['name'];
		$this->load->library('upload', $config);
		$this->upload->do_upload('concern_attach');
		$this->internview_mod->SUB_CONCERN($id,$email,$title,$concern,$dt,$name,$concern_attach);
	}

	

	//REPLY CONCERN
	public function reply_concern()
	{
		$id = $this->input->post('INF_USER_ID_INTR');
		$email = $this->input->post('INF_USER_EMAIL_INTR');
		$name = $this->input->post('INF_USER_NAME');
		$title = $this->input->post('replyTitle');
		$replyid = $this->input->post('replyId');
		$reply = $this->input->post('userReply');
		$ccount = $this->input->post('concernCount');
		$ccount += 1;
		$dt = date("Y-M-d h:m:s a");
		$dat = date("Y-M-d");

		$config['upload_path'] = './intern_concerns_attachments/';
        $config['allowed_types'] = 'pdf|gif|jpg|png';
        $config['max_size'] = '5000';
		$fileExtension = strrchr($_FILES['reply_attach']['name'], '.');
		$_FILES['reply_attach']['name'] = $id.'_'.$title.'_'.$replyid.'_'.$ccount.$fileExtension;
		$concern_attach = $_FILES['reply_attach']['name'];
		$this->load->library('upload', $config);
		$this->upload->do_upload('reply_attach');

		$this->internview_mod->REPLY_CONCERN($id,$email,$name,$title,$replyid,$reply,$dt,$concern_attach,$ccount);
	}

	public function show_concerns($id)
	{
		if ($this->input->is_ajax_request()) {
			$getConcerns = $this->internview_mod->GET_CONCERNS($id);
			echo json_encode($getConcerns);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function show_messages($id)
	{
		if ($this->input->is_ajax_request()) {
			$getMessages = $this->internview_mod->GET_MESSAGES($id);
			echo json_encode($getMessages);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function show_init_message($id)
	{
		if ($this->input->is_ajax_request()) {
			$getInitMessagesAdm = $this->internview_mod->GET_INIT_MESSAGE($id);
			echo json_encode($getInitMessagesAdm);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	
	public function report($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] == 'ADVISER') {
			redirect('adviser/' . $id);
		} else {
			if ($checkStatus['status'] == 'PENDING' || $checkStatus['status'] == NULL) {
				redirect('intern/' . $id);
			}
			if ($checkStatus['account_type'] == 'ADMIN') {
				redirect('admin/dashboard/' . $id);
			} else {
				$login_id = $this->session->userdata('USER_ID');
				if ($id == $login_id) {
					$info = [
						'title' => '******* | Report',
						'user_id' => $this->session->userdata('USER_ID'),
						'page' => 'Daily Attendance Report',
						'USER_DATA' => $this->internview_mod->GET_INFO($id),
						'USER_DEPARTMENT_DATA' => $this->internview_mod->GET_DEPARTMENT_INFO($id),
					];
					$this->load->view('layout/header', $info);
					$this->load->view('intern_view/report', $info);
					$this->load->view('layout/footer');
				}
			}
		}
	}

	public function upload_report()
	{
		if ($this->input->is_ajax_request()) {
			$intern_id = $this->input->post('intern_id');
			$intern_name = $this->input->post('intern_name');
			$DailyReport = $this->input->post('daily_report');
			$status = $this->input->post('status');

			$config['upload_path'] = './intern_report/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = '5000';
			$config['overwrite'] = TRUE;

			$this->load->library('upload', $config);

			$getReturn = $this->internview_mod->GET_UPLOAD_REPORT($intern_id);
			if (!$getReturn) {//INSERT
				if($this->upload->do_upload('daily_report')){
					$DailyReportName = $_FILES['daily_report']['name'];
					$DatePass = date('D, M d Y');
					$TimePass = date('h:i A');
					$this->upload->do_upload('daily_report');
					$this->internview_mod->UPLOAD_REPORT($intern_id,$intern_name,$DatePass,$TimePass,$DailyReportName,$status);
					
				}else{
					$error = 'Someting Went Wrong!';
					echo json_encode($error);
				}
			} else {//UPDATE
				$DailyReportName = $_FILES['daily_report']['name'];
				$DatePass = date('D, M d Y');
				$TimePass = date('h:i A');
				$this->upload->do_upload('daily_report');
				$this->internview_mod->UPDATE_UPLOAD_REPORT($intern_id,$DatePass,$TimePass,$DailyReportName,$status);
				
			}
			
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_report($id)
	{
		
			$getReport = $this->internview_mod->DISPLAY_UPLOADED_REPORT($id);
			
			echo json_encode($getReport);
		
	}


}

