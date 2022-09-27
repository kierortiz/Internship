<!-- TASK3 -->
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">


<!-- CURRENT SCHEDULE DETAILS CARD-->
<div class="card">
    <div class="card-header">
        <h3 class="card-title mt-3">
            Schedule Details
        </h3>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <dl class="row">
            <dt class="col-sm-4">Current Schedule: </dt>
            <dd class="col-sm-8 mb-3">
                <?php
                $schedule = explode("+", $USER_DATA['schedule']);
                $count = count($schedule) - 1;
                for ($i = 0; $i < $count; $i++) {
                    echo $schedule[$i] . '<br>';
                }
                ?>
            </dd>
            <dt class="col-sm-4">Credited Working Hours: </dt>
            <input type="hidden" name="INF_USER_COUNT_INTR" class="INF_USER_COUNT_INTR" id="INF_USER_COUNT_INTR" value="<?php echo $USER_DATA['req_count']?>">
            <input type="hidden" name="INF_USER_ID_INTR" class="INF_USER_ID_INTR" id="INF_USER_ID_INTR" value="<?php echo $USER_DATA['id']?>">
            <input type="hidden" name="INF_USER_EMAIL_INTR" class="INF_USER_EMAIL_INTR" id="INF_USER_EMAIL_INTR" value="<?php echo $USER_DATA['user']?>">
            <dd class="col-sm-8 mb-3"><?= $USER_DATA['work_hour'] . ' Hours' ?></dd>
            <dt class="col-sm-4">Request Status: </dt>

            <dd class="col-sm-8 mb-3" id="reqStat"> </dd>
        </dl>
    </div>
</div>

<!-- NEW SCHEDULE REQUEST CARD -->
<br><br>
<div class="card" id="reqCard1">
    <div class="card-header">
        <h3 class="card-title mt-3">
            New Schedule Request
        </h3>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
                <label for="">Status:</label>
            </div>
            <div class="col-lg-6 col-md-6 mb-3 STATUS">
                <small class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> EMPTY</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-3">
                <label class="">Hours:</label>
            </div>
            <div class="col-lg-6 col-md-6 mb-3">
                <label class="credited_work_hours" name="credited_work_hours" id="credited_work_hours"> 0</label>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 mb-12">
            <h6>Note: <br>1. Max working hours per week must not exceed to 39 hours<br>
                        2. Minimum working hours per week must not below 28 hours.<br>
                        3. You can only request change of schedule once.
            </h6>
        </div>
    </div>
</div>

