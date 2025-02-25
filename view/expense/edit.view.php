<!-- Edit Expense Modal -->
<div id="editExpenseModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-8 rounded-xl shadow-xl w-11/12 max-w-lg">
        <h2 class="text-2xl font-semibold mb-6 text-[#223843] text-center">Edit Expense</h2>
        <form id="editExpenseForm" class="space-y-4">
            <input type="hidden" id="edit_expense_id" name="id"> <!-- Hidden input for Expense ID -->

            <div>
                <label for="edit_title" class="block text-gray-700 font-medium">Expense Name</label>
                <input type="text" id="edit_title" name="title"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    placeholder="Enter expense name" />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="edit_amount" class="block text-gray-700 font-medium">Amount</label>
                <input type="number" id="edit_amount" name="amount"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    step="0.01" placeholder="Enter expense name" />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="edit_group_id" class="block text-gray-700 font-medium">Select Group</label>
                <select id="edit_group_id" name="group_id"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    required>
                    <option value="">Choose a Group</option>
                    <!-- Groups will be populated dynamically -->
                </select>
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="edit_expenseDate" class="block text-gray-700 font-medium">Date</label>
                <input type="date" id="edit_expenseDate" name="date"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    required />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" id="closeEditExpenseModal"
                    class="bg-gray-300 text-[#223843] px-5 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-[#223843] text-white px-6 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                    Update Expense
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Open Edit Expense Modal and Load Data
        $(document).on("click", ".edit-expense", function () {
            let expenseId = $(this).data("id");
            $('#editExpenseModal').removeClass('hidden').addClass('flex');

            $.ajax({
                url: "/expense/edit",
                type: "GET",
                data: { id: expenseId },
                dataType: "json",
                success: function (expense) {
                    console.log(expense);
                    $("#edit_expense_id").val(expense.id);
                    $("#edit_title").val(expense.title);
                    $("#edit_amount").val(expense.amount);
                    $("#edit_expenseDate").val(expense.date);

                    // Load groups and set the selected group
                    editloadCategory(expense.group_id);
                },
                error: function () {
                    toastr.error("Failed to fetch expense data", "Error");
                }
            });
        });

        // Close Edit Expense Modal
        $("#closeEditExpenseModal").click(function () {
            $("#editExpenseModal").addClass("hidden");
            $("#editExpenseForm")[0].reset();
            $(".error-message").text(""); // Clear validation messages
        });
        $.validator.addMethod("noFutureDate", function(value, element) {
        let selectedDate = new Date(value + "T00:00:00Z"); // Convert to UTC date
        let currentDate = new Date(new Date().toISOString().split('T')[0] + "T00:00:00Z"); // Today’s date in UTC
        return selectedDate <= currentDate;
    }, "You cannot select a future date!");

        // jQuery Validation Plugin for form validation
        $("#editExpenseForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },
                amount: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                group_id: {
                    required: true
                },
                date: {
                    required: true,
                    date: true
                }, 
                date: { 
                    required: true, 
                    noFutureDate: true 
                }
            },
            messages: {
                title: {
                    required: "Expense name is required",
                    minlength: "Title must be at least 3 characters"
                },
                amount: {
                    required: "Amount is required",
                    number: "Enter a valid amount",
                    min: "Amount must be greater than zero"
                },
                group_id: {
                    required: "Please select a group"
                },
                date: {
                    required: "Date is required",
                    date: "Enter a valid date"
                },
                date: { required: "Please select a date", noFutureDate: "Future dates are not allowed!" }
            },
            errorPlacement: function (error, element) {
                $(element).next(".error-message").html(error);
            },
            submitHandler: function (form) {
                let formData = {
                    id: $("#edit_expense_id").val(),
                    title: $("#edit_title").val().trim(),
                    amount: $("#edit_amount").val().trim(),
                    group_id: $("#edit_group_id").val(),
                    date: $("#edit_expenseDate").val()
                };

                $.ajax({
                    url: "/expenses",
                    type: "PATCH",
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message);
                            $("#editExpenseModal").addClass("hidden");
                            $("#editExpenseForm")[0].reset();
                            loadExpenses();
                            loadGroups(); // Refresh group list
                            updateDashboard();
                        } else {
                            toastr.error(response.message, "Error");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to update expense. Please try again.", "Error");
                    }
                });
            }
        });
    });

    function editloadCategory(selectedGroupId = null) {
        $.ajax({
            type: "GET",
            url: "/api/groups",
            success: function (response) {
                console.log("Categories:", response);
                if (!Array.isArray(response)) {
                    console.error("Error: API did not return an array!", response);
                    return;
                }

                let group_id = $("#edit_group_id");
                group_id.empty();
                group_id.append(`<option value="">Choose a Group</option>`);

                $.each(response, function (index, group) {
                    let selected = group.id == selectedGroupId ? "selected" : "";
                    let option = `<option value="${group.id}" ${selected}>${group.group_name}</option>`;
                    group_id.append(option);
                });
            },
            error: function (response) {
                console.error("AJAX Error:", response.responseText);
                toastr.error("Failed to load groups. Please try again.", "Error");
            }
        });
    }
</script>
