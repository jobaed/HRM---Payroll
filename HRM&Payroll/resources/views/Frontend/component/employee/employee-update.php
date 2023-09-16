<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="updateForm">
            <div class="modal-content">
                <div class="card-body">
                    <h4>Update Employee</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <h6>Basic Information</h6>
                            <div class="col-md-6 p-2">
                                <input type="hidden" name="" id="update_id">
                                <label>First Name</label>
                                <input id="efname" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Last Name</label>
                                <input id="elname" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Email Address</label>
                                <input id="eemail" placeholder="User Email" class="form-control" type="email" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Mobile Number</label>
                                <input id="emobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Role</label>
                                <select name="" id="erole" required class="form-control">
                                    <option value="">Select Role</option>
                                    <option value="user">user</option>
                                    <option value="manager">manager</option>
                                    <option value="admin">admin</option>
                                </select>
                            </div>

                            <h6 class="pt-3">Aditional Information</h6>
                            <div class="d-flex align-items-center">
                                <div class="col-md-4 p-2">
                                    <label>Present Profile</label><br>
                                    <input type="hidden" name="" id="eoldImage">
                                    <img class="w-40" id="enewImg" src="{{ asset('images/default.jpg') }}" />
                                </div>
                                <div class="col-md-8 p-2">
                                    <label>Change Image</label>
                                    <input type="file" oninput="enewImg.src=window.URL.createObjectURL(this.files[0])"
                                        accept="image/png, image/gif, image/jpeg" id="eprofilePic" class="form-control"
                                        value="">
                                    <div class="col-md-6">
                                        <label>Selary</label>
                                        <input id="eselary" placeholder="Selary" class="form-control"
                                            type="text" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <label>About Me</label>
                                <textarea name="" id="eaboutMe" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="ECloseCreateCust" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-primary" id="EsubmitEmployee">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#ECloseCreateCust").on('click', async function(e) {
        e.preventDefault();
        // $('#delete-modal').modal('hide');

    })


    $("#EsubmitEmployee").on('click', async function(e) {
        e.preventDefault();

        
        let firstName = document.getElementById('efname').value;
        let lastName = document.getElementById('elname').value;
        let mobile = document.getElementById('emobile').value;
        let email = document.getElementById('eemail').value;
        let profileImage = document.getElementById('eprofilePic');
        let aboutMe = document.getElementById('eaboutMe').value;
        let selary = document.getElementById('eselary').value;
        let role = document.getElementById('erole').value;
        let oldImg = document.getElementById('eoldImage').value;
        let id = document.getElementById('update_id').value;
        // console.log(role);


         if (firstName.length === 0) {
            errorToast("First Name Required")
        } else if (lastName.length === 0) {
            errorToast("Last Name Required")
        } else if (mobile.length === 0) {
            errorToast("Mobile Number Required !")
        } else {

            const imageFile = profileImage.files[0];

            const formData = new FormData();
            formData.append('password', password);
            formData.append('firstName', firstName);
            formData.append('lastName', lastName);
            formData.append('mobile', mobile);
            formData.append('profile', imageFile);
            formData.append('about_me', aboutMe);
            formData.append('email', email);
            formData.append('selary', selary);
            formData.append('role', role);
            formData.append('old_img', oldImg);
            formData.append('id', id);

            // console.log(formData);
            showLoader();

            const res = await axios.post("/userUdate", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            console.log(res.data);


            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast('Update Employee');

                $('#update-modal').modal('hide');
                $("#updateForm").trigger("reset");
                await getListemployeelist();

            } else {
                errorToast(res.data['message']);
            }
        }


    })
</script>
