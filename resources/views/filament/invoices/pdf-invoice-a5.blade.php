<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-size: 11px;
            color: #333;
        }

        {!! $css !!}
    </style>
</head>

<body>

    <div class="border-2 border-[#1a237e]">

        <div style="width:100%; text-align:center; padding:5px;">
            Cash Memo
        </div>
        {{-- ── Header ── --}}
        <table style="width:100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td class="px-5 py-3" style="width:53%;">
                    <div class="font-black text-[#fff] leading-none tracking-tight" style="font-size:30px;">Camera Ark
                    </div>
                    <div class="text-[14px] font-bold text-[#c5cae9] mt-0.5 leading-tight">ক্যামেরা আর্ক</div>
                    <div class="text-[9.5px] text-[#9fa8da] mt-1.5 leading-relaxed">Sony, Canon, Nikon, Fujifilm, Gopro,
                        DJI, Sigma, Tamron, Viltrox, Sandisk, Rode, Godox</div>
                </td>
                <td style="width:9%;"></td>
                <td class="px-5 py-3" style="width:38%; text-align:right;">
                    <table cellpadding="0" cellspacing="0" style="width:100%;">
                        <tr>
                            <td style="padding-bottom:2px; text-align:right;">Mobile : 01934-335251 01776-369004</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:2px; text-align:right;">Shop No #9, Block #D, Baitulmukarram,
                                Dhaka-1000</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:2px; text-align:right;">cameraarkbd@gmail.com</td>
                        </tr>
                        <tr>
                            <td style="text-align:right;">www.cameraark.com</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- ── Memo title row ── --}}
        <table style="width:100%; margin:10px 0;" class="bg-[#e8eaf6]" cellpadding="0" cellspacing="0">
            <tr>
                <td class="px-5 py-1.5" style="width:67%;">
                    <span style="font-weight: bold;">Invoice No. &nbsp;</span>
                    {{ $record->invoice_no }}
                </td>
                <td class="px-5 py-1.5 text-[12px] font-semibold text-[#1a237e]" style="width:33%; text-align:right;">
                    <span style="font-weight: bold;">Date: &nbsp;</span>
                    {{ $record->date->format('d - M - Y') }}
                </td>
            </tr>
        </table>

        {{-- ── Customer ── --}}
        <table style="width:100%; padding-bottom: 5px; border-bottom:1px solid #9fa8da;" cellpadding="0"
            cellspacing="0">
            <tr>
                <td class="px-5 py-2" style="width:50%; vertical-align:middle;">
                    <span style="font-weight: bold;">M/S:&nbsp;</span>
                    {{ $record->customer_name }}
                </td>
                <td class="px-5 py-2" style="width:50%; vertical-align:middle;">
                    <span style="font-weight: bold;">Address:</span>&nbsp;
                    <span class="font-bold text-[13px] text-[#111]">{{ $record->customer_address ?? '' }}</span>
                </td>
            </tr>
        </table>

        {{-- ── Items Table ── --}}
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="width:8%; text-align:center; border:1px solid #333; padding:6px;">S.N</th>
                    <th style="width:42%; text-align:left; border:1px solid #333; padding:6px;">Product Description</th>
                    <th style="width:15%; text-align:center; border:1px solid #333; padding:6px;">Quantity</th>
                    <th style="width:17%; text-align:center; border:1px solid #333; padding:6px;">Rate</th>
                    <th style="width:18%; text-align:center; border:1px solid #333; padding:6px;">Taka</th>
                </tr>
            </thead>
            <tbody>
                @forelse($record->items as $index => $item)
                    <tr>
                        <td
                            style="text-align:center; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            {{ $index + 1 }}
                        </td>
                        <td style="border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            <div class="font-semibold text-[13px] text-[#111]">{{ $item->product?->name ?? '—' }}</div>
                            @if ($item->description && $item->description !== $item->product?->name)
                                <div class="text-[11px] text-[#777] mt-0.5">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td
                            style="text-align:center; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            {{ (int) $item->quantity }}</td>
                        <td
                            style="text-align:right; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            {{ number_format($item->rate, 2) }}</td>
                        <td
                            style="text-align:right; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            {{ number_format($item->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:24px; color:#aaa; font-size:12px;">No items
                            found.</td>
                    </tr>
                @endforelse
                @for ($i = 0; $i < $emptyRows; $i++)
                    <tr>
                        <td
                            style="text-align:center; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            &nbsp;
                        </td>
                        <td style="border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            &nbsp;
                        </td>
                        <td
                            style="text-align:center; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            &nbsp;
                        </td>
                        <td
                            style="text-align:right; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            &nbsp;
                        </td>
                        <td
                            style="text-align:right; border-left: 1px solid #333; border-right:1px solid #333; padding:6px;">
                            &nbsp;
                        </td>
                    </tr>
                @endfor
            </tbody>
            <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right; border: 1px solid #333; padding:6px;">
                            <div>Sub Total</div>
                            @if ((float) $record->discount > 0)
                            <div style="padding-top:5px;">Discount</div>
                            @endif
                        </td>
                        <td style="text-align:right; border: 1px solid #333; padding:6px;">
                            <div>
                                {{ number_format($record->subtotal, 2) }}
                            </div>
                            @if ((float) $record->discount > 0)
                            <div style="padding-top:5px;">
                                {{ number_format($record->discount, 2) }}
                            </div>
                            @endif
                        </td>
                    </tr>
                <tr>
                    <td colspan="4" style="text-align:right; border: 1px solid #333; padding:6px;">Total</td>
                    <td style="text-align:right; border: 1px solid #333; padding:6px;">{{ number_format($total, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        {{-- ── In Word ── --}}
        <div style="margin-top:10px;">
            <span class="font-bold">In Word : </span>
            <span class="italic font-semibold">{{ $inWord }}</span>
        </div>

        {{-- ── Signatures ── --}}
        <table style="width:100%; margin-top:70px;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:50%; font-size:12px;">
                    Receiver's Signature
                </td>
                <td style="width:50%; font-size:12px; text-align:right;">
                    For: Camera Ark
                </td>
            </tr>
        </table>

    </div>
</body>

</html>
