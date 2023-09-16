<div class="modal" id="profile-show-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="">
            <div class="modal-header" style="position: relative">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class=" mt-3 text-warning"> Employee Profile</h4>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="closeBtn" class="btn shadow-sm btn-primary closeButton py-2 px-3"
                            data-bs-dismiss="modal"><i class="fas fa-times fw-bold"
                                style="font-size: 20px;"></i></button>

                    </div>
                </div>

            </div>
            <div class="modal-body px-5 mb-4">
                <div>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="">
                                <div class=" text-center">
                                    <img src="{{ asset('https://dummyimage.com/300x360/e8e8e8/000000.png&text=Profile') }}"
                                        class="img-fluid rounded" alt="" id="employeeProfile">
                                    <div class="bg-primary px-3 rounded mt-3">
                                        <h5 class="text-light fw-bold catName">Basic Information</h5>
                                    </div>
                                    <h6 class="text-warning"> <span class="role">Engineere </span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="bg-primary px-3 rounded " style="display: inline-block">
                                <h4 class="text-light fw-bold p-0 m-0" style="display: inline-block">Basic Information:
                                </h4>

                            </div>
                            <div class="p-3 bg-light mt-2 rounded">
                                <div class="d-flex align-items-center">
                                    <h6 class="me-3"><i class="fas fa-phone"></i></h6>
                                    <h6 id="phone"></h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <h6 class="me-3" style="padding-top: 12px;"><i class="fas fa-envelope"></i></h6>
                                    <h6 id="employeeEmail" class="mb-0">
                                    </h6>
                                </div>
                            </div>
                            <div class="bg-primary px-3 mt-4 rounded " style="display: inline-block">
                                <h4 class="text-light fw-bold p-0 m-0" style="display: inline-block">About ME: </h4>

                            </div>
                            <div class="p-3 bg-light mt-2 rounded">
                                <div class="d-flex align-items-center">
                                    <h6 class="me-3"><i class="fas fa-quote-left"></i></h6>
                                    <h6 id="employeeAboutMe"></h6>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>

            </div>

            <div class="modal-footer " style="justify-content: flex-start">
                <div class="bg-primary px-3 mt-2 rounded " style="display: inline-block">
                    <h5 class="text-light fw-bold p-0 m-0" style="display: inline-block">Selary: <span
                            id="employeeSelary"></span></h5>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $("#closeBtn").on('click', function(e) {
        e.preventDefault();
        $('#delete-modal').modal('hide');
    });
</script>
