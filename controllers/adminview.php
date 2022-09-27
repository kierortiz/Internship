<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Adminview extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('internview_mod');
		$this->load->model('adminview_mod');
		$this->load->library('session');
		$this->load->helper('form');
		if ($this->session->userdata('USER_ID') == '') {
			redirect('login');
		}
	}

	public function index()
	{
		$data = ['title' => '******** | Admin'];
		$this->load->view('intern_view/home', $data);
	}

	public function accepted_interns($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Accepted Interns',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'Filter_Department' => $this->adminview_mod->FILTER_ACCEPTED_INTERN_DEPARTMENTS(),
				];
					$this->load->view('admin_view/header',$info);
					$this->load->view('admin_view/accepted_interns',$info);
					
			}
		}
	}
	public function requests_list($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Change Schedule',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];
					$this->load->view('admin_view/header',$info);
					$this->load->view('admin_view/requests',$info);
					$this->load->view('admin_view/footer');
			}
		}
	}

	//DISPLAY REQUESTS
	public function display_requests()
	{
		if ($this->input->is_ajax_request()) {
			$getRequests = $this->adminview_mod->GET_REQUESTS();
			echo json_encode($getRequests);
		} else {
			echo "'No direct script access allowed'";
		}
		
	}

	//ACCEPTED REQUESTS
	public function display_acpt_requests()
	{
		if ($this->input->is_ajax_request()) {
			$getAcptRequests = $this->adminview_mod->GET_ACPT_REQUESTS();
			echo json_encode($getAcptRequests);
		} else {
			echo "'No direct script access allowed'";
		}
		
	}

	//DENIED REQUESTS
	public function display_denied_requests()
	{
		if ($this->input->is_ajax_request()) {
			$getDeniedRequests = $this->adminview_mod->GET_DENIED_REQUESTS();
			echo json_encode($getDeniedRequests);
		} else {
			echo "'No direct script access allowed'";
		}
		
	}

			
	//VIEW REQUEST FROM (VIEW)
	public function view_intr_request()
	{
		if ($this->input->is_ajax_request()) {
			$viewId = $this->input->post('viewId');
			if ($viewReq = $this->adminview_mod->VIEW_INTERN_REQUEST($viewId)) {
				$viewRequest = array('view' => $viewReq);
				echo json_encode($viewRequest);
			} else {
				echo "'No direct script access allowed'";
			}
		}
	}

	//APPROVE FUNCTION
	public function update_schedule_request()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$sched = $this->input->post('sched');
			$hours = $this->input->post('hours');
			$updated = $this->adminview_mod->UPDATE_INTERN_REQUEST($sched,$id,$hours);
		}
	}

	//DENY FUNCTION
	public function deny_schedule_request()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$denied = $this->adminview_mod->DENY_INTERN_REQUEST($id);
		}
	}
	
	public function total_reporting()
	{
	   
		if ($this->input->is_ajax_request()) {
			$getTotalReporting =  $this->adminview_mod->GET_TOTAL_REPORTING();
			$displayTotalReporting = array('total_reporting' => $getTotalReporting
			);
			
			echo json_encode($displayTotalReporting);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function total_onshift()
	{
	   
		if ($this->input->is_ajax_request()) {
			$getTotalOnshift =  $this->adminview_mod->GET_TOTAL_ONSHIFT();
			$displayTotalOnshift = array('total_onshift' => $getTotalOnshift
			);
			
			echo json_encode($displayTotalOnshift);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function total_finshift()
	{
	   
		if ($this->input->is_ajax_request()) {
			$getTotalFinshift =  $this->adminview_mod->GET_TOTAL_FINSHIFT();
			$displayTotalFinshift = array('total_finshift' => $getTotalFinshift
			);
			
			echo json_encode($displayTotalFinshift);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	////////////////////////////////

	//REPORTING INTERN
	public function display_reporting_intern()
	{
		if ($this->input->is_ajax_request()) {
			$displayReportingIntern = $this->adminview_mod->GET_REPORTING_INTERN();
			echo json_encode($displayReportingIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	//ON SHIFT
	public function display_onshift_intern()
	{
		if ($this->input->is_ajax_request()) {
			$displayOnshiftIntern = $this->adminview_mod->GET_ONSHIFT_INTERN();
			echo json_encode($displayOnshiftIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	//FINISHED SHIFT
	public function display_finshift_intern()
	{
		if ($this->input->is_ajax_request()) {
			$displayFinshiftIntern = $this->adminview_mod->GET_FINSHIFT_INTERN();
			echo json_encode($displayFinshiftIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function view_intern()
	{
		if ($this->input->is_ajax_request()) {
			$viewId = $this->input->post('viewId');
			if ($getView = $this->adminview_mod->VIEW_INTERN($viewId)) {
				$viewIntern = array('status' => 'VALID', 'view' => $getView);
			}
			echo json_encode($viewIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function reject_request()
	{
		if ($this->input->is_ajax_request()) {
			$rejectId = $this->input->post('rejectId');
			$rejectBy = $this->input->post('rejectBy');
			$rejectReason = $this->input->post('rejectReason');
			if ($getReject = $this->adminview_mod->REJECT_REQUEST($rejectId, $rejectBy, $rejectReason)) {
				$rejectRequest = array('status' => 'VALID', 'request' => $getReject);
			} else {
				$rejectRequest = array('status' => 'INVALID');
			}
			echo json_encode($rejectRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function limit_request()
	{
		if ($this->input->is_ajax_request()) {
			$limitId = $this->input->post('limitId');
			$limitBy = $this->input->post('limitBy');
			$limitReason = $this->input->post('limitReason');
			if ($getLimit = $this->adminview_mod->LIMIT_REQUEST($limitId, $limitBy, $limitReason)) {
				$limitRequest = array('status' => 'VALID', 'request' => $getLimit);
			} else {
				$limitRequest = array('status' => 'INVALID');
			}
			echo json_encode($limitRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function accept_request()
	{
		if ($this->input->is_ajax_request()) {
			$acceptId = $this->input->post('acceptId');
			$acceptDateTime = $this->input->post('acceptDateTime');
			$acceptBy = $this->input->post('acceptBy');
			if ($getAccept = $this->adminview_mod->ACCEPT_REQUEST($acceptId, $acceptDateTime, $acceptBy)) {
				$acceptRequest = array('status' => 'VALID', 'request' => $getAccept, 'time' => $acceptDateTime);
			} else {
				$acceptRequest = array('status' => 'INVALID');
			}
			echo json_encode($acceptRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function passed_interview()
	{
		if ($this->input->is_ajax_request()) {
			$interviewedId = $this->input->post('interviewedId');
			if ($getAccept = $this->adminview_mod->PASS_INTERVIEW($interviewedId)) {
				$acceptRequest = array('status' => 'VALID');
			} else {
				$acceptRequest = array('status' => 'INVALID');
			}
			echo json_encode($acceptRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function passed_presentation()
	{
		if ($this->input->is_ajax_request()) {
			$interviewedId = $this->input->post('interviewedId');
			if ($getAccept = $this->adminview_mod->PASS_PRESENTATION($interviewedId)) {
				$acceptRequest = array('status' => 'VALID');
			} else {
				$acceptRequest = array('status' => 'INVALID');
			}
			echo json_encode($acceptRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}
	
	public function passed_onboarding()
	{
		if ($this->input->is_ajax_request()) {
			$interviewedId = $this->input->post('interviewedId');
			if ($getAccept = $this->adminview_mod->PASS_ONBOARDING($interviewedId)) {
				$acceptRequest = array('status' => 'VALID');
			} else {
				$acceptRequest = array('status' => 'INVALID');
			}
			echo json_encode($acceptRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_rejected()
	{
		if ($this->input->is_ajax_request()) {
			$displayRejected = $this->adminview_mod->GET_REJECTED();
			echo json_encode($displayRejected);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_quota_limit()
	{
		if ($this->input->is_ajax_request()) {
			$displayQuotaLimit = $this->adminview_mod->GET_QUOTA_LIMIT();
			echo json_encode($displayQuotaLimit);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_for_interview()
	{
		if ($this->input->is_ajax_request()) {
			$displayForInterview = $this->adminview_mod->GET_FOR_INTERVIEW();
			echo json_encode($displayForInterview);
			
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_pending_request()
	{
		if ($this->input->is_ajax_request()) {
			$displayPendingRequest = $this->adminview_mod->GET_PENDING_REQUEST();
			echo json_encode($displayPendingRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_pending_presentation()
	{
		if ($this->input->is_ajax_request()) {
			$displayPendingPresentation = $this->adminview_mod->GET_PENDING_PRESENTATION();
			echo json_encode($displayPendingPresentation);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_request()
	{
		if ($this->input->is_ajax_request()) {
			$getRequest = $this->adminview_mod->GET_REQUEST();
			$displayRequest = array('status' => 'VALID', 'request' => $getRequest);

			echo json_encode($displayRequest);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function recruitment($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Recruitment',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];

				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/recruitment', $info);
				
			}
		}
	}

	
	public function presentation($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Presentation',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];

				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/presentation', $info);
				$this->load->view('admin_view/footer');
				
			}
		}
	}

	public function interview($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Interview',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];

				
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/interview', $info);
				$this->load->view('admin_view/footer');
				
			}
		}
	}

	public function settings($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN') {
			redirect('admin/recruitment/' + $id);
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Settings',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/settings', $info);
				$this->load->view('admin_view/footer');
			
			}
		}
	}


	public function create_account()
	{
		if ($this->input->is_ajax_request()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$accountType = $this->input->post('accountType');
			$lastnName = $this->input->post('lastName');
			$firstName = $this->input->post('firstName');
			if ($getUsername = $this->adminview_mod->GET_USERNAME($username)) {
				$createAccount = array('status' => 'TAKEN', 'message' => 'Username Already Taken.');
			} else {
				$getAccount = $this->adminview_mod->CREATE_ACCOUNT($username, $password, $accountType, $lastnName, $firstName);
				$createAccount = array('status' => 'VALID');
			}
			echo json_encode($createAccount);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function total_recruitment()
	{
		if ($this->input->is_ajax_request()) {
			$getTotalPending =  $this->adminview_mod->GET_TOTAL_PENDING();
			$getTotalAccepted =  $this->adminview_mod->GET_TOTAL_ACCEPTED();
			$getTotalQuotaLimit =  $this->adminview_mod->GET_TOTAL_QUOTALIMITED();
			$getTotalRejected =  $this->adminview_mod->GET_TOTAL_REJECTED();
			$displayTotalRecruitment = array(
				'pending' => $getTotalPending, 'accepted' => $getTotalAccepted,
				'quota_limited' => $getTotalQuotaLimit, 'rejected' => $getTotalRejected
			);

			echo json_encode($displayTotalRecruitment);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function total_presentation()
	{
		if ($this->input->is_ajax_request()) {
			$getTotalPresentation =  $this->adminview_mod->GET_TOTAL_PENDING_PRESENTATION();
			$displayTotalPresentation = array(
				'pending' => $getTotalPresentation
			);

			echo json_encode($displayTotalPresentation);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function total_interview()
	{
		if ($this->input->is_ajax_request()) {
			$getTotalInterview =  $this->adminview_mod->GET_TOTAL_PENDING_INTERVIEW();
			$displayTotalInterview = array(
				'pending' => $getTotalInterview
			);

			echo json_encode($displayTotalInterview);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function total_onboarding()
	{
		if ($this->input->is_ajax_request()) {
			$getTotalHired =  $this->adminview_mod->GET_TOTAL_HIRED();
			$getTotalForInterview =  $this->adminview_mod->GET_TOTAL_FOR_INTERVIEW();
			$getTotalRescheduled =  $this->adminview_mod->GET_TOTAL_RESCHEDULED();
			$getTotalFailed =  $this->adminview_mod->GET_TOTAL_FAILED();
			// TIME IN TIME OUT
			$getTotalTimein = $this->adminview_mod->GET_TIMEDIN_INTR();
			$getTotalTimeout = $this->adminview_mod->GET_TIMEDOUT_INTR();
			$displayTotalOnboarding = array('hired' => $getTotalHired,
			'for_interview' => $getTotalForInterview,
			'rescheduled' => $getTotalRescheduled,
			'failed' => $getTotalFailed,
			'time_in' => $getTotalTimein, 
			'time_out' => $getTotalTimeout,			
		);

			echo json_encode($displayTotalOnboarding);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function onboarding_list($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' AND $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		}
		$login_id = $this->session->userdata('USER_ID');
		if ($id == $login_id) {
			$info = [
				'title' => '******** | Admin',
				'user_id' => $this->session->userdata('USER_ID'),
				'page' => 'Onboarding',
				'USER_DATA' => $this->internview_mod->GET_INFO($id),
			];
			$this->load->view('admin_view/header', $info);
			$this->load->view('admin_view/onboarding', $info);
			$this->load->view('admin_view/footer');
		}
	}

	public function attendance($id)
	{
		//$filter_info = $this->adminview_mod->SELECT_STATUS();
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' AND $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		}
		$login_id = $this->session->userdata('USER_ID');
		if ($id == $login_id) {
			$info = [
				'title' => '******** | Admin',
				'user_id' => $this->session->userdata('USER_ID'),
				'page' => 'Daily Attendance',
				'USER_DATA' => $this->internview_mod->GET_INFO($id),
				'FILTER' => $this->adminview_mod->GET_FILTERED_ATTENDANCE(),
			];
			$this->load->view('admin_view/header', $info);
			$this->load->view('admin_view/attendance', $info);
			// $this->load->view('admin_view/footer');
		}
	}

	public function display_attendance()
	{
		if ($this->input->is_ajax_request()) {
			$getAttendance = $this->adminview_mod->GET_ATTENDANCE();
			$displayAttendance = array('status' => 'VALID', 'request' => $getAttendance);
			echo json_encode($displayAttendance);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_onboarding()
	{
		if ($this->input->is_ajax_request()) {
			$getOnboarding = $this->adminview_mod->GET_ONBOARDING();
			$displayOnboarding = array('status' => 'VALID', 'request' => $getOnboarding);
			echo json_encode($displayOnboarding);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_presentation()
	{
		if ($this->input->is_ajax_request()) {
			$getPresentation = $this->adminview_mod->GET_PRESENTATION();
			$displayPresentation = array('status' => 'VALID', 'request' => $getPresentation);
			echo json_encode($displayPresentation);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_interview()
	{
		if ($this->input->is_ajax_request()) {
			$getInterview = $this->adminview_mod->GET_INTERVIEW();
			$displayInterview = array('status' => 'VALID', 'request' => $getInterview);
			echo json_encode($displayInterview);
		} else {
			echo "'No direct script access allowed'";
		}
	}
	public function hire_intern()
	{
		if ($this->input->is_ajax_request()) {
			$hireId = $this->input->post('hireId');
			if ($getHire = $this->adminview_mod->HIRE_INTERN($hireId)) {
				$hireIntern = array('status' => 'VALID', 'request' => $getHire);
			} else {
				$hireIntern = array('status' => 'INVALID');
			}
			echo json_encode($hireIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function interviewed_intern()
	{
		if ($this->input->is_ajax_request()) {
			$interviewedId = $this->input->post('interviewedId');
			if ($getInterviewed = $this->adminview_mod->INTERVIEWED_INTERN($interviewedId)) {
				$interviewedIntern = array('status' => 'VALID', 'request' => $getInterviewed);
			} else {
				$interviewedIntern = array('status' => 'INVALID');
			}
			echo json_encode($interviewedIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function reschedule_intern()
	{
		if ($this->input->is_ajax_request()) {
			$rescheduleId = $this->input->post('rescheduleId');
			$rescheduleDateTime = $this->input->post('rescheduleDateTime');
			if ($getReschedule = $this->adminview_mod->RESCHEDULE_INTERN($rescheduleId, $rescheduleDateTime)) {
				$rescheduleIntern = array('status' => 'VALID', 'request' => $getReschedule);
			} else {
				$rescheduleIntern = array('status' => 'INVALID');
			}
			echo json_encode($rescheduleIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function failed_intern()
	{
		if ($this->input->is_ajax_request()) {
			$failedId = $this->input->post('failedId');
			if ($getFailed = $this->adminview_mod->FAILED_INTERN($failedId)) {
				$failedIntern = array('status' => 'VALID', 'request' => $getFailed);
			} else {
				$failedIntern = array('status' => 'INVALID');
			}
			echo json_encode($failedIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function details_intern()
	{
		if ($this->input->is_ajax_request()) {
			$detailsId = $this->input->post('detailsId');
			if ($getDetails = $this->adminview_mod->DETAILS_INTERN($detailsId)) {
				$detailsIntern = array('status' => 'VALID', 'details' => $getDetails);
			}
			echo json_encode($detailsIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_failed()
	{
		if ($this->input->is_ajax_request()) {
			$displayFailed = $this->adminview_mod->GET_FAILED();
			echo json_encode($displayFailed);
		} else {
			echo "'No direct script access allowed'";
		}
	}


	public function display_reschedule()
	{
		if ($this->input->is_ajax_request()) {
			$displayReschedule = $this->adminview_mod->GET_RESCHEDULE();
			echo json_encode($displayReschedule);
		} else {
			echo "'No direct script access allowed'";
		}
	}


	public function display_hired_intern()
	{
		if ($this->input->is_ajax_request()) {
			$displayHiredIntern = $this->adminview_mod->GET_HIRED_INTERN();
			$test['count_hired']= $this->adminview_mod->GET_HIRED_INTERN();
			echo json_encode($displayHiredIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_accepted_intern()
	{
		if ($this->input->is_ajax_request()) {
			$displayHiredIntern = $this->adminview_mod->GET_ACCEPTED_INTERN();
		

			echo json_encode($displayHiredIntern);
		} else {
			echo "'No direct script access allowed'";
		}
	}
	
	//NEW FUNCTION ANNOUNCEMENTS =============================================================================
	public function announcements($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Announcements',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/announcements', $info);
				$this->load->view('admin_view/footer');
			}
		}
	}

	public function add_announcements(){
		$announcements_title 	 = $this->input->post('announcements_title');
		$announcements_title = str_replace(' ', '_', $announcements_title);
		if($this->input->post('announcements_link')){
			$announcements_content 	 = $this->input->post('announcements_content').'+'.$this->input->post('announcements_link');
		}else{
			$announcements_content 	 = $this->input->post('announcements_content');
		}

		$config['upload_path'] = './announcements_photo/';
		$config['allowed_types'] = 'jpeg|png|gif|jpg|pdf|csv|ppt|doc|xlsx';
		$config['max_size'] = '5000';
		$config['overwrite'] = TRUE;

		if($this->input->post('announcements_important') || $this->input->post('announcements_important2') || $this->input->post('announcements_important3')){
			if($this->input->post('announcements_important')){
				$announcements_important = $this->input->post('announcements_important');
			}else if($this->input->post('announcements_important2')){
				$announcements_important = $this->input->post('announcements_important2');
			}else if($this->input->post('announcements_important3')){
				$announcements_important = $this->input->post('announcements_important3');
			}
			$imgExtension = strrchr($_FILES['img']['name'], '.');
			$fileExtension = strrchr($_FILES['announcement_attachment']['name'], '.');
			$_FILES['img']['name'] = $announcements_important.$imgExtension;
			$_FILES['announcement_attachment']['name'] = $announcements_important.$fileExtension;

			$announcement_image = $_FILES['img']['name'];
			$announcement_attachment = $_FILES['announcement_attachment']['name'];

			$this->adminview_mod->update_announcements(
				$announcement_image,
				$announcements_title,
				$announcements_content,
				$announcement_attachment,
				$announcements_important
			);
		}else{
			$announcements_important = 'standard_';
			$imgExtension = strrchr($_FILES['img']['name'], '.');
			$fileExtension = strrchr($_FILES['announcement_attachment']['name'], '.');
			$_FILES['img']['name'] = $announcements_important.$announcements_title.$imgExtension;
			$_FILES['announcement_attachment']['name'] = $announcements_important.$announcements_title.$fileExtension;

			$announcement_image = $_FILES['img']['name'];
			$announcement_attachment = $_FILES['announcement_attachment']['name'];

			$this->adminview_mod->add_announcements(
				$announcement_image,
				$announcements_title,
				$announcements_content,
				$announcement_attachment,
				$announcements_important
			);
		}
		$this->load->library('upload', $config);
		$this->upload->do_upload('img');
		$this->upload->do_upload('announcement_attachment');
	}

	public function fetch_important_announcements(){
		if ($this->input->is_ajax_request()) {
			$announcements_list = $this->adminview_mod->fetch_important_announcements();
			foreach($announcements_list->result_array() as $row){
				$displayImportantAnnouncements[] = array(
					'id'      	=> $row['id'],
					'title'   	=> str_replace('_', ' ', $row['col_annc_title']),
					'content' 	=> $row['col_annc_cont'],
					'image' 	=> "announcements_photo/".$row['col_annc_img'],
					'file' 		=> "announcements_photo/".$row['col_annc_attc'],
					'status'    => $row['col_annc_stat'],
					'added'     => $row['col_annc_crea']
				);
			}
			echo json_encode($displayImportantAnnouncements);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function fetch_announcements() {
		if ($this->input->is_ajax_request()) {
			$announcements_list = $this->adminview_mod->fetch_announcements();
			foreach($announcements_list->result_array() as $row){
				$displayAnnouncements[] = array(
					'id'      	=> $row['id'],
					'title'   	=> str_replace('_', ' ', $row['col_annc_title']),
					'content' 	=> $row['col_annc_cont'],
					'image' 	=> "announcements_photo/".$row['col_annc_img'],
					'file' 		=> "announcements_photo/".$row['col_annc_attc'],
					'status'    => $row['col_annc_stat'],
					'added'     => $row['col_annc_crea']
				);
			}
			echo json_encode($displayAnnouncements);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function archived_announcement(){
		$id = $this->input->post('id');
		$this->adminview_mod->archived_announcement($id);
	}

	public function delete_announcement(){
		$id = $this->input->post('id');
		$path = $this->input->post('path');
		$this->adminview_mod->delete_announcement($id);
	}

	public function update_announcement_upload(){
		$id = $this->input->post('update_id');
		$announcements_title_update = str_replace(' ', '_', $this->input->post('announcements_title_update'));
		if($this->input->post('announcements_link_update')){
			$announcements_content_update 	 = $this->input->post('announcements_content_update').'+'.$this->input->post('announcements_link_update');
		}else{
			$announcements_content_update 	 = $this->input->post('announcements_content_update');
		}

		$config['upload_path'] = './announcements_photo/';
		$config['allowed_types'] = 'jpeg|png|gif|jpg|pdf|csv|ppt|doc|xlsx';
		$config['max_size'] = '5000';
		$config['overwrite'] = TRUE;

		$announcements_important = 'standard_';
		$this->load->library('upload', $config);

		if(isset($_FILES['img']['name'])){
			$imgExtension = strrchr($_FILES['img']['name'], '.');
			$_FILES['img']['name'] = $announcements_important.$announcements_title_update.$imgExtension;
			$announcement_image = $_FILES['img']['name'];
			$this->upload->do_upload('img');
			$this->adminview_mod->update_announcement_img($id,$announcement_image);
		}
		if(isset($_FILES['announcement_attachment_update']['name'])){
			$fileExtension = strrchr($_FILES['announcement_attachment_update']['name'], '.');
			$_FILES['announcement_attachment_update']['name'] = $announcements_important.$announcements_title_update.$fileExtension;
			$announcement_attachment_update = $_FILES['announcement_attachment_update']['name'];
			$this->upload->do_upload('announcement_attachment_update');
			$this->adminview_mod->update_announcement_file($id,$announcement_attachment_update);
		}
		$this->adminview_mod->update_announcement_upload($id,$announcements_title_update,$announcements_content_update);
	}

	public function display_archived_announcements(){
		$archived_announcement_list = $this->adminview_mod->display_archived_announcements();
		foreach($archived_announcement_list->result_array() as $row){
			$displayArchivedAnnouncements[] = array(
				'id'      	=> $row['id'],
				'title'   	=> $row['col_annc_title'],
				'content' 	=> $row['col_annc_cont'],
				'image' 	=> "announcements_photo/".$row['col_annc_img'],
				'file' 		=> "announcements_photo/".$row['col_annc_attc'],
				'added'     => $row['col_annc_crea'],
				'status'    => $row['col_annc_stat'],
			);
		}
		echo json_encode($displayArchivedAnnouncements);
	}

	//NEW FUNCTION EVENTS =============================================================================
	public function events($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Events',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/events', $info);
				$this->load->view('admin_view/footer');
			}
		}
	}
	
	public function concluded_events(){
		$event_list = $this->adminview_mod->concluded_events();
		foreach($event_list->result_array() as $row){
			$displayEvents[] = array(
				'id'      	=> $row['id'],
				'title'   	=> $row['col_evnt_title'],
				'content' 	=> $row['col_evnt_cont'],
				'start'		=> $row['col_evnt_start'],
				'end'  	    => $row['col_evnt_end'],
				'time_start'=> $row['col_evnt_time_start'],
				'time_end'  => $row['col_evnt_time_end'],
				'color'     => $row['col_evnt_status'],
				'added'     => $row['col_evnt_add']
			);
		}
		echo json_encode($displayEvents);
	}
	
	public function display_events(){
		$event_list = $this->adminview_mod->fetch_events();
		$lastId = $this->adminview_mod->lastId();
		foreach($event_list->result_array() as $row){
			$displayEvents[] = array(
				'id'      	=> $row['id'],
				'title'   	=> $row['col_evnt_title'],
				'content' 	=> $row['col_evnt_cont'],
				'start'		=> $row['col_evnt_start'],
				'end'  	    => $row['col_evnt_end'],
				'time_start'=> $row['col_evnt_time_start'],
				'time_end'  => $row['col_evnt_time_end'],
				'color'     => $row['col_evnt_status'],
				'added'     => $row['col_evnt_add'],
				'lastId'    => $lastId
			);
		}
		echo json_encode($displayEvents);
	}

	public function render_events(){
		$renerer_event_list = $this->adminview_mod->fetch_eventsRender();
		foreach($renerer_event_list->result_array() as $row){
			if($row['col_evnt_status'] == 'primary'){
				$color = '#007bff';
			}else if($row['col_evnt_status'] == 'warning'){
				$color = '#ffc107';
			}else if($row['col_evnt_status'] == 'success'){
				$color = '#28a745';
			}else if($row['col_evnt_status'] == 'danger'){
				$color = '#dc3545';
			}else if($row['col_evnt_status'] == 'secondary'){
				$color = '#6c757d';
			}else{
				$color = '#007bff';
			}
			$renderEvents[] = array(
				'id'      	=> $row['id'],
				'title'   	=> $row['col_evnt_title'],
				'content' 	=> $row['col_evnt_cont'],
				'start'		=> $row['col_evnt_start'],
				'end'  	    => $row['col_evnt_end'],
				'time_start'=> $row['col_evnt_time_start'],
				'time_end'  => $row['col_evnt_time_end'],
				'color'     => $color,
				'bgcolor'   => $row['col_evnt_status'],
				'added'     => $row['col_evnt_add']
			);
		}
		echo json_encode($renderEvents);
	}

	public function add_event(){
		$event_title = $this->input->post('event_title');
		$event_content = $this->input->post('event_content');
		if($this->input->post('event_status')){
			$event_status = $this->input->post('event_status');
		}else{
			$event_status = "primary";
		}
		$this->adminview_mod->add_event($event_title, $event_content, $event_status);
	}

	public function update_event(){
		$id = $this->input->post('id');
		$event_title = $this->input->post('event_title');
		$event_start = $this->input->post('event_start');
		$event_end = $this->input->post('event_end');
		$this->adminview_mod->update_event($id,$event_title,$event_start,$event_end);
	}

	public function event_update(){
		$id = $this->input->post('update_id');
		$title = $this->input->post('update_title');
		$content = $this->input->post('update_content');
		$this->adminview_mod->event_update($id,$title,$content);
	}

	public function event_delete(){
		$id = $this->input->post('delete_id');
		$this->adminview_mod->event_delete($id);
	}

	//NEW FUNCTION DEPARTMENTS =============================================================================
	public function departments($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Departments',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					// 'USER_DEPARTMENT_DATA' => $this->adminview_mod->user_list(),

				];
				$data = [
					'DEPARTMENT_DATA' => $this->adminview_mod->view_departments(),
					'USER_DEPARTMENT_DATA' => $this->adminview_mod->user_list(),
				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/departments',$data);
				$this->load->view('admin_view/footer');
			}
		}
	}

	public function project_departments($id){
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Department',
					'USER_DATA' => $this->internview_mod->GET_INFO($this->session->userdata('USER_ID')),
				];
				$data = [
					'DEPARTMENT_DATA' => $this->adminview_mod->disp_departments($id),
					'USER_DEPARTMENT_DATA' => $this->adminview_mod->view_projects($id),
					'PROJECT_DATA' => $this->adminview_mod->disp_projects($id),

				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/project_departments', $data);
				$this->load->view('admin_view/footer');
		// 	}
		// }
	}
	
	public function display_projects($id){
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Department Projects',
					'USER_DATA' => $this->internview_mod->GET_INFO($this->session->userdata('USER_ID')),
				];
				$data = [
					'DEPARTMENT_DATA' => $this->adminview_mod->disp_departments($id),
					'USER_DEPARTMENT_DATA' => $this->adminview_mod->view_projects($id),
					'PROJECT_DATA' => $this->adminview_mod->disp_projects($id),
					'DISP_PROJECT_DATA' => $this->adminview_mod->disp_projects_div($id),
			
			
					
				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/disp_project', $data);
				$this->load->view('admin_view/footer');
		// 	}
		// }
	}
	
	public function view_departments(){
		$get_departments = $this->adminview_mod->view_departments();
		foreach($get_departments->result_array() as $row){
			$departments[] = array(
				'id'      		=> $row['id'],
				'department'   	=> $row['col_dept_name'],
				'leader'   	    => $row['col_dept_lead'],
				'member'      	=> $row['col_dept_tmem']
			);
		}
		echo json_encode($departments);
	}
	
	public function user_list(){
		$get_accounts = $this->adminview_mod->user_list();
		foreach($get_accounts->result_array() as $row){
			$acc_list[] = array(
				'id'      	=> $row['id'],
				'last'   	=> $row['col_last_name'],
				'first'   	=> $row['col_frst_name'],
				'middle'   	=> $row['col_midl_name']
			);
		}
		echo json_encode($acc_list);
	}

	public function add_department(){
		$deptName = $this->input->post('department_name');
		$deptLead = $this->input->post('department_leader');
		$this->adminview_mod->add_department($deptName, $deptLead);
	}

	public function add_project(){
		$projName = $this->input->post('project_name');
		$projPm = $this->input->post('project_pm');
		$projDept = $this->input->post('project_dept');
		$this->adminview_mod->add_project($projName, $projPm, $projDept);
	}

	public function add_dept_mem(){
		$deptMemName = $this->input->post('dept_mem_name');
		$deptMemProj = $this->input->post('dept_mem_proj');
		$deptMemDept = $this->input->post('dept_mem_dept');
		$deptPosi = $this->input->post('dept_mem_posi');
		$this->adminview_mod->add_dept_mem($deptMemName, $deptMemProj, $deptMemDept, $deptPosi);
	}

	


	// Student Profile ===========================================================================
	public function student_profile($id)
	{
		$checkStatus = $this->internview_mod->GET_INFO($id);
		$info = [
			'title' => '******** | Profile',
			'user_id' => $id,
			'page' => 'Intern Profile',
			'USER_DATA' => $this->internview_mod->GET_INFO($id),
		];
		$info_admin = [
			'title' => '******** | Profile',
			'user_id' => $id,
			'page' => 'Intern Profile',
			'USER_DATA' => $this->internview_mod->GET_INFO($this->session->userdata('USER_ID')),
		];
		$this->load->view('admin_view/header', $info_admin);
		$this->load->view('admin_view/view_student_profile', $info);
		$this->load->view('admin_view/footer');
	
	}
	//==================NEW FUNCTION
	// Async Function
    function display_status(){
		$status = $this->input->post('col_date_crea');
		$result = $this->adminview_mod->get_select_status($status);
		echo (json_encode($result));

	}

	//INTERN CONCERNS
	public function concerns_list($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Concerns List',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];
					$this->load->view('admin_view/header',$info);
					$this->load->view('admin_view/concerns',$info);
					$this->load->view('admin_view/footer');
			}
		}
	}

	public function list_concerns()
	{
		if ($this->input->is_ajax_request()) {
			$getConcernsAdm = $this->adminview_mod->LIST_CONCERNS();
			echo json_encode($getConcernsAdm);
		} else {
			echo "'No direct script access allowed'";
		}

	}


	

	public function show_init_message($id)
	{
		if ($this->input->is_ajax_request()) {
			$getInitMessagesAdm = $this->adminview_mod->GET_INIT_MESSAGE($id);
			echo json_encode($getInitMessagesAdm);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function show_message($id)
	{
		if ($this->input->is_ajax_request()) {
			$getMessagesAdm = $this->adminview_mod->GET_MESSAGE($id);
			echo json_encode($getMessagesAdm);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	//REPLY TO CONCERN
	public function reply_concern_adm()
	{
		$title = $this->input->post('replyTitle');
		$replyid = $this->input->post('replyId');
		$reply = $this->input->post('userReply');
		$dt = date("Y-M-d h:m:s a");
		$ccount = $this->input->post('concernCount');
		$ccount += 1;

		$config['upload_path'] = './intern_concerns_attachments/';
        $config['allowed_types'] = 'pdf|gif|jpg|png';
        $config['max_size'] = '5000';
		$fileExtension = strrchr($_FILES['reply_attach']['name'], '.');
		$_FILES['reply_attach']['name'] = $title.'_'.$replyid.'_'.$ccount.$fileExtension;
		$concern_attach = $_FILES['reply_attach']['name'];
		$this->load->library('upload', $config);
		$this->upload->do_upload('reply_attach');
		$this->adminview_mod->REPLY_CONCERN_ADM($title,$replyid,$reply,$dt,$concern_attach,$ccount);
	}

	//COMPLETE CONCERN
	public function complete_concern_adm()
	{
		$id = $this->input->post('id');
		$this->adminview_mod->COMPLETE_CONCERN_ADM($id);
	}

	//DELETE CONCERN
	public function delete_concern()
	{
		$id = $this->input->post('id');
		$this->adminview_mod->DELETE_CONCERN($id);
	}

	//GET FILTER DATE
	public function get_filter_date()
	{
		if ($this->input->is_ajax_request()) {
			$getFilterDate = $this->adminview_mod->GET_FILTER_DATE();
			echo json_encode($getFilterDate);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	//POST FILTER DATE
	public function get_date_fil()
	{
		$date = $this->input->post('date');
		$filteredList = $this->adminview_mod->GET_DATE_FIL($date);
		echo json_encode($filteredList);
	}

	//Download Resume
	function download_resume(){
		$intern_resume = $this->input->get('intern_resume');
		if($this->input->is_ajax_request()){
			
			$this->load->helper('download');
			
			$replace = array('.', ' ');
			$strSub = substr(str_replace($replace, '_', $intern_resume), 0, -4);

			force_download('./intern_requirements/' . $intern_resume, NULL);

			$retVal = array('status' => 'VALID');
			echo json_encode($retVal);
		}
		else{
			echo $intern_resume;
		}
		
	}

	

	//DAILY ATTENDANCE REPORT
	public function report($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Intern Daily Attendance Report',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'Filter_Date' => $this->adminview_mod->DISPLAY_UPLOADED_REPORT(),
				];
					$this->load->view('admin_view/header',$info);
					$this->load->view('admin_view/report',$info);
					//$this->load->view('admin_view/footer');
			}
		}
	}

	
	public function display_report()
	{
			$displayReport = $this->adminview_mod->DISPLAY_UPLOADED_REPORT();
			echo json_encode($displayReport);
		
	}


	// OVERTIME ===================================================================
	public function overtime($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Overtime Request',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
					'DATE_FILTER' => $this->adminview_mod->DISPLAY_OVERTIME_RECORDS(),
				];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/overtime', $info);
				
			}
		}
	}

	public function display_overtime(){
		if ($this->input->is_ajax_request()) {
			$displayOvertime = $this->adminview_mod->DISPLAY_OVERTIME();
			echo json_encode($displayOvertime);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function display_overtime_records(){
		if ($this->input->is_ajax_request()) {
			$displayOvertimeRecords = $this->adminview_mod->DISPLAY_OVERTIME_RECORDS();
			echo json_encode($displayOvertimeRecords);
		} else {
			echo "'No direct script access allowed'";
		}
	}

	public function get_overtime_records(){
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('viewId');
			if ($getOvertimeRecords = $this->adminview_mod->GET_OVERTIME_RECORDS($id)) {
				$viewOvertimeRecords = array('show' => $getOvertimeRecords);
				echo json_encode($viewOvertimeRecords);
			} else {
				echo "'No direct script access allowed'";
			}
		}
	}

	public function approve_overtime(){
		$id = $this->input->post('id');
		$this->adminview_mod->APPROVE_OVERTIME($id);
	}

	public function deny_overtime(){
		$id = $this->input->post('id');
		$this->adminview_mod->DENY_OVERTIME($id);
	}
	

	//ALUMNI ===================================================================
	public function display_alumni($id){
		$checkStatus = $this->internview_mod->GET_INFO($id);
		if ($checkStatus['account_type'] !== 'ADMIN' and $checkStatus['account_type'] !== 'HR') {
			redirect('404_override');
		} else {
			$login_id = $this->session->userdata('USER_ID');
			if ($id == $login_id) {
				$info = [
					'title' => '******** | Admin',
					'user_id' => $this->session->userdata('USER_ID'),
					'page' => 'Out-Going Interns',
					'USER_DATA' => $this->internview_mod->GET_INFO($id),
				];
				$result = $this->adminview_mod->GET_ALUMNI();
				$data['alumni'] = $result['rows'];
				$data['dept'] = $result['dept'];
				$this->load->view('admin_view/header', $info);
				$this->load->view('admin_view/alumni', $data);
				$this->load->view('admin_view/footer');
			}
		}
	}

	public function get_alumni(){
		
		$result = $this->adminview_mod->display_alumni();
		foreach($result->result_array() as $row){
			$get_alumni[] = array(
				'id'=>$row['col_mem_id'],
				'name' => $row['col_mem_name'],
			);
		}
		echo json_encode($get_alumni);
	}


}

