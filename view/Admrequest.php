<!-- Modal VIEW INTERN-->
<style>
    .profile-user-img{
        height: 150px !important;
        width: 150px !important;
    }
</style>

<!-- MODAL  -->
<div class="modal fade" id="view_request" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Intern Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <form class="form"> -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col">
                                <div class="card-header">
                                    <h3 class="card-title">
                                         Intern Information
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <input type="hidden" name='req_id_new' id='req_id_new' class="req_id_new" value="">
                                        <dt class="col-sm-4">Name:</dt>
                                        <dd class="col-sm-8 mb-3" id="intern_name"></dd>
                                        <dt class="col-sm-4">Email:</dt>
                                        <dd class="col-sm-8 mb-3" id="intern_email"></dd>
                                        <dt class="col-sm-4">School:</dt>
                                        <dd class="col-sm-8 mb-3" id="intern_school"></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Reason
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dd class="col-sm-8 mb-3">
                                        <div id="sched_reason">
                                        </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Intern Old Schedule
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-4">Old Schedule: </dt>
                                        <dd class="col-sm-8 mb-3">
                                        <div id="sched_container">
                                        </div>
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-sm-4">Old Schedule Hours: </dt>
                                        <dd class="col-sm-8 mb-3">
                                        <p id="old_hrs">0 </p>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Intern New Schedule
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <input type="hidden" name="req_sched_new" class="req_sched_new" id="req_sched_new" value="">
                                        <dt class="col-sm-4">New Schedule: </dt>
                                        <dd class="col-sm-8 mb-3">
                                        <div id="sched_container1">
                                        </div>
                                        </dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-sm-4">New Schedule Hours: </dt>
                                        <dd class="col-sm-8 mb-3">
                                        <p id="new_hrs">0 </p>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="Approve" id="Approve"> Approve </button>
                <button type="submit" class="btn btn-danger" name="Deny" id="Deny">Deny</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>



<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>  -->


<div class="content col-12">
    <div class="row ml-2 mr-2">
        <div class="col-lg-12">
        <div class="col-lg-12">
            
            <button type="button" class="btn btn-primary" id="pen_btn">PENDING</button>
            <button type="button" class="btn btn-success" id="acpt_btn">ACCEPTED</button>
            <button type="button" class="btn btn-danger" id="deny_btn">DENIED</button>
        
        </div>
        <br>
        <!-- PENDING CARD -->
        <div id="pen_card">
            <div class="card" >
                <div class="card-header">
                    <h3 class="card-title">Pending Requests List</h3>
                </div>
                
                <div class="card-body table-responsive">
                    <table class="table table-striped no-data-table">
                        <thead>
                            <tr>
                                <th class="col-1 text-left">Date Submitted</th>
                                <th class="col-1 text-left">E-mail</th>
                                <th class="col-3 text-left">Reason</th>
                                <th class="col-1 text-left">Status</th>
                                <th class="col-1 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_requests">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ACCEPTED CARD -->
        <div id="acpt_card">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Accepted Requests List</h3>
                </div>
                
                <div class="card-body table-responsive">
                    <table class="table table-striped no-data-table">
                        <thead>
                            <tr>
                                <th class="col-2 text-left">Date Submitted</th>
                                <th class="col-2 text-left">E-mail</th>
                                <th class="col-3 text-left">Reason</th>
                                <th class="col-1 text-left">Status</th>
                                <!-- <th class="col-1 text-left">Action</th> -->
                            </tr>
                        </thead>
                        <tbody id="tbl_req_acpt">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- DENIED CARD -->
        <div id="deny_card">
            <div class="card" >
                <div class="card-header">
                    <h3 class="card-title">Denied Requests List</h3>
                </div>
                
                <div class="card-body table-responsive">
                    <table class="table table-striped no-data-table">
                        <thead>
                            <tr>
                                <th class="col-2 text-left">Date Submitted</th>
                                <th class="col-2 text-left">E-mail</th>
                                <th class="col-3 text-left">Reason</th>
                                <th class="col-1 text-left">Status</th>
                                <!-- <th class="col-1 text-left">Action</th> -->
                            </tr>
                        </thead>
                        <tbody id="tbl_req_deny">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
