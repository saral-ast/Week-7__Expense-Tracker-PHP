<?php require 'partials/head.php'; ?>
<?php require 'partials/banner.php'; ?>

      <div class="container mx-auto p-6">
        <!-- Dashboard -->
        <section id="dashboard" class="mb-10">
          <!-- Dashboard -->
          <section id="dashboard" class="mb-10">
            <h2 class="text-2xl font-semibold mb-6">Dashboard</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-lg font-semibold">Total Expense</h3>
                <span id="totalExpense" class="text-xl font-bold text-[#223843]"><?= $totalExpense ?></span>
              </div>
              <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-lg font-semibold">Total Expense this Month</h3>
                <span id="monthExpense" class="text-xl font-bold text-[#223843]"><?= $totalCurrentMonth ?></span>
              </div>
              <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-lg font-semibold">Highest Spending this Month</h3>
                <span id="highestExpense" class="text-xl font-bold text-[#223843]"><?= $maxCurrentMonth ?></span>
              </div>
            </div>
          </section>

          <!-- Groups Section -->
          <section id="groups" class="mb-10">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
              <h2 class="text-2xl font-semibold">Groups</h2>
              <button id="addGroupBtn" class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-300 hover:text-black transition 
              font-medium shadow-md hover:shadow-lg inline-block text-center">
                      + Add Group
                  </button>
            </div>
            <div class="overflow-x-auto mt-4">
              
                <table class="min-w-full bg-white shadow-md rounded-lg">
                  <thead class="bg-[#223843] text-white">
                    <tr>
                      <th class="p-3 text-left">Group Name</th>
                      <th class="p-3 text-left">Created Date</th>
                      <th class="p-3 text-left">Total Amount</th>
                      <th class="p-3 text-left">Edit</th>
                      <th class="p-3 text-left">Delete</th>
                    </tr>
                  </thead>
                  <tbody id="groupData" class="text-gray-700"></tbody>
                </table>
            </div>
          </section>

          <!-- Expense-Data -->
          <section id="expense">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
              <h2 class="text-2xl font-semibold">Expense History</h2>
              <button id="addExpensebtn" class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-300 hover:text-black transition 
              font-medium shadow-md hover:shadow-lg inline-block text-center"
              >
                + Add Expense
              </button>
            </div>
            <div class="max-h-96 overflow-y-auto px-2 mt-4">
              
                <table class="min-w-full bg-white shadow-md rounded-lg">
                  <thead class="bg-[#223843] text-white">
                    <tr>
                      <th class="p-3 text-left">Expense Name</th>
                      <th class="p-3 text-left">Group Name</th>
                      <th class="p-3 text-left">Amount</th>
                      <th class="p-3 text-left">Date</th>
                      <th class="p-3 text-left">Edit</th>
                      <th class="p-3 text-left">Delete</th>
                    </tr>
                  </thead>
                  <tbody id="expenseData" class="text-gray-700"></tbody>
                </table>
            </div>
          </section>
        </div>

            <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 p-4">
    <div class="relative w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p id="deleteMessage" class="mb-4 text-gray-600"></p>
        <form id="deleteFormGroup" class="hidden">
            <input type="hidden" name="id" id="deleteId">
            <div class="flex justify-end gap-4">
               <button type="submit" class="bg-gray-100 border border-red-500 text-red-900 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition">Delete-Group</button>
            </div>
        </form>
        <form id="deleteFormExpense" class="hidden">
            <input type="hidden" name="id" id="deleteId">
            <div class="flex justify-end gap-4">
              <button type="submit" class="bg-gray-100 border border-red-500 text-red-900 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition">Delete-Expense</button>
            </div>
        </form>
        <button type="button" id="closeDeleteModal" class="bg-gray-300 text-black px-5 py-2 rounded-lg hover:bg-gray-900 hover:text-white transition font-medium shadow-md hover:shadow-lg inline-block text-center">Cancel</button>
    </div>
    </div>

