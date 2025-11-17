<div class="w-full max-w-xl mx-auto lg:mx-0">
    <h2 class="text-2xl font-bold mb-4">Nieuwe factuur aanmaken</h2>

    <div class="mb-4 p-4 border rounded bg-neutral-900">
        <p class="mb-2">Voer eerst de BKR-check uit voor deze klant. De klant mag niet in de BKR staan.</p>
        <div class="flex items-center gap-4">
            <label class="inline-flex items-center">
                <input type="radio" name="bkr" value="no" class="form-radio" id="bkr-no">
                <span class="ml-2">BKR: Nee</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="bkr" value="yes" class="form-radio" id="bkr-yes">
                <span class="ml-2">BKR: Ja</span>
            </label>
        </div>
        <p id="bkr-message" class="mt-2 text-sm text-yellow-300 hidden">Let op: klant staat in de BKR — je kunt geen factuur aanmaken voor deze klant.</p>
        <p id="select-customer-message" class="mt-2 text-sm text-yellow-400 hidden">Kies eerst een klant bovenaan om de BKR-check uit te voeren.</p>
    </div>

    <form method="POST" action="{{ route('invoices.store') }}" id="invoice-form" class="hidden">
        @csrf
        <input type="hidden" name="bkr" id="bkr-input" value="">
        <input type="hidden" name="customer_id" id="customer_id_input" value="{{ old('customer_id', $selected_customer_id ?? '') }}">

        {{-- Customer is selected at page level; hidden input holds the selected id --}}

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-medium">Factuurdatum</label>
                <input type="date" name="invoice_date" value="{{ now()->toDateString() }}" required class="w-full border rounded px-2 py-1" />
            </div>
            <div>
                <label class="block font-medium">Vervaldatum</label>
                <input type="date" name="due_date" value="{{ now()->addDays(14)->toDateString() }}" required class="w-full border rounded px-2 py-1" />
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Items (JSON array)</label>
            <textarea name="items_json" rows="6" class="w-full border rounded px-2 py-1">[{"description":"Voorbeeld","qty":1,"price":100}]</textarea>
            <p class="text-sm text-gray-500">Voer items in als JSON array; het formulier parseert dit naar items.</p>
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Genereer PDF</button>
        </div>
    </form>

    <script>
        (function(){
            const radioYes = document.getElementById('bkr-yes');
            const radioNo = document.getElementById('bkr-no');
            const form = document.getElementById('invoice-form');
            const bkrInput = document.getElementById('bkr-input');
            const msg = document.getElementById('bkr-message');
            const selectMsg = document.getElementById('select-customer-message');
            const customerSelect = document.getElementById('customer_select');
            const customerIdInput = document.getElementById('customer_id_input');

            function update() {
                const hasCustomer = customerSelect && customerSelect.value;

                if (! hasCustomer) {
                    form.classList.add('hidden');
                    selectMsg.classList.remove('hidden');
                    msg.classList.add('hidden');
                    bkrInput.value = '';
                    if (customerIdInput) customerIdInput.value = '';
                    return;
                }

                // we have a selected customer
                selectMsg.classList.add('hidden');
                if (customerIdInput) customerIdInput.value = customerSelect ? customerSelect.value : (customerIdInput.value || '');

                if (radioNo && radioNo.checked) {
                    form.classList.remove('hidden');
                    msg.classList.add('hidden');
                    bkrInput.value = 'no';
                } else if (radioYes && radioYes.checked) {
                    form.classList.add('hidden');
                    msg.classList.remove('hidden');
                    bkrInput.value = 'yes';
                } else {
                    form.classList.add('hidden');
                    msg.classList.add('hidden');
                    bkrInput.value = '';
                }
            }

            document.addEventListener('change', update);
            // initialize if radios are preselected or customer preselected
            update();
        })();
    </script>
</div>
