    <!-- Add Group Modal -->
    <div id="editGroupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-[#223843] text-center mb-6">Edit a Group</h2>
        <form id="editGroupForm">
      
            <!-- Group Name Input -->
            <div class="mb-6">
            <input type="hidden" id="editGroupId" name="id">
                <label for="groupName" class="block text-md font-medium text-[#223843] mb-2">Group Name</label>
                <input 
                    type="text" 
                    id="editgroupName" 
                    name="editgroupName" 
                    class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#223843] focus:outline-none transition-all duration-300 shadow-sm" 
                    placeholder="Enter group name"
                    >
                <span id="groupNameError" class="text-red-500 text-sm mt-1 block"></span>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <button type="button" id="editcloseAddModal" class="bg-gray-300 text-black px-5 py-2 rounded-lg hover:bg-gray-900 hover:text-white transition font-medium shadow-md hover:shadow-lg inline-block text-center">Cancel</button>
                <button type="submit" class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-300 hover:text-black transition font-medium shadow-md hover:shadow-lg inline-block text-center hover:cursor-pointer">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
     
        
        $('#editcloseAddModal').click(function () {
            $('#editGroupModal').addClass('hidden').removeClass('flex');
        });
        $(document).on("click", ".edit-group", function () {

            $('#editGroupModal').removeClass('hidden').addClass('flex');
            

            $.ajax({
                type: "GET",
                url: "/group/edit",
                data: {id: $(this).data('id')},
                success: function (response) {
                    $('#editgroupName').val(response.group_name);
                    $('#editGroupId').val(response.id);               
                },
                error:  (response)=>{
                    console.log('error',response);
                }
            });
        });
        
        
        $('#editGroupForm').validate({
            rules: {
                editgroupName: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                }
            },
            messages: {
                editgroupName: {
                    required: "Group Name is required",
                    minlength: "Group Name must be at least 3 characters",
                    maxlength: "Group Name must not exceed 50 characters"
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
                $(element).next(".error-message").html("");
            }, 
            
            submitHandler: function (form) {
                let formData = {
                        id: $('#editGroupId').val(),
                        name: $('#editgroupName').val(),
                    }
                    
              
                $.ajax({
                    type: "PATCH",
                    url: "/groups",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    dataType: "json",
                    success:  (response) =>{
                        if(response.success){
                            toastr.success("Group updated successfully!");
                            $('#editGroupModal').addClass('hidden').removeClass('flex');
                            loadGroups();
                            loadExpenses();
                            loadCategory();
                        }else{
                            toastr.error(response.message);
                        }
                        
                    },
                    error:  (response) => {
                        console.error("API Error:", response); // Debugging Step
                        toastr.error("An error occurred while updating the group!");
                    }
                });
            }
        });
});
</script>

