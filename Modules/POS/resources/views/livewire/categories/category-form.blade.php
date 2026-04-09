<div>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pos.categories.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $categoryId ? 'Edit Category' : 'Add Category' }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $categoryId ? 'Update category details' : 'Create a new category' }}</p>
        </div>
    </div>

    <form wire:submit="save" class="max-w-xl space-y-5">
        <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
                <input wire:model="name" type="text" placeholder="Enter category name"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea wire:model="description" rows="3" placeholder="Optional description..."
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 resize-none @error('description') border-red-400 @enderror"></textarea>
                @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input wire:model="is_active" type="checkbox" class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition disabled:opacity-60">
                <span wire:loading.remove>{{ $categoryId ? 'Update' : 'Save' }}</span>
                <span wire:loading>Saving...</span>
            </button>
            <a href="{{ route('pos.categories.index') }}"
               class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">Cancel</a>
        </div>
    </form>
</div>
