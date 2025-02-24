<?php require base_path('view/partials/head.php'); ?>
<?php require base_path('view/partials/banner.php'); ?>


<!-- Group Form -->
<div class="flex justify-center items-center bg-gray-100 px-4 justify-center mt-10">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold text-[#223843] text-center mb-6">Create a New Group</h2>

        <form action="/groups" method="POST" id="groupForm">
            <input type="hidden" id="id" name="id" value="group" />

            <!-- Group Name Input -->
            <div class="mb-6">
                <label for="groupName" class="block text-md font-medium text-[#223843] mb-2">
                    Group Name
                </label>

                <input
                    type="text"
                    id="groupName"
                    name="groupName"
                    class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#223843] focus:outline-none transition-all duration-300 shadow-sm"
                    placeholder="Enter group name"
                    value="<?= old('groupName') ?>"
                   
                />
                <span id="groupNameError" class="text-red-500 text-sm mt-1 block"><?= $errors['name'] ?? '' ?></span>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
            <a href="/" class="bg-gray-300 text-black px-5 py-2 rounded-lg hover:bg-gray-900 hover:text-white transition 
              font-medium shadow-md hover:shadow-lg inline-block text-center">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-300 hover:text-black transition 
              font-medium shadow-md hover:shadow-lg inline-block text-center hover:cursor-pointer">
                    Add Group
                </button>
            </div>
        </form>
    </div>
</div>



<script>
$(document).ready(function() {
    $("#groupForm").validate({
        rules: {
            groupName: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            groupName: {
                required: "Please enter a group name",
                minlength: "Group name must be at least 2 characters"
            }
        },
        errorPlacement:  (error, element) =>{
            $("#groupNameError").html(error);
        },
        highlight: (element) => {
            $(element).addClass("border-red-500").removeClass("border-gray-300");
        },
        unhighlight: (element) => {
            $(element).removeClass("border-red-500").addClass("border-gray-300");
        }
    });
});
</script>
<?php require_once base_path('view/partials/back_button.php'); ?>
<?php require base_path('view/partials/footer.php'); ?>
