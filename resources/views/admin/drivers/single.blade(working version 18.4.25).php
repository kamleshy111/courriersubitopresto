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
        .shipper {
            margin-top:20px;
            margin-bottom:40px;
            /* gap: 30px; */
            background-color: #f0f0f0; /* Light gray background for the boxes */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for a 3D effect */
            width: 75%; /*Ensure both boxes take up half of the container width*/
            box-sizing: border-box; /* To include padding in the width calculation */
        }

    .receiver{
            
            margin-bottom:10px;
            background-color: #f0f0f0; /* Light gray background for the boxes */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Slight shadow for a 3D effect */
            width: 75%; /*Ensure both boxes take up half of the container width*/
            box-sizing: border-box; /* To include padding in the width calculation */
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
                    <div class="shipper">
                        {{-- pickup sign note field --}}
                        <div class="note-section">
                            {{-- <h5>Ramassage des signatures</h5> --}}
                            <h5>Signature de l’{{__('translations.expediteur')}}</h5>

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
                                <br>
                            {{-- @endif --}}
                        </div>

                        <!-- Pickup Image Upload -->
                        {{-- <div class="upload-section">
                            <h5>Téléverser l’image pour ramassage</h5>
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
                                <h5>{{__('translations.Televerser')}} l’image pour ramassage</h5>
                                <div class="d-flex align-items-center">
                                    <!-- Step 1: Capture Button (Camera Icon) -->
                                    <span>1.</span>
                                    <button type="button" id="openCameraButton" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-camera"></i> Prendre photo
                                    </button>
                            
                                    <!-- Step 2: Upload Button -->
                                    <span class="ml-3">2.</span>
                                    <button type="button" id="uploadButton" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-upload"></i> {{__('translations.Televerser')}}
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
                                <form id="imageUploadForm" action="{{ route('admin.waybills.uploadPickupImageUpdated', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="pickup_image_path" id="pickup_image_path" />
                                </form>
                            </div>
                            
                        
                            <!-- Form to upload image -->
                            {{-- <form action="{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            </form> --}}
                        </div>
                    {{-- </div> --}}

                    {{-- drop/delivery sign note field --}}
                    <div class="receiver">
                        <div class="note-section">
                            <h5>Signature du destinataire</h5>

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
                            {{-- @endif --}}
                            <br>
                        </div>

                        <!-- Drop Image Upload -->
                        {{-- <div class="upload-section">
                            <h5>{{__('translations.Televerser')}} l’image de {{__('translations.reception')}}</h5>
                            <form action="{{ route('admin.waybills.uploadDropImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="drop_image" class="form-control mb-2">
                                <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                            </form>
                        </div> --}}
                    

                    {{--<div class="upload-section">
                        <h5>{{__('translations.Televerser')}} l’image de {{__('translations.reception')}}</h5>
                        <form action="{{ route('admin.waybills.uploadDropImage', $waybill->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="d-flex align-items-center">
                            <!-- Step 1: Capture Button -->
                            <span>1.</span> <!-- Prefix for Capture -->
                            <label for="drop_image" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-camera"></i> Prendre photo
                            </label>
                            
                            <!-- Hidden File Input -->
                            <input type="file" name="drop_image" class="form-control" id="drop_image" style="display: none;" accept="image/*" />
                    
                            <!-- Step 2: Upload Button -->
                            <span class="ml-3">2.</span> <!-- Prefix for Upload -->
                            <button type="submit" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-upload"></i> {{__('translations.Televerser')}}
                            </button>
                        </div>
                        
                        </form>
                    </div>--}}
                    

                    <div class="upload-section">
                        <h5>{{__('translations.Televerser')}} l’image de {{__('translations.reception')}}</h5>
                        <div class="d-flex align-items-center">
                            <!-- Step 1: Capture Button (Camera Icon) -->
                            <span>1.</span>
                            <button type="button" id="openCameraButtonReceiver" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-camera"></i> Prendre photo
                            </button>
                    
                            <!-- Step 2: Upload Button -->
                            <span class="ml-3">2.</span>
                            <button type="button" id="uploadButtonReceiver" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-upload"></i> {{__('translations.Televerser')}}
                            </button>
                        </div>
                    
                        <!-- Camera section (hidden by default) -->
                        <div id="cameraSectionReceiver" style="display: none;">
                            <video id="videoReceiver" width="320" height="240" autoplay></video>
                            <button type="button" id="captureButtonReceiver" class="btn btn-sm btn-primary mt-2">Capture</button>
                            <canvas id="canvasReceiver" style="display: none;"></canvas>
                            <img id="capturedImageReceiver" style="max-width: 100%; display: none;" />
                        </div>
                        {{-- action="{{ route('admin.waybills.uploadPickupImageUpdated', $waybill->id) }}" method="POST" enctype="multipart/form-data" --}}
                        <!-- Form to upload image -->
                         <form id="imageUploadFormReceiver" action="{{ route('admin.waybills.uploadDropImageUpdated', $waybill->id) }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" name="drop_image_path" id="drop_image_path" />
                        </form>
                    </div>
                    
                
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

// cam test 2
/*const video = document.getElementById('video');
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
    });*/

    // cam test 03

    /*const video = document.getElementById('video');
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
        // Request camera access
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                // Set the video source to the camera stream
                video.srcObject = stream;
                // Show the camera section
                cameraSection.style.display = 'block';
            })
            .catch((err) => {
                console.log('Error accessing the camera: ', err);
                alert('Please ensure that the camera is accessible and permissions are granted.');
            });
    }

    // Capture the image from the camera
    captureButton.addEventListener('click', function() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');
        capturedImage.src = imageData;
        capturedImage.style.display = 'block';
        pickupImagePath.value = imageData; // Save image data to the hidden input
        alert(pickupImagePath.value);
        alert(typeof(imageData));
    });

    // Open the camera when the "Capture Image" button is clicked
    openCameraButton.addEventListener('click', openCamera);

    // Upload the image when the Upload button is clicked
    uploadButton.addEventListener('click', function() {
        if (pickupImagePath.value) {
            // Send the Base64 image data to the server via Fetch API
            fetch("{{ route('admin.waybills.uploadPickupImage', $waybill->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    pickup_image: pickupImagePath.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Image uploaded successfully!");
                } else {
                    alert("Error uploading image.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("There was an error uploading the image.");
            });
        } else {
            alert("Please capture an image first!");
        }
    });
*/

// cam test 04

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
    const contraints = {
        video: {
            facingMode: "environment"
        }
    };

    let mediaStream = null;  // To hold the media stream so we can stop it later
    
    function openCamera() {
    // navigator.mediaDevices.getUserMedia({ video: true })
    navigator.mediaDevices.getUserMedia(contraints)
        .then(function(stream) {
            video.srcObject = stream; // Assign the stream to the video element
            mediaStream = stream; // Store the stream for later use (to stop it)
            cameraSection.style.display = 'block';
            video.style.display = 'block';
            captureButton.style.display = 'block';
        })
        .catch(function(error) {
            console.error('Error accessing the camera: ', error);
        });
}


function closeCamera() {
    if (mediaStream) {
        // Stop all the video tracks
        mediaStream.getTracks().forEach(track => track.stop());
        video.srcObject = null; // Clear the video feed
        video.style.display = 'none';
        captureButton.style.display = 'none';
        capturedImage.style.marginTop = "20px";
        console.log('Camera turned off');
    }
}

    // Capture the image from the camera
    captureButton.addEventListener('click', function() {
         // Stop the camera when capture is clicked
        //  stopCamera();
        
         canvas.width = 160;
         canvas.height = 120;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');
        capturedImage.src = imageData;
        capturedImage.style.display = 'block';
        pickupImagePath.value = imageData; // Save image data to the hidden input
        closeCamera();
    });

    // Open the camera when the "Capture Image" button is clicked
    openCameraButton.addEventListener('click', openCamera);

    // Upload the image when the Upload button is clicked
    uploadButton.addEventListener('click', function() {
        console.log(pickupImagePath.value);
        // closeCamera();
        if (pickupImagePath.value) {
            // Send the Base64 image data to the server via Fetch API
            fetch("{{ route('admin.waybills.uploadPickupImageUpdated', $waybill->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    pickup_image: pickupImagePath.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // alert("Image uploaded successfully!");
                    Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'image uploaded successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });
                    
                } else {
                    // alert("Error uploading image.");
                    Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Failed to update data!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
            
                }
            })
            .catch(error => {
                console.error("Error:", error);
                // alert("There was an error uploading the image.");
            });
        } else {
            // alert("Please capture an image first!");
        }
    });

// receiver camera section 
    const videoReceiver = document.getElementById('videoReceiver');
    const captureButtonReceiver = document.getElementById('captureButtonReceiver');
    const cameraSectionReceiver = document.getElementById('cameraSectionReceiver');
    const openCameraButtonReceiver = document.getElementById('openCameraButtonReceiver');
    const uploadButtonReceiver = document.getElementById('uploadButtonReceiver');
    const imageUploadFormReceiver = document.getElementById('imageUploadForm');
    const dropImagePath = document.getElementById('drop_image_path');
    const capturedImageReceiver = document.getElementById('capturedImageReceiver');
    const canvasReceiver = document.getElementById('canvasReceiver');
    const contextReceiver = canvasReceiver.getContext('2d');

    let mediaStreamReceiver = null;  // To hold the media stream so we can stop it later
    

    function openCameraReceiver() {
    // navigator.mediaDevices.getUserMedia({ video: true })
    navigator.mediaDevices.getUserMedia(contraints)
        .then(function(stream) {
            videoReceiver.srcObject = stream; // Assign the stream to the video element
            mediaStreamReceiver = stream; // Store the stream for later use (to stop it)
            cameraSectionReceiver.style.display = 'block';
            videoReceiver.style.display = 'block';
            captureButtonReceiver.style.display = 'block';
        })
        .catch(function(error) {
            console.error('Error accessing the camera: ', error);
        });
}


function closeCameraReceiver() {
    // alert("close function runs");
    console.log("colse function runs!");
    if (mediaStreamReceiver) {
        ("condition found!");
        // Stop all the video tracks
        mediaStreamReceiver.getTracks().forEach(track => track.stop());
        videoReceiver.srcObject = null; // Clear the video feed
        videoReceiver.style.display = 'none';
        captureButtonReceiver.style.display = 'none';
        capturedImageReceiver.style.marginTop = "20px";
        console.log('Receiver Camera turned off');
    }
}

    // Capture the image from the camera
    captureButtonReceiver.addEventListener('click', function() {
         // Stop the camera when capture is clicked
        //  stopCamera();
        
         canvasReceiver.width = 160;
         canvasReceiver.height = 120;
        contextReceiver.drawImage(videoReceiver, 0, 0, canvasReceiver.width, canvasReceiver.height);
        const imageDataReceiver = canvasReceiver.toDataURL('image/png');
        capturedImageReceiver.src = imageDataReceiver;
        capturedImageReceiver.style.display = 'block';
        dropImagePath.value = imageDataReceiver; // Save image data to the hidden input
        // console.log(`drop image path value: ${dropImagePath.value}`);
        closeCameraReceiver();
    });

    // Open the camera when the "Capture Image" button is clicked
    openCameraButtonReceiver.addEventListener('click', openCameraReceiver);

    // Upload the image when the Upload button is clicked
    uploadButtonReceiver.addEventListener('click', function() {
        console.log(dropImagePath.value);
        // closeCamera();
        if (dropImagePath.value) {
            // Send the Base64 image data to the server via Fetch API
            fetch("{{ route('admin.waybills.uploadDropImageUpdated', $waybill->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    drop_image: dropImagePath.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // alert("Image uploaded successfully!");
                    Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'image uploaded successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });
                } else {
                    // alert("Error uploading image.");
                    Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Failed to upload image!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("There was an error uploading the image.");
            });
        } else {
            alert("Please capture an image first!");
        }
    });

    

// });

});






    </script>

@endpush
