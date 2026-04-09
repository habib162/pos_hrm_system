<div x-data="{ toast: null, toastType: 'success' }"
     x-on:toast-success.window="toast = $event.detail.message; toastType='success'; setTimeout(() => toast = null, 3000)"
     x-on:toast-error.window="toast = $event.detail.message; toastType='error'; setTimeout(() => toast = null, 3000)">

    <div x-show="toast" x-transition
         :class="toastType === 'success' ? 'bg-green-600' : 'bg-red-600'"
         class="fixed top-5 right-5 z-50 text-white px-5 py-3 rounded-lg shadow-lg text-sm"
         style="display:none" x-text="toast"></div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sales History</h1>
            <p class="text-sm text-gray-500 mt-1">Today: <span class="font-semibold text-gray-800">{{ $todayCount }} sales</span> · <span class="font-semibold text-indigo-600">{{ setting('currency_symbol','৳') }}{{ number_format($todayTotal,2) }}</span></p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4 flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[180px]">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search invoice..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input wire:model.live="dateFrom" type="date" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        <input wire:model.live="dateTo" type="date" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        <select wire:model.live="methodFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <option value="">All Methods</option>
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="mobile">Mobile</option>
            <option value="split">Split</option>
        </select>
        <select wire:model.live="statusFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="refunded">Refunded</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Invoice</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Customer</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Cashier</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Method</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Total</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Date</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($sales as $sale)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-700">{{ $sale->invoice_no }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $sale->user?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-blue-50 text-blue-700 capitalize">{{ $sale->payment_method }}</span>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-gray-800">{{ setting('currency_symbol','৳') }}{{ number_format($sale->total,2) }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            {{ $sale->status === 'completed' ? 'bg-green-100 text-green-700' : ($sale->status === 'refunded' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $sale->created_at->format(setting('date_format','d/m/Y')) }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <button wire:click="viewSale({{ $sale->id }})"
                                    class="text-indigo-500 hover:text-indigo-700 p-1 rounded hover:bg-indigo-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            @if($sale->status !== 'refunded')
                            @if($confirmRefund === $sale->id)
                            <button wire:click="refundSale" class="text-xs bg-red-600 text-white px-2 py-1 rounded">Confirm</button>
                            <button wire:click="cancelRefund" class="text-xs text-gray-500 px-1">✕</button>
                            @else
                            <button wire:click="confirmRefundSale({{ $sale->id }})"
                                    class="text-orange-400 hover:text-orange-600 p-1 rounded hover:bg-orange-50" title="Refund">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                            </button>
                            @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400">No sales found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-100">{{ $sales->links() }}</div>
    </div>

    {{-- Sale Detail Modal --}}
    @if($viewingSale)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" wire:click.self="closeSaleModal">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 max-h-[85vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <h2 class="font-bold text-gray-900">{{ $viewingSale->invoice_no }}</h2>
                    <p class="text-xs text-gray-400">{{ $viewingSale->created_at->format(setting('date_format','d/m/Y') . ' H:i') }}</p>
                </div>
                <button wire:click="closeSaleModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><span class="text-gray-500">Customer:</span> <span class="font-medium">{{ $viewingSale->customer?->name ?? 'Walk-in' }}</span></div>
                    <div><span class="text-gray-500">Cashier:</span> <span class="font-medium">{{ $viewingSale->user?->name }}</span></div>
                    <div><span class="text-gray-500">Payment:</span> <span class="font-medium capitalize">{{ $viewingSale->payment_method }}</span></div>
                    <div><span class="text-gray-500">Status:</span>
                        <span class="font-medium {{ $viewingSale->status === 'completed' ? 'text-green-600' : ($viewingSale->status === 'refunded' ? 'text-red-600' : 'text-yellow-600') }}">
                            {{ ucfirst($viewingSale->status) }}
                        </span>
                    </div>
                </div>
                <table class="w-full text-sm border border-gray-100 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-3 py-2 text-gray-600 text-xs">Item</th>
                            <th class="text-center px-3 py-2 text-gray-600 text-xs">Qty</th>
                            <th class="text-right px-3 py-2 text-gray-600 text-xs">Price</th>
                            <th class="text-right px-3 py-2 text-gray-600 text-xs">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($viewingSale->saleItems as $item)
                        <tr>
                            <td class="px-3 py-2 text-gray-800">{{ $item->product_name }}</td>
                            <td class="px-3 py-2 text-center text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ setting('currency_symbol','৳') }}{{ number_format($item->unit_price,2) }}</td>
                            <td class="px-3 py-2 text-right font-semibold">{{ setting('currency_symbol','৳') }}{{ number_format($item->subtotal,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-gray-100 pt-3 space-y-1 text-sm">
                    <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($viewingSale->subtotal,2) }}</span></div>
                    @if($viewingSale->tax > 0)<div class="flex justify-between text-gray-600"><span>Tax</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($viewingSale->tax,2) }}</span></div>@endif
                    @if($viewingSale->discount > 0)<div class="flex justify-between text-red-500"><span>Discount</span><span>-{{ setting('currency_symbol','৳') }}{{ number_format($viewingSale->discount,2) }}</span></div>@endif
                    <div class="flex justify-between font-bold text-base text-gray-900 pt-1 border-t border-gray-100">
                        <span>Total</span><span class="text-indigo-600">{{ setting('currency_symbol','৳') }}{{ number_format($viewingSale->total,2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500"><span>Paid</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($viewingSale->paid,2) }}</span></div>
                    <div class="flex justify-between text-gray-500"><span>Change</span><span>{{ setting('currency_symbol','৳') }}{{ number_format($viewingSale->change,2) }}</span></div>
                </div>
                @if($viewingSale->status !== 'refunded' && $confirmRefund !== $viewingSale->id)
                <button wire:click="confirmRefundSale({{ $viewingSale->id }})"
                        class="w-full py-2 border border-red-200 text-red-600 rounded-lg text-sm hover:bg-red-50 transition mt-2">
                    Refund Sale
                </button>
                @elseif($confirmRefund === $viewingSale->id)
                <div class="flex gap-2">
                    <button wire:click="refundSale" class="flex-1 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">Confirm Refund</button>
                    <button wire:click="cancelRefund" class="flex-1 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Cancel</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
