@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZMgyvKW_R8_KOzVx169YqkpR6yrnjxhE&libraries=places"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
        // Find the anchor tag inside the li
        let clientProfileUpdate = document.querySelector('#dynamic-client-profile a');
        if (!clientProfileUpdate) return;
        @if(auth()->check() && auth()->user()->roles->contains('id', 2))
            clientProfileUpdate.href = "{{ url('admin/users/' . auth()->id()) .'/edit' }}";
            
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            // waybillLink.href = "/#"; // or set to some default link
        @endif
})
</script>

<script>
        function initAutocomplete_client() {
            const addressInput = document.getElementById('inp-address');
            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                types: ['address'],
                componentRestrictions: { country: 'ca' } // Optional: restrict to Canada
            });
        
            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    console.log('No details available for input: "' + place.name + '"');
                    return;
                }
        
                // Get street address from the place details
                let streetNumber = '';
                let streetName = '';
        
                for (const component of place.address_components) {
                    const addressType = component.types[0];
                    switch (addressType) {
                        case 'street_number':
                            streetNumber = component.long_name; // Get street number
                            break;
                        case 'route':
                            streetName = component.long_name; // Get street name
                            break;
                        // You can add more cases if needed for other components
                    }
                }
        
                // Combine street number and name
                document.getElementById('inp-address').value = `${streetNumber} ${streetName}`;
                for (const component of place.address_components) {
                    const addressType = component.types[0];
                    switch (addressType) {
                        case 'locality':
                            document.getElementById('inp-city_name').value = component.long_name;
                            // document.getElementById('inp-0-shipper-city_nom').value = component.long_name;
                            break;
                        case 'administrative_area_level_1':
                            document.getElementById('inp-city_state').value = component.long_name;
                            break;
                        case 'postal_code':
                            document.getElementById('inp-postal_code').value = component.long_name;
                            break;
                        // Add other cases if needed
                    }
                }

            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            initAutocomplete_client();
            
        });
    </script>
    
    @endpush


<div class="row">
    <div class="col-lg-6 col-sm-12">
        {!! Form::text('prefix', 'Prefix')->readonly($readonly) !!}
        {!! Form::text('name', 'Nom')->readonly($readonly) !!}
        {!! Form::text('phone', 'Téléphone')->type('phone')->readonly($readonly) !!}
        {!! Form::text('extension', 'Extension')->type('phone')->readonly($readonly) !!}
        {!! Form::text('address', 'Adresse ligne 1')->readonly($readonly) !!}
        {!! Form::text('address_ext', 'Adresse ligne 2 optional')->readonly($readonly) !!}
        {!! Form::text('city_name', 'Ville')->readonly($readonly) !!}
        {{-- {!! Form::select('city_name', 'Ville')->options($cities)->readonly($readonly) !!} --}}
        {!! Form::text('postal_code', 'Code Postale')->readonly($readonly) !!}
        {!! Form::text('city_state', 'Province')->readonly($readonly) !!}
        {!! Form::text('contact', 'Contact')->readonly($readonly) !!}
        {!! Form::textarea('note_permanent', 'Heures d’ouverture + Informations permanentes')->readonly($readonly) !!}
    </div>
</div>
