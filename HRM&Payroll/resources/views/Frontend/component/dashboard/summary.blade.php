<div class="container-fluid d-none">
    <div class="row">

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h3 class="mb-0 text-capitalize font-weight-bold">01</h3>
                                <p class="mb-0 text-sm">Title</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{ asset('images/icon.svg') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h3 class="mb-0 text-capitalize font-weight-bold">01</h3>
                                <p class="mb-0 text-sm">Title</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{ asset('images/icon.svg') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h3 class="mb-0 text-capitalize font-weight-bold">01</h3>
                                <p class="mb-0 text-sm">Title</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{ asset('images/icon.svg') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
            <div class="card card-plain h-100 animated fadeIn bg-white">
                <div class="p-3">
                    <div class="row">
                        <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                            <div>
                                <h3 class="mb-0 text-capitalize font-weight-bold">01</h3>
                                <p class="mb-0 text-sm">Title</p>
                            </div>
                        </div>
                        <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow float-end border-radius-md">
                                <img class="w-100 " src="{{ asset('images/icon.svg') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="attendence-wrapper my-5" >
    <div class="d-flex justify-content-center" style="margin-top: 170px">
        <div class="w-50 bg-light p-5 rounded">
            <h3 class=" d-inline-block fw-bold text-center text-primary pb-2">
                Today Attendence:
            </h3>
            <form id="myform">
                <div class="d-flex align-items-center">
                    <div class="col-md-6 pe-3">
                        <div class="date-wrapper text-dark ">

                            <div class="bg-success p-3 rounded">
                                <div class="display-1 fw-bold" id="todayDate"></div>
                                <div class="display-6"><span id="presentMonth"></span> <span id="presentYearCal"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <div class="">
                            <button class="btn in btn-primary btn-sm h6 px-5 d-flex align-items-center"><i class="fas fa-angle-double-left pe-2"
                                    style="font-size: 20px"></i> <span class="inSpan">IN</span></button><br>
                            <button class="btn out btn-success h6 btn-sm px-5 d-flex align-items-center" disabled><i
                                    class="fas fa-angle-double-right pe-2" style="font-size: 20px"></i> <span
                                    class="outSpan">Out</span></button>
                            <span id="DutyTime" class="fw-bold text-dark"></span>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>




<div class="modal" id="in-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Are You Sure To in at "<span class="currentTime"></span>"?</h3>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeBtn" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="iAgree" class="btn shadow-sm btn-danger">I Agree</button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal" id="out-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Are You Sure To Out at "<span class="currentTime"></span>"?</h3>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeBtn" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="iAgreeOut" class="btn shadow-sm btn-danger">I Agree</button>
                </div>
            </div>

        </div>
    </div>
</div>




<script>
    getDateMonthYear();

    function getDateMonthYear() {


        var today = new Date();
        var dd = String(today.getDate()).padStart(2, "0");

        const months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        var mm = months[today.getMonth()];
        var year = today.getFullYear();

        // today = mm + "/" + dd + "/" + yyyy;
        // console.log(yyyy);




        $("#todayDate").html(dd);
        $("#presentMonth").html(mm);
        $("#presentYearCal").html(year);
    }

    async function getTodayAttendence() {
        showLoader();
        let res = await axios.get('/today-attendence');
        hideLoader();
        console.log(res.data);
        let data = res.data.data;


        if (data['clock_in'] != null) {


            // In Complete
            // alert('In Complete');
            $('.inSpan').html('In At: (' + data['clock_in'] + ")");
            $('.in').attr("disabled", true);

            $(".out").removeAttr("disabled");


        }


        if (data['clock_out'] != null) {


            // Out Complete
            $('.outSpan').html('Out At: (' + data['clock_out'] + ")");
            $('.out').attr("disabled", true);

            $("#DutyTime").html(res.data.dutyTime);


        }

        if (data['dutyTime'] != null) {
            $("#dutyTime").html(res.data.dutyTime);
        }
    }
    getTodayAttendence();




    document.getElementById("todayDate").valueAsDate = new Date();

    $('.in').on('click', async function(e) {
        e.preventDefault();

        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        $(".currentTime").html(time);
        $('#in-modal').modal('show');

        $('#iAgree').on('click', async function(e) {
            e.preventDefault();
            showLoader();
            let res = await axios.post('/in-employee', {
                clock_in: time
            });
            hideLoader();

            if (res.data.status === 'success') {
                successToast(res.data['message']);
                $('#in-modal').modal('hide');

                getTodayAttendence();
            } else {
                errorToast(res.data['message']);
                $('#in-modal').modal('hide');

                getTodayAttendence();
            }


        })

    })
    $('.out').on('click', async function(e) {
        e.preventDefault();

        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        $(".currentTime").html(time);
        $('#out-modal').modal('show');

        $('#iAgreeOut').on('click', async function(e) {
            e.preventDefault();
            showLoader();
            let res = await axios.post('/out-employee', {
                clock_out: time
            });
            hideLoader();

            if (res.data.status === 'success') {
                successToast(res.data['message']);
                $('#out-modal').modal('hide');

                getTodayAttendence();
            } else {
                errorToast(res.data['message']);
                $('#out-modal').modal('hide');

                getTodayAttendence();
            }
        })

    })
</script>