<!-- ////////// -->
    <div class="row" id="reqCard">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile table-responsive">
                    <form class="form" id="reqReschedule">
                        <?php
                        $schedule = explode("+", $USER_DATA['schedule']);
                        ?> 
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Day</th>
                                    <th>Whole day<br>
                                        <h6 class="text-muted">(8:00 AM-4:00 PM)</h6>
                                    </th>
                                    <th>AM Half day<br>
                                        <h6 class="text-muted">(8:00 AM-11:30 AM)</h6>
                                    </th>
                                    <th>AM Half day<br>
                                        <h6 class="text-muted">(8:00 AM-12:00 AM)</h6>
                                    </th>
                                    <th>PM Half day<br>
                                        <h6 class="text-muted">(1:00 PM-4:30 PM)</h6>
                                    </th>
                                    
                                    <th>Rest day<br>
                                        <h6 class="text-muted">(Vacant)</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="#">1.</td>
                                    <td data-label="Day">Monday</td>
                                    <td data-label="Whole day(8:00 AM-4:00 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r0" id="radioMondayWhole" value="Monday - 8:00 AM-4:00 PM+" <?= (in_array("Monday - 8:00 AM-4:00 PM", $schedule)) ? 'checked' : 'disable'; ?> />
                                            <label for="radioMondayWhole"></label>
                                        </div>
                                        <input type="hidden" id="Monday_val" value="0" />
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r0" id="radioMondayHalfAm" value="Monday - 8:00 AM-11:30 AM+" <?= (in_array("Monday - 8:00 AM-11:30 AM", $schedule)) ? 'checked' : 'disable'; ?> />
                                            <label for="radioMondayHalfAm"></label>
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="Half day(1:00 PM-4:30 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r0" id="radioMondayHalfPm" value="Monday - 1:00 PM-4:30 PM+" <?= (in_array("Monday - 1:00 PM-4:30 PM", $schedule)) ? 'checked' : 'disable'; ?> />
                                            <label for="radioMondayHalfPm"></label>
                                        </div>
                                    </td>
                                    <td data-label="No Work(Vacant)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r0" id="radioMondayNoWork" value="Monday - No Work+"  checked />
                                            <!-- <?= (in_array("Monday - No Work", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioMondayNoWork"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="#">2.</td>
                                    <td data-label="Day">Tuesday</td>
                                    <td data-label="Whole day(8:00 AM-4:00 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r2" id="radioTuesdayWhole" value="Tuesday - 8:00 AM-4:00 PM+"  />
                                            <!-- <?= (in_array("Tuesday - 8:00 AM-4:00 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioTuesdayWhole"></label>
                                        </div>
                                        <input type="hidden" id="Tuesday_val" value="0" />
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r2" id="radioTuesdayHalfAm" value="Tuesday - 8:00 AM-11:30 AM+"  />
                                            <!-- <?= (in_array("Tuesday - 8:00 AM-11:30 AM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioTuesdayHalfAm"></label>
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="Half day(1:00 PM-4:30 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r2" id="radioTuesdayHalPm" value="Tuesday - 1:00 PM-4:30 PM+"  />
                                            <!-- <?= (in_array("Tuesday - 1:00 PM-4:30 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioTuesdayHalPm"></label>
                                        </div>
                                    </td>
                                    <td data-label="No Work(Vacant)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r2" id="radioTuesdayNoWork" value="Tuesday - No Work+"  checked/>
                                            <!-- <?= (in_array("Tuesday - No Work", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioTuesdayNoWork"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="#">3.</td>
                                    <td data-label="Day">Wednesday</td>
                                    <td data-label="Whole day(8:00 AM-4:00 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r3" id="radioWednesdayWhole" value="Wednesday - 8:00 AM-4:00 PM+"  />
                                            <!-- <?= (in_array("Wednesday - 8:00 AM-4:00 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioWednesdayWhole"></label>
                                        </div>
                                        <input type="hidden" id="Wednesday_val" value="0" />
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r3" id="radioWednesdayHalfAm" value="Wednesday - 8:00 AM-11:30 AM+"  />
                                            <!-- <?= (in_array("Wednesday - 8:00 AM-11:30 AM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioWednesdayHalfAm"></label>
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="Half day(1:00 PM-4:30 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r3" id="radioWednesdayHalPm" value="Wednesday - 1:00 PM-4:30 PM+"  />
                                            <!-- <?= (in_array("Wednesday - 1:00 PM-4:30 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioWednesdayHalPm"></label>
                                        </div>
                                    </td>
                                    <td data-label="No Work(Vacant)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r3" id="radioWednesdayNoWork" value="Wednesday - No Work+"  checked />
                                            <!-- <?= (in_array("Wednesday - No Work", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioWednesdayNoWork"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="#">4.</td>
                                    <td data-label="Day">Thursday</td>
                                    <td data-label="Whole day(8:00 AM-4:00 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r4" id="radioThursdayWhole" value="Thursday - 8:00 AM-4:00 PM+"  />
                                            <!-- <?= (in_array("Thursday - 8:00 AM-4:00 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioThursdayWhole"></label>
                                        </div>
                                        <input type="hidden" id="Thursday_val" value="0" />
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r4" id="radioThursdayHalfAm" value="Thursday - 8:00 AM-11:30 AM+"  />
                                            <!-- <?= (in_array("Thursday - 8:00 AM-11:30 AM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioThursdayHalfAm"></label>
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="Half day(1:00 PM-4:30 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r4" id="radioThursdayHalPm" value="Thursday - 1:00 PM-4:30 PM+"  />
                                            <!-- <?= (in_array("Thursday - 1:00 PM-4:30 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioThursdayHalPm"></label>
                                        </div>
                                    </td>
                                    <td data-label="No Work(Vacant)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r4" id="radioThursdayNoWork" value="Thursday - No Work+"  checked/>
                                            <!-- <?= (in_array("Thursday - No Work", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioThursdayNoWork"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="#">5.</td>
                                    <td data-label="Day">Friday</td>
                                    <td data-label="Whole day(8:00 AM-4:00 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r5" id="radioFridayWhole" value="Friday - 8:00 AM-4:00 PM+"  />
                                            <!-- <?= (in_array("Friday - 8:00 AM-4:00 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioFridayWhole"></label>
                                        </div>
                                        <input type="hidden" id="Friday_val" value="0" />
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r5" id="radioFridayHalfAm" value="Friday - 8:00 AM-11:30 AM+"  />
                                            <!-- <?= (in_array("Friday - 8:00 AM-11:30 AM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioFridayHalfAm"></label>
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="Half day(1:00 PM-4:30 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r5" id="radioFridayHalPm" value="Friday - 1:00 PM-4:30 PM+"  />
                                            <!-- <?= (in_array("Friday - 1:00 PM-4:30 PM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioFridayHalPm"></label>
                                        </div>
                                    </td>
                                    <td data-label="No Work(Vacant)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r5" id="radioFridayNoWork" value="Friday - No Work+"  checked/>
                                            <!-- <?= (in_array("Friday - No Work", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioFridayNoWork"></label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td data-label="#">6.</td>
                                    <td data-label="Day">Saturday</td>
                                    <td data-label="Whole day(8:00 AM-4:00 PM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r6" id="radioSaturdayWhole" value="Saturday - 8:00 AM-4:00 PM+"  />
                                            <!-- <?= (in_array("Saturday - 8:00 AM-4:00 PM", $schedule)) ? 'checked' : 'disable' ?> -->
                                            <label for="radioSaturdayWhole"></label>
                                        </div>
                                        <input type="hidden" id="Saturday_val" value="0" />
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r6" id="radioSaturdayHalfAm" value="Saturday - 8:00 AM-11:30 AM+"  />
                                            <!-- <?= (in_array("Saturday - 8:00 AM-11:30 AM", $schedule)) ? 'checked' : 'disable'; ?> -->
                                            <label for="radioSaturdayHalfAm"></label>
                                        </div>
                                    </td>
                                    <td data-label="Half day(8:00 AM-11:30 AM)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" disabled />
                                        </div>
                                    </td>
                                    <td data-label="No Work(Vacant)">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="r6" id="radioSaturdayNoWork" value="Saturday - No Work+"  checked />
                                            <?= (in_array("Saturday - No Work", $schedule)) ? 'checked' : 'disable'; ?>
                                            <label for="radioSaturdayNoWork"></label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-md-6">
                                    <div class="float-center">
                                        <textarea cols="50" rows="3" id="req_comment" class="form-control" name="reqcomment" placeholder="Please state your reason for this request" required></textarea>
                                    </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6">
                                    <div class="float-left">
                                        <button type="submit" class="btn btn-primary" id="subreq">Submit</button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- TASK3 END -->
