<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="insertData">
            <div class="modal-content">

                <div class="card-body">
                    <h4>Employee Register</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <h6>Basic Information</h6>
                            <div class="col-md-6 p-2">
                                <label>First Name</label>
                                <input id="fname" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Last Name</label>
                                <input id="lname" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control"
                                    type="password" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Role</label>
                                <select name="" id="role" required class="form-control">
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
                                    <input type="hidden" name="" id="oldImage">
                                    <img class="w-40" id="newImg" src="{{ asset('images/default.jpg') }}" />
                                </div>
                                <div class="col-md-8 p-2">
                                    <label>Change Image</label>
                                    <input type="file" oninput="newImg.src=window.URL.createObjectURL(this.files[0])"
                                        accept="image/png, image/gif, image/jpeg" id="profilePic" class="form-control"
                                        value="">
                                    <div class="col-md-6">
                                        <label>Selary</label>
                                        <input id="selary" placeholder="Selary" class="form-control"
                                            type="number" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <label>About Me</label>
                                <textarea name="" id="aboutMe" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="CloseCreateCust" class="btn  btn-sm btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-sm  btn-primary" id="submitEmployee">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#CloseCreateCust").on('click', async function(e) {
        e.preventDefault();
        // $('#delete-modal').modal('hide');

    })


    $("#submitEmployee").on('click', async function(e) {
        e.preventDefault();

        let password = document.getElementById('password').value;
        let firstName = document.getElementById('fname').value;
        let lastName = document.getElementById('lname').value;
        let mobile = document.getElementById('mobile').value;
        let email = document.getElementById('email').value;
        let profileImage = document.getElementById('profilePic');
        let aboutMe = document.getElementById('aboutMe').value;
        let selary = document.getElementById('selary').value;
        let role = document.getElementById('role').value;
        // console.log(role);


        if (password.length === 0) {
            errorToast("Password Required !")
        } else if (firstName.length === 0) {
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

            console.log(formData);
            showLoader();

            const res = await axios.post("/userApiData", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            console.log(res.data);
            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast('Create Employee');

                $('#create-modal').modal('hide');
                $("#insertData").trigger("reset");
                await getList();

            } else {
                errorToast(res.data['message']);
            }
        }


    })
</script>
