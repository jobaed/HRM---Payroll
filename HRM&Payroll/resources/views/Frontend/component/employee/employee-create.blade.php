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
                                <input id="firstName" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-6 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text" />
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
                                        accept="image/png, image/gif, image/jpeg" id="productImg" class="form-control"
                                        value="">
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
                    <button type="submit" class="btn btn-sm  btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    async function onRegistration() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let firstName = document.getElementById('firstName').value;
        let lastName = document.getElementById('lastName').value;
        let mobile = document.getElementById('mobile').value;
        if (email.length === 0) {
            errorToast("Email Required !");
        } else if (password.length === 0) {
            errorToast("Password Required !")
        } else if (firstName.length === 0) {
            errorToast("First Name Required")
        } else if (lastName.length === 0) {
            errorToast("Last Name Required")
        } else if (mobile.length === 0) {
            errorToast("Mobile Number Required !")
        } else {


            showLoader();
            let data = {
                firstName: firstName,
                lastName: lastName,
                email: email,
                password: password,
                mobile: mobile
            }
            let res = await axios.post("/userApiData", data)
            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast(res.data['message']);
                window.location.href = "/login"
            } else {
                errorToast(res.data['message']);
            }



        }
    }
</script>
