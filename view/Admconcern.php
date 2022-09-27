<style>

.scrollConcern{
max-height: 400px;
min-height: 400px;
overflow-y: auto;
}

.queries{
max-height: 600px;
min-height: 600px;
overflow-y: auto;
}

</style>

<!-- CONCERNS -->
<!-- UPPER ROW -->
<div class="row">

            <div class="col-lg-4 mb-3">
                <div class="col-sm-6 float-left" style="padding-right:30px">
                    <select  id="filter_date" class="form-control mb-2" required>
                        <option selected value="all">Show All</option>
                        
                    </select>
                </div>
                <div class="col-sm-6 float-right" style="padding-right:30px">
                    <select class="form-control" id="selectConvo">
                        <option selected value="3">New Messages</option>
                        <option value="all">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Active</option>
                        <option value="2">Completed</option>
                    </select>
                </div>
            </div>
            
        
    <!-- </div> -->


</div>



<div class="row">
    <div class="col-lg-4 mb-3">                  
        <div class="card col-lg-11">
            <div class="card-header">
                Concerns
            </div>
            <div class="card-body queries" id="concernBody1">
                
            </div>
            
        </div>
        
    </div>
    

    <div class="col-lg-8 mb-3">
            <div class="card col-lg-12">
                <div class="card-header">
                    <h3 class="card-title mt-3 fixed" id="convoHeader">
                        Concern Title
                    </h3>
                </div>
                <div class="card scrollConcern" id="concernMessages">
                    
                </div>
            </div>
                <form class="form" action="<?= base_url() ?>reply-concern-adm" method="post" id="subReply" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name='replyId' id='replyId' value="">
                        <input type="hidden" name='replyTitle' id='replyTitle' value="">
                        <input type="hidden" name='concernCount' id='concernCount' value="">
                        <label for="exampleFormControlTextarea1">Reply</label>
                        <textarea class="form-control" name="userReply" id="userReply" rows="4" required></textarea>
                    </div>
                    <div class="row-sm-12">
                        <div class="form-group">
                            <div class="float-center">
                            <input type="file" class="form-control-file" name="reply_attach" id="reply_attach" accept="application/pdf, image/jpeg, image/png">
                            </div>
                            <div class="float-right">
                                <button type="button" class="btn btn-primary" name="submitReply" id="submitReply">Reply</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="form" id="completeCon">
                    <input type="hidden" name='completeId' id='completeId' value="">
                    <center><button type="submit" class="btn btn-danger" id="completeConcern">Complete Concern</button></center>
                </form>
    </div>
</div>
