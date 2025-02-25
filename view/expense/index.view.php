


<!-- Expense Form -->
<div class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white p-8 rounded-xl shadow-xl w-11/12 max-w-lg">
        <h2 class="text-2xl font-semibold mb-6 text-[#223843] text-center">Add New Expense</h2>
        <form id="expenseForm" action="/expense" method="POST" class="space-y-4">
            <div>
                <label for="title" class="block text-gray-700 font-medium">Expense Name</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    placeholder="Enter expense name"
                    required
                />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="amount" class="block text-gray-700 font-medium">Amount</label>
                <input
                    type="number"
                    id="amount"
                    name="amount"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    placeholder="Enter amount"
                    step="0.01"
                    required
                />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="group-Name" class="block text-gray-700 font-medium">Select Group</label>
                <?php if (count($groups) === 0): ?>
                    <input
                        type="text"
                        class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                        placeholder="No Group Found"
                        disabled
                    />
                <?php else: ?>
                    <select
                        id="group-Name"
                        name="group_id"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                        required
                    >
                        <option value="">Choose a Group</option>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group['id'] ?>"><?= $group['group_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="expenseDate" class="block text-gray-700 font-medium">Date</label>
                <input
                    type="date"
                    id="expenseDate"
                    name="date"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    required
                />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div class="flex justify-between mt-4">
                <a href='/'
                    class="bg-gray-300 text-[#223843] px-5 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-[#223843] text-white px-6 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                    Add Expense
                </button>
            </div>
        </form>
    </div>
</div>




<script>
$(document).ready(function () {
    let today = new Date().toISOString().split('T')[0];
    $("#expenseDate").val(today); 
    

    // Custom validation method to prevent future dates
    $.validator.addMethod("noFutureDate",  (value, element) => {
        let selectedDate = new Date(value + "T00:00:00Z"); // Convert to UTC date
        let currentDate = new Date(new Date().toISOString().split('T')[0] + "T00:00:00Z"); // Today’s date in UTC
        return selectedDate <= currentDate; // Allow only past or current date
    }, "You cannot select a future date!");

    $("#expenseForm").validate({
        rules: {
            title: { required: true, minlength: 2, maxlength: 10 },
            amount: { required: true, min: 1 },
            group_id: { required: true },
            date: { required: true, noFutureDate: true } // Enforcing the no future date rule
        },
        messages: {
            title: { 
                required: "Please enter an expense name", 
                minlength: "Title must be at least 2 characters", 
                maxlength: "Title must be at most 10 characters"
            },
            amount: { required: "Please enter an amount", min: "Amount must be greater than 0" },
            group_id: { required: "Please select a group" },
            date: { required: "Please select a date", noFutureDate: "Future dates are not allowed!" }
        },
        errorPlacement: (error, element) => {
            $(element).next(".error-message").html(error);
        },
        highlight: (element) =>{
            $(element).addClass("border-red-500").removeClass("border-gray-300");
        },
        unhighlight:  (element) =>{
            $(element).removeClass("border-red-500").addClass("border-gray-300");
            $(element).next(".error-message").html("");
        }
    });

    $("#expenseForm").on("submit",  (e) => {
        let groupCount = <?= count($groups) ?>;

        if (groupCount === 0) {
            e.preventDefault(); // Stop form submission

            Swal.fire({
                title: "No Groups Found!",
                text: "You need to create a group before adding expenses.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Create Group",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/groups"; // Redirect to create group
                }
            });

            return false; // Ensure form does NOT submit
        }
    });
});
</script>
