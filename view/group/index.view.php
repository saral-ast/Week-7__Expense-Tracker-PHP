    <!-- Add Group Modal -->
<div id="addGroupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-[#223843] text-center mb-6">Create a New Group</h2>
        <form id="addGroupForm">
      
            <!-- Group Name Input -->
            <div class="mb-6">
                <label for="groupName" class="block text-md font-medium text-[#223843] mb-2">Group Name</label>
                <input 
                    type="text" 
                    id="groupName" 
                    name="groupName" 
                    class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#223843] focus:outline-none transition-all duration-300 shadow-sm" 
                    placeholder="Enter group name"
                >
                <span id="groupNameError" class="text-red-500 text-sm mt-1 block"></span>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <button type="button" id="closeAddModal" class="bg-gray-300 text-black px-5 py-2 rounded-lg hover:bg-gray-900 hover:text-white transition font-medium shadow-md hover:shadow-lg inline-block text-center">Cancel</button>
                <button type="submit" class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-300 hover:text-black transition font-medium shadow-md hover:shadow-lg inline-block text-center hover:cursor-pointer">Add Group</button>
            </div>
        </form>
    </div>
</div>



    <script>
    $(document).ready(function () {
    

        // Open Add Group Modal
        $("#addGroupBtn").click(function () {
            $("#addGroupModal").removeClass("hidden").addClass("flex");
        });

        // Close Add Group Modal
        $("#closeAddModal").click(function () {
            $("#addGroupModal").addClass("hidden");
        });

        // Submit Add Group Form (AJAX)
        $("#addGroupForm").validate({
            rules: {
                groupName: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                }
            },
            messages: {
                groupName: {
                    required: "Group name is required.",
                    minlength: "Group name must be at least 3 characters.",
                    maxlength: "Group name must not exceed 50 characters."
                }
            },
            errorPlacement: function (error, element) {
                $("#groupNameError").html(error);
            },
            highlight: function (element) {
                $(element).addClass("border-red-500").removeClass("border-gray-300");
            },
            unhighlight: function (element) {
                $(element).removeClass("border-red-500").addClass("border-gray-300");
            },
            submitHandler: function (form) {
                let groupName = $("#groupName").val().trim();
                        $.ajax({
                        url: "/groups",
                        type: "POST",
                        data: { group_name: groupName },
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $("#addGroupModal").addClass("hidden");
                                loadGroups();
                                loadCategory(); // Refresh group list
                                updateDashboard(); // Refresh dashboard
                               
                            } else {
                                $("#groupNameError").text(response.error);
                                toastr.error(response.error, "Validation Error");
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = "Failed to add group. Please try again.";
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                $("#groupNameError").text(errorMessage);
                                toastr.error(errorMessage, "Server Error");
                            }
                        });
                        $("#addGroupForm")[0].reset();
                }
        });

        // Open Delete Confirmation Modal
        $(document).on("click", ".delete-group", function () {
            let groupId = $(this).data("id");
            $("#deleteId").val(groupId);
            $("#deleteMessage").text("Are you sure you want to delete this group?");
            $("#deleteModal").removeClass("hidden").addClass("flex");
            $("#deleteFormGroup").removeClass("hidden");
        });

        // Close Delete Modal
        $("#closeDeleteModal").click(function () {
            $("#deleteModal").addClass("hidden");
            $("#deleteFormGroup").addClass("hidden");
        });

        // Handle AJAX Delete Request
        $("#deleteFormGroup").submit(function (e) {
            e.preventDefault();

            let groupId = $("#deleteId").val();
            console.log(groupId);

            $.ajax({
                url: "/group",
                type: "DELETE", // Change from DELETE to POST
                data: { id: groupId, method: "DELETE" }, // Send method override
                dataType: "json",
                success: (response) => {
                    if (response.success) {
                        toastr.success(response.message);
                        loadGroups(); // Refresh group list
                        loadExpenses(); // Refresh expense list
                        loadCategory(); // Refresh category list
                        updateDashboard(); // Refresh dashboard
                    } else {
                        toastr.error(response.error, "Error");
                    }
                    $("#deleteModal").addClass("hidden");
                    $("#deleteFormGroup").addClass("hidden");
                },
                error: () => {
                    toastr.error("Failed to delete group. Please try again.", "Server Error");
                    $("#deleteModal").addClass("hidden");
                    $("#deleteFormGroup").addClass("hidden");
                }
            });
        });      
    });
</script>
