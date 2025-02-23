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
                <span id="totalExpense" class="text-xl font-bold text-[#223843]"><?= $sum ?? '0' ?></span>
              </div>
              <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-lg font-semibold">Total Expense this Month</h3>
                <span id="monthExpense" class="text-xl font-bold text-[#223843]"><?= $total ?? '0' ?></span>
              </div>
              <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-lg font-semibold">Highest Spending this Month</h3>
                <span id="highestExpense" class="text-xl font-bold text-[#223843]"><?= $max ?? '0' ?></span>
              </div>
            </div>
          </section>

          <!-- Groups Section -->
          <section id="groups" class="mb-10">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
              <h2 class="text-2xl font-semibold">Groups</h2>
              <a href="/groups" class="bg-[#223843] text-white px-6 py-2 rounded-lg shadow hover:bg-[#1a2a34] transition w-full sm:w-auto">
                + Add Group
              </a>
            </div>
            <div class="overflow-x-auto mt-4">
              <?php if (count($groups) === 0): ?> 
                <p class="p-3 text-left">No Group Found</p>         
              <?php else: ?>
                <table class="min-w-full bg-white shadow-md rounded-lg">
                  <thead class="bg-[#223843] text-white">
                    <tr>
                      <th class="p-3 text-left">Group Name</th>
                      <th class="p-3 text-left">Created Date</th>
                      <th class="p-3 text-left">Total Amount</th>
                      <th class="p-3 text-left">View</th>
                      <th class="p-3 text-left">Edit</th>
                      <th class="p-3 text-left">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($groups as $group): ?>
                      <tr class="bg-gray-100 text-gray-900 transition">
                        <td class="p-3 text-left"><?= $group['group_name'] ?></td>
                        <td class="p-3 text-left"><?= $group['formatted_created_at'] ?></td>
                        <td class="p-3 text-left"><?= floor($group['total']) ?></td>
                        <td>
                        <a href="/group?id=<?= $group['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View Expense</a>
                       
                        </td>
                        <td>
                        <a href="/group/edit?id=<?= $group['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                       
                           </td>
                        <td>
                          <button class="delete-group bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition" 
                            data-id="<?= $group['id'] ?>" 
                            data-name="<?= $group['group_name'] ?>">
                            Delete
                          </button>
                        </td>  
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
          </section>

          <!-- Expense-Data -->
          <section id="expense">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
              <h2 class="text-2xl font-semibold">Expense History</h2>
              <a href="/expense"
                id="addExpense"
                class="bg-[#223843] text-white px-6 py-2 rounded-lg shadow hover:bg-[#1a2a34] transition w-full sm:w-auto"
                data-modal-target="expenseModal" data-modal-toggle="expenseModal"
              >
                + Add Expense
              </a>
            </div>
            <div class="max-h-96 overflow-y-auto px-2 mt-4">
              <?php if(count($expenses) === 0): ?> 
                <p class="p-3 text-left">No Expense Found</p>
              <?php else: ?>
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
                  <tbody id="expenseData" class="text-gray-700">
                    <?php foreach($expenses as $expense): ?>
                      <tr class="bg-gray-100 text-gray-900 transition">
                        <td class="p-3 text-left"><?= $expense['title'] ?></td>
                        <td class="p-3 text-left"><?= $expense['category'] ?></td>
                        <td class="p-3 text-left"><?= floor($expense['amount']) ?></td>
                        <td class="p-3 text-left"><?= $expense['date'] ?></td>
                        <td class="p-3 text-left">
                          <a href="/expense/edit?id=<?= $expense['id'] ?>" class="bg-[#223843] text-white px-4 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                            Edit
                          </a>
                        <td class="p-3 text-left">
                          <form action="/expense" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?= $expense['id'] ?>"> 
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                              Delete
                            </button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
          </section>
        </div>

      

<!-- Flowbite Add Expense Modal -->

 
  <!-- Flowbite Delete Confirmation Modal -->
<div id="deleteModal" tabindex="-1" class="hidden fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4">
  <div class="relative w-full max-w-md">
    <div class="bg-white p-6 rounded-lg shadow-lg">
      <button type="button" id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
      <p id="deleteMessage" class="mb-4 text-gray-600"></p>
      <form id="deleteForm" method="POST" action="/group">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" id="deleteGroupId">
        <div class="flex justify-end gap-4">
          <button type="button" id="cancelDelete" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition">
            Cancel
          </button>
          <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
            Delete
          </button>
        </div>
      </form>
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    $(".delete-group").click(function() {
      let groupId = $(this).data("id");
      let groupName = $(this).data("name");

      $("#deleteGroupId").val(groupId);
      $("#deleteMessage").text(`Are you sure you want to delete the group "${groupName}"?`);

      $("#deleteModal").removeClass("hidden");
    });

    $("#cancelDelete, #closeModal").click(function() {
      $("#deleteModal").addClass("hidden");
    });
  });
</script>


<?php require 'partials/footer.php'; ?>