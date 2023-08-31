<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br />
                    <input id="email" placeholder="User Email" class="form-control" type="email" />
                    <br />
                    <input id="pass" placeholder="User Password" class="form-control" type="password" />
                    <br />
                    <button onclick="SubmitLogin()" class="btn w-100 btn-primary">Next</button>
                    <hr />
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ url('/registration') }}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ url('/otp') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function SubmitLogin() {

        let email = document.getElementById('email').value;
        let pass = document.getElementById('pass').value;
        if (email.length === 0) {
            errorToast('Email Required !')
        } else if (pass.length === 0) {
            errorToast('Password Required !')
        } else {


            showLoader();
            let res = await axios.post("/userLogin", {
                email: email,
                password: pass,
            })
            hideLoader();

            if (res.data['status'] === 'success') {
                successToast("Login Successful");
                window.location.href = "/dashboard";
            } else if (res.data['status'] === 'failed') {
                errorToast("Invalid User Or Password");

            }




        }
    }
</script>
