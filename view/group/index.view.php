<?php require base_path('view/partials/head.php'); ?>
<?php require base_path('view/partials/banner.php'); ?>


<!-- Group Form -->
<div class="flex justify-center  mt-10">
    <div class="bg-white p-6 rounded-xl shadow-lg w-11/12 max-w-md ">
        <h2 class="text-xl font-semibold mb-4 text-[#223843]">Add Group</h2>
        <form action="/groups" method="POST" id="groupForm">
            <input type="text" id="id" name="id" value="group" hidden />
            <input
                type="text"
                id="groupName"
                name="groupName"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#223843] mb-4"
                placeholder="Enter Group Name"
            />
            <span><?=$errors['name'] ?? '' ?></span>
            <div class="flex justify-end gap-2">
                <a href='/'
                    class="bg-[#EFF1F3] text-[#223843] px-4 py-2 rounded-lg hover:bg-[#d1d8dd] transition">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-[#223843] text-white px-4 py-2 rounded-lg hover:bg-[#1a2a34] transition">
                    Add Group
                </button>
            </div>
        </form>
    </div>
</div>

<?php require base_path('view/partials/footer.php'); ?>
