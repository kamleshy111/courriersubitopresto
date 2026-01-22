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
    @php
            // $urlSegment = last(request()->segments());
            // echo $urlSegment;
            // var_dump($waybills);
            // echo "hello";
            foreach($waybills as $waybill)
                if ($waybill->delivery_status == 1){ 
                // if($urlSegment == 'pickedup')
                    // echo "here";
                    $title = "Livraison terminé"; 
                //    $title = "Livraison ramassé";
                }
                //    Livraison ramassé (picked up)
                else if ($waybill->delivery_status == 2){
                // else if($urlSegment == 'delivered'){
                    
                    $title = "Livraison ramassé";
                    // Livraison terminé (delivered)
                }
                else if ($waybill->delivery_status == 3 || $waybill->delivery_status == ""){
                // else if($urlSegment == 'in-progress'){
                    $title = "Livraison en cours";
                    // Livraison en cours
                }
            
        // else
        //     $title = "Default Title - Your App Name";
        // endif
        // echo $title;
        
    @endphp
        <div class="container">
            <h1 class="mt-4">{{$title}}</h1>
            {{-- <h1 class="mt-4">Bordereaux de livraison pour chauffeur</h1> --}}

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
                        {{-- <h5>Ramassage des signatures</h5> --}}
                        <h5>Signature de l'expediteur</h5>

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
                                <button type="submit" class="btn btn-sm btn-primary">Sauvegarder</button>
                            </form>
                            <br>
                        {{-- @endif --}}
                    </div>

                    <!-- Pickup Image Upload -->
                    {{-- <div class="upload-section">
                        <h5>Televerser l'image</h5>
                        <form action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="pickup_image"  class="form-control mb-2">
                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </form>
                    </div> --}}

                    
                    {{-- perfect --}}
{{-- 
                    <div class="upload-section">
                        <h5>Televerser l'image</h5>
                        <div class="d-flex align-items-center">
                            <!-- Step 1: Capture Button -->
                            <span>1.</span> <!-- Prefix for Capture -->
                            <label for="pickup_image" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-camera"></i> Capture
                            </label>
                            
                            <!-- Hidden File Input -->
                            <input type="file" name="pickup_image" class="form-control" id="pickup_image" style="display: none;" accept="image/*" />
                    
                            <!-- Step 2: Upload Button -->
                            <span class="ml-3">2.</span> <!-- Prefix for Upload -->
                            <button type="submit" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </div> --}}

                        {{-- camera t01 --}}
                        {{-- <div class="upload-section">
                            <h5>Televerser l'image</h5>
                            <div class="d-flex align-items-center">
                                <!-- Step 1: Capture Button -->
                                <span>1.</span>
                                <label for="pickup_image" class="btn btn-sm btn-primary ml-2">
                                    <i class="fas fa-camera"></i> Capture
                                </label>
                        
                                <!-- Hidden File Input (for uploading from file picker) -->
                                <input type="file" name="pickup_image" class="form-control" id="pickup_image" style="display: none;" accept="image/*" />
                                
                                <!-- Step 2: Upload Button -->
                                <span class="ml-3">2.</span>
                                <button type="button" id="upload_button" class="btn btn-sm btn-primary ml-2">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        
                            <!-- Camera section -->
                            <div id="cameraSection" style="display: none;">
                                <video id="video" width="320" height="240" autoplay></video>
                                <button id="capture_button" class="btn btn-sm btn-primary mt-2">Capture</button>
                                <canvas id="canvas" style="display: none;"></canvas>
                                <img id="capturedImage" style="max-width: 100%; display: none;" />
                            </div>
                        
                            <!-- Form to upload image -->
                            <form id="imageUploadForm" action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="pickup_image_path" id="pickup_image_path" />
                            </form>
                        </div> --}}
                        

                        <div class="upload-section">
                            <h5>Televerser l'image</h5>
                            <div class="d-flex align-items-center">
                                <!-- Step 1: Capture Button (Camera Icon) -->
                                <span>1.</span>
                                <button type="button" id="openCameraButton" class="btn btn-sm btn-primary ml-2">
                                    <i class="fas fa-camera"></i> Capture Image
                                </button>
                        
                                <!-- Step 2: Upload Button -->
                                <span class="ml-3">2.</span>
                                <button type="button" id="uploadButton" class="btn btn-sm btn-primary ml-2">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        
                            <!-- Camera section (hidden by default) -->
                            <div id="cameraSection" style="display: none;">
                                <video id="video" width="320" height="240" autoplay></video>
                                <button type="button" id="captureButton" class="btn btn-sm btn-primary mt-2">Capture</button>
                                <canvas id="canvas" style="display: none;"></canvas>
                                <img id="capturedImage" style="max-width: 100%; display: none;" />
                            </div>
                        
                            <!-- Form to upload image -->
                            <form id="imageUploadForm" action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="pickup_image_path" id="pickup_image_path" />
                            </form>
                        </div>
                        
                    
                        <!-- Form to upload image -->
                        <form action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                <button type="submit" class="btn btn-sm btn-primary">Sauvegarder</button>
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
                            <button type="button" class="btn btn-primary" onclick="submitSignature()">Sauvegarder</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    

    // Variables
    // camera test 01
    /*alert("runs the script");
const video = document.getElementById('video');
const captureButton = document.getElementById('capture_button');
const cameraSection = document.getElementById('cameraSection');
const uploadButton = document.getElementById('upload_button');
const imageUploadForm = document.getElementById('imageUploadForm');
const pickupImagePath = document.getElementById('pickup_image_path');
const capturedImage = document.getElementById('capturedImage');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

// Open Camera
function openCamera() {
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
            cameraSection.style.display = 'block';
        })
        .catch((err) => {
            console.log('Error accessing the camera: ', err);
        });
}

// Capture the image
captureButton.addEventListener('click', function() {
    // Draw the video frame to the canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert canvas to image
    const imageData = canvas.toDataURL('image/png');
    capturedImage.src = imageData;
    capturedImage.style.display = 'block';
    pickupImagePath.value = imageData; // Save image data to the hidden input
});

// Open the camera when the Capture button is clicked
document.querySelector('[for="pickup_image"]').addEventListener('click', openCamera);

// Upload the image
uploadButton.addEventListener('click', function() {
    alert("clicked");
    if (pickupImagePath.value) {
        // If an image is captured or selected, submit the form
        imageUploadForm.submit();
    } else {
        alert('Please capture an image first!');
    }
});*/

