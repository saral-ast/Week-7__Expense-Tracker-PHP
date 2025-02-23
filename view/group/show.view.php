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
                          <a href="/expense/edit?id=<?= $expense['id'] ?>" class="bg-[#223843] text-white px-4 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                            Edit
                          </a>
                                <td class="p-4 text-center">
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

        <!-- Footer Section -->
        <div class="flex justify-between items-center mt-6 border-t pt-4">
            <span class="text-xl font-bold text-[#223843]">
                Total Expenses: ₹<?= number_format(array_sum(array_column($expenses, 'amount')), 2) ?>
            </span>
            <a href="/" class="bg-[#223843] text-white px-6 py-2 rounded-lg shadow hover:bg-[#1a2a34] transition">
                 Back
            </a>
        </div>
    </div>
</div>

<?php require base_path('view/partials/footer.php'); ?>
