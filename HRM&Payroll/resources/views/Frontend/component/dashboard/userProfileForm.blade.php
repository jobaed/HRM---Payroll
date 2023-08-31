<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control"
                                    type="email" />
                                <label for="" class="text-xs text-danger">You Can't Change Email</label>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="fname" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lname" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="phone" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" type="text" placeholder="User Password" class="form-control"
                                    type="password" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Your Selary</label>
                                <h4 class="bg-primary px-4 py-1 rounded text-light fw-bold">12,000</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100">
                <div class="card-body">
                    <h4>Additional Informationo</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0 d-flex align-items-center">
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
                            <div class="col-md-12 p-2">
                                <label>About Me</label>
                                <textarea name="" id="aboutMe" cols="30" rows="5" class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Save
                                    Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile()
    async function getProfile() {

        showLoader();
        let res = await axios.get('/user-profile-full');
        hideLoader()

        // console.log(res.data)


        if (res.status === 200 && res.data['status'] === 'success') {
            let data = res.data['data'];
            document.getElementById('oldImage').value = data['user_detail']['profile'];

            document.getElementById('email').value = data['email'];
            document.getElementById('fname').value = data['firstName'];
            document.getElementById('lname').value = data['lastName'];
            document.getElementById('phone').value = data['mobile'];
            document.getElementById('password').value = data['password'];

            if (data['user_detail']['profile']) {
                $('#newImg').attr("src", data['user_detail']['profile']);

            } else {
                $('#newImg').attr("src", 'images/default.jpg');
            }

            document.getElementById('aboutMe').value = data['user_detail']['about_me'];

            // console.log(oldImg);


        } else if (res.data['status'] === 'failed') {
            errorToast("Something Went Wrong");
        }




    }


    async function onUpdate() {


        let password = document.getElementById('password').value;
        let firstName = document.getElementById('fname').value;
        let lastName = document.getElementById('lname').value;
        let mobile = document.getElementById('phone').value;
        let productImg = document.getElementById('productImg');
        let aboutMe = document.getElementById('aboutMe').value;
        let oldImg = document.getElementById('oldImage').value;
        // console.log(oldImg);


        if (password.length === 0) {
            errorToast("Password Required !")
        } else if (firstName.length === 0) {
            errorToast("First Name Required")
        } else if (lastName.length === 0) {
            errorToast("Last Name Required")
        } else if (mobile.length === 0) {
            errorToast("Mobile Number Required !")
        } else {

            const imageFile = productImg.files[0];

            const formData = new FormData();
            formData.append('password', password);
            formData.append('firstName', firstName);
            formData.append('lastName', lastName);
            formData.append('mobile', mobile);
            formData.append('profile', imageFile);
            formData.append('about_me', aboutMe);
            formData.append('old_img', oldImg);

            // console.log(formData);
            showLoader();

            const res = await axios.post("/userUdate", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            
            // console.log(res.data);
            hideLoader();
            if (res.status === 200 && res.data['status'] === "success") {
                successToast('Profile Update');
                await getProfile();

            } else {
                errorToast(res.data['message']);
            }
        }
    }
</script>
