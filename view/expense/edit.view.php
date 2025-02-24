<?php require base_path('view/partials/head.php'); ?>
<?php require base_path('view/partials/banner.php'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Expense Form -->
<div class="flex justify-center mt-10">
    <div class="bg-white p-8 rounded-xl shadow-xl w-11/12 max-w-lg">
        <h2 class="text-2xl font-semibold mb-6 text-[#223843] text-center">Edit Expense</h2>
        <form id="expenseForm" action="/expenses" method="POST" class="space-y-4">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="id" value="<?= $expense['id'] ?>">
           
            <div>
                <label for="title" class="block text-gray-700 font-medium">Expense Name</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    placeholder="Enter expense name"
                    value="<?= $expense['title'] ?>"
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
                    value="<?= $expense['amount'] ?>"
                />
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="group-Name" class="block text-gray-700 font-medium">Select Group</label>
                <select
                        id="group-Name"
                        name="group_id"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    >
                    <?php foreach ($groups as $group): ?>
                    <option value="<?= $group['id'] ?>" 
                        <?= (isset($expense['group_id']) && $expense['group_id'] == $group['id']) ? 'selected' : '' ?>>
                        <?= $group['group_name'] ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                <span class="text-red-500 text-sm error-message"></span>
            </div>

            <div>
                <label for="expenseDate" class="block text-gray-700 font-medium">Date</label>
                <input
                    type="date"
                    id="expenseDate"
                    name="date"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] focus:border-[#223843] transition"
                    value="<?= $expense['date'] ?>"
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

<?php require_once base_path('view/partials/back_button.php'); ?>
<?php require base_path('view/partials/footer.php'); ?>