<?php require base_path('view/group/index.view.php'); ?>
<?php require base_path('view/expense/index.view.php'); ?>
<?php require base_path('view/group/edit.view.php'); ?>
<?php require base_path('view/expense/edit.view.php'); ?>
<script>
 $(document).ready(function () {
    loadGroups();
    loadExpenses();
    
});
// Function to Update Dashboard Values via AJAX
function updateDashboard() {
    $.ajax({
        url: "/api/dashboard", // Make sure this endpoint returns the updated dashboard values
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // Update the values in the dashboard
                $("#totalExpense").text(response.totalExpense);
                $("#monthExpense").text(response.totalCurrentMonth);
                $("#highestExpense").text(response.maxCurrentMonth);
            } else {
                console.error("Failed to update dashboard:", response.message);
                toastr.error("Failed to update dashboard", "Error");
            }
        },
        error: function (xhr) {
            console.error("AJAX Error:", xhr.responseText);
            toastr.error("Error fetching dashboard data", "Error");
        }
    });
}

// Fetch Groups via AJAX
function loadGroups() {
    $.ajax({
        url: "/api/groups",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log("API Response:", response); // Debugging Step

            if (!Array.isArray(response)) {
                console.error("Error: API did not return an array!", response);
                return;
            }

            let groupTable = $("#groupData").empty();

            if (response.length === 0) {
                groupTable.html("<tr><td colspan='6' class='p-3 text-left'>No Groups Found</td></tr>");
                return;
            }

            $.each(response, function (index, group) {
                let row = `
                    <tr class="bg-gray-100 text-gray-900">
                        <td class="p-3 text-left">${group.group_name}</td>
                        <td class="p-3 text-left">${group.formatted_created_at}</td>
                        <td class="p-3 text-left">${Math.floor(group.total)}</td>
                        <td><button class="edit-group bg-gray-100 border border-blue-500 text-blue-500 px-4 py-2 rounded-lg hover:bg-blue-800 hover:text-white transition" data-id="${group.id}" data-name= "${group.group_name}">Edit</button></td>
                        <td><button class="delete-group bg-gray-100 border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition" data-id="${group.id}">Delete</button></td>
                    </tr>
                `;
                groupTable.append(row);
            });
        },
        error: function (xhr) {
            console.error("AJAX Error:", xhr.responseText);
            toastr.error("Failed to load groups. Please try again.", "Error");
        }
    });
}

// Fetch Expenses via AJAX
function loadExpenses() {
    $.ajax({
        url: "/api/expenses",
        type: "GET",
        dataType: "json",
        success: function (response) {
            let expenseTable = $("#expenseData").empty();
          
            if (response.length === 0) {
                expenseTable.html("<tr><td colspan='6' class='p-3 text-left'>No Expenses Found</td></tr>");
                return;
            }
            console.log("Expenses:", response);
            $.each(response, function (index, expense) {
                let row = `
                    <tr class="bg-gray-100 text-gray-900">
                        <td class="p-3 text-left">${expense.title}</td>
                        <td class="p-3 text-left">${expense.category}</td>
                        <td class="p-3 text-left">${expense.amount}</td>
                        <td class="p-3 text-left">${expense.date}</td>
                        <td><button class="edit-expense bg-gray-100 border border-blue-500 text-blue-500 px-4 py-2 rounded-lg hover:bg-blue-800 hover:text-white transition" data-id="${expense.expense_id}">Edit</button></td>
                        <td><button class="delete-expense bg-gray-100 border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition" data-id="${expense.expense_id}">Delete</button></td>
                    </tr>
                `;
                expenseTable.append(row);
            });
        },
        error: function (xhr) {
            console.error("Error fetching expenses:", xhr.responseText);
            toastr.error("Failed to load expenses. Please try again.", "Error");
        }
    });
}

</script>



<?php require 'partials/footer.php'; ?>