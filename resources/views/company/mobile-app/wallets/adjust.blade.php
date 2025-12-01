<form method="POST" action="{{ route('admin.app.wallets.adjust.store') }}">
    @csrf

    <div class="mb-4">
        <label class="font-medium">User</label>
        <input type="text" autocomplete="off" id="walletUserSearch" placeholder="Search name/email/mobile"
            class="border p-2 rounded w-full">
        <input type="hidden" name="user_id" id="selectedUserId">
        <div id="walletUserResults" style="max-height: calc(0.25rem * 56);min-height:120px"
            class="bg-blue-200 hidden border mt-1.5 overflow-y-auto rounded"></div>
    </div>

        <div class="mb-4">
            <label class="font-medium">Title</label>
            <input type="text" name="title" class="border p-2 rounded w-full">
        </div>

    <div class="grid md:grid-cols-2 gap-6">

        <div class="mb-4">
            <label class="font-medium">Green Coins</label>
            <input type="number" name="amount" min="1" class="border p-2 rounded w-full">
        </div>

        <div class="mb-4">
            <label class="font-medium">Action</label>
            <select name="action" class="border p-2 rounded w-full">
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>
        </div>
    </div>
    <div class="mb-4">
        <label class="font-medium">Note (optional)</label>
        <textarea name="note" class="border p-2 rounded w-full" rows="3"></textarea>
    </div>

    <button class="bg-green-600 text-white px-3 py-2 rounded w-full">
        Manage Wallet
    </button>
</form>


@push('scripts')
    <script>
        let searchTimer = null;

        // Search users by typing
        document.getElementById("walletUserSearch").addEventListener("keyup", function() {
            let keyword = this.value.trim();
            // if (keyword.length < 2) return;
            let box = document.getElementById("walletUserResults");
            box.innerHTML = "";
            box.classList.add("hidden");


            if (keyword.length < 1) {

              box.innerHTML = "";
              box.classList.add("hidden");
          }



        clearTimeout(searchTimer); searchTimer = setTimeout(() => {
            fetch("{{ route('admin.search-users') }}?key=" + keyword)
                .then(res => res.json())
                .then(data => {

                    box.innerHTML = "";
                    box.classList.remove("hidden");

                    if (data.length === 0) {
                        box.innerHTML = "<p class='p-2 text-gray-500'>No results</p>";
                        return;
                    }

                    data.forEach(u => {
                        let row = document.createElement("div");
                        row.classList = "p-2 border-b cursor-pointer hover:bg-gray-100";

                        row.innerHTML = `
                        <b>${u.name}</b><br>
                        <small>${u.email}</small><br>
                        <small>${u.mobile}</small><br>
                        <span class="text-xs uppercase bg-gray-200 px-2 rounded">${u.acc_type}</span>
                    `;

                        row.onclick = () => {
                            document.getElementById("walletUserSearch").value = u.name +
                                " (" + u.mobile + ")";
                            document.getElementById("selectedUserId").value = u.id;
                            box.classList.add("hidden");
                        };

                        box.appendChild(row);
                    });
                });
        }, 400);
        });
    </script>
@endpush
