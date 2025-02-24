<?php require base_path('view/partials/head.php'); ?>
<?php require base_path('view/partials/banner.php'); ?>

<!-- Group Wise Data Section -->
<div class="flex justify-center mt-10">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-11/12 max-w-4xl">
        <h2 class="text-3xl font-bold mb-6 text-[#223843] text-center">
            Group Wise Expenses
        </h2>

        <!-- Expense Table -->
        <div class="overflow-x-auto">
            <?php if (!$expenses): ?>
                <p class="text-center text-gray-600 text-lg">No expenses found for this group.</p>
            <?php else: ?>
                <table class="min-w-full bg-white shadow-md rounded-lg border-collapse">
                    <thead class="bg-[#223843] text-white">
                        <tr>
                            <th class="p-4 text-left uppercase tracking-wide">Expense Name</th>
                            <th class="p-4 text-left uppercase tracking-wide">Amount (₹)</th>
                            <th class="p-4 text-left uppercase tracking-wide">Date</th>
                            <th  class="p-4 text-left uppercase tracking-wide">Edit</th>
                            <th class="p-4 text-left uppercase tracking-wide text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($expenses as $expense): ?>
                            <tr class="border-b hover:bg-gray-100 transition">
                                <td class="p-4"><?= htmlspecialchars($expense['title']) ?></td>
                                <td class="p-4 font-semibold text-[#223843]">
                                    ₹<?= number_format($expense['amount'], 2) ?>
                                </td>
                                <td class="p-4"><?= htmlspecialchars($expense['formatted_date']) ?></td>
                                <td class="p-3 text-left">
                          <a href="/expense/edit?id=<?= $expense['id'] ?>" class="bg-gray-100 border border-blue-500 text-blue-500 px-4 py-2 rounded-lg hover:bg-blue-800 hover:text-white transition">
                            Edit
                          </a>
                                <td class="p-4 text-center">
                                    <form action="/expense" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="id" value="<?= $expense['id'] ?>"> 
                                        <button type="submit" class="bg-gray-100 border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-red-800 hover:text-white transition">
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

        <!-- Footer Section -->
        <div class="flex justify-between items-center mt-6 border-t pt-4">
            <span class="text-xl font-bold text-[#223843]">
                Total Expenses: ₹<?=array_sum(array_column($expenses, 'amount')) ?>
            </span>
            <a href="/" class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-300 hover:text-black transition 
              font-medium shadow-md hover:shadow-lg inline-block text-center">
                 Back
            </a>
        </div>
    </div>
</div>
<?php require_once base_path('view/partials/back_button.php'); ?>
<?php require base_path('view/partials/footer.php'); ?>
