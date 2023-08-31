<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br />
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-6"><label>6 Digit Code Here</label></div>
                        <div class="col-md-6">
                            <h4 class="pe-3 m-0 text-end"><span id="timer"></span> S</h4>
                        </div>

                    </div>
                    <input placeholder="Code" class="form-control" id="otp" type="text" />
                    <br />
                    <button onclick="VerifyOtp()" class="btn w-100 float-end btn-primary">Next</button>
                    <div class="float-end mt-3">
                        <span>

                            <a class="text-center ms-3 h6" href="{{ url('/otp') }}">Resent OTP</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //  Timer Set 
    const timerDuration = 60 * 10;

    function redirectTo(url) {
        window.location.href = url;
    }

    // Start the timer
    let remainingTime = timerDuration;
    const timerElement = document.getElementById("timer");
    let otpInput = document.getElementById("otp");

    function startTimer() {
        const timerInterval = setInterval(function() {
            remainingTime--;
            timerElement.textContent = remainingTime;

            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                otpInput.setAttribute("disabled", "true");
            }
        }, 1000);
    }
    startTimer();



    // Otp Varification 

    async function VerifyOtp() {

        let otpInput = document.getElementById('otp').value;
        // console.log(otpInput);

        if (otpInput.length === 0) {
            errorToast("Otp Required !");
        } else {


            let res = await axios.post('/verifiedOTP', {
                email: sessionStorage.getItem('email'),
                otp: otpInput
            });
            console.log(res);
            if (res.data['status'] === 'success') {
                successToast("Your Password Changed");
                window.location.href="/reset"

            } else if (res.data['code'] === '403') {
                errorToast("Your OTP Must be 6 Digite!");
            } else if (res.data['status'] === 'failed') {
                errorToast(res.data['message']);
            }

        }
    }
</script>
