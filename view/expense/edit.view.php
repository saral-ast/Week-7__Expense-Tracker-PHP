<?php require base_path('view/partials/head.php'); ?>
<?php require base_path('view/partials/banner.php'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Expense Form -->
<div class="flex justify-center mt-10">
    <div class="bg-white p-6 rounded-xl shadow-lg w-11/12 max-w-md">
        <h2 class="text-xl font-semibold mb-4 text-[#223843]">Add Expense</h2>
        <form id="expenseForm" action="/expenses" method="POST">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="id" value="<?= $expense['id'] ?>">
            <input
                type="text"
                id="title"
                name="title"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] mb-4"
                placeholder="Expense Name"
                value="<?= $expense['title'] ?>"

                required
            />
            <input
                type="number"
                id="amount"
                name="amount"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] mb-4"
                placeholder="Amount"
                required
                value="<?= floor($expense['amount']) ?>"
            />

            
              <select
                id="group-Name"
                name="group_id"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] mb-4"
                required
            >
                <?php foreach ($groups as $group): ?>
                    <option value="<?= $group['id'] ?>" 
                        <?= (isset($expense['group_id']) && $expense['group_id'] == $group['id']) ? 'selected' : '' ?>>
                        <?= $group['group_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>


            <input
                type="date"
                id="expenseDate"
                name="date"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] mb-4"
                required
                value="<?= $expense['date'] ?>"
            />

            <div class="flex justify-end gap-2">
                <a href='/'
                    class="bg-gray-200 text-[#223843] px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-[#223843] text-white px-4 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                    Add Expense
                </button>
            </div>
        </form>
    </div>
</div>

<?php require base_path('view/partials/footer.php'); ?>
