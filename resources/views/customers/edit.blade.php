<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')

    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection


    <div class="min-h-screen p-6">
        <div class="flex justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-6 text-left">Pas klant informatie aan</h1>
            </div>
            <div class="">
                <flux:button href="{{ route('customers.index') }}" variant="primary" color="blue" icon="chevron-left"
                    class="mr-auto hover:cursor-pointer">Back</flux:button>
            </div>
        </div>
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <flux:field variant="block" class="mb-4">
                    <flux:label for="name">Bedrijfsnaam</flux:label>
                    <flux:input id="name" name="name" type="text" placeholder="Barroc Intens" required
                        class="w-full" value="{{ old('name', $customer->name ?? '') }}" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field variant="block" class="mb-4">
                    <flux:label for="contact_person"> Contactspersoon</flux:label>
                    <flux:input id="contact_person" name="contact_person" type="contact_person" placeholder="John Doe"
                        required class="w-full" value="{{ old('contact_person', $customer->contact_person ?? '') }}" />
                    <flux:error name="contact_person" />
                </flux:field>

                <flux:field variant="block" class="mb-4">
                    <flux:label for="email">Emailadres</flux:label>
                    <flux:input id="email" name="email" type="email" placeholder="example@email.com" required
                        class="w-full" value="{{ old('email', $customer->email ?? '') }}" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field variant="block" class="mb-4">
                    <flux:label for="phone">Telefoonnummer</flux:label>
                    <flux:input id="phone" name="phone" type="tel" placeholder="+31 6 123 45678"
                        class="w-full" />
                    <flux:error name="phone" value="{{ old('phone', $customer->phone ?? '') }}" />
                </flux:field>

                <flux:field variant="block" class="mb-6">
                    <flux:label for="kvk_number">Kvk-nummer</flux:label>
                    <flux:input id="kvk_number" name="kvk_number" type="number" placeholder="123456" class="w-full" />
                    <flux:error name="kvk_number" value="{{ old('kvk_number', $customer->kvk_number ?? '') }}" />
                </flux:field>

                <div class="mb-6">
                    <flux:heading size="lg" class="mb-6">Bedrijfsadres</flux:heading>

                    <div class="flex gap-4 items-center mb-4">
                        <flux:field variant="block" class="mb-6 w-3/5">
                            <flux:label for="street">Straat</flux:label>
                            <flux:input id="street" name="street" type="text"
                                placeholder="Terheijdenstraat bijv." class="w-full"
                                value="{{ old('street', $customer->street ?? '') }}" />
                            <flux:error name="street" />
                        </flux:field>
                        <flux:field variant="block" class="mb-6">
                            <flux:label for="house_number">Huisnummer</flux:label>
                            <flux:input id="house_number" name="house_number" type="text" placeholder="11 bijv."
                                class="w-full" value="{{ old('house_number', $customer->house_number ?? '') }}" />
                            <flux:error name="house_number" />
                        </flux:field>
                    </div>

                    <div class="flex gap-4 items-center">
                        <flux:field variant="block" class="mb-6 w-1/5">
                            <flux:label for="postcode">Postcode</flux:label>
                            <flux:input id="postcode" name="postcode" type="text" placeholder="4830 GH bijv."
                                class="w-full" />
                            <flux:error name="postcode" value="{{ old('postcode', $customer->postcode ?? '') }}" />
                        </flux:field>
                        <flux:field variant="block" class="mb-6 w-3/5">
                            <flux:label for="place">Plaats</flux:label>
                            <flux:input id="place" name="place" type="text" placeholder="Breda bijv."
                                class="w-full" />
                            <flux:error name="place" value="{{ old('place', $customer->place ?? '') }}" />
                        </flux:field>
                    </div>
                </div>

                <div class="mb-6">
                    @if ($customer->bkr_status === 'registered')
                        <flux:radio.group label="Status" name="status" class="flex gap-2 opacity-50"
                            variant="segmented" disabled>
                            <flux:radio value="new" icon="sparkles" label="New" checked />
                            <flux:radio value="active" icon="check-circle" label="Active" />
                            <flux:radio value="inactive" icon="x-circle" label="Inactive" />
                        </flux:radio.group>
                        <p class="text-red-600">Klant staat geregistreerd in de BKR systeem!</p>
                    @else
                        <flux:radio.group label="Status" name="status" class="flex gap-2" variant="segmented">
                            <flux:radio value="new" icon="sparkles" label="New" checked />
                            <flux:radio value="active" icon="check-circle" label="Active" />
                            <flux:radio value="inactive" icon="x-circle" label="Inactive" />
                        </flux:radio.group>
                    @endif
                </div>


                <flux:field variant="block" class="mb-6">
                    <flux:textarea label="Aanvullende opmerkingen" placeholder="Aanvullende opmerkingen over klant..."
                        name="notes" value="{{ old('notes', $customer->notes ?? '') }}" />
                </flux:field>


                <div class="flex gap-4">
                    <flux:button type="submit" variant="primary" class="w-full mt-4">
                        Opslaan
                    </flux:button>
                </div>

            </div>

        </form>
        <form action="{{ route('customers.destroy', $customer) }}" method="POST">
            @csrf
            @method('DELETE')


            <flux:button type="submit" variant="danger" class="w-full mt-4" onclick="return confirm('Weet je het zeker? Deze actie kan niet ongedaan gemaakt worden!')">
                Verwijderen
            </flux:button>
        </form>


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

</x-layouts.dashboard>
