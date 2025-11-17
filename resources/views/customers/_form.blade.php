<div>
    <flux:field variant="block" class="mb-4">
        <flux:label for="name">Company name</flux:label>
        <flux:input id="name" name="name" type="text" placeholder="John Doe" required class="w-full"
            value="{{ old('name', $customer->name ?? '') }}" />
        <flux:error name="name" />
    </flux:field>

    <flux:field variant="block" class="mb-4">
        <flux:label for="email"> Company email address</flux:label>
        <flux:input id="email" name="email" type="email" placeholder="example@email.com" required class="w-full"
            value="{{ old('email', $customer->email ?? '') }}" />
        <flux:error name="email" />
    </flux:field>

    <flux:field variant="block" class="mb-4">
        <flux:label for="phone">Company phone number</flux:label>
        <flux:input id="phone" name="phone" type="tel" placeholder="+31 6 123 45678" class="w-full" />
        <flux:error name="phone" value="{{ old('phone', $customer->phone ?? '') }}" />
    </flux:field>

    <flux:field variant="block" class="mb-6">
        <flux:label for="kvk_nummer">Company kvk-nummer</flux:label>
        <flux:input id="kvk_nummer" name="kvk_nummer" type="number" placeholder="123456" class="w-full" />
        <flux:error name="kvk_nummer" value="{{ old('kvk_nummer', $customer->kvk_nummer ?? '') }}" />
    </flux:field>

    <div class="mb-6">
        <flux:heading size="lg" class="mb-6">Company Address</flux:heading>

        <div class="flex gap-4 items-center mb-4">
            <flux:field variant="block" class="mb-6 w-3/5">
                <flux:label for="straat">Street</flux:label>
                <flux:input id="straat" name="straat" type="text" placeholder="Terheijdenstraat bijv."
                    class="w-full" value="{{ old('straat', $customer->straat ?? '') }}" />
                <flux:error name="straat" />
            </flux:field>
            <flux:field variant="block" class="mb-6">
                <flux:label for="huisnummer">House number</flux:label>
                <flux:input id="huisnummer" name="huisnummer" type="text" placeholder="11 bijv." class="w-full"
                    value="{{ old('huisnummer', $customer->huisnummer ?? '') }}" />
                <flux:error name="huisnummer" />
            </flux:field>
        </div>

        <div class="flex gap-4 items-center">
            <flux:field variant="block" class="mb-6 w-1/5">
                <flux:label for="postcode">Postcode</flux:label>
                <flux:input id="postcode" name="postcode" type="text" placeholder="4830 GH bijv." class="w-full" />
                <flux:error name="postcode" value="{{ old('postcode', $customer->postcode ?? '') }}" />
            </flux:field>
            <flux:field variant="block" class="mb-6 w-3/5">
                <flux:label for="plaats">Plaats</flux:label>
                <flux:input id="plaats" name="plaats" type="text" placeholder="Breda bijv." class="w-full" />
                <flux:error name="plaats" value="{{ old('plaats', $customer->plaats ?? '') }}" />
            </flux:field>
        </div>
    </div>

    <flux:radio.group label="Status" name="status" class="mb-6 flex gap-2" variant="segmented">
        <flux:radio value="new" icon="sparkles" label="New" checked />
        <flux:radio value="active" icon="check-circle" label="Active" />
        <flux:radio value="pending" icon="clock" label="Pending" />
        <flux:radio value="inactive" icon="x-circle" label="Inactive" />
    </flux:radio.group>



    <flux:field variant="block" class="mb-6">
        <flux:textarea label="Additional Notes" placeholder="Additional information about the customer..."
            value="{{ old('notes', $customer->notes ?? '') }}" />
    </flux:field>


    <flux:button type="submit" variant="primary" class="w-full mt-4">
        Add Customer
    </flux:button>

    @if ($errors->any)
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
            <strong>Whoops! There were some problems with your input:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif
</div>
