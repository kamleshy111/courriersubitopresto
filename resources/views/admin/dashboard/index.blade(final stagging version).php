@extends('adminlte::page')



@section('title', 'Tableau de bord')



@section('content_header')
@role('Driver')
    <h1>Tableau de bord du Chauffeur</h1>
@else
    <h1>Tableau de bord</h1>
@endrole
@stop



@section('content')




    <div class="container">
        @role('Driver')
        <div class="row">


            {{-- in progress --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-waybill/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#' }}"> --}}
                        {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#'. /in-progress }}"> --}}
                    <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id() . '/in-progress') : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #e2c53d; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison en cours</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            {{-- picked up --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-waybill/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#' }}"> --}}
                    <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id() . '/pickedup') : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #de7d55; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison ramassé</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>


            {{-- Delivered --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-waybill/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#' }}"> --}}
                <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id() . '/delivered') : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #003482; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison terminé</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>


                        {{-- Summary --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-summary-table/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-summary-table/' . auth()->id()) : '#' }}"> --}}
                <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-summary-table/' . auth()->id()) : '#' }}">

                    <div class="card" style="border-radius: 14px; background-color: #34495e; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Rapport de commission</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>


            @endrole
        </div>
    {{-- </div> --}}
    {{-- @else --}}
    @php
        $user = auth()->user();
    @endphp
    @if( ($user && $user->roles->contains('id', 1)) || ($user && $user->roles->contains('id', 2)))
        {{-- @if(auth()->check() && auth()->user()->roles->contains('id', 1)){ --}}
    <p>Bienvenue sur votre plateforme administrative.</p>



    <div class="container">

        <div class="row">

            {{-- @role('Driver') --}}


            {{-- @endrole --}}
            {{-- @else --}}

            <div class="col-md-4">

                <a href="{{ url('admin/waybills?waybill=true') }}">

                    <div class="card" style="border-radius: 14px; background-color: #003482; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Bordereaux</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>





            <div class="col-md-4">

                <div class="card" style="border-radius: 14px; background-color: #DE7E55; width: 100%; height: 134px;">

                    <div class="card-body">

                        <div class="d-flex">

                            <p class="d-flex flex-column">

                                <span class="text-bold text-lg value" style="color: #ffffff;">Factures (à venir)</span>

                                <span class="label"></span>

                            </p>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card" style="border-radius: 14px; background-color: #5C0454; width: 100%; height: 134px;">

                    <div class="card-body">

                        <div class="d-flex">

                            <p class="d-flex flex-column">

                                <span class="text-bold text-lg value" style="color: #ffffff;">Preuves de livraison (à venir)</span>

                                <span class="label"></span>

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>





        <div class="row">

            <div class="col-md-4">

                <a href="{{ url('admin/waybills?waybill=false') }}">

                    <div class="card" style="border-radius: 14px; background-color: #105631; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Soumissions</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>





            <div class="col-md-4">

                <div class="card" style="border-radius: 14px; background-color: #E3C63D; width: 100%; height: 134px;">

                    <div class="card-body">

                        <div class="d-flex">

                            <p class="d-flex flex-column">

                                <span class="text-bold text-lg value" style="color: #ffffff;">Compte (à venir)</span>

                                <span class="label"></span>

                            </p>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <a href="{{ url('admin/clients') }}">

                    <div class="card" style="border-radius: 14px; background-color: #D72F52; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Carnet d´adresse</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>
            @if( ($user && $user->roles->contains('id', 2)))

            {{-- in progress --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-waybill/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#' }}"> --}}
                        {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#'. /in-progress }}"> --}}
                    <a href="admin/client/in-progress">

                    <div class="card" style="border-radius: 14px; background-color: #e2c53d; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison en cours</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            {{-- picked up --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-waybill/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#' }}"> --}}
                        <a href="admin/client/pickedup">

                    <div class="card" style="border-radius: 14px; background-color: #de7d55; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison ramassé</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>


            {{-- Delivered --}}

            <div class="col-md-4">

                {{-- <a href="{{ url('admin/driver-waybill/{id}') }}"> --}}
                    {{-- <a href="{{ auth()->check() && auth()->user()->roles->contains('id', 3) ? url('admin/driver-waybill/' . auth()->id()) : '#' }}"> --}}
                        <a href="admin/client/delivered">

                    <div class="card" style="border-radius: 14px; background-color: #003482; width: 100%; height: 134px;">

                        <div class="card-body">

                            <div class="d-flex">

                                <p class="d-flex flex-column">

                                    <span class="text-bold text-lg value" style="color: #ffffff;">Livraison terminé</span>

                                    <span class="label"></span>

                                </p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            @endif

        </div>

    </div>

    @endif
    {{-- @endrole --}}
    <style>

    .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    --bs-gutter-x: 0rem;  /* Set the gutter space */
    /* max-width: 100%;         Set the max width for containers */
    /* padding-left: 15px;      Custom padding */
    /* padding-right: 15px;     Custom padding */
}

        .note-editable {

            background-color: white !important;

        }

        /* CSS */

        .limited-text.expanded #client_news_preview {

            display: none;

        }



        .limited-text.expanded #client_news_full {

            display: block;

        }

        .center-button {

            display: block;

            margin: 0 auto;

            background-color: gray; /* This color can be customized */

            color: white; /* Text color, you can customize this as well */

        }



    </style>










    @if(auth()->check() && auth()->user()->roles->contains('id', 1))

 {{-- @role('admin') --}}
    <form method="POST" action="{{ route('admin.notes.store') }}">

        <div class="content">

            <div class="container">

                <div class="row">

                    <div class="col-lg-8">

                        <div class="card" style="height: 240px;">

                            <div class="card-header">

                                <h5 class="card-title" style="font-weight: bold;">Nouvelles</h5>

                            </div>

                            <textarea id="news" name="news" class="card-body">

                                           {!! $note->news !!}

                                        </textarea>



                        </div>

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card" style="height: 282px;">

                                    <div class="card-header">

                                        <h5 class="card-title" style="font-weight: bold;">Liens utiles</h5>

                                    </div>

                                    <textarea id="useful_links_1" name="useful_links_1" class="card-body">

                                                 {!! $note->useful_links_1 !!}

                                            </textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card" style="height: 540px;">

                            <div class="card-header">

                                <h5 class="card-title" style="font-weight: bold;">Documentations</h5>

                            </div>

                            <textarea id="quick_links_1" name="quick_links_1" class="card-body">

                                        {!! $note->quick_links_1 !!}

                                    </textarea>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary center-button btn-lg mt-5" style="background-color: gray; border: none;">Submit</button>

                </div>

            </div>

        </div>

    </form>



    <h1 class="mt-4">Imprimée les waybills crée aujourd'hui pour le client:</h1>

    @foreach(\App\Models\Client::get() as $client)

        <a href="{{route('admin.waybills.client_bulk', $client->id)}}" class="btn btn-info">{{$client->name}}</a>

    @endforeach



    @elseif(auth()->check() && auth()->user()->roles->contains('id', 2))

        <div class="content">

            <div class="container">

                <div class="row">

                    <div class="col-lg-8">

                        <div class="card" style="height: auto;">

                            <div class="card-header">

                                <h5 class="card-title" style="font-weight: bold;">Nouvelles</h5>

                            </div>

                            <div class="card-body">

                                <div class="limited-text">

                                    <div id="client_news_preview">

                                        @if($note->news)

                                            {!! Str::limit(strip_tags($note->news), 400) !!}

                                            <button id="expand-button" class="btn btn-primary center-button mt-5" style="background-color: gray; border: none;">Cliquez pour agrandir</button>

                                        @endif

                                    </div>

                                    <div id="client_news_full" style="display: none;">

                                        {!! $note->news !!}

                                    </div>

                                </div>



                            </div>

                        </div>



                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card" style="height: 282px;">

                                    <div class="card-header">

                                        <h5 class="card-title" style="font-weight: bold;">Liens utiles</h5>

                                    </div>

                                    <div class="card-body">

                                        {!! $note->useful_links_1 !!}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card" style="height: 540px;">

                            <div class="card-header">

                                <h5 class="card-title" style="font-weight: bold;">Documentations</h5>

                            </div>

                            <div class="card-body">

                                {!! $note->quick_links_1 !!}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        @endif

        @stop







        @push('js')

            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.62.0/codemirror.js"></script>


            {{-- <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // alert("working!");
        const dynamicLink = document.getElementById('dynamic-waybill-link');

        @if(auth()->check() && auth()->user()->roles->contains('id', 3))
        alert("working!");
            dynamicLink.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}";
        @else
            dynamicLink.href = "/6"; // Or redirect elsewhere
        @endif
    });
    </script> --}}

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
        });

    </script>


            <script>

                // JavaScript

                document.addEventListener("DOMContentLoaded", function () {

                    const expandButton = document.getElementById("expand-button");

                    const previewDiv = document.getElementById("client_news_preview");

                    const fullDiv = document.getElementById("client_news_full");



                    let expanded = false;



                    expandButton.addEventListener("click", function () {

                        expanded = !expanded;

                        if (expanded) {

                            previewDiv.style.display = "none";

                            fullDiv.style.display = "block";

                        } else {

                            previewDiv.style.display = "block";

                            fullDiv.style.display = "none";

                        }

                    });



                    // Ensure that the initial state is set correctly

                    if (!expanded) {

                        previewDiv.style.display = "block";

                        fullDiv.style.display = "none";

                    }

                });



            </script>



            <script type="text/javascript">

                $(document).ready(function () {

                    $('#news').summernote({

                        tabsize: 0,

                        height: 150,

                        focus: true,

                        toolbar: [

                            // [groupName, [list of button]]

                            ['style', ['bold', 'italic', 'underline', 'clear']],

                            ['link', ['linkDialogShow', 'unlink']],

                            ['font', ['strikethrough', 'superscript', 'subscript']],

                            ['fontsize', ['fontsize']],

                            ['color', ['color']],

                            ['para', ['ul', 'ol', 'paragraph']],

                            ['height', ['height']]

                        ]

                    });



                    $('#client_news').summernote({

                        tabsize: 0,

                        height: 150,

                        focus: true,

                        toolbar: [

                            // [groupName, [list of button]]



                        ],

                        codemirror: { // Enable CodeMirror plugin

                            theme: 'default', // You can choose a different theme if you prefer

                            readOnly: true // Set the editor to read-only

                        }

                    });

                    $('#client_news').summernote('disable');





                    $('#useful_links_1').summernote({

                        tabsize: 0,

                        height: 145,

                        focus: true,

                        toolbar: [

                            // [groupName, [list of button]]

                            ['style', ['bold', 'italic', 'underline', 'clear']],

                            ['link', ['linkDialogShow', 'unlink']],

                            ['font', ['strikethrough', 'superscript', 'subscript']],

                            ['fontsize', ['fontsize']],

                            ['color', ['color']],

                            ['para', ['ul', 'ol', 'paragraph']],

                            ['height', ['height']]

                        ]

                    });



                    $('#useful_links_2').summernote({

                        tabsize: 0,

                        height: 145,

                        focus: true,

                        toolbar: [

                            // [groupName, [list of button]]

                            ['style', ['bold', 'italic', 'underline', 'clear']],

                            ['link', ['linkDialogShow', 'unlink']],

                            ['font', ['strikethrough', 'superscript', 'subscript']],

                            ['fontsize', ['fontsize']],

                            ['color', ['color']],

                            ['para', ['ul', 'ol', 'paragraph']],

                            ['height', ['height']]

                        ]

                    });



                    $('#quick_links_1').summernote({

                        tabsize: 0,

                        height: 400,

                        focus: true,

                        toolbar: [

                            // [groupName, [list of button]]

                            ['style', ['bold', 'italic', 'underline', 'clear']],

                            ['link', ['linkDialogShow', 'unlink']],

                            ['font', ['strikethrough', 'superscript', 'subscript']],

                            ['fontsize', ['fontsize']],

                            ['color', ['color']],

                            ['para', ['ul', 'ol', 'paragraph']],

                            ['height', ['height']]

                        ]

                    });



                    var $summernoteQuickLinkDisable = $('#disable_quick_links_1');

                    $summernoteQuickLinkDisable.summernote();

                    $summernoteQuickLinkDisable.summernote('disable');



                    var $summernoteUsefulLinkDisable = $('#disable_useful_links_2');

                    $summernoteUsefulLinkDisable.summernote();

                    $summernoteUsefulLinkDisable.summernote('disable');



                    var $summernoteUsefulLinkOneDisable = $('#disable_useful_links_1');

                    $summernoteUsefulLinkOneDisable.summernote();

                    $summernoteUsefulLinkOneDisable.summernote('disable');



                    var $summernoteNewsDisable = $('#disable_news');

                    $summernoteNewsDisable.summernote();

                    $summernoteNewsDisable.summernote('disable');









                    $summernoteNewsDisable.summernote({

                        tabsize: 0,

                        height: 150,

                        focus: true,

                        toolbar: [

                            // [groupName, [list of button]]

                            ['style', ['bold', 'italic', 'underline', 'clear']],

                            ['link', ['linkDialogShow', 'unlink']],

                            ['font', ['strikethrough', 'superscript', 'subscript']],

                            ['fontsize', ['fontsize']],

                            ['color', ['color']],

                            ['para', ['ul', 'ol', 'paragraph']],

                            ['height', ['height']]

                        ]

                    });





                });



            </script>

        @endpush



