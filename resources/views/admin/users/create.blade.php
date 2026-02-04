<x-layouts.app :title="__('Create User')">
    <div class="mx-auto w-full max-w-2xl space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Create account</h1>
            <a href="{{ route('dashboard') }}" class="rounded-lg border border-neutral-300 px-3 py-2 text-sm font-medium text-neutral-700 hover:border-neutral-400 dark:border-neutral-700 dark:text-neutral-200">
                Back
            </a>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            @csrf

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-200">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-4">
                <label class="flex flex-col gap-1 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Name
                    <input type="text" name="name" value="{{ old('name') }}" required class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100" />
                </label>

                <label class="flex flex-col gap-1 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" required class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100" />
                </label>

                <label class="flex flex-col gap-1 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Role
                    <select name="role" required class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @selected(old('role', 'none') === $role)>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-1 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Password
                    <input type="password" name="password" required class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100" />
                </label>

                <label class="flex flex-col gap-1 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                    Confirm password
                    <input type="password" name="password_confirmation" required class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100" />
                </label>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="rounded-lg bg-neutral-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-neutral-800 dark:bg-white dark:text-neutral-900">
                    Create account
                </button>
                <a href="{{ route('dashboard') }}" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 hover:border-neutral-400 dark:border-neutral-700 dark:text-neutral-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
