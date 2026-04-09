<div x-data="{ toast: null }"
     x-on:toast-success.window="toast = $event.detail.message; setTimeout(() => toast = null, 3000)">

    <div x-show="toast" x-transition
         class="fixed top-5 right-5 z-50 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg text-sm"
         style="display:none" x-text="toast"></div>

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pos.products.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $productId ? 'Edit Product' : 'Add Product' }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $productId ? 'Update product details' : 'Create a new product' }}</p>
        </div>
    </div>

    <form wire:submit="save" class="grid grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800 border-b border-gray-100 pb-3">Basic Information</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                    <input wire:model.live="name" type="text" placeholder="Enter product name"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                        <input wire:model="sku" type="text" placeholder="Auto-generated"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:ring-2 focus:ring-indigo-500 @error('sku') border-red-400 @enderror">
                        @error('sku')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Barcode</label>
                        <input wire:model="barcode" type="text" placeholder="Optional barcode"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select wire:model="category_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select wire:model="type" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="standard">Standard</option>
                            <option value="variant">Variant</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="description" rows="3" placeholder="Product description..."
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800 border-b border-gray-100 pb-3">Pricing & Stock</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-sm text-gray-500">{{ setting('currency_symbol','৳') }}</span>
                            <input wire:model="purchase_price" type="number" step="0.01" min="0"
                                   class="w-full pl-7 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('purchase_price') border-red-400 @enderror">
                        </div>
                        @error('purchase_price')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-sm text-gray-500">{{ setting('currency_symbol','৳') }}</span>
                            <input wire:model="sale_price" type="number" step="0.01" min="0"
                                   class="w-full pl-7 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('sale_price') border-red-400 @enderror">
                        </div>
                        @error('sale_price')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stock Qty *</label>
                        <input wire:model="stock" type="number" min="0"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('stock') border-red-400 @enderror">
                        @error('stock')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alert Qty</label>
                        <input wire:model="alert_quantity" type="number" min="0"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                        <input wire:model="unit" type="text" placeholder="pcs, kg, l..."
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <h2 class="font-semibold text-gray-800 border-b border-gray-100 pb-3">Product Image</h2>
                @if($currentImage && ! $image)
                <img src="{{ Storage::url($currentImage) }}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                @endif
                @if($image)
                <img src="{{ $image->temporaryUrl() }}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                @endif
                <input wire:model="image" type="file" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:text-sm file:font-medium hover:file:bg-indigo-100">
                @error('image')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">Status</h2>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input wire:model="is_active" type="checkbox" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">Active (visible in POS)</span>
                </label>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-3">
                <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-2.5 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition disabled:opacity-60">
                    <span wire:loading.remove>{{ $productId ? 'Update Product' : 'Save Product' }}</span>
                    <span wire:loading>Saving...</span>
                </button>
                <a href="{{ route('pos.products.index') }}"
                   class="block text-center w-full py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
