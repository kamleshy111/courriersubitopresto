@php
    /**
     * Reusable Google Maps link renderer.
     *
     * Expected variables (all optional):
     * - $enabled (bool): if false, renders plain text
     * - $text (string): the visible text in the table
     * - $name (string|null)
     * - $address (string|null)
     * - $city_name (string|null)
     * - $city_state (string|null)
     * - $requireAddress (bool): if true, link only when $address is non-empty
     */
    $enabled = (bool)($enabled ?? false);
    $text = (string)($text ?? '');
    $name = $name ?? null;
    $address = $address ?? null;
    $city_name = $city_name ?? null;
    $city_state = $city_state ?? null;
    $requireAddress = (bool)($requireAddress ?? false);

    $parts = array_values(array_filter(
        [$name, $address, $city_name, $city_state],
        fn ($v) => isset($v) && trim((string)$v) !== ''
    ));

    $fullAddress = implode(', ', $parts);
    $encoded = urlencode($fullAddress);
@endphp

@if($enabled && $fullAddress !== '' && (!$requireAddress || (isset($address) && trim((string)$address) !== '')))
    <a href="https://www.google.com/maps/search/?api=1&query={{ $encoded }}" target="_blank" rel="noopener noreferrer">
        {{ $text }}
    </a>
@else
    {{ $text }}
@endif
