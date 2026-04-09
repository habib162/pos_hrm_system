<div x-data="{ toast: null }"
     x-on:toast-success.window="toast = $event.detail.message; setTimeout(() => toast = null, 3000)">

    <div x-show="toast" x-transition
         class="fixed top-5 right-5 z-50 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg text-sm"
         style="display:none" x-text="toast"></div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Products</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your product catalogue</p>
        </div>
        <a href="{{ route('pos.products.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4 flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name or SKU..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <select wire:model.live="categoryFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="statusFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Product</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">SKU</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Category</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Price</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Stock</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="w-9 h-9 rounded-lg object-cover border border-gray-200">
                            @else
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">{{ ucfirst($product->type) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $product->sku }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-right font-semibold text-gray-800">{{ setting('currency_symbol','৳') }}{{ number_format($product->sale_price,2) }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $product->stock <= 0 ? 'bg-red-100 text-red-700' : ($product->is_low_stock ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700') }}">
                            {{ $product->stock }} {{ $product->unit }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button wire:click="toggleActive({{ $product->id }})"
                                class="text-xs px-2.5 py-1 rounded-full font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('pos.products.edit', $product) }}"
                               class="text-indigo-500 hover:text-indigo-700 p-1 rounded hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if($confirmDelete === $product->id)
                            <button wire:click="deleteProduct" class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Confirm</button>
                            <button wire:click="cancelDelete" class="text-xs text-gray-500 hover:text-gray-700 px-1">✕</button>
                            @else
                            <button wire:click="confirmDeleteProduct({{ $product->id }})"
                                    class="text-red-400 hover:text-red-600 p-1 rounded hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $products->links() }}</div>
    </div>
</div>
