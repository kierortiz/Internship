<!-- TASK3 -->
<!-- Sweet Alert CSS -->
<!-- <link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css"> -->


<style>

.scrollConcern{
max-height: 500px;
overflow-y: auto;
}

.queries{
max-height: 300px;
overflow-y: auto;
}

</style>

<!-- CONCERNS -->
<div class="row">
    <div class="col-lg-8 mb-3 d-flex align-items-stretch">
        <div class="card col-lg-12">
            <div class="card-header">
                <h3 class="card-title mt-3">
                    Submit a Concern
                </h3>
            </div>
            <div class="card-body" style="padding: 1.5rem;">
                <form class="form" action="<?= base_url() ?>sub-concern" method="post" id="subConcern" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="INF_USER_ID_INTR" class="INF_USER_ID_INTR" id="INF_USER_ID_INTR" value="<?php echo $USER_DATA['id']?>">
                        <input type="hidden" name="INF_USER_EMAIL_INTR" class="INF_USER_EMAIL_INTR" id="INF_USER_EMAIL_INTR" value="<?php echo $USER_DATA['user']?>">
                        <input type="hidden" name="INF_USER_NAME" class="INF_USER_NAME" id="INF_USER_NAME" value="<?php echo $USER_DATA['firstname'] .' '. $USER_DATA['middlename'] .' '. $USER_DATA['lastname']?>">
                        <label for="conTitle">Title</label>
                        <input type="text" class="form-control" name="conTitle" id="conTitle" placeholder="What is your concern about? Ex. Schedule" required>
                    </div>
                    <div class="form-group">
                        <label for="conTxt">Concern</label>
                        <textarea class="form-control" name="concern" id="conTxt" rows="3" required></textarea>
                    </div>
                    <div class="row-sm-12">
                        <div class="form-group">
                            <!-- <label for="conAtch">Attachment</label> -->
                            
                            
                            <input type="file" class="form-control-file" name="concern_attach" id="concern_attach" accept="application/pdf, image/jpeg, image/png">
                         </div>
                        
                        <!-- <div class="custom-file">
                            <input type="file" class="custom-file-input" name="announcement_attachment" id="announcement_attachment" accept="application/msword, application/pdf, application/vnd.ms-powerpoint, application/vnd.ms-excel, .csv"/>
                            <label class="custom-file-label text-muted" name="file_name" id="file_name" for="announcement_attachment">Choose file</label>
                        </div> -->
                        <div class="form-group">
                            <div class="float-right">
                                <button type="button" name="subConcern_btn" id="subConcern_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>


    <div class="col-lg-4 mb-3 d-flex align-items-stretch">                  
        <div class="card col-lg-12">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#" id="newMessage">New Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="allConcern">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="pendingConcern">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="activeConcern">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="completeConcern">Completed</a>
                </li>
                </ul>
            </div>
            <div class="card-body queries" id="concernBody">
                  
            </div>
        </div>
    </div>
</div>


<!-- MESSAGES -->
<div class="card" id="showMessages">
    <div class="card-header">
        <h3 class="card-title mt-3 fixed" id="convoHeader">
        </h3>
    </div>
    <div class="card scrollConcern" id="concernMessages">
        
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-3 d-flex align-items-stretch">
        <div class="card col-lg-12">
            <div class="card-body" style="padding: 1.5rem;">
                <form class="form" action="<?= base_url() ?>reply-concern" method="post" id="subReply" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="INF_USER_ID_INTR" class="INF_USER_ID_INTR" id="INF_USER_ID_INTR" value="<?php echo $USER_DATA['id']?>">
                        <input type="hidden" name="INF_USER_EMAIL_INTR" class="INF_USER_EMAIL_INTR" id="INF_USER_EMAIL_INTR" value="<?php echo $USER_DATA['user']?>">
                        <input type="hidden" name="INF_USER_NAME" class="INF_USER_NAME" id="INF_USER_NAME" value="<?php echo $USER_DATA['firstname'] .' '. $USER_DATA['middlename'] .' '. $USER_DATA['lastname']?>">
                        <input type="hidden" name='replyId' id='replyId' value="">
                        <input type="hidden" name='replyTitle' id='replyTitle' value="">
                        <input type="hidden" name='concernCount' id='concernCount' value="">
                        <label for="exampleFormControlTextarea1">Reply</label>
                        <textarea class="form-control" name="userReply" id="userReply" rows="3" required></textarea>
                    </div>
                    <div class="row-sm-12">
                        <div class="form-group">
                        <input type="file" class="form-control-file" name="reply_attach" id="reply_attach" accept="application/pdf, image/jpeg, image/png">
                            <div class="float-right">
                                <button type="button" class="btn btn-primary" name="subcon" id="subcon">Reply</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>



<!-- //TASK4 -->
<!-- ////////// -->
   
