{{-- @extends('adminlte::page') --}}
@extends('adminlte::iframe')

@section('title', 'Aperçu bordereau #' . $waybill->id)

@section('content_header')
@endsection

@push('css')
<style>
.waybill-label-preview {
    font-family: Arial, sans-serif;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 60vh;
    margin: 20px 0;
}
.waybill-label-preview .label {
    width: 4in;
    max-width: 100%;
    min-height: 5.5in;
    border: 1px solid #000;
    padding: 0;
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
    background: #fff;
}
.waybill-label-preview .header {
    display: flex;
    height: 1.1in;
    border-bottom: 2px solid #000;
}
.waybill-label-preview .header-left {
    width: 20%;
    border-right: 3px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
    box-sizing: border-box;
}
.waybill-label-preview .header-left img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}
.waybill-label-preview .header-middle {
    width: 25%;
    font-size: 10px;
    padding: 5px;
    line-height: 1.2;
}
.waybill-label-preview .header-right {
    width: 55%;
    padding: 5px;
    position: relative;
    font-size: 9px;
    line-height: 1.3;
}
.waybill-label-preview .header-right-text {
    display: flex;
    justify-content: space-between;
    font-size: 9px;
    line-height: 1.1;
}
.waybill-label-preview .nir-line {
    text-align: center;
    font-size: 12px;
    padding: 4px 0;
}
.waybill-label-preview .service {
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    border-bottom: 2px solid #000;
    padding: 4px 0;
    letter-spacing: 0.5px;
}
.waybill-label-preview .address-section {
    min-height: 2.0in;
    padding: 10px;
    position: relative;
    border-bottom: 2px solid #000;
    padding-top: 21px;
}
.waybill-label-preview .address-top-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 15px;
    width: 100%;
}
.waybill-label-preview .return-address {
    font-size: 15px;
    line-height: 1.2;
    flex: 1;
    min-width: 0;
    font-weight: bold
}
.waybill-label-preview .to-address {
    margin-top: 20px;
    font-size: 15px;
    line-height: 1.2;
    font-weight: bold;
}
.waybill-label-preview .right-codes {
    text-align: right;
    flex-shrink: 0;
}
.waybill-label-preview .code-0001 {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 12px;
}
.waybill-label-preview .code-c005 {
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #000;
    padding: 2px 8px;
}
@media print {
    .waybill-label-preview .print-btn,
    .waybill-label-preview .container .print-btn,
    a.print-btn,
    button.print-btn { display: none !important; }
    .waybill-label-preview { min-height: auto; }
}
.waybill-label-preview .tracking-section {
    text-align: center;
    padding-top: 5px;
    padding-bottom: 5px;
}
.waybill-label-preview .tracking-title {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
}
.waybill-label-preview .tracking-number {
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
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
.waybill-label-preview .print-btn:hover {
    background: #0056b3;
    color: #fff;
}

/* Print & PDF ke liye */
.page-break {
    page-break-after: always;
}

/* Last page ke baad blank page na aaye */
.page-break:last-child {
    page-break-after: auto;
}

@media print {
    .page-break {
        page-break-after: always;
    }
}

</style>
@endpush

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.waybill.label-preview.pdf', [
            'id' => $waybill->id,
            'leval' => count($labels)
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
                        <div class="header">
                            <div class="header-left">@include('admin.waybills.partials.waybill-logo')</div>
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
                                    <div class="text-end">
                                        {{ $waybill->created_at ? $waybill->created_at->format('m/d/Y H:i') : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="nir-line">(NIR): R5608402</div>

                        <div class="service">
                            BORDEREAU / WAYBILL
                        </div>

                        <div class="address-section">
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
                                    {{-- <div class="code-c005">C{{ str_pad($waybill->id, 4, '0', STR_PAD_LEFT) }}</div> --}}
                                    <div class="code-c005">{{ $loop->iteration }}/{{ $loop->count }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="tracking-section">
                            <div class="tracking-title">TRACKING #</div>
                            <div class="tracking-number">
                                {{ str_pad($waybill->id, 14, '0', STR_PAD_LEFT) }}
                            </div>
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
    @endforeach
@endsection