const video = document.getElementById('video');
    const captureButton = document.getElementById('captureButton');
    const cameraSection = document.getElementById('cameraSection');
    const openCameraButton = document.getElementById('openCameraButton');
    const uploadButton = document.getElementById('uploadButton');
    const imageUploadForm = document.getElementById('imageUploadForm');
    const pickupImagePath = document.getElementById('pickup_image_path');
    const capturedImage = document.getElementById('capturedImage');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    // Function to open the camera
    function openCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                // Set the video source to the camera stream
                video.srcObject = stream;
                // Show the camera section
                cameraSection.style.display = 'block';
            })
            .catch((err) => {
                console.log('Error accessing the camera: ', err);
            });
    }

    // Capture the image from the camera
    captureButton.addEventListener('click', function() {
        // Draw the video frame to the canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert canvas to image
        const imageData = canvas.toDataURL('image/png');
        capturedImage.src = imageData;
        capturedImage.style.display = 'block';
        pickupImagePath.value = imageData; // Save image data to the hidden input
    });

    // Open the camera when the "Capture Image" button is clicked
    openCameraButton.addEventListener('click', openCamera);

    // Upload the image when the Upload button is clicked
    uploadButton.addEventListener('click', function() {
        if (pickupImagePath.value) {
            // If an image is captured, submit the form
            imageUploadForm.submit();
        } else {
            alert('Please capture an image first!');
        }
    });

});
    </script>

@endpush
