@extends('adminlte::page')
{{-- @extends('adminlte::iframe') --}}

@section('title', 'Aperçu bordereau #' . $waybill->id)

@section('content_header')
@endsection

@push('css')
<style>
/* Standard 4" x 6" box label – preview design (PDF follows this) */
.waybill-label-preview {
    font-family: Arial, Helvetica, sans-serif;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    margin: 20px 0;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

.waybill-label-preview .label {
    width: 4in;
    height: 6in;
    max-width: 100%;
    border: 1px solid #333;
    padding: 0;
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.waybill-label-preview .label-inner {
    padding: 0.1in;
    height: 100%;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
}

.waybill-label-preview .header {
    display: flex;
    height: 0.88in;
    min-height: 0.88in;
    border-bottom: 2px solid #000;
    flex-shrink: 0;
}

.waybill-label-preview .header-left {
    width: 20%;
    border-right: 2px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.06in;
    box-sizing: border-box;
}

.waybill-label-preview .header-left img {
    max-height: 0.7in;
    max-width: 100%;
    object-fit: contain;
}

.waybill-label-preview .header-middle {
    width: 26%;
    font-size: 8pt;
    padding: 0.06in;
    line-height: 1.25;
    color: #222;
}

.waybill-label-preview .header-right {
    width: 54%;
    padding: 0.06in;
    font-size: 8pt;
    line-height: 1.2;
    box-sizing: border-box;
}

.waybill-label-preview .header-right-text {
    display: flex;
    justify-content: space-between;
    gap: 0.1in;
}

.waybill-label-preview .nir-line {
    text-align: center;
    font-size: 9pt;
    padding: 0.04in 0;
    border-bottom: 1px solid #000;
    flex-shrink: 0;
}

.waybill-label-preview .service {
    text-align: center;
    font-size: 11pt;
    font-weight: bold;
    padding: 0.06in 0;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #000;
    flex-shrink: 0;
}

.waybill-label-preview .address-section {
    flex: 1;
    min-height: 0;
    padding: 0.08in 0.1in;
    border-bottom: 2px solid #000;
    display: flex;
    flex-direction: column;
    gap: 0.12in;
}

.waybill-label-preview .address-top-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 0.12in;
    flex: 1;
    min-height: 0;
}

.waybill-label-preview .return-address {
    font-size: 9pt;
    line-height: 1.2;
    flex: 1;
    min-width: 0;
    font-weight: bold;
}

.waybill-label-preview .right-codes {
    text-align: right;
    flex-shrink: 0;
}

.waybill-label-preview .code-0001 {
    font-size: 14pt;
    font-weight: bold;
    margin-bottom: 0.04in;
    letter-spacing: 0.5px;
}

.waybill-label-preview .code-c005 {
    font-size: 10pt;
    font-weight: bold;
    border: 1px solid #000;
    padding: 0.02in 0.06in;
    display: inline-block;
}

.waybill-label-preview .tracking-section {
    padding: 0.06in 0.1in;
    border-top: 1px solid #ddd;
    flex-shrink: 0;
}

.waybill-label-preview .tracking-title {
    font-size: 8pt;
    font-weight: bold;
    margin-bottom: 0.02in;
    letter-spacing: 0.5px;
    color: #444;
}

.waybill-label-preview .tracking-number {
    font-size: 12pt;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 0.04in;
}

.waybill-label-preview .to-address {
    font-size: 10pt;
    line-height: 1.2;
    font-weight: bold;
    text-transform: uppercase;
}

.waybill-label-preview .print-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 8px 24px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}

.waybill-label-preview .print-btn:hover { background: #0056b3; color: #fff; }

@media print {
    @page { size: 4in 6in; margin: 0; }
    body { margin: 0; padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .waybill-label-preview .print-btn,
    .waybill-label-preview .container .print-btn,
    .content-wrapper .btn.print-btn,
    a.print-btn,
    button.print-btn { display: none !important; }
    .waybill-label-preview { min-height: auto; margin: 0; }
    .waybill-label-preview .label { box-shadow: none; border: 1px solid #000; }
    .page-break { page-break-after: always; }
    .page-break:last-child { page-break-after: auto; }
}

.page-break { page-break-after: always; }
.page-break:last-child { page-break-after: auto; }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.waybill.label-preview.pdf', [
            'id' => $waybill->id,
            'label_count' => count($labels)
        ]) }}"
        target="_blank"
        class="btn btn-primary print-btn">
            Générer PDF
        </a>
    </div>
    @foreach($labels as $label)

        <div class="page-break">
            <div class="container d-flex justify-content-center">

                <div class="waybill-label-preview">
                    <div class="label">
                        <div class="label-inner">
                            <div class="header">
                                <div class="header-left">@include('admin.waybills.partials.waybill-logo', ['maxWidth' => '100%', 'maxHeight' => '0.7in'])</div>
                                <div class="header-middle">
                                    US POSTAGE<br>
                                    PAID<br>
                                    {{ $waybill->date ? \Carbon\Carbon::parse($waybill->date)->format('m/d/Y') : date('m/d/Y') }}<br>
                                    @if($shipper && $shipper->postal_code)
                                        From {{ preg_replace('/\s+/', '', $shipper->postal_code) }}<br>
                                    @endif
                                    @if($waybill->status)
                                        <strong>{{ strtoupper(str_replace('_', ' ', $waybill->status)) }}</strong><br>
                                    @endif
                                </div>
                                <div class="header-right">
                                    <div class="header-right-text">
                                        <div>
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
                                        </div>
                                        <div class="text-end" style="white-space: nowrap;">
                                            {{ $waybill->created_at ? $waybill->created_at->format('m/d/Y H:i') : '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="nir-line">(NIR): R5608402</div>

                            <div class="service">BORDEREAU / WAYBILL</div>

                            <div class="address-section">
                                <div class="address-top-row-main">
                                    <div class="address-top-row">
                                        <div class="return-address">
                                            @if($shipper)
                                                {{ $shipper->name ?? 'N/A' }}<br>
                                                {{ $shipper->address ?? '' }}{{ !empty($shipper->address_ext) ? ', ' . $shipper->address_ext : '' }}<br>
                                                {{ $shipper->city_name ?? '' }} {{ $shipper->city_state ?? '' }} {{ $shipper->postal_code ?? '' }}
                                            @else
                                                —
                                            @endif
                                        </div>
                                        <div class="right-codes">
                                            <div class="code-0001">{{ $waybill->user && $waybill->user->client ? $waybill->user->client->prefix . str_pad($waybill->soft_id, 6, '0', STR_PAD_LEFT) : str_pad($waybill->soft_id ?? $waybill->id, 6, '0', STR_PAD_LEFT) }}</div>
                                            <div class="code-c005">{{ $loop->iteration }}/{{ $loop->count }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tracking-section">
                                    <p>{{ $waybill->shipper_note ?? '' }}</p>
                                </div>
                            </div>

                            <div class="tracking-section">
                                <div class="to-address">
                                    @if($recipient)
                                        {{ strtoupper($recipient->name ?? 'N/A') }}<br>
                                        {{ strtoupper($recipient->address ?? '') }}{{ !empty($recipient->address_ext) ? ', ' . strtoupper($recipient->address_ext) : '' }}<br>
                                        {{ strtoupper($recipient->city_name ?? '') }} {{ strtoupper($recipient->city_state ?? '') }} {{ $recipient->postal_code ?? '' }}
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
@endsection
