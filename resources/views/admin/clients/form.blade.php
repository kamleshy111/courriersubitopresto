@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZMgyvKW_R8_KOzVx169YqkpR6yrnjxhE&libraries=places"></script>
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
        {{-- {!! Form::text('prefix', 'Prefix')->readonly($readonly) !!} --}}
        {!! Form::text('prefix', 'Prefix')
    ->readonly($readonly || !\Laratrust::hasRole('admin')) !!}
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




@section('adminlte_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(isset($model) && !empty($model->id))
<script>
document.addEventListener('DOMContentLoaded', function () {
    // alert("developer working!");
    const form = document.getElementById('clientPdfForm');
    const fileInput = document.getElementById('pdfFile');
    const clientIdInput = document.getElementById('client_id');
    const uploadBtn = document.getElementById('uploadPdfBtn');
    const errorBox = document.getElementById('pdfError');
    const preview = document.getElementById('pdfPreview');
    const currentLink = document.getElementById('currentPdfLink');

    form.addEventListener('submit', function (e) {
        alert("submit button called")
        e.preventDefault();

        errorBox.style.display = 'none';
        const files = fileInput.files;
        if (!files || files.length === 0) {
            errorBox.innerText = 'Please select a PDF';
            errorBox.style.display = 'block';
            return;
        }

        const pdf = files[0];
        // simple client-side validation
        if (pdf.type !== 'application/pdf' && !pdf.name.toLowerCase().endsWith('.pdf')) {
            errorBox.innerText = 'Only PDF files allowed';
            errorBox.style.display = 'block';
            return;
        }
        if (pdf.size > 10 * 1024 * 1024) {
            errorBox.innerText = 'File too large (max 10MB)';
            errorBox.style.display = 'block';
            return;
        }

        uploadBtn.disabled = true;
        uploadBtn.innerText = 'Uploading…';

        const fd = new FormData();
        fd.append('pdf', pdf);
        fd.append('client_id', clientIdInput.value);

        // Append CSRF token (Laravel will accept token in header or body)
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('admin.clients.store_pdf') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: fd,
        }).then(async (res) => {
            uploadBtn.disabled = false;
            uploadBtn.innerText = 'Upload PDF';

            /*if (res.ok) {
                const json = await res.json();
                // update preview link
                // old error
                /*const url = json.path || json.relative_path;
                const filename = json.filename || (pdf && pdf.name);

                if (currentLink) {
                    currentLink.href = url;
                    currentLink.innerText = filename;
                } else if (preview) {
                    const p = document.createElement('p');
                    p.innerHTML = '<strong>Current PDF:</strong> <a id="currentPdfLink" href="' + url + '" target="_blank">' + filename + '</a>';
                    preview.insertBefore(p, preview.firstChild);
                }//here comments end before
                
                const fileUrl = json.url;                 // FULL public URL
            const filename = json.filename;           // original name
            
            if (currentLink) {
                currentLink.href = fileUrl;
                currentLink.innerText = filename;
            } else {
                const p = document.createElement('p');
                p.innerHTML = '<strong>Current PDF:</strong> <a id="currentPdfLink" href="' + fileUrl + '" target="_blank">' + filename + '</a>';
                preview.insertBefore(p, preview.firstChild);
            }

                preview.style.display = 'block';
                alert('Upload successful');
            } else {
                // try to parse validation errors
                const contentType = res.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    const err = await res.json();
                    const msg = (err.errors && (err.errors.pdf || err.errors.client_id)) ?
                        (err.errors.pdf ? err.errors.pdf.join(', ') : err.errors.client_id.join(', ')) :
                        (err.message || 'Upload failed');
                    errorBox.innerText = msg;
                } else {
                    errorBox.innerText = 'Upload failed';
                }
                errorBox.style.display = 'block';
            }*/
            // old working good
           if (res.ok) {
    const json = await res.json();

    const fileUrl = json.url;
    const filename = json.filename;

    // Update existing link OR create new one
    if (currentLink) {
        currentLink.href = fileUrl;
        currentLink.innerText = filename;
    } else if (preview) {
        const p = document.createElement('p');
        p.innerHTML =
            '<strong>Current PDF:</strong> <a id="currentPdfLink" href="' +
            fileUrl +
            '" target="_blank">' +
            filename +
            '</a>';

        preview.appendChild(p);
    }

    // Only update preview display if the element exists
    if (preview) {
        preview.style.display = 'block';
    }

    // alert('Upload successful');
    Swal.fire({
    icon: 'success',
    title: 'PDF uploaded successfully',
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
});
    return;
}
        }).
        // catch(err => {
        //     console.error(err);
        //     uploadBtn.disabled = false;
        //     uploadBtn.innerText = 'Upload PDF';
        //     errorBox.innerText = 'Upload error';
        //     errorBox.style.display = 'block';
        // });
        
        catch(err => {
    console.error(err);

    uploadBtn.disabled = false;
    uploadBtn.innerText = 'Upload PDF';

    const msg = errorBox.innerText || 'An unexpected error occurred.';

    Swal.fire({
        icon: 'error',
        title: 'Upload failed!',
        text: msg,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
    });
});
    });
    
    
    // delete
    const deleteBtn = document.getElementById('deletePdfBtn');

if (deleteBtn) {
    deleteBtn.addEventListener('click', function () {

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the PDF.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {

            if (result.isConfirmed) {

                fetch("{{ route('admin.clients.delete_pdf', $model->id) }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(json => {
                    if (json.success) {

                        // Hide preview
                        const preview = document.getElementById('pdfPreview');
                        if (preview) preview.style.display = 'none';

                        // Hide the view link
                        const link = document.getElementById('currentPdfLink');
                        if (link) link.style.display = 'none';

                        // Hide delete button
                        const delBtn = document.getElementById('deletePdfBtn');
                        if (delBtn) delBtn.style.display = 'none';

                        // Success toast
                        Swal.fire({
                            icon: 'success',
                            title: 'PDF deleted successfully',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete failed',
                        text: 'An unexpected error occurred.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500
                    });
                });

            }
        });

    });
}

});
</script>
@endif
@endsection
