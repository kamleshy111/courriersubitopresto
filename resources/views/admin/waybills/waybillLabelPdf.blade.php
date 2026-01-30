<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { margin: 0; padding: 0; font-family: Arial, sans-serif; font-size: 8pt; }
table { border-collapse: collapse; page-break-inside: avoid; }
td { vertical-align: top; }
.logo-cell img { width: 60px; height: auto; }
</style>
</head>
<body style="margin:0; padding:0;">

<table cellpadding="2" cellspacing="0" border="1" style="width: 100%; border: 1px solid #000; page-break-inside: avoid;">
    <!-- Header row: Logo | Postage | Courier -->
    <tr>
        <td width="20%" class="logo-cell" style="border-right: 3px solid #000; text-align: center; padding: 2px;">
            @include('admin.waybills.partials.waybill-logo')
        </td>
        <td width="25%" style="font-size: 8pt; line-height: 1.2; padding: 2px;">
            US POSTAGE<br>
            PAID<br>
            {{ $waybill->date ? \Carbon\Carbon::parse($waybill->date)->format('m/d/Y') : date('m/d/Y') }}<br>
            @if($shipper && $shipper->postal_code)
                From {{ preg_replace('/\s+/', '', $shipper->postal_code) }}<br>
            @endif
            @if($waybill->status)
                <strong>{{ strtoupper(str_replace('_', ' ', $waybill->status)) }}</strong>
            @endif
        </td>
        <td width="55%" style="font-size: 8pt; line-height: 1.2; padding: 2px;">
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                    <td style="font-size: 8pt;">
                        <strong>Courier</strong><br>
                        #{{ str_pad($waybill->id, 10, '0', STR_PAD_LEFT) }}<br>
                        @if($waybill->description)
                            {{ \Str::limit($waybill->description, 25) }}<br>
                        @endif
                        @if($waybill->weight_1)
                            Wt: {{ $waybill->weight_1 }}<br>
                        @endif
                        @if($waybill->total)
                            Total: {{ $waybill->total }}<br>
                        @endif
                        @if($waybill->who_pay)
                            Pay: {{ ucfirst($waybill->who_pay) }}
                        @endif
                    </td>
                    <td style="text-align: right; font-size: 8pt; white-space: nowrap;">
                        {{ $waybill->created_at ? $waybill->created_at->format('m/d/Y H:i') : '' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- NIR -->
    <tr>
        <td colspan="3" style="text-align: center; font-size: 9pt; padding: 1px 0; border-top: 2px solid #000;">(NIR): R5608402</td>
    </tr>
    <!-- BORDEREAU / WAYBILL -->
    <tr>
        <td colspan="3" style="text-align: center; font-size: 12pt; font-weight: bold; padding: 2px 0; border-top: 2px solid #000;">BORDEREAU / WAYBILL</td>
    </tr>
    <!-- Address section: Shipper + codes in one row -->
    <tr>
        <td colspan="3" style="padding: 4px; border-top: 2px solid #000;">
            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                    <td style="font-size: 8pt; line-height: 1.2; width: 65%;">
                        @if($shipper)
                            {{ $shipper->name ?? 'N/A' }}<br>
                            {{ $shipper->address ?? '' }}{{ !empty($shipper->address_ext) ? ', ' . $shipper->address_ext : '' }}<br>
                            {{ $shipper->city_name ?? '' }} {{ $shipper->city_state ?? '' }} {{ $shipper->postal_code ?? '' }}
                        @else
                            —
                        @endif
                    </td>
                    <td style="text-align: right; width: 35%;">
                        <span style="font-size: 12pt; font-weight: bold;">{{ $waybill->user && $waybill->user->client ? $waybill->user->client->prefix . str_pad($waybill->soft_id, 6, '0', STR_PAD_LEFT) : str_pad($waybill->soft_id ?? $waybill->id, 6, '0', STR_PAD_LEFT) }}</span><br>
                        <span style="font-size: 10pt; font-weight: bold; border: 1px solid #000; padding: 1px 3px;">C{{ str_pad($waybill->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 10pt; font-weight: bold; line-height: 1.2; padding-top: 4px;">
                        @if($recipient)
                            {{ strtoupper($recipient->name ?? 'N/A') }}<br>
                            {{ strtoupper($recipient->address ?? '') }}{{ !empty($recipient->address_ext) ? ', ' . strtoupper($recipient->address_ext) : '' }}<br>
                            {{ strtoupper($recipient->city_name ?? '') }} {{ strtoupper($recipient->city_state ?? '') }} {{ $recipient->postal_code ?? '' }}
                        @else
                            —
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Tracking -->
    <tr>
        <td colspan="3" style="text-align: center; padding: 3px 0; border-top: 2px solid #000;">
            <span style="font-size: 9pt; font-weight: bold;">TRACKING #</span><br>
            <span style="font-size: 10pt; font-weight: bold;">{{ str_pad($waybill->id, 14, '0', STR_PAD_LEFT) }}</span>
        </td>
    </tr>
</table>

</body>
</html>
