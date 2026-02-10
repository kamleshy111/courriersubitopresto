<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; font-size: 8pt; }
table { border-collapse: collapse; page-break-inside: avoid; }
td { vertical-align: top; }
.logo-cell img { max-width: 16mm; max-height: 12mm; object-fit: contain; }
</style>
</head>
<body style="margin:0; padding:0;">

<!-- PDF matches preview layout: Header | NIR | BORDEREAU | Address (shipper + codes) | Tracking + recipient -->
<div style="border: 2px solid #000; height: 70mm; margin-bottom: 3mm; page-break-inside: avoid;">
<table cellpadding="0" cellspacing="0" border="0" style="width: 100%; height: 100%;">
    <!-- Header: Logo | Postage | Courier -->
    <tr>
        <td width="10%" style="border-right: 2px solid #000; text-align: center; padding: 1.5mm;" class="logo-cell">
            @include('admin.waybills.partials.waybill-logo', ['maxWidth' => '25mm', 'maxHeight' => '12mm'])
        </td>
        <td width="26%" style="padding: 1.5mm; font-size: 8pt; line-height: 1.25;">
            US POSTAGE<br>PAID<br>
            @if($shipper && $shipper->postal_code)
                From {{ preg_replace('/\s+/', '', $shipper->postal_code) }}<br>
            @endif
            @if($waybill->status)
                <strong>{{ strtoupper(str_replace('_', ' ', $waybill->status)) }}</strong>
            @endif
        </td>
        <td width="35%" style="padding: 1.5mm; font-size: 8pt; line-height: 1.2;">
            <strong>Courier</strong> #{{ str_pad($waybill->id, 10, '0', STR_PAD_LEFT) }}<br>
            @if($waybill->description){{ \Str::limit($waybill->description, 25) }}<br>@endif
            @if($waybill->weight_1)Wt: {{ $waybill->weight_1 }}<br>@endif
            @if($waybill->total)Total: {{ $waybill->total }}<br>@endif
            @if($waybill->who_pay)Pay: {{ ucfirst($waybill->who_pay) }}@endif
        </td>
        <td width="20%" style="padding: 1.5mm; font-size: 8pt; line-height: 1.2;">
            <span style="white-space: nowrap;">{{ $waybill->created_at ? $waybill->created_at->format('m/d/Y H:i') : ($waybill->date ? \Carbon\Carbon::parse($waybill->date)->format('m/d/Y') : date('m/d/Y')) }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center; font-size: 9pt; padding: 0.5mm 0; border-top: 1px solid #000;">(NIR): R5608402</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center; font-size: 11pt; font-weight: bold; padding: 1mm 0; border-top: 2px solid #000;">BORDEREAU / WAYBILL</td>
    </tr>
    <!-- Address: Shipper (left) | Code + 1/4 (right) -->
    <tr>
        <td colspan="4" style="padding: 2mm; border-top: 2px solid #000;">
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                    <td style="font-size: 9pt; line-height: 1.2; width: 65%; font-weight: bold;">
                        @if($shipper)
                            {{ $shipper->name ?? 'N/A' }}<br>
                            {{ $shipper->address ?? '' }}{{ !empty($shipper->address_ext) ? ', ' . $shipper->address_ext : '' }}<br>
                            {{ $shipper->city_name ?? '' }} {{ $shipper->city_state ?? '' }} {{ $shipper->postal_code ?? '' }}
                        @else — @endif
                    </td>
                    <td style="text-align: right; width: 35%;">
                        <div style="font-size: 14pt; font-weight: bold; padding: 0.5mm 1.5mm; margin-bottom: 1mm; min-width: 40mm; text-align: center;">
                            {{ $waybill->user && $waybill->user->client ? $waybill->user->client->prefix . str_pad($waybill->soft_id, 6, '0', STR_PAD_LEFT) : str_pad($waybill->soft_id ?? $waybill->id, 6, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="font-size: 14pt; font-weight: bold; border: 1px solid #000; padding: 0.5mm 1.5mm; min-width: 55mm; text-align: center;">{{ $pageNo }}/{{ $totalPage }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Tracking + Recipient (to-address) -->
    <tr>
        <td colspan="4" style="height: 50px;"></td>
    </tr>
    <tr>
        <td colspan="4" style="padding: 2mm; border-top: 1px solid #ccc;">
            <div style="font-size: 11pt; font-weight: bold; line-height: 1.2; text-transform: uppercase;">
                @if($recipient)
                    {{ strtoupper($recipient->name ?? 'N/A') }}<br>
                    {{ strtoupper($recipient->address ?? '') }}{{ !empty($recipient->address_ext) ? ', ' . strtoupper($recipient->address_ext) : '' }}<br>
                    {{ strtoupper($recipient->city_name ?? '') }} {{ strtoupper($recipient->city_state ?? '') }} {{ $recipient->postal_code ?? '' }}
                @else — @endif
            </div>
        </td>
    </tr>
</table>
</div>

</body>
</html>
