<div class="flex h-[calc(100vh-4rem)] overflow-hidden bg-gray-100"
     x-data="{ toast: null, toastType: 'success' }"
     x-on:toast-success.window="toast = $event.detail.message; toastType='success'; setTimeout(() => toast = null, 3500)"
     x-on:toast-error.window="toast = $event.detail.message; toastType='error'; setTimeout(() => toast = null, 3500)">

    {{-- TOAST --}}
    <div x-show="toast" x-transition
         :class="toastType === 'success' ? 'bg-green-600' : 'bg-red-600'"
         class="fixed top-5 right-5 z-50 text-white px-5 py-3 rounded-lg shadow-lg text-sm font-medium"
         style="display:none" x-text="toast"></div>

    {{-- LEFT PANEL (60%) --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Search & Category Filter --}}
        <div class="bg-white border-b border-gray-200 p-4 space-y-3 flex-shrink-0">
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text"
                       placeholder="Search by name, SKU or scan barcode..."
                       autofocus
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div class="flex gap-2 flex-wrap">
                <button wire:click="filterByCategory(null)"
                        class="px-3 py-1 rounded-full text-xs font-medium border transition
                               {{ $filterCategory === null ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                    All
                </button>
                @foreach($categories as $cat)
                <button wire:click="filterByCategory({{ $cat['id'] }})"
                        class="px-3 py-1 rounded-full text-xs font-medium border transition
                               {{ $filterCategory === $cat['id'] ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                    {{ $cat['name'] }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Product Grid --}}
        <div class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-3 gap-3">
                @forelse($products as $product)
                <button wire:click="addToCart({{ $product['id'] }})"
                        class="bg-white rounded-xl border border-gray-200 p-3 text-left hover:border-indigo-400 hover:shadow-md transition-all group relative">
                    @if($product['is_low_stock'])
                    <span class="absolute top-2 right-2 bg-orange-100 text-orange-700 text-[10px] font-semibold px-1.5 py-0.5 rounded-full">Low</span>
                    @endif
                    @if($product['stock'] <= 0)
                    <span class="absolute top-2 right-2 bg-red-100 text-red-700 text-[10px] font-semibold px-1.5 py-0.5 rounded-full">Out</span>
                    @endif
                    <div class="h-20 bg-gray-50 rounded-lg mb-2 flex items-center justify-center overflow-hidden">
                        @if($product['image'])
                        <img src="{{ Storage::url($product['image']) }}" class="h-full w-full object-cover rounded-lg" alt="{{ $product['name'] }}">
                        @else
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-gray-800 truncate group-hover:text-indigo-700">{{ $product['name'] }}</p>
                    <p class="text-sm font-bold text-indigo-600 mt-1">{{ setting('currency_symbol','৳') }}{{ number_format($product['sale_price'],2) }}</p>
                    <p class="text-[10px] text-gray-400">Stock: {{ $product['stock'] }}</p>
                </button>
                @empty
                <div class="col-span-3 py-20 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p>No products found</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL (40%) --}}
    <div class="w-96 bg-white border-l border-gray-200 flex flex-col flex-shrink-0">

        {{-- Customer Search --}}
        <div class="p-4 border-b border-gray-100 flex-shrink-0" x-data="{ open: false }">
            <div class="relative">
                <input wire:model.live.debounce.300ms="customerSearch"
                       wire:keyup="searchCustomer"
                       x-on:focus="open = true"
                       x-on:click.away="open = false"
                       type="text" placeholder="Search customer (optional)..."
                       class="w-full pl-8 pr-8 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <svg class="absolute left-2.5 top-2.5 w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                @if($selectedCustomerId)
                <button wire:click="clearCustomer" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @endif
                @if(count($customerResults) > 0)
                <div x-show="open" class="absolute z-20 top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg mt-1 max-h-40 overflow-y-auto">
                    @foreach($customerResults as $cust)
                    <button wire:click="selectCustomer({{ $cust['id'] }})" x-on:click="open = false"
                            class="w-full text-left px-3 py-2 text-sm hover:bg-indigo-50 border-b border-gray-50 last:border-0">
                        <span class="font-medium">{{ $cust['name'] }}</span>
                        @if($cust['phone']) <span class="text-gray-400 text-xs ml-1">{{ $cust['phone'] }}</span> @endif
                        <span class="float-right text-xs text-indigo-500">{{ $cust['points'] }} pts</span>
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Cart Items --}}
        <div class="flex-1 overflow-y-auto">
            @if(empty($cart))
            <div class="flex flex-col items-center justify-center h-full text-gray-300 py-12">
                <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-sm">Cart is empty</p>
                <p class="text-xs mt-1">Click products to add</p>
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($cart as $index => $item)
                <div class="px-4 py-3">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-sm font-medium text-gray-800 flex-1 leading-tight">{{ $item['name'] }}</p>
                        <button wire:click="removeFromCart({{ $index }})" class="text-gray-300 hover:text-red-500 flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mt-2 gap-2">
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <button wire:click="updateQty({{ $index }}, {{ $item['qty'] - 1 }})" class="px-2 py-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-sm">−</button>
                            <span class="px-3 py-1 text-sm font-semibold min-w-[2rem] text-center">{{ $item['qty'] }}</span>
                            <button wire:click="updateQty({{ $index }}, {{ $item['qty'] + 1 }})" class="px-2 py-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-sm">+</button>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400">{{ setting('currency_symbol','৳') }}{{ number_format($item['unit_price'],2) }}</span>
                            <span class="text-sm font-bold text-indigo-600">{{ setting('currency_symbol','৳') }}{{ number_format($item['subtotal'],2) }}</span>
                        </div>
                    </div>
                    <div class="mt-1.5 flex items-center gap-2">
                        <label class="text-[11px] text-gray-400">Disc:</label>
                        <input type="number" min="0" step="0.01"
                               wire:change="updateDiscount({{ $index }}, $event.target.value)"
                               value="{{ $item['discount'] }}"
                               class="w-20 text-xs border border-gray-200 rounded px-2 py-0.5 focus:ring-1 focus:ring-indigo-400">
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Order Summary & Actions --}}
        <div class="border-t border-gray-200 p-4 space-y-3 flex-shrink-0 bg-gray-50">
            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>{{ setting('currency_symbol','৳') }}{{ number_format($this->subtotal,2) }}</span>
                </div>
                @if($this->tax > 0)
                <div class="flex justify-between text-gray-600">
                    <span>Tax ({{ setting('tax_percentage',0) }}%)</span>
                    <span>{{ setting('currency_symbol','৳') }}{{ number_format($this->tax,2) }}</span>
                </div>
                @endif
                @if($discount > 0)
                <div class="flex justify-between text-gray-600">
                    <span>Discount</span>
                    <span class="text-red-500">-{{ setting('currency_symbol','৳') }}{{ number_format($discount,2) }}</span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-lg text-gray-900 pt-1 border-t border-gray-200">
                    <span>TOTAL</span>
                    <span class="text-indigo-600">{{ setting('currency_symbol','৳') }}{{ number_format($this->total,2) }}</span>
                </div>
            </div>

            <div class="flex gap-2">
                <input wire:model="discount" type="number" min="0" step="0.01"
                       placeholder="Order discount..."
                       class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <select wire:model="paymentMethod" class="text-sm border border-gray-200 rounded-lg px-2 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="mobile">Mobile</option>
                    <option value="split">Split</option>
                </select>
            </div>

            <textarea wire:model="note" placeholder="Note (optional)..."
                      rows="1" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>

            <div class="flex gap-2">
                <button wire:click="clearCart" class="flex-1 py-2 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                    Clear
                </button>
                <button wire:click="openPaymentModal"
                        @disabled(empty($cart))
                        class="flex-1 py-2.5 text-sm font-semibold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition disabled:opacity-40 disabled:cursor-not-allowed">
                    Checkout
                </button>
            </div>
        </div>
    </div>

    {{-- PAYMENT MODAL --}}
    @if($showPaymentModal)
    <div class="fixed inset-0 z-40 flex items-center justify-center bg-black/50 backdrop-blur-sm" wire:click.self="$set('showPaymentModal', false)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 text-white">
                <h2 class="text-lg font-bold">Payment</h2>
                <p class="text-indigo-200 text-sm">{{ $paymentMethod === 'cash' ? 'Cash' : ($paymentMethod === 'card' ? 'Card' : ($paymentMethod === 'mobile' ? 'Mobile' : 'Split')) }} Payment</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-indigo-50 rounded-xl p-4 text-center">
                    <p class="text-sm text-gray-500">Total Amount</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ setting('currency_symbol','৳') }}{{ number_format($this->total,2) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Received</label>
                    <input wire:model.live="amountPaid" type="number" min="{{ $this->total }}" step="0.01"
                           class="w-full text-center text-2xl font-bold border-2 border-indigo-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="bg-green-50 rounded-xl p-3 flex justify-between items-center">
                    <span class="text-sm text-gray-600 font-medium">Change</span>
                    <span class="text-xl font-bold {{ $this->change >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ setting('currency_symbol','৳') }}{{ number_format(max(0,$this->change),2) }}
                    </span>
                </div>
                {{-- Numpad shortcuts --}}
                <div class="grid grid-cols-4 gap-2">
                    @foreach([100,200,500,1000] as $quick)
                    <button wire:click="$set('amountPaid', {{ $quick }})"
                            class="py-2 text-sm border border-gray-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-300 font-medium text-gray-700 transition">
                        {{ $quick }}
                    </button>
                    @endforeach
                </div>
                <div class="flex gap-3 pt-2">
                    <button wire:click="$set('showPaymentModal', false)" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Cancel</button>
                    <button wire:click="checkout" wire:loading.attr="disabled"
                            class="flex-1 py-2.5 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition disabled:opacity-60">
                        <span wire:loading.remove wire:target="checkout">Confirm Payment</span>
                        <span wire:loading wire:target="checkout">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- RECEIPT MODAL --}}
    @if($showReceiptModal && $lastSale)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 max-h-[90vh] overflow-y-auto">
            <div id="receipt-content" class="p-6">
                {{-- Header --}}
                <div class="text-center border-b border-dashed border-gray-300 pb-4 mb-4">
                    @if(setting('company_logo'))
                    <img src="{{ Storage::url(setting('company_logo')) }}" class="h-12 mx-auto mb-2 object-contain" alt="Logo">
                    @endif
                    <h2 class="font-bold text-lg text-gray-900">{{ setting('company_name','POS System') }}</h2>
                    @if(setting('company_phone')) <p class="text-xs text-gray-500">{{ setting('company_phone') }}</p> @endif
                    @if(setting('company_address')) <p class="text-xs text-gray-500">{{ setting('company_address') }}</p> @endif
                </div>
                {{-- Invoice Info --}}
                <div class="text-xs space-y-1 mb-4">
                    <div class="flex justify-between"><span class="text-gray-500">Invoice:</span><span class="font-semibold">{{ $lastSale->invoice_no }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Date:</span><span>{{ $lastSale->created_at->format(setting('date_format','d/m/Y')) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Cashier:</span><span>{{ $lastSale->user->name }}</span></div>
                    @if($lastSale->customer)<div class="flex justify-between"><span class="text-gray-500">Customer:</span><span>{{ $lastSale->customer->name }}</span></div>@endif
                </div>
                {{-- Items --}}
                <table class="w-full text-xs mb-4">
                    <thead>
                        <tr class="border-t border-b border-dashed border-gray-300">
                            <th class="py-1 text-left text-gray-600">Item</th>
                            <th class="py-1 text-center text-gray-600">Qty</th>
                            <th class="py-1 text-right text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dashed divide-gray-200">
                        @foreach($lastSale->saleItems as $item)
                        <tr>
                            <td class="py-1 text-gray-800">{{ $item->product_name }}</td>
                            <td class="py-1 text-center text-gray-600">{{ $item->quantity }} × {{ setting('currency_symbol','৳') }}{{ number_format($item->unit_price,2) }}</td>
                            <td class="py-1 text-right font-medium">{{ setting('currency_symbol','৳') }}{{ number_format($item->subtotal,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Totals --}}
                <div class="border-t border-dashed border-gray-300 pt-3 space-y-1 text-xs">
                    <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($lastSale->subtotal,2) }}</span></div>
                    @if($lastSale->tax > 0)<div class="flex justify-between text-gray-600"><span>Tax</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($lastSale->tax,2) }}</span></div>@endif
                    @if($lastSale->discount > 0)<div class="flex justify-between text-red-500"><span>Discount</span><span>-{{ setting('currency_symbol','৳') }}{{ number_format($lastSale->discount,2) }}</span></div>@endif
                    <div class="flex justify-between font-bold text-base text-gray-900 pt-1 border-t border-dashed border-gray-300">
                        <span>TOTAL</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($lastSale->total,2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600"><span>Paid ({{ strtoupper($lastSale->payment_method) }})</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($lastSale->paid,2) }}</span></div>
                    <div class="flex justify-between text-gray-600"><span>Change</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($lastSale->change,2) }}</span></div>
                </div>
                @if(setting('receipt_footer'))
                <p class="text-center text-xs text-gray-400 mt-4 pt-3 border-t border-dashed border-gray-300">{{ setting('receipt_footer') }}</p>
                @endif
            </div>
            {{-- Actions --}}
            <div class="px-6 pb-6 flex gap-3">
                <button wire:click="printReceipt" x-on:click="window.print()"
                        class="flex-1 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
                    Print Receipt
                </button>
                <button wire:click="closeReceipt" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 font-medium">
                    New Sale
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
