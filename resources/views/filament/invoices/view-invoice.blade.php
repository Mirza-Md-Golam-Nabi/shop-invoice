@php
    use Illuminate\Support\Number;

    $total = round((float) $record->subtotal - (float) $record->discount, 2);

    $inWord = ucwords(str_replace('-', ' ', Number::spell($total)));
    $inWord .= ' Only /-';
@endphp

{{-- PDF button --}}
<form method="GET" action="{{ route('invoices.pdf', $record->id) }}" target="_blank"
    class="flex flex-row justify-end items-stretch sm:items-center gap-2 mb-4">
    <select name="page_size"
        class="border border-gray-300 rounded-md text-sm px-4 py-2 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#1a237e]">
        <option value="A5" selected>A5</option>
        <option value="A4">A4</option>
    </select>
    <button type="submit"
        class="inline-flex items-center justify-center gap-2 bg-[#1a237e] hover:bg-[#283593] text-white text-sm font-semibold px-4 py-2 rounded-md transition-colors">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Print Invoice
    </button>
</form>

<div class="max-w-3xl mx-auto font-sans text-[12px] sm:text-[13px] text-[#111]">
    <div class="border-2 border-[#1a237e]">

        {{-- ── Header ── --}}
        <div class="bg-[#1a237e] px-3 sm:px-5 py-3 sm:py-3.5 flex flex-row sm:flex-row justify-between items-start gap-3 sm:gap-4">

            {{-- Left: Logo + Name --}}
            <div class="flex items-start gap-2.5 sm:gap-3 flex-1">
                {{-- <div class="w-[44px] h-[44px] sm:w-[52px] sm:h-[52px] bg-white/15 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="1.6"
                        stroke="white" class="sm:w-7 sm:h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                </div> --}}
                <div>
                    <div
                        class="inline-block border border-white/50 rounded-full px-2 py-px text-[9px] sm:text-[10px] text-white/80 mb-1 tracking-wide">
                        Cash Memo</div>
                    <div class="text-[20px] sm:text-[26px] font-black text-white leading-none tracking-tight">Camera Ark</div>
                    <div class="text-sm sm:text-lg font-bold text-white/90 mt-0.5 leading-tight">ক্যামেরা আর্ক</div>
                    <div class="text-[9px] sm:text-[10.5px] text-white/70 mt-1.5 leading-relaxed">Sony, Canon, Nikon, Fujifilm, Gopro,
                        DJI, Sigma, Tamron, Viltrox, Sandisk, Rode, Godox</div>
                </div>
            </div>

            {{-- Right: Contact --}}
            <div class="flex-shrink-0 w-auto grid grid-cols-1 gap-x-3 gap-y-1 sm:gap-y-0">
                <div class="flex items-start gap-1.5 sm:mb-1 text-[10.5px] sm:text-[11.5px] text-white/90 leading-snug">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mt-0.5 flex-shrink-0 text-white/60">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <div class="flex items-start gap-1 text-[10.5px] sm:text-[11.5px] text-white/90 leading-snug">
                        <span class="font-medium whitespace-nowrap">Mobile :</span>
                        <div class="font-mono leading-relaxed">
                            <div>01934-335251</div>
                            <div>01776-369004</div>
                        </div>
                    </div>
                </div>
                <div class="flex items-start gap-1.5 sm:mb-1 text-[10.5px] sm:text-[11.5px] text-white/90 leading-snug">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mt-0.5 flex-shrink-0 text-white/60">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    <div class="text-[10.5px] sm:text-[11.5px] text-white/90 leading-snug">Shop No #9, Block #D<br>Baitulmukarram, Dhaka-1000</div>
                </div>
                <div class="flex items-start gap-1.5 sm:mb-1 text-[10.5px] sm:text-[11.5px] text-white/90">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mt-0.5 flex-shrink-0 text-white/60">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <div>cameraarkbd@gmail.com</div>
                </div>
                <div class="flex items-start gap-1.5 text-[10.5px] sm:text-[11.5px] text-white/90">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mt-0.5 flex-shrink-0 text-white/60">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253" />
                    </svg>
                    <div>www.cameraark.com</div>
                </div>
            </div>
        </div>

        {{-- ── Memo title row ── --}}
        <div
            class="bg-[#e8eaf6] border-t-[1.5px] border-b-[1.5px] border-[#1a237e] px-3 sm:px-5 py-1.5 flex items-center justify-between gap-2">
            <div class="flex items-center gap-1 text-[11px] sm:text-[12.5px] font-semibold text-[#1a237e]">
                No. &nbsp;<span class="font-bold text-[12px] sm:text-[14px] text-[#111]">{{ $record->invoice_no }}</span>
            </div>
            <div class="flex items-center gap-1 text-[11px] sm:text-[12.5px] font-semibold text-[#1a237e]">
                Date: &nbsp;<span
                    class="font-bold text-[12px] sm:text-[14px] text-[#111]">{{ $record->date->format('d / m / Y') }}</span>
            </div>
        </div>

        {{-- ── Customer ── --}}
        <div class="px-3 sm:px-5 py-2 border-b border-[#9fa8da] flex flex-row gap-1.5 sm:gap-0">
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-[#1a237e] flex-1">
                M/S: &nbsp;<span
                    class="font-bold text-[12px] text-[#111] border-b border-[#9fa8da] min-w-28 sm:min-w-36 pb-px">{{ $record->customer_name }}</span>
            </div>
            <div class="flex items-center gap-1.5 text-[11px] font-semibold text-[#1a237e] flex-1">
                Address: &nbsp;<span
                    class="font-bold text-[12px] text-[#111] border-b border-[#9fa8da] min-w-28 sm:min-w-36 pb-px">{{ $record->customer_address ?? '—' }}</span>
            </div>
        </div>

        {{-- ── Items Table ── --}}
        <div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#1a237e]">
                        <th class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-left text-[11px] sm:text-[12.5px] font-bold text-white border-r border-white/25 w-8 sm:w-9">
                            #</th>
                        <th class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-left text-[11px] sm:text-[12.5px] font-bold text-white border-r border-white/25">
                            Description</th>
                        <th
                            class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-center text-[11px] sm:text-[12.5px] font-bold text-white border-r border-white/25 w-14 sm:w-20">
                            Qty</th>
                        <th
                            class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right text-[11px] sm:text-[12.5px] font-bold text-white border-r border-white/25 w-18 sm:w-28">
                            Rate</th>
                        <th class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right text-[11px] sm:text-[12.5px] font-bold text-white w-18 sm:w-28">Taka</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record->items->load('product') as $index => $item)
                        <tr class="border-b border-[#c5cae9]">
                            <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-center text-gray-400 border-r border-[#c5cae9]">
                                {{ $index + 1 }}</td>
                            <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 border-r border-[#c5cae9] align-top">
                                <div class="font-semibold text-[#111]">{{ $item->product?->name ?? '—' }}</div>
                                @if ($item->description && $item->description !== $item->product?->name)
                                    <div class="text-[10.5px] sm:text-[11.5px] text-[#777] mt-0.5">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-center border-r border-[#c5cae9]">{{ (int) $item->quantity }}
                            </td>
                            <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right border-r border-[#c5cae9]">
                                {{ number_format($item->rate, 2) }}</td>
                            <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right font-bold">{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400">No items found.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="border-t border-[#c5cae9] bg-orange-50">
                        <td colspan="3"></td>
                        <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right text-[11px] sm:text-[12px] font-semibold text-[#555] border-r border-[#9fa8da]">
                            <div>Sub Total</div>
                            @if ((float) $record->discount > 0)
                                <div style="padding-top:2px;">Discount</div>
                            @endif
                        </td>
                        <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right font-bold text-[#c62828]">
                            <div>{{ number_format($record->subtotal, 2) }}</div>
                            @if ((float) $record->discount > 0)
                                <div style="padding-top:2px;">{{ number_format($record->discount, 2) }}</div>
                            @endif
                        </td>
                    </tr>
                    <tr class="bg-[#e8eaf6] border-t-2 border-[#1a237e]">
                        <td colspan="3"></td>
                        <td
                            class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right text-[12px] sm:text-[13.5px] font-bold text-[#1a237e] border-r border-[#9fa8da]">
                            Total</td>
                        <td class="py-2 sm:py-2.5 px-2 sm:px-3.5 text-right text-[13px] sm:text-[14px] font-black text-[#111]">৳
                            {{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ── In Word ── --}}
        <div class="border-t-[1.5px] border-[#1a237e] px-3 sm:px-5 py-2 sm:py-2.5 flex items-start sm:items-center gap-2 text-[11px] sm:text-[12.5px]">
            <span class="font-bold text-[#1a237e] whitespace-nowrap flex-shrink-0">In Word :</span>
            <span
                class="italic font-semibold text-[#111] border-b border-dashed border-[#9fa8da] flex-1 pb-px">{{ $inWord }}</span>
        </div>

        {{-- ── Footer: Signatures ── --}}
        <div class="border-t-[1.5px] border-[#1a237e] px-4 sm:px-6 pt-4 pb-5 flex justify-between items-end">
            <div style="margin-top: 30px;">
                <div class="border-t-2 border-[#111] w-28 sm:w-40 mb-1"></div>
                <div class="text-[10.5px] sm:text-[11.5px] font-semibold text-[#333]">Client</div>
            </div>
            <div class="text-right">
                <div class="border-t-2 border-[#111] w-28 sm:w-40 mb-1 ml-auto"></div>
                <div class="text-[10.5px] sm:text-[11.5px] font-semibold text-[#333]">For: Camera Ark</div>
            </div>
        </div>

    </div>
</div>
