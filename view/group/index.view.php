<?php require base_path('view/partials/head.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Add Group Modal -->
    <div id="addGroupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-[#223843] text-center mb-6">Create a New Group</h2>
        <form id="addGroupForm">
            <input type="hidden" id="id" name="id" value="group" />
            
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

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p id="deleteMessage" class="mb-4 text-gray-600"></p>
        <form id="deleteForm">
        <input type="hidden" name="id" id="deleteGroupId">
        <div class="flex justify-end gap-4">
            <button type="button" id="closeDeleteModal" class="bg-gray-300 text-black px-5 py-2 rounded-lg hover:bg-gray-900 hover:text-white transition font-medium shadow-md hover:shadow-lg inline-block text-center">Cancel</button>
            <button type="submit" class="bg-gray-100 border border-red-500 text-red-900 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition">Delete</button>
        </div>
        </form>
    </div>
    </div>

    <script>
    $(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "3000"
    };

    loadGroups(); // Initial load of groups

    // Open Add Group Modal
    $("#addGroupBtn").click(function () {
        $("#groupName").val(""); // Clear input
        $("#groupNameError").text(""); // Clear error
        $("#addGroupModal").removeClass("hidden").addClass("flex");
    });

    // Close Add Group Modal
    $("#closeAddModal").click(function () {
        $("#addGroupModal").addClass("hidden");
    });

    // Submit Add Group Form (AJAX)
    $("#addGroupForm").submit(function (event) {
        event.preventDefault();
        let groupName = $("#groupName").val().trim();
        $("#groupNameError").text(""); // Clear error message

        if (groupName.length < 2) {
        $("#groupNameError").text("Group name must be at least 2 characters.");
        return;
        }

        $.ajax({
        url: "/groups",
        type: "POST",
        data: { group_name: groupName },
        dataType: "json",
        success: function (response) {
            if (response.success) {
            toastr.success(response.message);
            $("#addGroupModal").addClass("hidden");
            loadGroups(); // Refresh group list
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
    });

    // Open Delete Confirmation Modal
    $(document).on("click", ".delete-group", function () {
        let groupId = $(this).data("id");
        $("#deleteGroupId").val(groupId);
        $("#deleteMessage").text("Are you sure you want to delete this group?");
        $("#deleteModal").removeClass("hidden").addClass("flex");
    });

    // Close Delete Modal
    $("#closeDeleteModal").click(function () {
        $("#deleteModal").addClass("hidden");
    });

    // Handle AJAX Delete Request
    $("#deleteForm").submit(function (e) {
        e.preventDefault();

        let groupId = $("#deleteGroupId").val();

        $.ajax({
        url: "/group",
        type: "DELETE",
        data: { id: groupId },
        dataType: "json",
        success: function (response) {
            if (response.success) {
            toastr.success(response.message);
            loadGroups(); // Refresh group list
            } else {
            toastr.error(response.error, "Error");
            }
            $("#deleteModal").addClass("hidden");
        },
        error: function () {
            toastr.error("Failed to delete group. Please try again.", "Server Error");
            $("#deleteModal").addClass("hidden");
        }
        });
    });

    // Function to Load Groups
    
    });
    </script>


    <?php require base_path('view/partials/footer.php'); ?> 