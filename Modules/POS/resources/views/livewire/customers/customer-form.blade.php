<div>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pos.customers.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $customerId ? 'Edit Customer' : 'Add Customer' }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $customerId ? 'Update customer details' : 'Register a new customer' }}</p>
        </div>
    </div>

    <form wire:submit="save" class="max-w-xl space-y-5">
        <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input wire:model="name" type="text" placeholder="Customer name"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input wire:model="phone" type="text" placeholder="Phone number"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input wire:model="email" type="email" placeholder="Email address"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea wire:model="address" rows="2" placeholder="Full address..."
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Credit Limit ({{ setting('currency_symbol','৳') }})</label>
                <input wire:model="credit_limit" type="number" step="0.01" min="0"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition disabled:opacity-60">
                <span wire:loading.remove>{{ $customerId ? 'Update' : 'Save' }}</span>
                <span wire:loading>Saving...</span>
            </button>
            <a href="{{ route('pos.customers.index') }}"
               class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">Cancel</a>
        </div>
    </form>
</div>
