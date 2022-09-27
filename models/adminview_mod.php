<?php

class adminview_mod extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    function UPDATE_PERSONAL_INFO($id, $last, $first, $middle, $address, $email, $contact, $birthday, $gender, $skill, $img)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_frst_name=?, col_midl_name=?, col_last_name=?,
                                              col_curr_addr=?, col_cell_numb=?, col_birt_date=?,
                                              col_intr_gndr=?, col_intr_skil=?, col_imag_name=? WHERE id=?";
        $this->db->query($sql, array($first, $middle, $last, $address, $contact, $birthday, $gender, $skill, $img, $id));
    }


    // ================================================== START ONBOARDING ==================================================
   //GET PENDING
   function GET_REQUESTS()
   {
       $sql = "SELECT * FROM tbl_user_request WHERE col_req_stat= ?";
       $query = $this->db->query($sql, 'PENDING');

       if (count($query->result()) > 0) {
           return $query->result();
       }
   }

   //GET ACCEPTED
   function GET_ACPT_REQUESTS()
   {
       $sql = "SELECT * FROM tbl_user_request WHERE col_req_stat= ?";
       $query = $this->db->query($sql, 'APPROVED');

       if (count($query->result()) > 0) {
           return $query->result();
       }
   }

   //GET DENIED
   function GET_DENIED_REQUESTS()
   {
       $sql = "SELECT * FROM tbl_user_request WHERE col_req_stat= ?";
       $query = $this->db->query($sql, 'DENIED');

       if (count($query->result()) > 0) {
           return $query->result();
       }
   }

   //GETTING PENDING REQUESTS
   function VIEW_INTERN_REQUEST($id)
   {
       $this->db->select('*');
       $this->db->from('tbl_user_acct_list');
       $this->db->join('tbl_user_request', 'tbl_user_request.col_intr_id = tbl_user_acct_list.id');
       $this->db->where('tbl_user_acct_list.id =', $id);
       $this->db->where('tbl_user_request.col_intr_id', $id);
       $this->db->where('tbl_user_request.col_req_stat', 'PENDING');
       $query = $this->db->get();
       if ($query->result() > 0) {
           return $query->row();
       }
   }

   //APPROVE
   function UPDATE_INTERN_REQUEST($sched,$id,$hours)
   {
       $sql = "UPDATE tbl_user_acct_list SET col_sche_day = ?, col_req_count = ?, col_work_hour = ? WHERE id = ?";
       $query = $this->db->query($sql, array($sched,'2', $hours, $id));
       $sql2 = "UPDATE tbl_user_request SET col_req_stat = ?, col_req_aprv_date = ? WHERE col_intr_id = ? AND col_req_stat = ?";
       $query2 = $this->db->query($sql2, array('APPROVED', date('Y-m-d'), $id, 'PENDING'));
       return $query;
   }

   //DENY
   function DENY_INTERN_REQUEST($id)
   {
       $sql = "UPDATE tbl_user_acct_list SET col_req_count = ? WHERE id = ?";
       $query = $this->db->query($sql, array('3', $id));
       $sql2 = "UPDATE tbl_user_request SET col_req_stat = ?, col_req_aprv_date = ? WHERE col_intr_id = ? AND col_req_stat = ?";
       $query2 = $this->db->query($sql2, array('DENIED', date('Y-m-d') , $id, 'PENDING'));
       return $query;
   }

    function GET_TOTAL_REPORTING()
    {
        $sql = "SELECT COUNT(ALL id) as 'total_reporting' FROM tbl_user_attn_list WHERE (col_time_in !='' AND col_date_crea=?) ";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_ONSHIFT()
    {
        $sql = "SELECT COUNT(ALL id) as 'total_onshift' FROM tbl_user_attn_list WHERE (col_time_in !='' AND col_time_out ='' AND col_date_crea=?) ";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_FINSHIFT()
    {
        $sql = "SELECT COUNT(ALL id) as 'total_finshift' FROM tbl_user_attn_list WHERE (col_time_in !='' AND col_time_out !='' AND col_date_crea=?) ";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    ////////////////////////////////

    //TOTAL REPORTING TODAY
    function GET_REPORTING_INTERN()
    {
        $this->db->select('*');
        $this->db->from('tbl_user_acct_list');
        $this->db->join('tbl_user_attn_list', 'tbl_user_attn_list.col_intr_id = tbl_user_acct_list.id');
        $this->db->where('tbl_user_attn_list.col_date_crea', date('Y-m-d'));
        $this->db->where('tbl_user_attn_list.col_time_in IS NOT NULL');
        $query = $this->db->get();
        if (count($query->result()) > 0) {
                return $query->result();
        }
    }
    
    //TOTAL ON SHIFT TODAY
    function GET_ONSHIFT_INTERN()
    {
        $nully = '';
        $this->db->select('*');
        $this->db->from('tbl_user_acct_list');
        $this->db->join('tbl_user_attn_list', 'tbl_user_attn_list.col_intr_id = tbl_user_acct_list.id');
        $this->db->where('tbl_user_attn_list.col_date_crea', date('Y-m-d'));
        $this->db->where('tbl_user_attn_list.col_time_in !=', $nully);
        $this->db->where('tbl_user_attn_list.col_time_out =', $nully);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
                return $query->result();
        }
    }

    //FINISHED SHIFT
    function GET_FINSHIFT_INTERN()
    {
        $nully = '';
        $this->db->select('*');
        $this->db->from('tbl_user_acct_list');
        $this->db->join('tbl_user_attn_list', 'tbl_user_attn_list.col_intr_id = tbl_user_acct_list.id');
        $this->db->where('tbl_user_attn_list.col_date_crea', date('Y-m-d'));
        $this->db->where('tbl_user_attn_list.col_time_in !=', $nully);
        $this->db->where('tbl_user_attn_list.col_time_out !=', $nully);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
                return $query->result();
        }
    }

    function GET_TOTAL_FOR_INTERVIEW()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_for_interview' FROM tbl_user_acct_list WHERE col_user_stat = ? AND col_user_type= ?";
        $query = $this->db->query($sql, array('FOR INTERVIEW', 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_HIRED()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_hired' FROM tbl_user_acct_list WHERE col_user_stat = ? AND col_user_type= ?";
        $query = $this->db->query($sql, array('ACCEPTED', 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_RESCHEDULED()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_rescheduled' FROM tbl_user_acct_list WHERE col_user_stat = ? AND  col_user_type = ?";
        $query = $this->db->query($sql, array('RESCHEDULE', 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_FAILED()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_failed' FROM tbl_user_acct_list WHERE col_user_stat = ?  AND col_user_type= ?";
        $query = $this->db->query($sql, array('FAILED', 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_ONBOARDING()
    {
        $sql = "SELECT `id`, `col_acnt_crea`, `col_user_type`, `col_emai_veri`, `col_emai_addr`,
        `col_user_pass`, `col_last_name`, `col_frst_name`, `col_midl_name`, `col_curr_addr`,
        `col_cell_numb`, `col_birt_date`, `col_intr_gndr`, `col_intr_skil`, `col_imag_name`,
        `col_imag_path`, `col_scho_name`, `col_schl_cont`, `col_advs_name`, `col_advs_cont`,
        `col_intr_cour`, `col_totl_hour`, `col_sche_day`, `col_work_hour`, `col_reqm_waiv`,
        `col_reqm_resm`, `col_reqm_endo`, `col_reqm_agre`, `col_esay_ansr`, `col_date_sbmt`,
        `col_step_prog`, `col_user_stat`, `col_date_inte`, `col_inte_resc`,
        `col_star_date`, `col_inte_stat`,SUBSTRING(`col_date_inte`,1,10) AS 'SUB_DATE',col_user_stat,
        STR_TO_DATE(SUBSTRING(`col_date_inte`,11,18),'%l:%i %p') AS 'SUB_TIME' FROM tbl_user_acct_list
        WHERE (col_user_stat = 'ONBOARDING' OR col_user_stat = 'RESCHEDULE') AND (col_step_prog > 0 AND col_user_type = 'INTERN')
        ORDER BY `SUB_DATE` ASC, `SUB_TIME`";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function GET_PRESENTATION()
    {
        $sql = "SELECT `id`, `col_acnt_crea`, `col_user_type`, `col_emai_veri`, `col_emai_addr`,
        `col_user_pass`, `col_last_name`, `col_frst_name`, `col_midl_name`, `col_curr_addr`,
        `col_cell_numb`, `col_birt_date`, `col_intr_gndr`, `col_intr_skil`, `col_imag_name`,
        `col_imag_path`, `col_scho_name`, `col_schl_cont`, `col_advs_name`, `col_advs_cont`,
        `col_intr_cour`, `col_totl_hour`, `col_sche_day`, `col_work_hour`, `col_reqm_waiv`,
        `col_reqm_resm`, `col_reqm_endo`, `col_reqm_agre`, `col_esay_ansr`, `col_date_sbmt`,
        `col_step_prog`, `col_user_stat`, `col_date_inte`, `col_inte_resc`, `col_reje_reas`,
        `col_star_date`, `col_inte_stat`,SUBSTRING(`col_date_inte`,1,10) AS 'SUB_DATE',col_user_stat,
        STR_TO_DATE(SUBSTRING(`col_date_inte`,11,18),'%l:%i %p') AS 'SUB_TIME' FROM tbl_user_acct_list
        WHERE (col_user_stat = 'FOR PRESENT') AND (col_step_prog > 0 AND col_user_type = 'INTERN')
        ORDER BY `SUB_DATE` ASC, `SUB_TIME`";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function GET_INTERVIEW()
    {
        $sql = "SELECT `id`, `col_acnt_crea`, `col_user_type`, `col_emai_veri`, `col_emai_addr`,
        `col_user_pass`, `col_last_name`, `col_frst_name`, `col_midl_name`, `col_curr_addr`,
        `col_cell_numb`, `col_birt_date`, `col_intr_gndr`, `col_intr_skil`, `col_imag_name`,
        `col_imag_path`, `col_scho_name`, `col_schl_cont`, `col_advs_name`, `col_advs_cont`,
        `col_intr_cour`, `col_totl_hour`, `col_sche_day`, `col_work_hour`, `col_reqm_waiv`,
        `col_reqm_resm`, `col_reqm_endo`, `col_reqm_agre`, `col_esay_ansr`, `col_date_sbmt`,
        `col_step_prog`, `col_user_stat`, `col_date_inte`, `col_inte_resc`, `col_reje_reas`,
        `col_star_date`, `col_inte_stat`,SUBSTRING(`col_date_inte`,1,10) AS 'SUB_DATE',col_user_stat,
        STR_TO_DATE(SUBSTRING(`col_date_inte`,11,18),'%l:%i %p') AS 'SUB_TIME' FROM tbl_user_acct_list
        WHERE (col_user_stat = 'FOR INTERVIEW') AND (col_step_prog > 0 AND col_user_type = 'INTERN')
        ORDER BY `SUB_DATE` ASC, `SUB_TIME`";
        $query = $this->db->query($sql);
        return $query->result();
    }


    function HIRE_INTERN($id)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ? , col_star_date = NOW(), col_inte_stat = ? WHERE id=?";
        $query = $this->db->query($sql, array(3, 'ACCEPTED', 'PASSED', $id));
        return $query;
    }

    function INTERVIEWED_INTERN($id)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ? , col_star_date = NOW() WHERE id=?";
        $query = $this->db->query($sql, array(3, 'FOR PRESENT', $id));
        return $query;
    }

    function RESCHEDULE_INTERN($id, $rescheduleDateTime)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ?, col_date_inte = ? WHERE id=?";
        $query = $this->db->query($sql, array(2, 'RESCHEDULE', $rescheduleDateTime, $id));
        return $query;
    }

    function FAILED_INTERN($id)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ?, col_inte_stat = ? WHERE id=?";
        $query = $this->db->query($sql, array(1, 'FAILED', 'FAILED', $id));
        return $query;
    }

    function DETAILS_INTERN($id)
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_FAILED()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('FAILED', 1, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_RESCHEDULE()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('RESCHEDULE', 2, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_HIRED_INTERN()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('ACCEPTED', 3, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_ACCEPTED_INTERN()
    {
        $sql = "SELECT a.id as acc_id, a.col_last_name, a.col_frst_name, a.col_midl_name, b.col_mem_posi, b.col_mem_dept, b.col_mem_project FROM tbl_user_acct_list as a
                LEFT JOIN tbl_dept_member as b
                ON a.id = b.col_mem_id
                WHERE (a.col_user_stat = ? AND a.col_step_prog = ?) AND a.col_user_type= ?";
        $query = $this->db->query($sql, array('ACCEPTED', 3, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }
    
    function GET_ACCEPTED_INTERN_DEPARTMENTS()
    {
        $sql = "SELECT * FROM tbl_dept_member";
        $query = $this->db->query($sql);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function FILTER_ACCEPTED_INTERN_DEPARTMENTS(){
        $sql = "SELECT col_dept_name FROM tbl_dept_list ORDER BY id ASC";
        $query = $this->db->query($sql, array());
        return $query->result();
    }
    // ================================================== END ONBOARDING ==================================================






    // ================================================== START RECRUITMENT ==================================================

    function GET_TOTAL_PENDING()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_pending' FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('PENDING', 1, 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_PENDING_PRESENTATION()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_presentation' FROM tbl_user_acct_list WHERE col_user_stat = ?  AND col_user_type= ?";
        $query = $this->db->query($sql, array('FOR PRESENT', 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_PENDING_INTERVIEW()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_interview' FROM tbl_user_acct_list WHERE col_user_stat = ?  AND col_user_type= ?";
        $query = $this->db->query($sql, array('FOR INTERVIEW', 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }


    function GET_TOTAL_ACCEPTED()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_accepted' FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog > ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('FOR INTERVIEW', 1, 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_TOTAL_QUOTALIMITED()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_quota_limit' FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('QUOTA LIMIT', 1, 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_REJECTED()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('REJECTED', 1, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_QUOTA_LIMIT()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('QUOTA LIMIT', 1, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_FOR_INTERVIEW()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('FOR INTERVIEW', 2, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_PENDING_REQUEST()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('PENDING', 1, 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_PENDING_PRESENTATION()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE col_user_stat = ? AND col_user_type= ?";
        $query = $this->db->query($sql, array('FOR PRESENT', 'INTERN'));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }


    function GET_TOTAL_REJECTED()
    {
        $sql = "SELECT COUNT(ALL col_user_stat) as 'total_rejected' FROM tbl_user_acct_list WHERE (col_user_stat = ? AND col_step_prog = ?) AND col_user_type= ?";
        $query = $this->db->query($sql, array('REJECTED', 1, 'INTERN'));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function GET_ATTENDANCE()
    {
        $sql = "SELECT INTERN.id, INTERN.col_last_name AS LAST_NAME,INTERN.col_sche_day AS SCHEDULE, INTERN.col_frst_name AS FIRST_NAME,ATTENDANCE.col_intr_id, INTERN.`col_user_type` AS ACCOUNT_TYPE, INTERN.col_user_stat AS STATUS, ATTENDANCE.col_attn_date, ATTENDANCE.col_date_crea, ATTENDANCE.col_time_in AS TIME_IN, ATTENDANCE.col_time_out AS TIME_OUT 
                FROM tbl_user_acct_list INTERN 
                LEFT JOIN tbl_user_attn_list ATTENDANCE ON ATTENDANCE.col_intr_id = INTERN.id 
                WHERE INTERN.col_user_type='INTERN' AND INTERN.col_user_stat='ACCEPTED' AND ATTENDANCE.col_date_crea ORDER BY ATTENDANCE.col_date_crea DESC;";
        $query = $this->db->query($sql, array());
        return $query->result();
    }

    function GET_REQUEST()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE (col_user_stat = 'PENDING' OR col_user_stat = 'QUOTA LIMIT' ) AND (col_user_type = 'INTERN' AND col_step_prog <= 1) ORDER BY `col_user_stat` ASC, `col_date_sbmt` ASC;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function GET_ACCEPTED()
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE col_user_stat = ? OR col_user_stat =? AND col_step_prog = ?";
        $query = $this->db->query($sql, array('PENDING', 'RESCHEDULE', 1));
        return $query->result();
    }

    function VIEW_INTERN($id)
    {
        $sql = "SELECT * FROM tbl_user_acct_list WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function REJECT_REQUEST($id, $rejectBy, $rejectReason)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ?, col_step_prog = ?, col_reje_by = ? , col_reje_reas = ? WHERE id=?";
        $query = $this->db->query($sql, array(1, 'REJECTED', 1, $rejectBy, $rejectReason, $id));
        return $query;
    }

    function LIMIT_REQUEST($id, $limitBy, $limitReason)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ?, col_reje_by = ? , col_reje_reas = ? WHERE id=?";
        $query = $this->db->query($sql, array(1, 'QUOTA LIMIT', $limitBy, $limitReason, $id));
        return $query;
    }

    function ACCEPT_REQUEST($id, $interviewSchedule, $acceptBy)
    {
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ?, col_date_inte = ? , col_inte_resc =? , col_inte_name =? WHERE id=?";
        $query = $this->db->query($sql, array(2, 'FOR INTERVIEW', $interviewSchedule, $interviewSchedule, $acceptBy, $id));
        return $query;
    }
    // ================================================== END RECRUITMENT ==================================================

    // ================================================== START INTERVIEW ==================================================
    function PASS_INTERVIEW($interviewedId){
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ? WHERE id=?";
        $query = $this->db->query($sql, array(3, 'FOR PRESENT', $interviewedId));
        return $query;
    }

    // ================================================== END INTERVIEW ====================================================

    // ================================================== START PRESENTATION ==================================================
    function PASS_PRESENTATION($interviewedId){
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_user_stat = ? WHERE id=?";
        $query = $this->db->query($sql, array(4, 'ONBOARDING', $interviewedId));
        return $query;
    }

    // ================================================== END PRESENTATION ====================================================

    // ================================================== START ONBOARDING ==================================================
    function PASS_ONBOARDING($interviewedId){
        $sql = "UPDATE tbl_user_acct_list SET col_step_prog = ?, col_inte_stat = 'PASSED', col_user_stat = ?, col_star_date = NOW() WHERE id=?";
        $query = $this->db->query($sql, array(3, 'ACCEPTED', $interviewedId));
        return $query;
    }

    // ================================================== END ONBOARDING ====================================================

    // ================================================== START ANNOUNCEMENTS ==================================================
    function add_announcements($img_filename,$announcements_title,$announcements_content,$announcement_attachment,$announcements_important){
        $sql = "INSERT INTO tbl_annc_list (col_annc_title, col_annc_cont, col_annc_img, col_annc_attc, col_annc_crea, col_annc_stat) VALUES (?,?,?,?,NOW(),?)";
        $query = $this->db->query($sql, array($announcements_title,$announcements_content,$img_filename,$announcement_attachment,str_replace('_', '',$announcements_important)));
        return $query;
    }

    function update_announcements($img_filename,$announcements_title,$announcements_content,$announcement_attachment,$announcements_important){
        $sql = "UPDATE tbl_annc_list SET col_annc_title=?, col_annc_cont=?, col_annc_img=?, col_annc_attc=? WHERE col_annc_stat = ?";
        $query = $this->db->query($sql, array($announcements_title,$announcements_content,$img_filename,$announcement_attachment,$announcements_important));
        return $query;
    }

    function fetch_important_announcements(){
        $sql = "SELECT * FROM tbl_annc_list WHERE col_annc_stat = 'important1' OR col_annc_stat = 'important2' OR col_annc_stat = 'important3'";
        $query = $this->db->query($sql);
        return $query;
    }

    function fetch_announcements(){
        $sql = "SELECT * FROM tbl_annc_list WHERE id IS NOT NULL AND col_annc_stat = 'standard'";
        $query = $this->db->query($sql);
        return $query;
    }

    function display_archived_announcements(){
        $sql = "SELECT * FROM tbl_annc_list WHERE id IS NOT NULL AND col_annc_stat = 'archived'";
        $query = $this->db->query($sql);
        return $query;
    }

    function archived_announcement($id){
        $sql = "UPDATE tbl_annc_list SET col_annc_stat=? WHERE id = ?";
        $query = $this->db->query($sql, array('archived',$id));
        return $query;
    }

    function delete_announcement($id){
        $sql = "DELETE FROM tbl_annc_list WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query;
    }

    function update_announcement_upload($id,$announcements_title_update,$announcements_content_update){
        $sql = "UPDATE tbl_annc_list SET col_annc_title=?, col_annc_cont=?, col_annc_crea=NOW() WHERE id=?";
        $query = $this->db->query($sql, array($announcements_title_update,$announcements_content_update,$id));
        return $query;
    }

    function update_announcement_img($id,$announcement_image){
        $sql = "UPDATE tbl_annc_list SET col_annc_img=? WHERE id=?";
        $query = $this->db->query($sql, array($announcement_image,$id));
        return $query;
    }

    function update_announcement_file($id,$announcement_attachment_update){
        $sql = "UPDATE tbl_annc_list SET col_annc_attc=? WHERE id=?";
        $query = $this->db->query($sql, array($announcement_attachment_update,$id));
        return $query;
    }
    // ================================================== END ANNOUNCEMENTS ==================================================

    // ================================================== START EVENTS ==================================================
    function fetch_events(){
        $sql = "SELECT * FROM tbl_event_list WHERE id IS NOT NULL";
        $query = $this->db->query($sql);
        return $query;
    }

    function concluded_events(){
        $sql = "SELECT * FROM tbl_event_list WHERE id IS NOT NULL AND col_evnt_end <= CURDATE() ORDER BY col_evnt_end DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    function fetch_eventsRender(){
        $sql = "SELECT * FROM tbl_event_list WHERE id IS NOT NULL AND col_evnt_end >= CURDATE() ORDER BY col_evnt_start DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    function lastId(){
        $sql = "SELECT MAX( id ) FROM tbl_event_list";
        $query = $this->db->query($sql);
        return $query;
    }

    function add_event($event_title, $event_content, $event_status){
        $sql = "INSERT INTO tbl_event_list (col_evnt_title, col_evnt_cont, col_evnt_status, col_evnt_add) VALUES (?,?,?,NOW())";
        $query = $this->db->query($sql, array($event_title, $event_content, $event_status));
        return $query;
    }

    function update_event($id,$event_title,$event_start,$event_end){
        $original_date = $event_start;
        $time_original = strtotime($original_date);
        $time_add      = $time_original + (3600*8);
        $event_start   = date("Y-m-d", $time_add);
        if(!empty($event_end)){
            $original_date2 = $event_end;
            $time_original2 = strtotime($original_date2);
            $time_add2      = $time_original2 + (3600*8);
            $event_end      = date("Y-m-d", $time_add2);
        }else{
            $original_date2 = $event_start;
            $time_original2 = strtotime($original_date2);
            $time_add2      = $time_original2 + (3600*8);
            $event_end      = date("Y-m-d", $time_add2);
        }

        $sql = "UPDATE tbl_event_list SET col_evnt_title=?, col_evnt_start=?, col_evnt_end=? WHERE id=?";
        $query = $this->db->query($sql, array($event_title,$event_start,$event_end,$id));
        return $query;
    }

    function event_update($id,$title,$content){
        $sql = "UPDATE tbl_event_list SET col_evnt_title=?, col_evnt_cont=? WHERE id=?";
        $query = $this->db->query($sql, array($title,$content,$id));
        return $query;
    }

    function event_delete($id){
        $sql = "DELETE FROM tbl_event_list WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query;
    }
    // ================================================== END EVENTS ====================================================

    // ================================================== START DEPARTMENTS ====================================================

    function view_departments(){
        $sql = "SELECT * FROM tbl_dept_list WHERE id IS NOT NULL AND col_dept_stat != 'archived' ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function disp_departments($id){
        $sql = "SELECT * FROM tbl_dept_list WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    function view_projects($id){
        $sql = "SELECT * FROM tbl_dept_member WHERE col_dept_id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    function disp_projects($id){
        $sql = "SELECT * FROM tbl_proj_list WHERE col_proj_dept = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }

    function disp_projects_div($id){
        $sql = "SELECT * FROM tbl_proj_list WHERE id = ?";
        $query = $this->db->query($sql, array($id));
       $row = $query->row();
        if ($row == NULL) {
            return 0;
        } else {
            $data = [
                'id' => $row->id,
                'proj_name' => $row->col_proj_name,
                'proj_pm' => $row->col_proj_pm,
                'proj_dept' => $row->col_proj_dept,
                'proj_mem' => $row->col_proj_mem,
                
            ];
        }
        return $data;
    }

    function user_list(){
        $sql = "SELECT * FROM tbl_user_acct_list WHERE col_inte_stat = 'PASSED' AND col_user_stat = 'ACCEPTED' AND id IS NOT NULL";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function add_department($deptName, $deptLead){
        $sql = "INSERT INTO tbl_dept_list (col_dept_name, col_dept_lead) VALUES (?,?)";
        $query = $this->db->query($sql, array($deptName, $deptLead));
        return $query;
    }

    function add_project($projName, $projPm, $projDept){
        $sql = "INSERT INTO tbl_proj_list (col_proj_name, col_proj_pm, col_proj_dept) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($projName, $projPm, $projDept));
        return $query;
    }
    
    function add_dept_mem($deptMemName, $deptMemProj, $deptMemDept, $deptPosi){
        $sql = "INSERT INTO tbl_dept_member (col_mem_name, col_mem_project, col_dept_id, col_mem_posi) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($deptMemName, $deptMemProj, $deptMemDept, $deptPosi));
        return $query;
    }

    function display_department()
    {
        // $sql = "SELECT * FROM tbl_dept_list WHERE id IS NOT NULL AND col_dept_stat != 'archived' ORDER BY id DESC";
        // $query = $this->db->query($sql);
        // $row = $query->row();
        // if ($row == NULL) {
        //     return 0;
        // } else {
        //     $data = [
        //         'id' => $row->id,
        //         'dept_name' => $row->col_dept_name,
        //         'dept_lead' => $row->col_dept_lead,
        //         'dept_tname' => $row->col_dept_tname,
        //         'dept_stat' => $row->col_dept_stat,
                
        //     ];
        // }
        // return $data;
        // $sql = "SELECT * FROM tbl_dept_list WHERE id IS NOT NULL AND col_dept_stat != 'archived' ORDER BY id DESC";
        // $query = $this->db->query($sql);
        // return $query->result();
        // $data = [
        //             'id' => $row->id,
        //             'dept_name' => $row->col_dept_name,
        //             'dept_lead' => $row->col_dept_lead,
        //             'dept_tname' => $row->col_dept_tname,
        //             'dept_stat' => $row->col_dept_stat,
                    
        //         ];
        // return $data;
    }

    // ================================================== END DEPARTMENTS ====================================================

    // ================================================== START CONCERNS ====================================================
    function LIST_CONCERNS()
    {
        $sql = "SELECT * FROM tbl_concerns";
        $query = $this->db->query($sql);
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


     //GET MESSAGES
     function GET_MESSAGE($id)
     {
       $sql = "SELECT * FROM tbl_concern_convo WHERE col_concern_id = ?";
       $query = $this->db->query($sql, array($id));
         if (count($query->result()) > 0) {
             return $query->result();
         }
     }

    //REPLY CONCERN
    function REPLY_CONCERN_ADM($title,$replyId,$reply,$dt,$concern_attach, $ccount)
    {
        $sql = "INSERT INTO tbl_concern_convo (col_convo_title, col_convo_mess, col_concern_id, col_convo_date, col_convo_status, col_convo_attach) VALUES (?,?,?,?,?,?)";
        $this->db->query($sql, array($title, $reply, $replyId, $dt, '1', $concern_attach));
        $sql1 = "UPDATE tbl_concerns SET col_con_convo = ?, col_con_reply= ?, col_con_attach_count = ? WHERE id = ?";
        $this->db->query($sql1, array('4','1', $ccount, $replyId));
    }

     //COMPLETE CONCERN
     function COMPLETE_CONCERN_ADM($id)
     {
         $sql1 = "UPDATE tbl_concerns SET col_con_convo = ? WHERE id = ?";
         $this->db->query($sql1, array('2', $id));
     }

     //COMPLETE CONCERN
     function DELETE_CONCERN($id)
     {
         $sql1 = "UPDATE tbl_concerns SET col_con_stat = ? WHERE id = ?";
         $this->db->query($sql1, array('ARCHIVED', $id));
     }

     //GET FILTER DATE
     function GET_FILTER_DATE()
     {
         $sql = "SELECT `col_con_create` FROM tbl_concerns GROUP BY col_con_create DESC LIMIT 30";
         $query = $this->db->query($sql);
         if (count($query->result()) > 0) {
             return $query->result();
         }
     }

     //GET FILTERED DATE REQUEST
     function GET_DATE_FIL($date)
     {
         $sql1 = "SELECT * FROM tbl_concerns WHERE col_con_create = ?";
         $query = $this->db->query($sql1, array($date));
         if (count($query->result()) > 0) {
            return $query->result();
        }
     }




    function CREATE_ACCOUNT($username, $password, $accountType, $lastnName, $firstName){
        $sql = "INSERT INTO tbl_user_acct_list (col_emai_addr, col_user_pass, col_user_type, col_last_name, col_frst_name, col_acnt_crea) VALUES (?,?,?,?,?,NOW())";
        $query = $this->db->query($sql, array($username, $password, $accountType, $lastnName, $firstName));
        return $query;
    }


    function GET_USERNAME($username){
        $sql = "SELECT `col_emai_addr` FROM tbl_user_acct_list WHERE `col_emai_addr`= ?";
        $query = $this->db->query($sql, array($username));
        if ($query->result() > 0) {
            return $query->row();
        }
    }


    //NEW FUNCTIONS ============================================================================================================
    function SELECT_STATUS(){
        $sql = "SELECT DISTINCT col_date_crea FROM tbl_user_attn_list ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        return $query->result();
    }

    function GET_FILTERED_ATTENDANCE(){
        $sql = "SELECT DISTINCT col_date_crea FROM tbl_user_attn_list ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        return $query->result();
    }

    function FILTER_ATTENDACE($date){
        $sql = "SELECT * FROM tbl_user_attn_list WHERE col_date_crea=? ORDER BY id DESC";
        $query = $this->db->query($sql, array($date));
        return $query->result();
    }

    function SELECT_INTERN($intr_id){
        $sql = "SELECT * FROM tbl_user_acct_list WHERE id=?";
        $query = $this->db->query($sql, array($intr_id));
        return $query->result();
    }

















    // // Async Function
    // function get_select_status($stat){
    //     $sql = "SELECT * FROM tbl_user_attn_list WHERE col_date_crea=?";
    //     $query = $this->db->query($sql,array($stat));
    //     $query->next_result();
    //     return $query->result();
    // }
    function GET_TIMEDIN_INTR(){
        $sql = "SELECT COUNT(ALL id) as 'total_timein' FROM tbl_user_attn_list WHERE (col_time_in !='' AND col_date_crea=?) ";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        if ($query->result() > 0) {
            return $query->row();
        }
    }
    function GET_TIMEDOUT_INTR(){
        $sql = "SELECT COUNT(ALL id) as 'total_timeout' FROM tbl_user_attn_list WHERE  col_date_crea=? AND (col_time_out !='')";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        if ($query->result() > 0) {
            return $query->row();
        }
    }
    function GET_RPRTING_INTR(){
        if(date('l')=="Monday"){
            $sql = "SELECT COUNT(ALL id) as 'total_rprt_intr' FROM tbl_user_sche_list WHERE  col_mond_sche !=''";
        }
        else if(date('l')=="Tuesday"){
            $sql = "SELECT COUNT(ALL id) as 'total_rprt_intr' FROM tbl_user_sche_list WHERE  col_tues_sche !=''";
        }
        else if(date('l')=="Wednesday"){
            $sql = "SELECT COUNT(ALL id) as 'total_rprt_intr' FROM tbl_user_sche_list WHERE  col_wedn_sche !=''";
        }
        else if(date('l')=="Thursday"){
            $sql = "SELECT COUNT(ALL id) as 'total_rprt_intr' FROM tbl_user_sche_list WHERE  col_thur_sche !=''";
        }
        else if(date('l')=="Friday"){
            $sql = "SELECT COUNT(ALL id) as 'total_rprt_intr' FROM tbl_user_sche_list WHERE  col_frid_sche !=''";
        }
        else if(date('l')=="Saturday"){
            $sql = "SELECT COUNT(ALL id) as 'total_rprt_intr' FROM tbl_user_sche_list WHERE  col_satu_sche !=''";
        }
        $query = $this->db->query($sql, array(date('Y-m-d')));
        if ($query->result() > 0) {
            return $query->row();
        }
    }

    function DISPLAY_UPLOADED_REPORT()
    {
        $sql = "SELECT * FROM `tbl_dar_list` ORDER BY col_dar_crea ASC";
        $query = $this->db->query($sql);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    // ======================================== ALUMNI ====================================================
    function GET_ALUMNI(){
        $query = $this->db->select('*')
                          ->from('tbl_dept_member')
                          ->join('tbl_user_acct_list', 'tbl_user_acct_list.id = tbl_dept_member.col_mem_id')
                          ->where('tbl_dept_member.col_mem_hrs = tbl_user_acct_list.col_totl_hour');
                            
                          
                          $return['rows'] = $query->get()->result();

        $query = $this->db->distinct('*')
                          ->from('tbl_dept_list');
                        //   ->join('tbl_dept_member', 'tbl_dept_member.col_dept_id = tbl_dept_list.id')
                        //   ->join('tbl_user_acct_list', 'tbl_user_acct_list.id = tbl_dept_member.col_mem_id');

                          $return['dept'] = $query->get()->result();

        return $return;
    }

    function display_alumni(){
        $sql = "SELECT * FROM tbl_dept_member WHERE id IS NOT NULL";
        $query = $this->db->query($sql);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    // OVERTIME
    function DISPLAY_OVERTIME(){
        $sql = "SELECT * FROM `tbl_otim_req_list` WHERE col_ot_stat = 'Pending'";
        $query = $this->db->query($sql);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function DISPLAY_OVERTIME_RECORDS(){
        $sql = "SELECT * FROM `tbl_otim_req_list` WHERE col_ot_stat != 'Pending' ORDER BY id DESC";
        $query = $this->db->query($sql);
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function GET_OVERTIME_RECORDS($id){
        $sql = "SELECT * FROM `tbl_otim_req_list` WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        if (count($query->result()) > 0) {
            return $query->result();
        }
    }

    function APPROVE_OVERTIME($id){
        $sql = "UPDATE tbl_otim_req_list SET col_ot_stat = ? WHERE id = ?";
        $this->db->query($sql, array('Accepted', $id));
    }

    function DENY_OVERTIME($id){
        $sql = "UPDATE tbl_otim_req_list SET col_ot_stat = ? WHERE id = ?";
        $this->db->query($sql, array('Denied', $id));
    }







}
