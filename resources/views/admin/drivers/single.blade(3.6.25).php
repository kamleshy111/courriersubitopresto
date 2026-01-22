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

        /* processing logo show */

                /* #loadingIndicator {
            display: none;
            text-align: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        } */

                /* Floating Loading Indicator */
        /* #loadingIndicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 9999;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
        }


        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }


        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
 */

        /* Full-Screen Overlay */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.7); /* Dark background with transparency */
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure it is on top of other content */
            flex-direction: column;
        }

        /* Overlay content (spinner + text) */
        .overlay-content {
            color: white;
            font-size: 18px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Spinner style */
        .spinner {
            border: 4px solid #f3f3f3; /* Light gray */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 50px; /* Adjust size */
            height: 50px; /* Adjust size */
            animation: spin 1s linear infinite;
            margin-bottom: 10px; /* Space between spinner and text */
        }

        /* Keyframe for spinning animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

                            <h5>Signature de l’{{__('translations.expediteur')}}</h5>

                                

                                <form id="shipper_signature" action="{{ route('admin.waybills.uploadSignatureNote', $waybill->id) }}" method="POST" >
                                    @csrf
                                    @if($waybill->sender_textSignature)
                                    {{-- <h6><strong>{{ $waybill->sender_textSignature }}</strong></h6> --}}
                                    <textarea id="sender_textSignature" name="sender_textSignature" class="form-control mb-2" placeholder="{{ $waybill->sender_textSignature }}" required></textarea>
                                    @else
                                    <textarea id="sender_textSignature" name="sender_textSignature" class="form-control mb-2" placeholder="Entrez votre signature ici" required></textarea>
                                    @endif
                                </form>
                                <br>
                            {{-- @endif --}}
                        </div>


                            <div class="upload-section">
                                <h5>{{__('translations.Televerser')}} l’image pour ramassage</h5>
                                @if($waybill->pickup_image)
                                    <img src="{{ asset('storage/' . $waybill->pickup_image) }}" alt="Pickup Image" class="img-thumbnail" width="500">
                                @endif
                                <div class="d-flex align-items-center">
                                    <!-- Step 1: Capture Button (Camera Icon) -->
                                    {{-- <span>1.</span> --}}
                                    <button type="button" id="openCameraButton" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-camera"></i> Prendre photo
                                    </button>

                                    <!-- Step 2: Upload Button -->
                                    {{-- <span class="ml-3">2.</span>
                                    <button type="button" id="uploadButton" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-upload"></i> {{__('translations.Televerser')}}
                                    </button> --}}
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
                            <button id = "savePickup" type="submit" class="btn btn-sm btn-primary">Sauvegarder</button>

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
                                <form id="receiver_signature" action="{{ route('admin.waybills.uploadSignatureNote', $waybill->id) }}" method="POST" >
                                    @csrf
                                    @if($waybill->receiver_textSignature)
                                        {{-- <h6><strong>{{ $waybill->receiver_textSignature }}</strong></h6> --}}
                                        <textarea id = "receiver_textSignature" name="receiver_textSignature" class="form-control mb-2" placeholder="{{ $waybill->receiver_textSignature }}"></textarea>
                                    @else
                                        <textarea id = "receiver_textSignature" name="receiver_textSignature" class="form-control mb-2" placeholder="Entrez votre signature ici"></textarea>
                                    @endif
                                    {{-- <button type="submit" class="btn btn-sm btn-primary">Sauvegarder</button> --}}
                                </form>
                            {{-- @endif --}}
                            <br>
                        </div>



                    <div class="upload-section">
                        <h5>{{__('translations.Televerser')}} l’image de {{__('translations.reception')}}</h5>
                        @if($waybill->drop_image)
                                <img src="{{ asset('storage/' . $waybill->drop_image) }}" alt="Drop Image" class="img-thumbnail">
                            @endif
                        <div class="d-flex align-items-center">
                            <!-- Step 1: Capture Button (Camera Icon) -->
                            {{-- <span>1.</span> --}}
                            <button type="button" id="openCameraButtonReceiver" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-camera"></i> Prendre photo
                            </button>

                            <!-- Step 2: Upload Button -->
                            {{-- <span class="ml-3">2.</span>
                            <button type="button" id="uploadButtonReceiver" class="btn btn-sm btn-primary ml-2">
                                <i class="fas fa-upload"></i> {{__('translations.Televerser')}}
                            </button> --}}
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

                    <button id = "saveDropImage" type="submit" class="btn btn-sm btn-primary">Sauvegarder</button>
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

        <!-- Full-Screen Overlay (Initially hidden) -->
        <div id="overlay" style="display: none;">
            <div class="overlay-content">
                <div class="spinner"></div> <!-- Spinner -->
                <span>Processing...</span>
            </div>
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
        let waybillInprogress = document.querySelector('#dynamic-waybill-inprogress a');
        let waybillPickedup = document.querySelector('#dynamic-waybill-pickedup a');
        let waybillDelivered = document.querySelector('#dynamic-waybill-delivered a');
        // Check if the user is logged in and has the 'driver' role
        @if(auth()->check() && auth()->user()->roles->contains('id', 3))
            // Set the dynamic URL for drivers
            // waybillLink.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}";
            waybillLink.href = "{{ url('admin/driver-summary-table/' . auth()->id()) }}";
            waybillInprogress.href = "{{ url('admin/driver-waybill/' . auth()->id()) .'/in-progress'}}";
            waybillPickedup.href = "{{ url('admin/driver-waybill/' . auth()->id()) .'/pickedup'}}";
            waybillDelivered.href = "{{ url('admin/driver-waybill/' . auth()->id()) .'/delivered'}}";
        @else
            // Optionally, set a fallback URL for non-drivers (or leave as is)
            waybillLink.href = "/#"; // or set to some default link
        @endif




// cam test 04

    const video = document.getElementById('video');
    const captureButton = document.getElementById('captureButton');
    const cameraSection = document.getElementById('cameraSection');
    const openCameraButton = document.getElementById('openCameraButton');
    const uploadButton = document.getElementById('uploadButton');
    const savePickupButton = document.getElementById('savePickup');
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



    savePickupButton.addEventListener('click',  async function() {
    // savePickupButton.addEventListener('click',  function() {
        // document.getElementById('loadingIndicator').style.display = 'block';
        document.getElementById('overlay').style.display = 'flex';

        console.log(shipper_signature.checkValidity())
        const shipperSignature = document.getElementById('sender_textSignature').value.trim();
        const pickupImageData = pickupImagePath.value;
        // console.log(shipperSignature);
        // console.log(pickupImageData);

        if (!pickupImageData || !shipper_signature.checkValidity()) {
            alert("fill all the forms!");
        }
        // closeCamera();
        else if (pickupImageData && shipper_signature.checkValidity()) {

            try{
                const [shipperSignature_response, pickupImageData_response] = await Promise.all([



                    fetch("{{route('admin.waybills.uploadSignatureNote', $waybill->id)}}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            sender_textSignature: shipperSignature
                        })
                    }),

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
                ]);

                const shipperData = await shipperSignature_response.json();
                const pickupData = await pickupImageData_response.json();

                console.log('shipper response:', shipperData);
                console.log('pickup response:', pickupData);

                if (
                    shipperSignature_response.ok &&
                    pickupImageData_response.ok &&
                    shipperData.success &&
                    pickupData.success
                ) {
                    document.getElementById('overlay').style.display = 'none';
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'image & signature uploaded successfully!',
                    showConfirmButton: false, // No button
                    timer: 1500, // Notification will disappear in 3 seconds
                    timerProgressBar: true, // Show progress bar

                    });
                } else {
                    document.getElementById('overlay').style.display = 'none';
                    // alert("One or both submissions failed.");
                    throw new Error("One or both requests failed.");
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to upload image or text!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    });

                }
            }
            catch (error) {
            // console.error(error);
            // alert('Something went wrong while saving.');
                document.getElementById('overlay').style.display = 'none';
                Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error! Someting went wrong',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
        }
        // });
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
    const saveDropButton = document.getElementById('saveDropImage');

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

    saveDropButton.addEventListener('click',  async function() {
    // savePickupButton.addEventListener('click',  function() {
        // document.getElementById('loadingIndicator').style.display = 'block';
        document.getElementById('overlay').style.display = 'flex';

        console.log(receiver_signature.checkValidity())
        const receiverSignature = document.getElementById('receiver_textSignature').value.trim();
        const dropImageData = dropImagePath.value;
        // console.log(shipperSignature);
        // console.log(pickupImageData);

        if (!dropImageData || !receiver_signature.checkValidity()) {
            alert("fill all the forms!");
        }
        // closeCamera();
        else if (dropImageData && receiver_signature.checkValidity()) {

            try{
                const [receiverSignature_response, dropImageData_response] = await Promise.all([



                    fetch("{{ route('admin.waybills.uploadSignatureNote', $waybill->id) }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            receiver_textSignature: receiverSignature
                        })
                    }),

                    fetch("{{ route('admin.waybills.uploadDropImageUpdated', $waybill->id) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            drop_image: dropImageData
                        })
                    })
                ]);

                const receiverData = await receiverSignature_response.json();
                const dropData = await dropImageData_response.json();

                console.log('shipper response:', receiverData);
                console.log('pickup response:', dropData);

                if (
                    receiverSignature_response.ok &&
                    dropImageData_response.ok &&
                    receiverData.success &&
                    dropData.success
                ) {
                    document.getElementById('overlay').style.display = 'none';
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'image & signature uploaded successfully!',
                    showConfirmButton: false, // No button
                    timer: 1500, // Notification will disappear in 3 seconds
                    timerProgressBar: true, // Show progress bar

                    });
                } else {
                    document.getElementById('overlay').style.display = 'none';
                    // alert("One or both submissions failed.");
                    throw new Error("One or both requests failed.");
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to upload image or text!',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    });

                }
            }
            catch (error) {
            // console.error(error);
            // alert('Something went wrong while saving.');
                document.getElementById('overlay').style.display = 'none';
                Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error! Someting went wrong',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
        }
        // });
    }

    });

// });

});






    </script>

@endpush
