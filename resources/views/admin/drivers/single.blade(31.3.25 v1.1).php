{{-- production version  --}}
@extends('adminlte::page')

@section('title', ucfirst('Chauffeurs'))

@push('css')
    <style>
        .section-container {
            margin-top: 20px;
        }

        .upload-section {
            margin-bottom: 20px;
        }

        .modal-body {
            padding: 15px;
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content_header')
    <h1>{{ ucfirst('Chauffeurs') }}
        {{-- @if (\Laratrust::isAbleTo('admin.drivers.create'))
            <a href="{{ route('admin.waybills.uploadPickupImage', "2860") }}" class="btn btn-lg btn-success">NOUVEAU</a>
        @endif --}}
    </h1>
@stop

@section('content')
    @role('admin' || 'driver')
        <div class="container">
            <h1 class="mt-4">Bordereaux de livraison pour chauffeur</h1>

            @forelse($waybills as $waybill)
                <div class="section-container">
                    <div style="display: flex; align-items: center;">
                        {{-- <h3 style="margin-right: 10px;">Waybill ID: {{ $waybill->id }}</h3> --}}
                        <h3 style="margin-right: 10px;">Waybill Number: {{ $waybill->shipper->prefix . str_pad($waybill->soft_id, 6, 0, STR_PAD_LEFT);}}</h3>
                        @if($waybill->delivery_status == 1)
                            <span class="btn btn-lg btn-success">Déjà livré</span>
                        @endif
                    </div>

                    {{-- pickup sign note field --}}
                    <div class="note-section">
                        <h5>Ramassage des signatures</h5>

                        <!-- Display existing note if available -->

                        {{-- @if ($note)
                            <p>{{ $note->note }}</p>
                            <form action="{{ route('waybill.storeNote', $waybill->id) }}" method="POST">
                                @csrf
                                <textarea name="note" class="form-control mb-2">{{ $note->note }}</textarea>
                                <button type="submit" class="btn btn-sm btn-primary">Update Note</button>
                            </form>
                        @else
                            <!-- No note exists, so allow adding a new one --> --}}
                            <form action="{{ route('admin.waybills.uploadSignatureNote', $waybill->id) }}" method="POST" >
                                @csrf
                                <textarea name="receiver_textSignature" class="form-control mb-2" placeholder="Entrez votre signature ici"></textarea>
                                <button type="submit" class="btn btn-sm btn-primary">save</button>
                            </form>
                            <br>
                        {{-- @endif --}}
                    </div>

                    <!-- Pickup Image Upload -->
                    <div class="upload-section">
                        <h5>Televerser  image pour ramassage</h5>
                        <form action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="pickup_image" class="form-control mb-2">
                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </form>
                    </div>

                    {{-- drop/delivery sign note field --}}
                    <div class="note-section">
                        <h5>Livraison des signatures</h5>

                        <!-- Display existing note if available -->

                        {{-- @if ($note)
                            <p>{{ $note->note }}</p>
                            <form action="{{ route('waybill.storeNote', $waybill->id) }}" method="POST">
                                @csrf
                                <textarea name="note" class="form-control mb-2">{{ $note->note }}</textarea>
                                <button type="submit" class="btn btn-sm btn-primary">Update Note</button>
                            </form>
                        @else
                            <!-- No note exists, so allow adding a new one --> --}}
                            <form action="{{ route('admin.waybills.uploadSignatureNote', $waybill->id) }}" method="POST" >
                                @csrf
                                <textarea name="sender_textSignature" class="form-control mb-2" placeholder="Entrez votre signature ici"></textarea>
                                <button type="submit" class="btn btn-sm btn-primary">save</button>
                            </form>
                        {{-- @endif --}}
                        <br>
                    </div>

                    <!-- Drop Image Upload -->
                    <div class="upload-section">
                        <h5>Televerser image pour livraison</h5>
                        <form action="{{ route('admin.waybills.uploadDropImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="drop_image" class="form-control mb-2">
                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </form>
                    </div>

                    <!-- Signature Pad -->
                    {{-- <div class="upload-section">
                        <h5>Ajouter Signature</h5>
                        <button class="btn btn-sm btn-info" onclick="openSignatureModal({{ $waybill->id }})">Ajouter signature</button>
                    </div> --}}

                    {{--signature txt note --}}


                    <!-- Delivered Button -->

                    @if($waybill->pickup_image && $waybill->drop_image && $waybill->signature && $waybill->delivery_status !=1) <!-- Check if all three fields have values -->
                        <div class="upload-section">
                            <form action="{{ route('admin.waybills.markDelivered', $waybill->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-lg btn-success">Marquer comme livré</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center">Aucune lettre de voiture trouvée pour le chauffeurs</div>
            @endforelse
        </div>

        {{-- Signature Modal --}}
        <div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="signatureForm" action="{{ route('admin.waybills.uploadSignature') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="signatureModalLabel">Add Signature</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <canvas id="signaturePad" style="border: 1px solid #ddd; width: 100%; height: 200px;"></canvas>
                            <input type="hidden" name="signature" id="signatureInput">
                            <input type="hidden" name="waybill_id" id="waybillIdInput">
                            <button type="button" class="btn btn-secondary mt-2" onclick="clearSignature()">Clear</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="submitSignature()">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endrole
@stop

@push('js')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle JS (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    {{-- new for session update notice --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

    <script>
        let signaturePad, canvas;

        function openSignatureModal(waybillId) {
            const modal = new bootstrap.Modal(document.getElementById('signatureModal'));
            modal.show();
            document.getElementById('waybillIdInput').value = waybillId;

            // Initialize the signature pad
            canvas = document.getElementById('signaturePad');
            signaturePad = new SignaturePad(canvas);
        }

        function clearSignature() {
            signaturePad.clear();
        }

        function submitSignature() {
            if (!signaturePad.isEmpty()) {
                const dataUrl = signaturePad.toDataURL();
                document.getElementById('signatureInput').value = dataUrl;
                document.getElementById('signatureForm').submit();
            } else {
                alert('Please add a signature before submitting.');
            }
        }
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Find the anchor tag inside the li
        let waybillLink = document.querySelector('#dynamic-waybill-link a');

        // Check if the user is logged in and has the 'driver' role
        @if(auth()->check() && auth()->user()->roles->contains('id', 3))
            // Set the dynamic URL for drivers
            waybillLink.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}";
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            waybillLink.href = "/#"; // or set to some default link
        @endif
    });
</script>

@endpush
