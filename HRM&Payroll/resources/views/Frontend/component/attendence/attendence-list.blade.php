<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>My Attendence</h4>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>Date</th>
                            <th>In </th>
                            <th>Out</th>
                            <th>Duty Time</th>
                            <th>Issue</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">
                        {{-- Table Data --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    getListemployeelist();


    async function getListemployeelist() {
        // swal("My title", "My description", "danger");

        showLoader();
        let res = await axios.get("/my-attendence");
        hideLoader();

        console.log(res.data);


        let tableData = $('#tableData');
        let tableList = $('#tableList');

        tableData.DataTable().destroy();
        tableList.empty();


        res.data['data'].forEach(function(item, index) {

            let dutyTime = null;

            // Time strings
            const timeString1 = item.clock_in;
            const timeString2 = item.clock_out;

            // Validate the time strings
            const timeFormatRegex = /^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/;
            if (!timeFormatRegex.test(timeString1) || !timeFormatRegex.test(timeString2)) {
                dutyTime = 'Error TimeFream';
            } else {
                // Split the time strings into hours, minutes, and seconds
                const [hours1, minutes1, seconds1] = timeString1.split(':').map(Number);
                const [hours2, minutes2, seconds2] = timeString2.split(':').map(Number);

                // Calculate the time difference
                const totalSeconds1 = hours1 * 3600 + minutes1 * 60 + seconds1;
                const totalSeconds2 = hours2 * 3600 + minutes2 * 60 + seconds2;
                const timeDifferenceInSeconds = Math.abs(totalSeconds2 - totalSeconds1);

                // Calculate hours, minutes, and seconds from the time difference in seconds
                const hoursDiff = Math.floor(timeDifferenceInSeconds / 3600);
                const minutesDiff = Math.floor((timeDifferenceInSeconds % 3600) / 60);
                const secondsDiff = timeDifferenceInSeconds % 60;

                // Output the time difference
                dutyTime = `${hoursDiff} h : ${minutesDiff} m : ${secondsDiff} s`;
            }


            const dateString = item.updated_at;
            const datePart = dateString.match(/^\d{4}-\d{2}-\d{2}/)[0];


            let row = `<tr>
                    <td >${datePart}</td>`;


            if (item.clock_in === null) {
                row += `
                    <td><span class="bg-danger text-white rounded px-4 py-1"> Absens </span></td>
                    <td> -- </td>
                    <td > -- </td>
                    <td > <button class="bg-info btn btn-sm text-white"> Apply <i class="bi bi-person-exclamation" style="font-size: 18px"></i> </button> </td>
                </tr>`;
            } else if (item.clock_out === null) {
                row += `
                    <td>${item.clock_in}</td>
                    <td> <span class="bg-warning text-dark rounded px-4 py-1"> Not Close </span> </td>
                    <td > -- </td>
                    <td > <button class="bg-info btn btn-sm text-white"> Apply <i class="bi bi-person-exclamation" style="font-size: 18px"></i> </button> </td>
                </tr>`;
            } else {
                row += `
                    <td>${item.clock_in}</td>
                    <td> ${item.clock_in} </td>
                    <td><span class="bg-primary text-white  rounded px-4 py-1"> ${dutyTime} </span></td>
                    <td></td>
                </tr>`;
            }

            tableList.append(row);


        })


        $('.editBtn').on('click', async function() {
            let id = $(this).data('id');


            $("#update_id").val(id);

            showLoader();
            let res = await axios.post('/user-profile-full', {
                id: id
            });



            let data = res.data['data'];
            // console.log(data);

            let role = data['role'];
            document.getElementById('eoldImage').value = data['user_detail']['profile'];

            document.getElementById('eemail').value = data['email'];
            document.getElementById('efname').value = data['firstName'];
            document.getElementById('elname').value = data['lastName'];
            document.getElementById('emobile').value = data['mobile'];
            document.getElementById('eselary').value = data['user_detail']['selary'];
            document.getElementById('update_id').value = data['id'];


            if (data['user_detail']['profile'] === 'noImage') {

                $('#enewImg').attr("src", 'images/default.jpg');

            } else if (data['user_detail']['profile']) {
                $('#enewImg').attr("src", data['user_detail']['profile']);
            } else {
                $('#enewImg').attr("src", 'images/default.jpg');
            }
            document.getElementById('eaboutMe').value = data['user_detail']['about_me'];


            $('#erole > option').each(function() {
                if ($(this).val() === role) {
                    $(this).attr("selected", "selected");
                }
            });

            hideLoader()


            $("#update-modal").modal('show');
            $("#update_id").val(id);
        })

        $('.delete').on('click', function() {
            let id = $(this).data('id');
            let Name = $(this).data('name');
            $(".catName").text(Name);
            $("#delete-modal").modal('show');
            $(".catID").html(id);
        })


        $('.show').on('click', async function() {
            let id = $(this).data('id');
            $("#profile-show-modal").modal('show');
            $(".catID").html(id);


            showLoader();
            let res = await axios.post("/single-employee-list", {
                id: id
            });
            hideLoader();

            console.log(res.data.data);
            console.log(res.data.data['user_detail']['profile']);

            $(".catName").text(res.data.data['firstName'] + " " + res.data.data['lastName']);


            if (res.data.data['user_detail']['profile'] != 'noImage') {
                $("#employeeProfile").attr("src", res.data.data['user_detail']['profile']);
            }

            // $(".role").text(res.data.data['role']);
            if (res.data.data['role'] == 'user') {
                $(".role").text('Employee');
            }
            $("#phone").text(res.data.data['mobile']);
            $("#employeeEmail").text(res.data.data['email']);

            $("#employeeAboutMe").text(res.data.data['user_detail']['about_me']);
            $("#employeeSelary").text(res.data.data['user_detail']['selary']);


        })


        tableData.DataTable({
            order: [
                [0, 'desc']
            ],
            lengthMenu: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            language: {
                paginate: {
                    next: '&#8594;', // or '→'
                    previous: '&#8592;' // or '←'
                }
            }
        });
    }
</script>
