<div class="modal" id="delete-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 450px;">

            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Are You Went To Delete "<span class="catName"></span>"?</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <div class="catID d-none">

                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="closeBtn" class="btn shadow-sm btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDelete" class="btn shadow-sm btn-danger">Delete</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $("#closeBtn").on('click', function(e) {
        e.preventDefault();
        $('#delete-modal').modal('hide');

    })
    $("#confirmDelete").on("click", async function() {
        let id = $(".catID").html();
        let res = await axios.post("/delete-customer", {
            id: id
        });
        // console.log(res.data);
        if (res.data.status === "success") {
            // e.preventDefault();
            $('#delete-modal').modal('hide');
            successToast(res.data.message);
            $("#insertData").trigger("reset");
            await getList();
        } else {
            errorToast("Something Went Wrong");
        }
    })
</script>
