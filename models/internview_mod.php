<?php

class internview_mod extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    function GET_INFO($id)
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row();

        if ($row == NULL) {
            return 0;
        } else {
            $data = [
                'id' => $row->id,
                'account_created' => $row->col_acnt_crea,
                'account_type' => $row->col_user_type,
                'email_verified' => $row->col_emai_veri,
                'user' => $row->col_emai_addr,
                'pass' => $row->col_user_pass,
                'lastname' => $row->col_last_name,
                'firstname' => $row->col_frst_name,
                'middlename' => $row->col_midl_name,
                
                'name' => $row->col_last_name.', '.$row->col_frst_name,

                'address' => $row->col_curr_addr,
                'contact' => $row->col_cell_numb,
                'birthday' => $row->col_birt_date,
                'gender' => $row->col_intr_gndr,
                'skill_set' => $row->col_intr_skil,
                'photo' => $row->col_imag_name,
                'photo_dir' => $row->col_imag_path,
                'school_name' => $row->col_scho_name,
                'school_contact' => $row->col_schl_cont,
                'adviser_name' => $row->col_advs_name,
                'adviser_contact' => $row->col_advs_cont,
                'course' => $row->col_intr_cour,
                'hours' => $row->col_totl_hour,
                'schedule' => $row->col_sche_day,
                'work_hour' => $row->col_work_hour,
                'step' => $row->col_step_prog,

                'int_satus' => $row->col_inte_stat,
                'status' => $row->col_user_stat,

                'date_hired' => $row->col_star_date,
                'waiver' => $row->col_reqm_waiv,
                'resume' => $row->col_reqm_resm,
                'endorsement' => $row->col_reqm_endo,
                'agreement' => $row->col_reqm_agre,
                'essay_answer' => $row->col_esay_ansr,
                'date_submitted' => $row->col_date_sbmt,
                'interview_schedule' => $row->col_date_inte,
                'presentation_schedule' => $row->col_date_pres,
                'interviewer_name' => $row->col_inte_name,
                'comment' => $row->col_reje_reas,
                'req_count' => $row->col_req_count,
            ];
        }
        return $data;
    }

    function GET_DEPARTMENT_INFO($id) {
        $sql = "SELECT * FROM tbl_dept_member WHERE col_mem_id = ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row();

        if ($row == NULL) {
            return 0;
        } else {
            $data = [
				'id'      	 => $row->id,
				'inte_id'    => $row->col_mem_id,
				'dept_id' 	 => $row->col_dept_id,
				'department' => $row->col_mem_dept,
				'position' 	 => $row->col_mem_posi,
				'name'       => $row->col_mem_name,
				'project'    => $row->col_mem_project,
				'task'       => $row->col_mem_task,
				'status'     => $row->col_mem_status,
				'hours'      => $row->col_mem_hrs
            ];
        }
        return $data;
    }

    function GET_DEPARTMENT_DETAILS() {
        $sql = "SELECT * FROM tbl_dept_member";
        $query = $this->db->query($sql);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }
    
    function GET_USER_DATA() {
        $sql = "SELECT * FROM tbl_user_acct_list as a
        INNER JOIN tbl_dept_member as b
        ON a.id = b.col_mem_id
        WHERE (a.col_user_stat = ? AND a.col_step_prog = ?) AND a.col_user_type= ?";
        $query = $this->db->query($sql, array('ACCEPTED', 3, 'INTERN'));
        if (count($query->result()) > 0) {
        return $query->result();
        }
    }

    function CHECK_COUNT($id)
    {
        $sql = "SELECT col_req_count FROM tbl_user_request WHERE id=?";
        $query = $this->db->query($sql, $id);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function REQ_SCHEDULE($id, $schedule, $work_hour, $req_comment, $email)
    {
        $sql = "INSERT INTO tbl_user_request (col_intr_id, col_req_sched, col_req_wrk_hr,col_req_date, col_req_comment, col_req_stat, col_intr_email) VALUES (?,?,?,?,?,?,?)";
        $this->db->query($sql, array($id, $schedule, $work_hour, date('Y-m-d'), $req_comment, 'PENDING', $email));
    }

    function REQ_COUNT($id)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_req_count=? WHERE id=?";
        $this->db->query($sql, array('1', $id));
    }
    

    function UPDATE_PERSONAL_INFO($id, $last, $first, $middle, $address, $email, $contact, $birthday, $gender, $skill, $img)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_frst_name=?, col_midl_name=?, col_last_name=?,
                                              col_curr_addr=?, col_cell_numb=?, col_birt_date=?,
                                              col_intr_gndr=?, col_intr_skil=?, col_imag_name=? WHERE id=?";
        $this->db->query($sql, array($first, $middle, $last, $address, $contact, $birthday, $gender, $skill, $img, $id));
    }

    function UPDATE_INTERNSHIP_DETAILS($id, $schl_name, $schl_cont, $advs_name, $advs_cont, $intn_cour, $intn_hour)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_scho_name=?, col_schl_cont=?, col_advs_name=?,
                                              col_advs_cont=?, col_intr_cour=?, col_totl_hour=? WHERE id=?";
        $this->db->query($sql, array($schl_name, $schl_cont, $advs_name, $advs_cont, $intn_cour, $intn_hour, $id));
    }

    function UPDATE_SCHEDULE($id, $schedule, $work_hour)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_sche_day=?, col_work_hour=? WHERE id=?";
        $this->db->query($sql, array($schedule, $work_hour, $id));
    }

    function UPDATE_REQUIREMENTS($id, $waiver)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_reqm_waiv=? WHERE id=?";
        $this->db->query($sql, array($waiver, $id));
    }

    // -------------------------------------------------------------------------------------[ INTERN UPLOAD FILE ]
    function UPDATE_FILENAME($id, $waiver, $resume, $recommendation, $agreement, $step, $status)
    {
        if ($waiver == 'Choose file') {
            $waiver = 'EMPTY';
        }
        if ($resume == 'Choose file') {
            $resume = 'EMPTY';
        }
        if ($recommendation == 'Choose file') {
            $recommendation = 'EMPTY';
        }
        if ($agreement == 'Choose file') {
            $agreement = 'EMPTY';
        }

        $sql = "UPDATE tbl_user_acct_list SET col_reqm_waiv=?, col_reqm_resm=?, col_reqm_endo=?, col_reqm_agre=?, col_date_sbmt= NOW(), col_step_prog=? , col_user_stat=? WHERE id=?";
        $this->db->query($sql, array($waiver, $resume, $recommendation, $agreement, $step, $status, $id));
    }

    function  UPDATE_ESSAY($id, $essay)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_esay_ansr=? WHERE id=?";
        $this->db->query($sql, array($essay, $id));
    }

    function DISPLAY_INFO()
    {
        $sql = "UPDATE tbl_user_acct_list SET `name`=? WHERE id=?";
        $this->db->query($sql, array());
    }


    function GET_ATTENDANCE($id)
    {
        $sql = "SELECT * FROM tbl_user_attn_list WHERE col_intr_id = ? ORDER BY id DESC";
        $query = $this->db->query($sql, array($id));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_CURR_DATE($id)
    {
        $sql = "SELECT id, col_time_out, col_time_in FROM tbl_user_attn_list WHERE col_intr_id = ? AND col_date_crea=? ORDER BY id DESC LIMIT 1;";
        $query = $this->db->query($sql, array($id,date('Y-m-d')));
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }

    function GET_ATTENDANCE_LAST($id)
    {
        $sql = "SELECT `id` FROM tbl_user_attn_list WHERE col_intr_id = ? ORDER BY id DESC LIMIT 1;";
        $query = $this->db->query($sql, array($id));
        $row = $query->row();
        return $row->id;
    }

    function UPDATE_ATTENDANCE($attendID, $time)
    {
        $sql = "UPDATE tbl_user_attn_list SET col_time_out=? WHERE id=?";
        $this->db->query($sql, array($time, $attendID));
    }

    function INSERT_ATTENDANCE($id, $name, $date, $time)
    {
        $sql = "INSERT INTO tbl_user_attn_list (col_intr_id, col_intr_name, col_attn_date, col_time_in,col_date_crea) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($id, $name, $date, $time,date('Y-m-d')));
    }

    function UPDATE_EMAIL($intr_last_name,$intr_frst_name,$intr_mddl_name,$intr_emai_addr,$intr_curr_addr,$intr_cntc_nmbr,$intr_brth_date,$id)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_last_name=?, col_frst_name=?, col_midl_name=?, col_emai_addr=?, col_curr_addr=?, col_cell_numb=?, col_birt_date=? WHERE id=?";
        $this->db->query($sql, array($intr_last_name,$intr_frst_name,$intr_mddl_name,$intr_emai_addr,$intr_curr_addr,$intr_cntc_nmbr,$intr_brth_date,$id));
    }

    function update_intr_image($filename,$id){
        $sql = "UPDATE tbl_user_acct_list SET col_imag_name=? WHERE id=?";
        $this->db->query($sql, array($filename, $id));
    }
    // -------------------------------------------------------------------------------------[ UPDATE WAIVER ]
    function update_intr_waiver($filename,$id){
        $sql = "UPDATE tbl_user_acct_list SET col_reqm_waiv=? WHERE id=?";
        $this->db->query($sql, array($filename, $id));
    }
    // -------------------------------------------------------------------------------------[ UPDATE RESUME ]
    function update_intr_resume($filename,$id){
        $sql = "UPDATE tbl_user_acct_list SET col_reqm_resm=? WHERE id=?";
        $this->db->query($sql, array($filename, $id));
    }
    // -------------------------------------------------------------------------------------[ UPDATE RECOMMENDATION ]
    function update_intr_recommendation($filename,$id){
        $sql = "UPDATE tbl_user_acct_list SET col_reqm_endo=? WHERE id=?";
        $this->db->query($sql, array($filename, $id));
    }
    // -------------------------------------------------------------------------------------[ UPDATE AGREEMENT ]
    function update_intr_agreement($filename,$id){
        $sql = "UPDATE tbl_user_acct_list SET col_reqm_agre=? WHERE id=?";
        $this->db->query($sql, array($filename, $id));
    }
    function update_intr_stepstat($id, $step, $status)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_date_sbmt= NOW(), col_step_prog=? , col_user_stat=? WHERE id=?";
        $this->db->query($sql, array($step, $status, $id));
    }

    //SUBMIT CONCERN
    function SUB_CONCERN($id,$email,$title,$concern,$dt,$name,$attch)
    {
        $sql = "INSERT INTO tbl_concerns (col_intr_id, col_intr_email, col_con_title, col_con_txt,col_con_date, col_con_stat, col_con_name, col_con_attach, col_con_create) VALUES (?,?,?,?,?,?,?,?,NOW())";
        $query = $this->db->query($sql, array($id, $email, $title, $concern, $dt, 'ACTIVE', $name, $attch));
    }

    //REPLY CONCERN
    function REPLY_CONCERN($id,$email,$name,$title,$replyId,$reply,$dt,$attch,$ccount)
    {
        $sql = "INSERT INTO tbl_concern_convo (col_intr_id, col_convo_email, col_intr_name, col_convo_title, col_convo_mess, col_concern_id, col_convo_date, col_convo_status, col_convo_attach) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($id, $email, $name, $title, $reply, $replyId, $dt, '2', $attch));
        $sql1 = "UPDATE tbl_concerns SET col_con_convo = ?,col_con_reply = ?, col_con_attach_count = ? WHERE id = ?";
        $this->db->query($sql1, array('3','0', $ccount, $replyId));
    }

    //GET CONCERNS
   function GET_CONCERNS($id)
   {
       $sql = "SELECT * FROM tbl_concerns WHERE col_intr_id = ?";
       $query = $this->db->query($sql, array($id));

       if (count($query->result()) > 0) {
           return $query->result();
       }
        //   return $id;
   }


    //GET MESSAGES
    function GET_MESSAGES($id)
    {
        $sql = "SELECT * FROM tbl_concern_convo WHERE col_concern_id = ?";
        $query = $this->db->query($sql, array($id));
 
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

     //GET INITIAL MESSAGE
     function GET_INIT_MESSAGE($id)
     {
       $sql = "SELECT * FROM tbl_concerns WHERE id = ?";
       $query = $this->db->query($sql, array($id));
         if (count($query->result()) > 0) {
             return $query->result();
         }
     }

    // DAILY REPORT ATTENDANCE
    function GET_UPLOAD_REPORT($intern_id)
    {
        $sql = "SELECT * FROM `tbl_dar_list` WHERE `col_dar_crea` = ? AND `col_intr_id` = ?";
        $query = $this->db->query($sql, array(date("D, M d Y"),$intern_id));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function DISPLAY_UPLOADED_REPORT($intern_id)
    {
        $sql = "SELECT * FROM `tbl_dar_list` WHERE `col_intr_id` = ?";
        $query = $this->db->query($sql, array($intern_id));
        return $query->result();
    }

    function UPLOAD_REPORT($intern_id,$intern_name,$DatePass,$TimePass,$DailyReportName,$status)
    {
        $sql = "INSERT INTO tbl_dar_list (col_dar_crea, col_intr_id, col_intr_name, col_file_name,	col_time_pass, col_dar_stat) VALUE (?,?,?,?,?,?)";
        $this->db->query($sql, array($DatePass,$intern_id,$intern_name,$DailyReportName,$TimePass,$status));
    }

    function UPDATE_UPLOAD_REPORT($intern_id,$DatePass,$TimePass,$DailyReportName,$status)
    {
        $sql = "UPDATE tbl_dar_list SET col_dar_crea = ?, col_file_name = ?, col_time_pass = ?, col_dar_stat = ? WHERE col_dar_crea = ? AND col_intr_id = ?";
        $this->db->query($sql, array($DatePass,$DailyReportName,$TimePass,$status,$DatePass,$intern_id));
    }


    function GET_OVERTIME($id)
    {
        $sql = "SELECT * FROM `tbl_otim_req_list` WHERE `col_ot_date` = ? AND `col_intr_id` = ?";
        $query = $this->db->query($sql, array(date("D, M d Y"),$id));
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }

    function OVERTIME_TIME_IN_OUT($id)
    {
        $sql = "SELECT * FROM `tbl_otim_req_list` WHERE `col_intr_id` = ? AND `col_ot_date` = ?";
        $query = $this->db->query($sql, array($id, date("D, M d Y")));
        return $query->result();
    }

    function DISPLAY_OVERTIME($id)
    {
        $sql = "SELECT * FROM `tbl_otim_req_list` WHERE `col_intr_id` = ? ORDER BY id DESC";
        $query = $this->db->query($sql, array($id));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function INTSERT_REQUEST_OVERTIME($name, $id, $dept, $proj, $stat, $date, $reas, $file)
    {
        $sql = "INSERT INTO tbl_otim_req_list (col_intr_name, col_intr_id, col_intr_dept, col_intr_proj, col_ot_stat, col_ot_date, col_ot_rea, col_ot_file, col_ot_crea) VALUE (?,?,?,?,?,?,?,?,NOW())";
        $this->db->query($sql, array($name, $id, $dept, $proj, $stat, $date, $reas, $file));
    }

    function UPDATE_REQUEST_OVERTIME($name, $id, $dept, $proj, $stat, $date, $reas, $file)
    {
        $sql = "UPDATE tbl_otim_req_list SET col_ot_rea = ?, col_ot_file = ? WHERE col_ot_date = ? AND col_intr_id = ?";
        $this->db->query($sql, array($reas, $file, $date, $id));
    }

    function UPDATE_REQUEST_OVERTIME_TIME_IN($id, $timeIn)
    {
        $sql = "UPDATE tbl_otim_req_list SET col_ot_tin = ? WHERE col_intr_id = ? AND col_ot_date = ?";
        $this->db->query($sql, array($timeIn, $id, date("D, M d Y")));
    }

    function UPDATE_REQUEST_OVERTIME_TIME_OUT($id, $timeOut)
    {
        $sql = "UPDATE tbl_otim_req_list SET col_ot_tout = ? WHERE col_intr_id = ? AND col_ot_date = ?";
        $this->db->query($sql, array($timeOut, $id, date("D, M d Y")));
    }
    
    //SUBMIT REQUEST EVAL
    function SUBMIT_EVAL($id,$email,$name,$fileExtension,$dt)
    {
        $sql = "INSERT INTO tbl_user_requestdocu (col_intr_id, col_intr_name, col_intr_email, col_req_fileName, col_req_stat, col_req_date) VALUES (?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($id, $email,$name, $fileExtension, 'PENDING', $dt));
    }








}
