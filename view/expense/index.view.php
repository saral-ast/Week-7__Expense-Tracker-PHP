<!-- Expense Form -->
<div id="expenseModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-8 rounded-xl shadow-xl w-11/12 max-w-lg">
        <h2 class="text-2xl font-semibold mb-6 text-[#223843] text-center">Add New Expense</h2>
        <form id="expenseForm" class="space-y-4">
            <div>
                <label for="title" class="block text-gray-700 font-medium">Expense Name</label>
                <input type="text" id="title" name="title"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    placeholder="Enter expense name" required />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="amount" class="block text-gray-700 font-medium">Amount</label>
                <input type="number" id="amount" name="amount"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    placeholder="Enter amount" step="0.01" required />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                
                <select id="group_id" name="group_id"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    required>
                    <option value="">Choose a Group</option>
                  </select>
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="expenseDate" class="block text-gray-700 font-medium">Date</label>
                <input type="date" id="expenseDate" name="date"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    required />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" id="closeExpenseModal"
                    class="bg-gray-300 text-[#223843] px-5 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-[#223843] text-white px-6 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                    Add Expense
                </button>
            </div>
        </form>
    </div>
</div>


<div id="deleteModalExpense" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p id="deleteMessageExpense" class="mb-4 text-gray-600"></p>
        <form id="deleteFormExpense">
        <input type="hidden" name="id" id="deleteExpenseId">
        <div class="flex justify-end gap-4">
            <button type="button" id="closeDeleteModalExpense" class="bg-gray-300 text-black px-5 py-2 rounded-lg hover:bg-gray-900 hover:text-white transition font-medium shadow-md hover:shadow-lg inline-block text-center">Cancel</button>
            <button type="submit" class="bg-gray-100 border border-red-500 text-red-900 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition">Delete</button>
        </div>
        </form>
    </div>
    </div>


<script>
$(document).ready(function () {
     loadCategory();
   
    let today = new Date().toISOString().split('T')[0];
    

    // Open Expense Modal
    $("#addExpensebtn").click(function () {
        $("#expenseDate").val(today); 
        $("#expenseModal").removeClass("hidden").addClass("flex");
    });

    // Close Expense Modal
    $("#closeExpenseModal").click(function () {
        $('#expenseForm')[0].reset();
        $("#expenseModal").addClass("hidden");
    });

    // Custom validation for no future dates
    $.validator.addMethod("noFutureDate", function(value, element) {
        let selectedDate = new Date(value + "T00:00:00Z"); // Convert to UTC date
        let currentDate = new Date(new Date().toISOString().split('T')[0] + "T00:00:00Z"); // Today’s date in UTC
        return selectedDate <= currentDate;
    }, "You cannot select a future date!");

    $("#expenseForm").validate({
        rules: {
            title: { required: true, minlength: 2, maxlength: 50 },
            amount: { required: true, min: 1 },
            group_id: { required: true },
            date: { required: true, noFutureDate: true }
        },
        messages: {
            title: { required: "Please enter an expense name", minlength: "Minimum 2 characters", maxlength: "Maximum 50 characters" },
            amount: { required: "Please enter an amount", min: "Amount must be greater than 0" },
            group_id: { required: "Please select a group" },
            date: { required: "Please select a date", noFutureDate: "Future dates are not allowed!" }
        },
        errorPlacement: function (error, element) {
            $(element).next(".error-message").html(error);
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
                title: $("#title").val().trim(),
                amount: $("#amount").val().trim(),
                group_id: $("#group_id").val(),
                date: $("#expenseDate").val()
            };

            $.ajax({
                url: "/expense",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $("#expenseModal").addClass("hidden");
                        $('#expenseForm')[0].reset(); // Reset form after submission
                        updateDashboard();
                        loadExpenses(); // Reload expenses
                        loadGroups(); // Reload groups
                    } else {
                        toastr.error(response.message, "Error");
                    }
                },
                error: function (xhr) {
                    console.error("AJAX Error:", xhr.responseText);
                    toastr.error("Failed to add expense. Please try again.", "Error");
                }
            });
        }
    });

    $(document).on("click", ".delete-expense", function () {
            let expenseId = $(this).data("id");
            $("#deleteId").val(expenseId);
            $("#deleteMessage").text("Are you sure you want to delete this expense?");
            $("#deleteModal").removeClass("hidden").addClass("flex");
            $("#deleteFormExpense").removeClass("hidden");
        });

        // Close Delete Modal
        $("#closeDeleteModal").click(function () {
            $("#deleteModal").addClass("hidden");
            $("#deleteFormExpense").addClass("hidden");
        });

        // Handle AJAX Delete Request
        $("#deleteFormExpense").submit(function (e) {
            e.preventDefault();


            let expenseId = $("#deleteId").val();
            console.log(expenseId);
            $.ajax({
                url: "/expense",
                type: "DELETE", // Change from DELETE to POST
                data: { id: expenseId, method: "DELETE" }, // Send method override
                dataType: "json",
                success: (response) => {
                    if (response.success) {
                        toastr.success(response.message);
                        loadGroups(); // Refresh group list
                        loadExpenses(); // Refresh expense list
                        updateDashboard();
                       
                        
                    } else {
                        toastr.error(response.error, "Error");
                    }
                    $("#deleteModal").addClass("hidden");
                    $("#deleteFormExpense").addClass("hidden");
                },
                error: () => {
                    toastr.error("Failed to delete expense. Please try again.", "Server Error");
                    
                    $("#deleteModal").addClass("hidden");
                    $("#deleteFormExpense").addClass("hidden");
                }
            });
        });

      
    })

    function loadCategory() {
    $.ajax({
        type: "GET",
        url: "/api/groups",
        success: function (response) {
            if (!Array.isArray(response)) {
                console.error("Error: API did not return an array!", response);
                return;
            }

            let group_id = $("#group_id"); // Select dropdown correctly
            group_id.empty(); // Clear previous options
            group_id.append(`<option value="">Choose a Group</option>`); // Default option

            $.each(response, function (index, group) {
                let option = `<option value="${group.id}">${group.group_name}</option>`;
                group_id.append(option);
            });
        },
        error: function (response) { // Moved outside success function
            console.error("AJAX Error:", response.responseText);
            toastr.error("Failed to load groups. Please try again.", "Error");
        }
    });
}

</script>
