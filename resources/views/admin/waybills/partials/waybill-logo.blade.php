@php
$logoSrc = file_exists(resource_path('views/admin/waybills/partials/waybill-logo-src.txt'))
    ? file_get_contents(resource_path('views/admin/waybills/partials/waybill-logo-src.txt'))
    : '';
@endphp
@if($logoSrc)
<img src="{{ $logoSrc }}" alt="Logo" style="max-height: 100%; max-width: 100%; object-fit: contain; display: block;" />
@endif
