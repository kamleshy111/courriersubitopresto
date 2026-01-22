{{-- v5.4 working good version  --}}
{{--
    1.append node child problem for moving bills to the driver sub menus but no major problem
    2. moving via click replaced single cell waybill with the latest one
    6.3.25
    line 1997 updated
--}}

@extends('adminlte::page')

@section('title', ucfirst('Voir/Cacher prix'))

@section('content_header')
    <!-- <h1>Sticky Notes with Bootstrap Table</h1> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
@endsection

@section('content')

<div class="container mt-4" style="margin: 0px; padding-left:0px; padding-rigth:0px; ">

        <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- <div class="mb-4" id="#table-title"> --}}
        <h1>Bordereaux</h1>
        <a href="https://dev.courriesubito.wbmsites.com/admin/waybills/create?waybill=true" class="btn btn-lg btn-success">NOUVEAU</a>
    </div>
</div>

        <!-- <div class="sticky-notes-container" id="sticky-notes-container">
        </div> -->
        <!-- <table class="table table-bordered" id="sticky-table"> -->
        <table id="maintable" class="table table-bordered">
            <!-- <thead>
               <tr id="table-header-row">
                </tr>
            </thead>
            <tbody id="table-body">
            </tbody> -->

            <tr>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                {{-- <th rowspan="2">Sylvain 64 camion 20pi hauteur 82po <br>(4383349216)</th>
                <th rowspan="2">Arnaud 52 camion 22pi hauteur 86po <br>(5128809690)</th>
                <th rowspan="2">Achraf 55 camion 20pi hauteur 101po <br>(4384677732)</th>
                <th rowspan="2">Raymond 49 caravane <br> (5148638082)</th>
                <!-- <th colspan="2">St Arnaud</th> -->
                <th rowspan="2">André 43 camion 22pi hauteur 89po<br> (5148291298)</th>
                <th rowspan="2">Jolio 27 camion 20pi <br>(5146636145)</th>
                <th rowspan="2">Dany 01 caravane (5146052253)</th>
                <th rowspan="2">Chauffeur 1 <br>(5146052255)</th>
                <th rowspan="2">Chauffeur 2 <br>(5146052279)</th> --}}
                {{-- @foreach(range(1, 8) as $i)
                <th rowspan="2">
                    <select class="driver-select" name="driver_{{ $i }}">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" data-name="{{ $driver->name }}">
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                </th>
            @endforeach --}}
                {{-- <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th>
                <th rowspan="2"><select name="driver_id">
              0     <option 25lue="">Select Dr2ver</option>
                    @foreach($drivers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select></th> --}}
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>
                <th rowspan="2">
                    <select name="driver_id" style="width: 90px; height: 25px; font-size: 11px;">
                        <option value="">Select Driver</option>
                        @foreach($drivers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </th>

                <th rowspam="2"></th>
                <th rowspam="2"></th>
                <!-- <th rowspan="2">Cheque</th> -->
            </tr>
            <!-- <tr>
                        <th>55 </th>
                        <th>64</th>
                    </tr> -->
            </thead>
            <tbody id="table-body">
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Lundi</div>
                            <td class="note-container side-note">
                            </td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" >Mira</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <!-- <td colspan="6">Livraison Empilable à gauche voir tout les papiers</td> -->
                    <td class="note-container">

                    </td>
                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td class="note-container">

                    </td>
                    <td>
                        <div class="absent cornerSpecialNote" id="absent">ABS</div>
                    </td>
                    <td>
                        <div class="cheque" id="cheque">Cheque</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mardi</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" id="Dany">Dany</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <!-- <td colspan="6">Livraison Empilable à gauche voir tout les papiers</td> -->
                    {{-- <td> --}}
                        {{-- <div class="absent" id="absent">ABS</div> --}}

                    {{-- </td> --}}
                    <td class="note-container side-note"></td>
                    <td class="note-container side-note"></td>
                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Mercredi</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" >Donner</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <!-- <td>1</td> -->
                    <!-- <td colspan="6">à la fois</td> -->
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td>Note</td>
                    <td class="note-container side-note"></td>

                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Jeudi</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Donner1</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td>Envoi</td>
                    <!-- <td colspan="2">1</td> -->
                    <!-- <td colspan="4">à la fois</td> -->
                    <!-- <td rowspan="2">Jeudi</td> -->
                    <!-- <td rowspan="2">5 PM</td> -->
                    <td class="note-container side-note"></td>
                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Vendredi</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header" >Ramasser</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <td class="note-container"></td>
                    <!-- <td colspan="5">Livraison Empilable à gauche souri voir tout.</td> -->
                    <td>Deschamps</td>
                    <td class="note-container side-note"></td>
                </tr>
                <tr>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">A venir</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td>
                        <table class="inside-table">
                            <div class="side-header">Terminer</div>
                            <td class="note-container side-note"></td>
                        </table>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    {{-- <td></td> --}}
                    <!-- <td colspan="5">Cumulatif de la journée envoyé vers feuille de commission avec Web</td> -->
                    <!-- <td></td> -->
                    <td>Bureau</td>
                    <td class="note-container side-note"></td>
                </tr>
            </tbody>
        </table>
        <h1 class="mb-4" id="bottom-heading">Bordereaux en cours</h1>
        <div class="sticky-notes-container" id="sticky-notes-container">
    </div>
    <div clas="bottom-sticky-notes-container" id="bottom-sticky-notes-container"></div>
        </div>
    </div>
    <div class="overlay">
        <div class="popup">
            <div class="header">
                <h2>All Deliveries</h2>
                <button id="btn-close-popup">X</button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
    {{-- <div id="contextMenu" class="custom-context-menu" style="display: none;">
        <button id="moveToLundi">Move to Lundi</button>
        <button id="moveToMardi">Move to Mardi</button>
        <button id="moveToMercredi">Move to Mercredi</button>
        <button id="moveToJeudi">Move to Jeudi</button>
        <button id="moveToVendredi">Move to Vendredi</button>
        <button id="moveTovenir">Move to Livraison a venir</button>

    </div> --}}

    {{-- <div id="contextMenu" class="custom-context-menu" style="display: none;">
        <ul class="main-menu">
            <li class="menu-item">
                Drivers
                <ul class="sub-menu">
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                    <li>4</li>
                    <li>5</li>
                    <li>6</li>
                    <li>7</li>
                    <li>8</li>
                </ul>
            </li>
            <li class="menu-item">
                Clients
                <ul class="sub-menu">
                    <li>A</li>
                    <li>B</li>
                    <li>C</li>
                    <li>D</li>
                </ul>
            </li>
            <li class="menu-item">
                Days
                <ul class="sub-menu">
                    <li id="moveToLundi">Lundi</li>
                    <li id="moveToMardi">Mardi </li>
                    <li id="moveToMercredi">Mercredi</li>
                    <li id="moveToJeudi">Jeudi</li>
                    <li id="moveToVendredi">Vendredi</li>
                    <li>Samedi</li>
                    <li>Dimanche</li>
                </ul>
            </li>
        </ul>
    </div> --}}


    <div id="contextMenu" class="custom-context-menu">
        <!-- Main Menu -->
        <div id= "chaufferMenu"class="menu-item">
            Chauffeur
            <div class="sub-menu-item" id="Sylvain 64">Sylvain
                {{-- <button id="Sylvain 64">Sylvain 64</button> --}}
            <div class="sub-menu1">
                    <button id="64Donner">Donner</button>
                    <button id="64Donner1">Donner</button>
                    <button id="64Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
            </div>
            </div>
            <div class="sub-menu-item" id="Arnaud 52">Arnaud 52
                {{-- <button id="Arnaud 52">Arnaud 52</button> --}}
                <div class="sub-menu1">
                    <button id="52Donner">Donner</button>
                    <button id="52Donner1">Donner</button>
                    <button id="52Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>

            <div class="sub-menu-item" id="Achraf 55">Achraf 55
                <div class="sub-menu1">
                    <button id="55Donner">Donner</button>
                    <button id="55Donner1">Donner</button>
                    <button id="55Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
                {{-- <button id="Raymond 49">Raymond 49</button> --}}
            <div class="sub-menu-item" id="Raymond 49">Raymond 49
                <div class="sub-menu1">
                    <button id="49Donner">Donner</button>
                    <button id="49Donner1">Donner</button>
                    <button id="49Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
                <div class="sub-menu-item" id="André 43">André 43
                <div class="sub-menu1">
                    <button id="43Donner">Donner</button>
                    <button id="43Donner1">Donner</button>
                    <button id="43Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
                </div>
            <div class="sub-menu-item" id="Jolio 27">Jolio 27
                <div class="sub-menu1">
                    <button id="27Donner">Donner</button>
                    <button id="27Donner1">Donner</button>
                    <button id="27Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="Dany 01">Dany 01
                <div class="sub-menu1">
                    <button id="D01Donner">Donner</button>
                    <button id="D01Donner1">Donner</button>
                    <button id="D01Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="Chauffeur 1">Chauffeur 1
                <div class="sub-menu1">
                    <button id="Ch01Donner">Donner</button>
                    <button id="Ch01Donner1">Donner</button>
                    <button id="Ch01Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
            <div class="sub-menu-item" id="Chauffeur 2">Chauffeur 2
                <div class="sub-menu1">
                    <button id="Ch02Donner">Donner</button>
                    <button id="Ch02Donner1">Donner</button>
                    <button id="Ch02Ramasser">Ramasser</button>
                    {{-- <button id="Dany">Dany</button> --}}
                    {{-- <button id="Dany">Dany</button> --}}
                </div>
            </div>
        </div>



        {{-- </div> --}}
        {{-- <div class="sub-menu"> --}}
        <div class="menu-item">
            Clients
            <div class="sub-menu">
                <button id="Mira">Mira</button>
                <button id="Dany">Dany</button>
                <button id="Donner">Donner</button>
                <button id="Donner1">Donner1</button>
                <button id="Ramasser">Ramasser</button>
                {{-- <button id="Dany">Dany</button> --}}
            </div>
        </div>
        <div class="menu-item">
            Journée
            <div class="sub-menu">
                <button id="moveToLundi">Move to Lundi</button>
        <button id="moveToMardi">Move to Mardi</button>
        <button id="moveToMercredi">Move to Mercredi</button>
        <button id="moveToJeudi">Move to Jeudi</button>
        <button id="moveToVendredi">Move to Vendredi</button>
        <button id="moveTovenir">Move to Livraison a venir</button>

            </div>
        </div>
    </div>


@endsection

@push('css')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<style>
body{
    font-family: Arial, sans-serif;
    margin: 0;
    padding-left: 15px;
    font-size: 11.5px;
    font-weight: 400px;
}
#hidden{
    display: none;
}
#maintable{
    margin-left:5px;
}

/* styles.css */
#table-title {
  display: flex;
  justify-content: space-between;
  align-items: center; /* Vertically aligns the heading and button */
}

#table-title h1 {
  margin: 0; /* Remove default margin to prevent spacing issues */
}

#table-title a {
  text-decoration: none; /* Optional, in case you don't want the link to have an underline */
}


.side-header{
    font-weight: bold;
}
#bottom-heading{
    margin-left: 40px;
}
.bottom-sticky-note {
    background-color: #d6e8d3;
    /* Ensure width has units, e.g., px */
    /* max-width:: 200px; */
    width: 208px;
    /* max-height: 270px; */
    padding: 1px;
    border: 2px solid #000;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* This will handle both vertical and horizontal scrolling */
    /* overflow: auto;  */
    /*Ensure horizontal scrolling is enabled if needed*/
    /* overflow-x: auto; */
    /* Ensure vertical scrolling is enabled if needed */
    /* overflow-y: auto;  */
}

.bottom-sticky-note-piled {
    background-color: #d6e8d3;
    /* Ensure width has units, e.g., px */
    /* max-width: 293px; //old */
    max-width: 208px;
    /* max-height: 270px; */
    padding: 1px;
    border: 2px solid #000;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* This will handle both vertical and horizontal scrolling */
    /* overflow: auto;  */
    /*Ensure horizontal scrolling is enabled if needed*/
    /* overflow-x: auto; */
    /* Ensure vertical scrolling is enabled if needed */
    /* overflow-y: auto;  */
}


/* below two is to show short sticky notes */
.note-container .bottom-sticky-note {
    width: 340px;
    max-height: 230px;
    overflow: hidden;
}
/*.sticky-notes-container .bottom-sticky-note {
    width: 340px;
    max-height: 230px;
    overflow: hidden;
}*/

.multiple-notes .bottom-sticky-note {
    /* show only the first 2 rows */
    max-height: 15.5rem;
    margin-bottom: 0.5rem;
    width: 20rem;
}
/* n+3 note container  */
.note-container .bottom-sticky-note:nth-child(n)
{
    display: none;

}
/* display sigle  */
/* .note-container .bottom-sticky-note:nth-child:nth-child(n+1)
{
    display: block;

} */

/*.note-container .bottom-sticky-note:nth-child(n+2)
{
    display: block;

}*/

.multiple-divNotes{
    max-height: 10.30rem;
    /* width: 100%;   */
    /* height: 50%;   */
    overflow: hidden;  /* Hide the content that goes beyond the specified height */
    /* background-color: lightblue; */

}
.bottom-sticky-notes-container .multiple-divNotes:nth-child(n+6) {
    display: none; /* Hide divs 6 to 10 */
}

.bottom-sticky-notes-container .multiple-divNotes:nth-child(-n+5) {
    display: block; /* Ensure divs 1 to 5 are visible */
}

.bottom-note-table .bottom-table{
    width: 200px;
}
.bottom-note-table th,
.bottom-note-table td {
    border: 1px solid #000 !important;
    text-align: center;
    padding: 1px;
    font-size: 12px;
    /* font-weight: bold; */
    border-collapse: collapse;
}

.bottom-note-body {
    font-size: 10px;
    margin-top: 5px;
}

.bottom-section-title {
    font-weight: bold;
    margin-bottom: 2px;
    font-size: 15px;
}

.bottom-note-section {
    background: white;
    border: 1.5px solid #000;
    padding: 1px;
    text-align: center;
    font-style: italic;
    font-size: 10px;
    justify-content: center;
    align-items: center;
    margin-bottom:10px
}

.bottom-from-to-section {
    text-align: left;
    /* display: flex; */
    justify-content: space-between;
    margin-bottom: 2px;
}

/*.bottom-from-section, .bottom-to-section {
    width: 48%;
}*/

.bottom-from-section p,
.bottom-to-section p {
    margin: 0;
    font-size: 15px;
}

#bottom-special-Note {
    margin-bottom: 0;
    padding: 1px;
    font-size: 15px;
    /* width: 1px; */
}

/* new update by val */
/* .table-bordered {
    border-collapse: separate;
} */

.sticky-notes-container {
    /* previously it was 1200px */
    width: 1150px;
    max-width: 1200px;
    margin-left: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 2px dashed #ddd;
    position: relative;
    /* height: 200px; */
    overflow: auto;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.sticky-note {
    border: 1px solid #f0c340;
    border-radius: 4px;
    padding: 10px;
    cursor: move;
    position: relative;
    width: 200px;
    height: auto;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    word-wrap: break-word;
    z-index: 1000;
}

.status-tomorrow {
    background-color: #8fdefb;
    /* background-color: #28a745; */
    color: black;
}

.status-today {
    background-color: #a6f4ee;
    /* background-color:#A7F4F0; */
    /* background-color: #28a745; */
    /* background-color: #f9f79f; */
    color: black;
    /* color: white; */
}

.status-urgent {
    /*background-color: #e3342f;*/
    background-color: #e3342f;
    color: white;
}

.status-urgent {
    /*background-color: #e3342f;*/
    background-color: #FEFBC0;
    color: black;
}

.status-code_red{
    background-color: #E8A7BF;
    color: black;

}
.status-tres_urgent {
    background-color: #F09286;
    color: black;
}
.status-special_night{
    background-color: #E8A7BF;
    color: black;
}


.status-default {
    background-color: #B089F8;
    color: black;
}

.table-bordered {
    border: 2px solid #818181;
    border-collapse: collapse;
    background-color: #e7f3fa;
}

.table-bordered thead {
    background-color: #cbdefa;

}

.table-bordered th {
    border: 2px solid #818181;
    padding: 12px;
}


.table-bordered td {
    border: 2px solid #818181;
    padding: 4px;

    vertical-align: middle;
    text-align: center;
}

.table-bordered table {
    width: 100%;
}

.drag-over {
    border: 3px dashed #000 !important;
}

.table-header {
    vertical-align: top;
    text-transform: capitalize;
    /* vertical-align: top; */
}

.header-bold {
    font-weight: bold;
}

.note-container .side-note {
    height: 50px;
    width: 75px;
}

/*.bottom-note-table .bottom-table{
            border: 100px solid white;
        }*/
.corner-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-size: 15px;
}

.left-text {
    font-weight: bold;
}

.right-text {
    font-weight: bold;
}

.name-left-text {
    font-weight: bold;
    max-width: 250px;
}

.container .container-fluid {
    margin: 0px;
    padding-left: 65px;
    padding-right: 20px;

}

.container mt-4 {
    margin: 0px;
    padding: 0px;
}

.table {
    /* margin-left:100px; */
}

.overlay {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(16px);
    z-index: 1000;
}



.popup {
    display: flex;
    flex-direction: column;
    height: 32rem;
    width: 75rem;
    background-color: white;
    border-radius: 1rem;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.popup .header {
    padding: 1rem;
    border-bottom: 1px solid #ddd;
    display: flex;
    gap: 1rem;
    align-items: center;
}

#btn-save-waybill {
    height: fit-content;
}

#btn-close-popup {
    margin-left: auto;
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
}

.popup .body {
    margin-top: 15px;
    display: flex;
    flex-wrap: wrap;
    gap: 100px;
    padding: 1.25rem;
    /* height: 100%; //earlier */
    width: 100%;
    overflow: auto;
    justify-content: center;
}

.popup .body .sticky-note {
    overflow: unset;
    height: auto;
}

.absent {
    display: flex;
    justify-content: center;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
}

.absent span {
    margin: auto;
}

.cheque {
    display: flex;
    justify-content: center;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;
}

/* turned off for bubble */
.waybill-text{
    display: flex;
    justify-content: center;
    background-color: #8fdefb;
    color: black;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    padding: 5px;
    margin: 5px;

}
.note-count span{
    flex-grow: 1;
}*/

.cheque span {
    flex-grow: 1;
}

.two-line{
  text-align: center;  /* Center the content horizontally within the container */
  margin-bottom: 5px;
  font-size: 15px;
  /* padding: 20px;  Optional: Add some padding */
}
.name-center {
    display: block;
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;
    /* display: inline-block;  //Make span behave like a block */
    word-wrap: break-word;  /* Ensure words break when too long */
    overflow-wrap: break-word;  /* Alias for word-wrap */
    max-width: 100%;  /* Ensure the span doesn't overflow */

}
.phone-center{
    display: block;
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px
}

.address-center{
    display: inline-block;  /* Make span behave like a block */
    word-wrap: break-word;  /* Ensure words break when too long */
    overflow-wrap: break-word;  /* Alias for word-wrap */
    max-width: 100%;  /* Ensure the span doesn't overflow */
}


#bottom-sticky-notes-container {
    /* previously it was 1200px */
    width: 1150px; /* old value 1650*/
    max-width: 1200px; /* old value 1650*/
    margin-left: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 2px dashed #ddd;
    position: relative;
    /* height: 200px; */
    overflow: auto;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.side-note{
    height: 45px;
}

/* Style for the entire table cell */
.note-container {
  position: relative;        /* Allows positioning of the notification bubble */
  padding-left: 30px;        /* Space for the notification bubble on the left side */
}

/* Style for the notification bubble */
 /*.note-container div {
  position: absolute;
  top: 0;
  right: 0;
  background-color: #f00;    Red background (common for notifications)
  color: #fff;               White text color
  font-size: 12px;           Font size for the number
  width: 18px;               Width of the bubble
  height: 18px;              Height of the bubble
  border-radius: 50%;        Makes the bubble round
  display: flex;             Flexbox for centering text
  justify-content: center;   Center horizontally
  align-items: center;       Center vertically
}*/
.count-bubble-number {
  position: absolute;
  top: 0;
  right: 0;
  background-color: #f00;    /* Red background (common for notifications) */
  color: #fff;               /* White text color */
  font-size: 12px;           /* Font size for the number */
  width: 20px;               /* Width of the bubble */
  height: 20px;              /* Height of the bubble (equal to width for a perfect circle) */
  border-radius: 50%;        /* Makes the bubble round */
  display: flex;             /* Flexbox for centering text */
  justify-content: center;   /* Center horizontally */
  align-items: center;       /* Center vertically */
  font-weight: bold;         /* Optional: makes the number stand out more */
  text-align: center;        /* Ensures text is centered */
}

/* Optional: Style for when the number is '0' */
/*.note-container div:empty {
  display: none;             /* Hide the bubble if the number is 0 */
/* } */

/* context design */
/* old design */
/*.custom-context-menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: absolute;
    background-color: #ffffff;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    padding: 8px;
    z-index: 1000;
}
.custom-context-menu button {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    padding: 5px;
    font-size: 14px;
}
.custom-context-menu button:hover {
    color: #0056b3;
}*/
/* just turned off for sub menu */
/*.custom-context-menu {
            display: flex;
            flex-direction: column;  Stack buttons vertically
            gap: 10px; /* Space between buttons
            background-color: white;
            border: 1px solid #ccc;
            position: absolute;
            padding: 10px;
            width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
        }


        .custom-context-menu button {
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }


        .custom-context-menu button:hover {
            background-color: #e0e0e0;
        }*/




        .inside-table td{
            border: none;
        }

/*.custom-context-menu {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    width: 200px;
    padding: 0;
    margin: 0;
    display: none;
}

.main-menu,
.sub-menu {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.menu-item {
    position: relative;
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #ccc;
    background-color: #f9f9f9;
}

.menu-item:hover {
    background-color: #eaeaea;
}

.sub-menu {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.menu-item:hover .sub-menu {
    display: block;
    z-index: 1001;
}*/

/* menu context working */
/*.custom-context-menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: white;
    border: 1px solid #ccc;
    position: absolute;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 1000;
}

.menu-item {
    position: relative;
    cursor: pointer;
    padding: 8px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.menu-item:hover {
    background-color: #e0e0e0;
}

.sub-menu {
    display: none;
    flex-direction: column;
    gap: 5px;
    position: absolute;
    top: 0;
    left: 210px;
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1001;
}

.menu-item:hover .sub-menu {
    display: flex;
}

.sub-menu button {
    padding: 8px;
    font-size: 14px;
    cursor: pointer;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.sub-menu button:hover {
    background-color: #e0e0e0;
}*/
/* Main context menu styling */
.custom-context-menu {
    display: flex;
    flex-direction: column;
    background-color: white;
    border: 1px solid #ccc;
    position: absolute;
    padding: 10px;
    width: 200px; /* Main menu width */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: none; /* Hidden by default */
    z-index: 1000;
}

/* Styling for individual menu items in the main menu */
.menu-item {
    height: 35px;
    position: relative;
    flex-direction: column;
    cursor: pointer;
    padding: 8px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.menu-item:hover {
    background-color: #e0e0e0;
}

/* Second-level submenu (sub-menu) styling */
.sub-menu {
    display: none; /* Hidden by default */
    flex-direction: column;
    gap: 0;
    position: absolute;
    top: 0;
    left: 175px; /* Position to the right of the main menu item */
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    width: 200px; /* Same width as main menu */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1001;
}

.sub-menu-item{
    display: none; /* Hidden by default */
    flex-direction: column;
    gap: 0;
    position: relative;
    top: -35px;
    left: 165px; /* Position to the right of the main menu item */
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    width: 200px; /* Same width as main menu */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1005;
}

.sub-menu1{
    display: none; /* Hidden by default */
    flex-direction: column;
    gap: 0;
    position: absolute;
    top: 0;
    left: 198px; /* Position to the right of the main menu item */
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    width: 200px; /* Same width as main menu */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1002;
}

/* Show second-level submenu when hovering over a menu item */
.menu-item:hover .sub-menu {
    display: flex; /* Show submenu on hover */
}
/*.sub-menu:hover .sub-menu-item{
    display: flex;
}*/

/*#chaufferMenu.menu-item:hover .sub-menu-item{
    display: flex;
}*/
.sub-menu-item:hover .sub-menu1{
    display: flex;
}

/*#chaufferMenu.menu-item:hover .sub-menu{
    display: none;
}*/

#chaufferMenu.menu-item:hover .sub-menu-item{
    display: flex;
}



/* Third-level submenu (sub-menu1) styling */

/* Show third-level submenu when hovering over a button in the second-level submenu */
.sub-menu button {
    position: relative;
}


/* Show sub-menu1 when hovering over the button in sub-menu */



/* Styling for buttons in submenus */
.sub-menu button, .sub-menu1 button {
    padding: 8px;
    font-size: 14px;
    cursor: pointer;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

/* Hover effect for buttons in submenus */
.sub-menu button:hover, .sub-menu1 button:hover {
    background-color: #e0e0e0;
}

/* Optional: Add unique hover effect for sub-menu1 buttons */
.sub-menu1 button:hover {
    background-color: #df1717; /* Unique hover effect for sub-menu1 buttons */
}


/* Main context menu styling */
/* Main context menu styling */




.note-close-button {
    background-color: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/*.note-remove-button {
    background-color: transparent;
    color: red;
    border: none;
    border-radius: 50%;
    width: 400px;
    height: 20px;
    cursor: pointer;
    /* font: 16 & width: 20
    font-size: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.note-remove-button:hover {
    background-color: rgba(255, 0, 0, 0.1);
}*/


.note-wrapper {
    position: relative;
    margin-bottom: 10px;
}

.note-remove-button {
    margin-top:-22px;
    position: absolute;
    top: 0px;
    right: 0px;
    background-color: transparent;
    color: red;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 35px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

.note-remove-button:hover {
    background-color: rgba(255, 0, 0, 0.1);
}

/* Basic editable style */
.editable {
  /* background-color: #f9f9f9;   Light gray background */
  border: 1px solid #ddd;      /* Subtle border around editable areas */
  padding: 5px 10px;           /* Padding for comfortable text editing */
  text-align: center;          /* Center text in the editable cells */
  cursor: pointer;            /* Change cursor to indicate it’s clickable */
  transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transitions for interactivity */
}

/* On hover: change background to indicate that it's editable */
.editable:hover {
  background-color: #e6f7ff;  /* Light blue background on hover */
  border-color: #66b3ff;      /* Light blue border */
}

/* When the cell is in contenteditable mode (actively being edited) */
.editable[contenteditable="true"] {
  /* background-color: #fff;     White background for active editing */
  border-color: #007bff;      /* Blue border for active editing */
  outline: none;              /* Remove the default outline for focus */
}

/* Focus state when the user starts editing (for better visual feedback) */
.editable[contenteditable="true"]:focus {
  border-color: #0056b3;      /* Darker blue border when focused */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: add a subtle glow effect on focus */
}

/* Optional: Style for invalid input (if you want to highlight invalid entries) */
.editable.invalid {
  background-color: #ffcccc;  /* Light red background for invalid input */
  border-color: #ff0000;      /* Red border to indicate an issue */
}

/* Basic editable style */
.client-editable {
  /* background-color: #f9f9f9;   Light gray background */
  /* border: 1px solid #ddd;      Subtle border around editable areas */
  padding: 5px 10px;           /* Padding for comfortable text editing */
  text-align: center;          /* Center text in the editable cells */
  cursor: pointer;            /* Change cursor to indicate it’s clickable */
  transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transitions for interactivity */
}

/* On hover: change background to indicate that it's editable */
.client-editable:hover {
  background-color: #e6f7ff;  /* Light blue background on hover */
  border-color: #66b3ff;      /* Light blue border */
}

/* When the cell is in contenteditable mode (actively being edited) */
.client-editable[contenteditable="true"] {
  background-color: #fff;     /* White background for active editing */
  border-color: #007bff;      /* Blue border for active editing */
  outline: none;              /* Remove the default outline for focus */
}

/* Focus state when the user starts editing (for better visual feedback) */
.client-editable[contenteditable="true"]:focus {
  border-color: #0056b3;      /* Darker blue border when focused */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Optional: add a subtle glow effect on focus */
}

/* Optional: Style for invalid input (if you want to highlight invalid entries) */
.client-editable.invalid {
  /* background-color: #ffcccc;  Light red background for invalid input */
  border-color: #ff0000;      /* Red border to indicate an issue */
}
.minimized-note
{
    max-height: 11.8rem;
    overflow: hidden;
}

</style>
@endpush

@push('js')

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', () => {
    var flag = 0;
    const stickyNotesContainer = document.querySelector('#sticky-notes-container');
    const bottomStickyNotesContainer = document.querySelector('#bottom-sticky-notes-container');
    const tableBody = document.querySelector('#table-body');
    const tableHeaderRow = document.querySelector('#table-header-row');
    const waybillContainer = document.querySelector(".waybill-container");
    let selectedStickyNote = null;;

    async function fetchNotes() {
        let notes; // Replace with your API endpoint
        // return fetch('/Html Template for dashboard/dashboard/dev stagging module/devsimplified/Data/waybills.json') // Replace with your API endpoint
        return fetch('/admin/waybills/today') // Replace with your API endpoint
            .then(response => {notes = response.json(); return notes;})
            .catch(error => {
                console.error('Error fetching notes data:', error);
            });
    }

    async function saveNote(noteid, JSONdata){
        let notes = await fetchNotes();
        //replace the note (identified by id) with the new data
        let index = notes.findIndex(note => note.id === noteid);
        if(index !== -1){
            notes[index] = JSONdata;
        }
        //save
        localStorage.setItem('notes', JSON.stringify(notes));

    }
    saveNote();

    function fetchDriverData() {
        // return fetch('https://dev.courriesubito.wbmsites.com/admin/list-drivers',{
        return fetch('/admin/list-drivers',{
        // return fetch('/Html Template for dashboard/dashboard/dev stagging module/devsimplified/Data/drivers.json', {
            // return fetch('{list-drivers.json') }}',{
            method: 'GET',
            headers: {
                'Authorization': 'Bearer your-token',
                'Content-Type': 'application/json'
            }
        }) // Replace with your driver's API endpoint
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching driver data:', error);
            });
    }

    /*async function fetchDriverData() {
    try {
        const response = await fetch('https://dev.courriesubito.wbmsites.com/admin/list-drivers', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer your-token',
                'Content-Type': 'application/json'
            }
        });

        // Check if the response is OK (status in the range 200-299)
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching driver data:', error);
    }
}*/


    function fetchAdditionalData() {
        return fetch('/admin/api/clients') // Replace with your new API endpoint
        // return fetch('/Html Template for dashboard/dashboard/dev stagging module/devsimplified/Data/clients.json') // Replace with your new API endpoint
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching additional data:', error);
            });
    }

    /*function waybillCreation(value, length, padChar) {
        const str = String(value); // Convert the value to a string if it's not already
        return str.padStart(length, padChar); // Use String.prototype.padStart
    }*/

    function waybillCreation(value, length, padChar, prefix) {
        const str = String(value); // Convert the value to a string if it's not already
        const paddedValue = str.padStart(length, padChar); // Pad the value
        return prefix + paddedValue; // Add the prefix and return the result
    }

    function generateTopStickyNotes1(notes, additionalData) {
        //we setup the table and the sticky notes container
        // const topNotes = notes.slice(0, 10);
        addDragAndDropToCells();

        stickyNotesContainer.innerHTML = '';
        // topNotes.forEach(note => {
        notes.forEach(note => {
            const waybillDiv = document.createElement('div');
            waybillDiv.className = 'waybill-container';
            var dispacherId = note.shipper_id;
            // var dispacherId = note.recipient_id;
            var description = note.description;
            var sortDescription = description.substring(0, 10);
            // var clientID = note.
            // console.log("dispacher ID(soft_ID): ")
            // console.log(additionalData[0]);
            const additionalInfo = additionalData.find(data => data.id === dispacherId); // Replace `key` with the actual key name
            console.log('additional Info: ');
            console.log(additionalInfo);
            // if(additionalData.find(data => data.id == dispacherId))
            // {
            var dispacherIndexNumber = additionalData.findIndex(data => data.id == dispacherId)
            var prefix = additionalData[dispacherIndexNumber].prefix;
            // console.log('prefix: ' +prefix);

            // soft_id is the number of waybill
            var waybillSoftId = note.soft_id;

            // user_id is the client identity number
            var clientID = note.user_id;


            // console.log('waybill: ' + waybill);

            var dispacherName = additionalData[dispacherIndexNumber].name;
            var dispacherPhone = additionalData[dispacherIndexNumber].phone;
            var dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            var dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            var dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            // receiver details:

            var receiverID = note.recipient_id


            var receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID)

            // var prefix = additionalData[receiverIndexNumber].prefix;
            var waybill = waybillCreation(waybillSoftId, 6, 0, prefix);
            var receiverName = additionalData[receiverIndexNumber].name;
            var receiverPhone = additionalData[receiverIndexNumber].phone;
            var receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            var receiverStreetAddress = additionalData[receiverIndexNumber].address;
            var receiverCityName = additionalData[receiverIndexNumber].city_name;

            const noteDiv = document.createElement('div');
            noteDiv.className = 'bottom-sticky-note';
            noteDiv.draggable = true;
            noteDiv.dataset.id = note.id;

            if (note.status === 'tomorrow') {
                noteDiv.classList.add('status-tomorrow');
                var statusTranslated = 'Lendemain';
            }
            else if (note.status === 'same_day') {
                noteDiv.classList.add('status-today');
                var statusTranslated = 'Même Jour';

            }

            else if (note.status === 'urgent') {
                noteDiv.classList.add('status-urgent');
                var statusTranslated = 'urgent';
            }

            else if (note.status === 'very_urgent') {
                noteDiv.classList.add('status-tres_urgent');
                var statusTranslated = 'TRES urgent';
            }
            else if (note.status === 'code_red') {
                noteDiv.classList.add('status-code_red');
                var statusTranslated = 'RED CODE';
            }

            else if (note.status === 'special_night') {
                noteDiv.classList.add('status-special_night');
                var statusTranslated = 'SPECIAL NIGHT';
            }

            else {
                noteDiv.classList.add('status-default');
                var statusTranslated = 'Invalide';
            }

            // <span class="right-text">${dispacherPhone}</span>

            noteDiv.innerHTML = `

                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2">05-09-2024</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td >8:00</td>
                                    <td >${statusTranslated.toUpperCase()}</td>
                                    <td >08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td >${clientID}</td>
                                    <td >${waybill}</td>
                                    <td >560,00 $</td>
                                </tr>
                                <tr>
                                    <td >AUTRES</td>
                                    <td >POIDS</td>
                                    <td ></td>
                                </tr>

                                <tr>
                                    <td ></td>
                                    <td >TRUCK SIZE</td>
                                    <td ></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center"> ${dispacherPhone}</span>
                                    <span class="address-center" >${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text" >${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center">${receiverName.toUpperCase()} </span>
                                    <span class="phone-center"> ${receiverPhone}</span>
                                    <span class="address-center" >${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${receiverCityName.toUpperCase()}</span>
                                        <span class="right-text" >${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;

            // val new test start

            console.log("appending " + note.id + " to sticky notes container");
            // Otherwise, place it in the sticky notes container
            stickyNotesContainer.appendChild(noteDiv);

            // Add event listeners for drag and drop
            noteDiv.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                e.target.style.zIndex = 1000;
            });

            noteDiv.addEventListener('dragend', (e) => {
                e.target.style.zIndex = '';
            });

            // open in new tab the waybill
            /*noteDiv.addEventListener('contextmenu', (e) => {
                       e.preventDefault(); // Prevent the default context menu from appearing
                       const noteId = noteDiv.dataset.id;
                       const url = `https://app.courriersubitopresto.com/admin/waybills/${note.id}/edit?waybill=true/`; // Replace with your actual URL pattern
                       window.open(url, '_blank');
                   });*/
        });

        // contex menu

        /*stickyNote.addEventListener("contextmenu", function (event) {
            event.preventDefault();

            // Store the clicked sticky note
            selectedStickyNote = stickyNote;

            // Position and display the context menu
            contextMenu.style.display = "block";
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        });
    // });

    // Handle click on "Move to Cell 0" button
    document.getElementById("moveToCell0").addEventListener("click", function () {
        if (selectedStickyNote && mainTable) {
            const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
        }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // Hide context menu on outside click
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".custom-context-menu")) {
            contextMenu.style.display = "none";
        }
    });*/


        /*const allNotePositions = getSavedPositions();

        for (const position of allNotePositions) {
            const noteDiv = document.querySelector(`.bottom-sticky-note[data-id="${position.noteId}"]`);
            console.log("inserting " + position.noteId + " in cell " + position.cellId );
            if (noteDiv) {
                insertNoteInCell(noteDiv, position.cellId);
            }
            else {
                console.log("special note", position.noteId);
                const specialNote = document.querySelector(`.${position.noteId}`);
                insertNoteInCell(specialNote, position.cellId, true);
            }
        }*/




    }


    function generateTopStickyNotes(notes, additionalData) {
        flag = 0;
        addDragAndDropToCells();
        const stickyNotesContainer = document.querySelector('.sticky-notes-container');
        const contextMenu = document.getElementById("contextMenu");
        const mainTable = document.querySelector("#main-table"); // Replace with your table's actual ID
        // let selectedStickyNote = null;

    // Clear the existing notes
    stickyNotesContainer.innerHTML = '';

    // const topNotes = notes.slice(0, 10);
    // addDragAndDropToCells();
        // var flag = 0;
            stickyNotesContainer.innerHTML = '';
        // topNotes.forEach(note => {
        notes.forEach((note,index) => {
            flag = 1;
            // const waybillDiv = document.createElement('div');
            // waybillDiv.className = 'waybill-container';

            // var dispacherId = note.recipient_id;


        const waybillDiv = document.createElement('div');
        waybillDiv.className = 'waybill-container';

        const noteDiv = document.createElement('div');
        noteDiv.className = 'bottom-sticky-note';
        noteDiv.draggable = true;
        noteDiv.dataset.id = note.id;


            var dispacherId = note.shipper_id;
            var description = note.description;
            var sortDescription = description.substring(0, 10);
            // var clientID = note.
            // console.log("dispacher ID(soft_ID): ")
            // console.log(additionalData[0]);
            const additionalInfo = additionalData.find(data => data.id === dispacherId); // Replace `key` with the actual key name
            console.log('additional Info: ');
            console.log(additionalInfo);
            // if(additionalData.find(data => data.id == dispacherId))
            // {
            var dispacherIndexNumber = additionalData.findIndex(data => data.id == dispacherId)
            var prefix = additionalData[dispacherIndexNumber].prefix;
            // console.log('prefix: ' +prefix);

            // soft_id is the number of waybill
            var waybillSoftId = note.soft_id;

            // user_id is the client identity number
            var clientID = note.user_id;


            // console.log('waybill: ' + waybill);
            var updateDate = note.date;
            console.log(updateDate);

            var inputDate = "2024-10-12 04:09:10";

// Create a new Date object from the input string
var dateObj = new Date(updateDate);

// Get the day, month, and year from the Date object
var day = dateObj.getDate(); // Returns the day of the month (1-31)
var month = dateObj.getMonth() + 1; // Months are zero-based, so we add 1
var year = dateObj.getFullYear(); // Returns the full year (e.g., 2024)

// Format the date as 'dd-mm-yyyy'
var formattedDate = (day < 10 ? '0' + day : day) + '-' + (month < 10 ? '0' + month : month) + '-' + year;


            var dispacherName = additionalData[dispacherIndexNumber].name;
            var dispacherPhone = additionalData[dispacherIndexNumber].phone;
            var dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            var dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            var dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            // receiver details:

            var receiverID = note.recipient_id


            var receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID)

            // var prefix = additionalData[receiverIndexNumber].prefix;
            var waybill = waybillCreation(waybillSoftId, 6, 0, prefix);
            var receiverName = additionalData[receiverIndexNumber].name;
            var receiverPhone = additionalData[receiverIndexNumber].phone;
            var receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            var receiverStreetAddress = additionalData[receiverIndexNumber].address;
            var receiverCityName = additionalData[receiverIndexNumber].city_name;

            var statusTranslated =  updateNoteStatus(note,noteDiv)
            // <span class="right-text">${dispacherPhone}</span>

            noteDiv.innerHTML = `

                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2" contenteditable="true">${formattedDate}</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td contenteditable="true">8:00</td>
                                    <td class="editable" data-table="waybills" data-column="status" data-id=${note.id}>${statusTranslated.toUpperCase()}</td>
                                    <td contenteditable="true">08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td class="editable" data-table="waybills" data-column="user_id" data-id=${note.id}>${clientID}</td>

                                    <td contenteditable="true">${waybill}</td>
                                    <td contenteditable="true">560,00 $</td>
                                </tr>
                                <tr>
                                    <td contenteditable="true">AUTRES</td>
                                    <td contenteditable="true">POIDS</td>
                                    <td contenteditable="true"></td>
                                </tr>

                                <tr>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true">TRUCK SIZE</td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center client-editable" data-table="clients" data-column="phone" data-id=${dispacherId}> ${dispacherPhone}</span>
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${dispacherId}>${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note" contenteditable="true">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${dispacherId}>${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text client-editable" data-table="clients" data-column="postal_code" data-id=${dispacherId}>${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center client-editable" data-table="clients" data-column="phone" data-id=${receiverID}> ${receiverPhone}</span>
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${receiverID}>${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note" contenteditable="true">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">

                                        {{-- <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${receiverID}>${receiverCityName.toUpperCase()}</span>--}}
                                        <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${receiverID}">${receiverCityName ? receiverCityName.toUpperCase() : 'City Not Found'}</span>
                                        <span class="right-text client-editable" data-table="clients" data-column="postal_code" data-id=${receiverID}>${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;


        // Add note to container
        // stickyNotesContainer.appendChild(noteDiv);


        if(index>=10)
        {
            noteDiv.classList.add('minimized-note');
            // console.log(noteDiv.id);

            // showBottomPopUp(note.id);
        }
        const savedPosition = getSavedPosition(note.id);
            console.log(savedPosition);
            if (savedPosition) {
                insertNoteInCell(noteDiv, savedPosition.cellId);
            } else {
                // Otherwise, place it in the sticky notes container
                stickyNotesContainer.appendChild(noteDiv);
            }

        // Add context menu event to each note
        noteDiv.addEventListener("contextmenu", function (event) {
            event.preventDefault();
            selectedStickyNote = noteDiv;
            console.log(selectedStickyNote);
            // Show and position context menu
            contextMenu.style.display = "block";
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        });

    //     document.querySelectorAll(".sub-menu li").forEach((item) => {
    //     item.addEventListener("click", function (e) {
    //     console.log("Selected:", this.textContent);
    //     const contextMenu = document.getElementById("contextMenu");
    //     contextMenu.style.display = "none";
    //  });
    // });

    document.querySelectorAll(".sub-menu button").forEach((button) => {
    button.addEventListener("click", function () {
        // alert(`Selected: ${this.textContent}`);
        const contextMenu = document.getElementById("contextMenu");
        contextMenu.style.display = "none"; // Hide menu after selection
    });


    });

    document.querySelectorAll(".sub-menu1 button").forEach((button) => {
    button.addEventListener("click", function () {
        // alert(`Selected: ${this.textContent}`);
        const contextMenu = document.getElementById("contextMenu");
        contextMenu.style.display = "none"; // Hide menu after selection
    });


    });



        // addDragAndDropToCells();
        // Drag and Drop event listeners
        noteDiv.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
            e.dataTransfer.effectAllowed = 'move';
            e.target.style.zIndex = 1000;
        });

        noteDiv.addEventListener('dragend', (e) => {
            e.target.style.zIndex = '';
        });
    });
    flag = 0;
    showAllNotes();
    // Move selected sticky note to cell 0 when context menu option is clicked
    /*document.getElementById("moveToLundi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell0");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    // Move to Mardi
    // week days!!
    document.getElementById("moveToLundi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell11");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell0");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveToMardi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell11");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // move To Mercredi

    document.getElementById("moveToMercredi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell24");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    document.getElementById("moveToJeudi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell36");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("moveToVendredi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell48");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell60");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // clients

    document.getElementById("Mira").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell1");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Dany").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell12");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell25");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });
    document.getElementById("Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell37");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell49");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });




    // drivers

    document.getElementById("Sylvain 64").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell2");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            insertNoteInCell(selectedStickyNote,"cell2");
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // submenu 01

    document.getElementById("64Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell26");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            insertNoteInCell(selectedStickyNote,"cell26");
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("64Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell38");
        // console.log(`selected cellID: ${destinationCell}`);
        // const cell = document.querySelector(`#${cellId}`);
        // const targetCellId = "cell38";
        insertNoteInCell(selectedStickyNote,"cell38");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("64Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell50");
        // console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            insertNoteInCell(selectedStickyNote,"cell50");
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Arnaud 52").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell3");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell3");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("52Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell27");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell27");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("52Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell39");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell39");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("52Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell51");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell51");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });


    document.getElementById("Achraf 55").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell4");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell4");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("55Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell28");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell28");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("55Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell40");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell40");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("55Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell52");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell52");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Raymond 49").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell5");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell5");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("49Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell29");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell29");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("49Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell41");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell41");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("49Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell53");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell53");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("André 43").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell6");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell6");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("43Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell30");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell30");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("43Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell42");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell42");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("43Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell54");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell54");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Jolio 27").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell7");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell7");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("27Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell31");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell31");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("27Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell43");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell43");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("27Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell55");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell55");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Dany 01").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell8");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell8");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("D01Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell32");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell32");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("D01Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell44");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell44");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("D01Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell56");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell56");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Chauffeur 1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell9");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell9");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("Ch01Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell33");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell33");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch01Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell45");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell45");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch01Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell57");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell57");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Chauffeur 2").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell10");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell10");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    // sub menu
    document.getElementById("Ch02Donner").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell34");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell34");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch02Donner1").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell46");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell46");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });

    document.getElementById("Ch02Ramasser").addEventListener("click", function () {
        console.log(selectedStickyNote);
        // const destinationCell = document.querySelector("#cell58");
        // console.log(`selected cellID: ${destinationCell}`);
        insertNoteInCell(selectedStickyNote,"cell58");
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            // destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            // showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });





    /*document.getElementById("moveTovenir").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell60");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    // input data on the cell


    /*document.getElementById("").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell0");
        console.log(`selected cellID: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/

    // Hide context menu on outside click
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".custom-context-menu")) {
            contextMenu.style.display = "none";
        }
    });

    // bottom sticky notes

    const bottomPilledNotes = document.querySelectorAll('.minimized-note');

        // Ensure bottomStickyNotesContainer is not empty
        // if (bottomStickyNotesContainer1.length > 0) {
            bottomPilledNotes.forEach(div => {
                // Add click event listener to each div

                div.addEventListener('click', function() {
                    // alert("identified!");
                    // debug
                    // console.log(`Clicked on div with data-id: ${dataId}`);
                    // const innderDivData = document.querySelector(`div[data-id="${dataId}"]`);
                    // console.log(innderDivData);
                    const dataId = div.getAttribute('data-id');
                    showNewBottomPopUp(dataId);
                });
            });

    addDragAndDropToCells();
}


function updateNoteStatus(note, noteDiv) {
    let statusTranslated;

    // Clear any existing status classes
    noteDiv.classList.remove(
        'status-tomorrow', 'status-today', 'status-urgent', 'status-tres_urgent',
        'status-code_red', 'status-special_night', 'status-default'
    );

    // Check the note's status and assign classes and translated status
    switch(note.status) {
        case 'tomorrow':
            noteDiv.classList.add('status-tomorrow');
            statusTranslated = 'Lendemain';
            break;
        case 'same_day':
            noteDiv.classList.add('status-today');
            statusTranslated = 'Même Jour';
            break;
        case 'urgent':
            noteDiv.classList.add('status-urgent');
            statusTranslated = 'urgent';
            break;
        case 'very_urgent':
            noteDiv.classList.add('status-tres_urgent');
            statusTranslated = 'TRES urgent';
            break;
        case 'code_red':
            noteDiv.classList.add('status-code_red');
            statusTranslated = 'RED CODE';
            break;
        case 'night':
            noteDiv.classList.add('status-special_night');
            statusTranslated = 'SPECIAL NIGHT';
            break;
        default:
            noteDiv.classList.add('status-default');
            statusTranslated = 'Invalide';
            break;
    }

    // You can return the translated status if needed
    return statusTranslated;
}


    /*function generateTopStickyNotes(notes, additionalData) {
    // Set up the table and sticky notes container
    addDragAndDropToCells();
    const topNotes = notes.slice(0, 10);

    // Clear the sticky notes container
    stickyNotesContainer.innerHTML = '';

    // Group notes by waybill (soft_id)
    const groupedNotes = {};

    topNotes.forEach(note => {
        const waybill = note.soft_id; // Group by waybill (soft_id)
        if (!groupedNotes[waybill]) {
            groupedNotes[waybill] = []; // Initialize array if this waybill doesn't exist yet
        }
        groupedNotes[waybill].push(note); // Add the note to the respective waybill group
    });

    // Now loop through each group and create separate divs for each waybill
    Object.keys(groupedNotes).forEach(waybill => {
        const waybillNotes = groupedNotes[waybill];
        const waybillDiv = document.createElement('div');
        waybillDiv.className = 'waybill-container';
        // waybillDiv.className = 'multiple-divNotes';
        // waybillDiv.dataset.waybill = waybill;

        // Optionally, sort the notes within each waybill group (by some criteria)
        // waybillNotes.sort((a, b) => a.id - b.id); // Sorting by note ID, change to other criteria if needed

        // Process each note in this waybill group
        waybillNotes.forEach(note => {
            const dispacherId = note.shipper_id;
            const description = note.description;
            const sortDescription = description.substring(0, 10);
            const additionalInfo = additionalData.find(data => data.id === dispacherId);

            const dispacherIndexNumber = additionalData.findIndex(data => data.id === dispacherId);
            const prefix = additionalData[dispacherIndexNumber].prefix;
            const waybillSoftId = note.soft_id;
            const clientID = note.user_id;

            const dispacherName = additionalData[dispacherIndexNumber].name;
            const dispacherPhone = additionalData[dispacherIndexNumber].phone;
            const dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            const dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            const dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            const receiverID = note.recipient_id;
            const receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID);
            const receiverName = additionalData[receiverIndexNumber].name;
            const receiverPhone = additionalData[receiverIndexNumber].phone;
            const receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            const receiverStreetAddress = additionalData[receiverIndexNumber].address;
            const receiverCityName = additionalData[receiverIndexNumber].city_name;

            const waybillCreationResult = waybillCreation(waybillSoftId, 6, 0, prefix);
            const statusTranslated = translateStatus(note.status);

            // Create the sticky note div for this note
            const noteDiv = document.createElement('div');
            noteDiv.className = 'bottom-sticky-note';
            noteDiv.draggable = true;
            noteDiv.dataset.id = note.id;

            noteDiv.classList.add(`status-${note.status}`);

            noteDiv.innerHTML = `
                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2" contenteditable="true">05-09-2024</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td contenteditable="true">8:00</td>
                                    <td contenteditable="true">${statusTranslated.toUpperCase()}</td>
                                    <td contenteditable="true">08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td contenteditable="true">${clientID}</td>
                                    <td contenteditable="true">${waybill}</td>
                                    <td contenteditable="true">560,00 $</td>
                                </tr>
                                <tr>
                                    <td contenteditable="true">AUTRES</td>
                                    <td contenteditable="true">POIDS</td>
                                    <td contenteditable="true"></td>
                                </tr>

                                <tr>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true">TRUCK SIZE</td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" contenteditable="true">${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center" contenteditable="true"> ${dispacherPhone}</span>
                                    <span class="address-center" contenteditable="true">${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note" contenteditable="true">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text" contenteditable="true">${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text" contenteditable="true">${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center" contenteditable="true">${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center" contenteditable="true"> ${receiverPhone}</span>
                                    <span class="address-center" contenteditable="true">${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note" contenteditable="true">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text" contenteditable="true">${receiverCityName.toUpperCase()}</span>
                                        <span class="right-text" contenteditable="true" >${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;

            // Append this sticky note to the current waybill container
            waybillDiv.appendChild(noteDiv);

            // Add drag and drop event listeners
            noteDiv.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                e.target.style.zIndex = 1000;
            });

            noteDiv.addEventListener('dragend', (e) => {
                e.target.style.zIndex = '';
            });
        });

        // Append the waybill div to the main container
        stickyNotesContainer.appendChild(waybillDiv);
    });
}
*/


// bottom sticky notes
/*function generateBottomStickyNotes(notes, additionalData) {
    // Set up the table and sticky notes container
    // addDragAndDropToCells();
    // div.addEventListener('click', (e) => showPopUp(e));
    const bottomNotes = notes.slice(10);

    // Clear the sticky notes container
    bottomStickyNotesContainer.innerHTML = '';

    // Group notes by waybill (soft_id)
    const groupedNotes = {};

    bottomNotes.forEach(note => {
        const waybill = note.soft_id; // Group by waybill (soft_id)
        if (!groupedNotes[waybill]) {
            groupedNotes[waybill] = []; // Initialize array if this waybill doesn't exist yet
        }
        groupedNotes[waybill].push(note); // Add the note to the respective waybill group
    });

    // Now loop through each group and create separate divs for each waybill
    Object.keys(groupedNotes).forEach(waybill => {
        const waybillNotes = groupedNotes[waybill];
        const waybillDiv = document.createElement('div');
        // waybillDiv.className = 'waybill-container';
        waybillDiv.className = 'multiple-divNotes';
        // waybillDiv.dataset.waybill = waybill;

        // Optionally, sort the notes within each waybill group (by some criteria)
        // waybillNotes.sort((a, b) => a.id - b.id); // Sorting by note ID, change to other criteria if needed

        // Process each note in this waybill group
        waybillNotes.forEach(note => {
            const dispacherId = note.shipper_id;
            const description = note.description;
            const sortDescription = description.substring(0, 10);
            const additionalInfo = additionalData.find(data => data.id === dispacherId);

            const dispacherIndexNumber = additionalData.findIndex(data => data.id === dispacherId);
            const prefix = additionalData[dispacherIndexNumber].prefix;
            const waybillSoftId = note.soft_id;
            const clientID = note.user_id;

            const dispacherName = additionalData[dispacherIndexNumber].name;
            const dispacherPhone = additionalData[dispacherIndexNumber].phone;
            const dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            const dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            const dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            const receiverID = note.recipient_id;
            const receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID);
            const receiverName = additionalData[receiverIndexNumber].name;
            const receiverPhone = additionalData[receiverIndexNumber].phone;
            const receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            const receiverStreetAddress = additionalData[receiverIndexNumber].address;
            const receiverCityName = additionalData[receiverIndexNumber].city_name;

            const waybillCreationResult = waybillCreation(waybillSoftId, 6, 0, prefix);
            const statusTranslated = translateStatus(note.status);

            // Create the sticky note div for this note
            const noteDiv = document.createElement('div');
            noteDiv.className = 'bottom-sticky-note-piled';
            noteDiv.draggable = true;
            noteDiv.dataset.id = note.id;

            noteDiv.classList.add(`status-${note.status}`);

            noteDiv.innerHTML = `
                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2">05-09-2024</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td >8:00</td>
                                    <td >${statusTranslated.toUpperCase()}</td>
                                    <td >08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td >${clientID}</td>
                                    <td >${waybill}</td>
                                    <td >560,00 $</td>
                                </tr>
                                <tr>
                                    <td >AUTRES</td>
                                    <td >POIDS</td>
                                    <td ></td>
                                </tr>

                                <tr>
                                    <td ></td>
                                    <td >TRUCK SIZE</td>
                                    <td ></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center"> ${dispacherPhone}</span>
                                    <span class="address-center" >${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text" >${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center">${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center"> ${receiverPhone}</span>
                                    <span class="address-center" >${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${receiverCityName.toUpperCase()}</span>
                                        <span class="right-text" >${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;

            // Append this sticky note to the current waybill container
            waybillDiv.appendChild(noteDiv);

            // Add drag and drop event listeners
            noteDiv.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                e.target.style.zIndex = 1000;
            });

            noteDiv.addEventListener('dragend', (e) => {
                e.target.style.zIndex = '';
            });
        });

        // Append the waybill div to the main container
        bottomStickyNotesContainer.appendChild(waybillDiv);
    });
    bottomStickyNotesContainer.addEventListener('click', (e) => {
        // Ensure the clicked element is a sticky note
        // alert("function called");
        showBottomPopUp(e);

    });
}*/

function generateBottomStickyNotes(notes, additionalData) {
        //we setup the table and the sticky notes container
        const bottomNotes = notes.slice(10);
        // addDragAndDropToCells();

        bottomStickyNotesContainer.innerHTML = '';
        bottomNotes.forEach(note => {
            const waybillDiv = document.createElement('div');
            waybillDiv.className = 'multiple-divNotes';
            waybillDiv.dataset.waybill = note.id;
            var dispacherId = note.shipper_id;
            // var dispacherId = note.recipient_id;
            var description = note.description;
            var sortDescription = description.substring(0, 10);
            // var clientID = note.
            // console.log("dispacher ID(soft_ID): ")
            // console.log(additionalData[0]);
            const additionalInfo = additionalData.find(data => data.id === dispacherId); // Replace `key` with the actual key name
            console.log('additional Info: ');
            console.log(additionalInfo);
            // if(additionalData.find(data => data.id == dispacherId))
            // {
            var dispacherIndexNumber = additionalData.findIndex(data => data.id == dispacherId)
            var prefix = additionalData[dispacherIndexNumber].prefix;
            // console.log('prefix: ' +prefix);

            // soft_id is the number of waybill
            var waybillSoftId = note.soft_id;

            // user_id is the client identity number
            var clientID = note.user_id;


            // console.log('waybill: ' + waybill);

            var dispacherName = additionalData[dispacherIndexNumber].name;
            var dispacherPhone = additionalData[dispacherIndexNumber].phone;
            var dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            var dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            var dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            // receiver details:

            var receiverID = note.recipient_id


            var receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID)

            // var prefix = additionalData[receiverIndexNumber].prefix;
            var waybill = waybillCreation(waybillSoftId, 6, 0, prefix);
            var receiverName = additionalData[receiverIndexNumber].name;
            var receiverPhone = additionalData[receiverIndexNumber].phone;
            var receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            var receiverStreetAddress = additionalData[receiverIndexNumber].address;
            var receiverCityName = additionalData[receiverIndexNumber].city_name;

            // <p class="address">${dispacherStreetAddress}</p>
            // <p class="address">${receiverStreetAddress}</p>

            // <div class="bottom-sticky-note">


            /*<tr>
                                <td>Marchandise</td>
                                <td>Poids</td>
                                <td>Grandeur Camion</td>
                            </tr>*/


            // <td class="header-bold">N° CLIENT</td>
            //     <td class="header-bold">DIVERS</td>
            //     <td class="header-bold">PRIX</td>

            // <p class="company">${dispacherName}</p>
            // <p class="contact">${dispacherPhone}</p>
            const noteDiv = document.createElement('div');
            noteDiv.className = 'bottom-sticky-note-piled';
            noteDiv.draggable = true;
            noteDiv.dataset.id = note.id;

            if (note.status === 'tomorrow') {
                noteDiv.classList.add('status-tomorrow');
                var statusTranslated = 'Lendemain';
            }
            else if (note.status === 'same_day') {
                noteDiv.classList.add('status-today');
                var statusTranslated = 'Même Jour';

            }

            else if (note.status === 'urgent') {
                noteDiv.classList.add('status-urgent');
                var statusTranslated = 'urgent';
            }
            else if (note.status === 'very_urgent') {
                noteDiv.classList.add('status-tres_urgent');
                var statusTranslated = 'TRES urgent';
            }
            else if (note.status === 'code_red') {
                noteDiv.classList.add('status-code_red');
                var statusTranslated = 'RED CODE';
            }

            else if (note.status === 'special_night') {
                noteDiv.classList.add('status-special_night');
                var statusTranslated = 'SPECIAL NIGHT';
            }



            else {
                noteDiv.classList.add('status-default');
                var statusTranslated = 'Invalide';
            }

            // <span class="right-text">${dispacherPhone}</span>

            noteDiv.innerHTML = `

                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2">05-09-2024</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td >8:00</td>
                                    <td >${statusTranslated.toUpperCase()}</td>
                                    <td >08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td >${clientID}</td>
                                    <td >${waybill}</td>
                                    <td >560,00 $</td>
                                </tr>
                                <tr>
                                    <td >AUTRES</td>
                                    <td >POIDS</td>
                                    <td ></td>
                                </tr>

                                <tr>
                                    <td ></td>
                                    <td >TRUCK SIZE</td>
                                    <td ></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center"> ${dispacherPhone}</span>
                                    <span class="address-center" >${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text" >${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center">${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center"> ${receiverPhone}</span>
                                    <span class="address-center" >${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text">${receiverCityName.toUpperCase()}</span>
                                        <span class="right-text" >${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;


            // <strong>Additional Info:</strong> ${additionalInfo ? additionalInfo.value : 'N/A'}<br>
            // <strong>Recipient_Name:</strong> ${note.recipient_contact}<br></br>
            /*if (note.status === 'tomorrow') {
                noteDiv.classList.add('status-tomorrow');
                var statusTranslated = 'Demain';
            }
            else if (note.status === 'same_day')  {
                noteDiv.classList.add('status-today');
                var statusTranslated = 'aujourd’hui';

            }

            else if (note.status === 'urgent')  {
                noteDiv.classList.add('status-urgent');
                var statusTranslated = 'urgent';
            }

            else {
                noteDiv.classList.add('status-default');
                var statusTranslated = 'défaut';
            }*/


            // val new test start

            console.log("appending " + note.id + " to sticky notes container");
            // Otherwise, place it in the sticky notes container
            bottomStickyNotesContainer.appendChild(waybillDiv);
            waybillDiv.appendChild(noteDiv);

            // Add event listeners for drag and drop
            noteDiv.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                e.dataTransfer.effectAllowed = 'move';
                e.target.style.zIndex = 1000;
            });

            noteDiv.addEventListener('dragend', (e) => {
                e.target.style.zIndex = '';
            });



            // open in new tab the waybill
            /*noteDiv.addEventListener('contextmenu', (e) => {
                       e.preventDefault(); // Prevent the default context menu from appearing
                       const noteId = noteDiv.dataset.id;
                       const url = `https://app.courriersubitopresto.com/admin/waybills/${note.id}/edit?waybill=true/`; // Replace with your actual URL pattern
                       window.open(url, '_blank');
                   });*/
        });

        // const allNotePositions = getSavedPositions();

        /*for (const position of allNotePositions) {
            const noteDiv = document.querySelector(`.bottom-sticky-note[data-id="${position.noteId}"]`);
            console.log("inserting " + position.noteId + " in cell " + position.cellId );
            if (noteDiv) {
                insertNoteInCell(noteDiv, position.cellId);
            }
            else {
                console.log("special note", position.noteId);
                const specialNote = document.querySelector(`.${position.noteId}`);
                insertNoteInCell(specialNote, position.cellId, true);
            }
        }*/
        /*bottomStickyNotesContainer.addEventListener('click', (e) => {
        // Ensure the clicked element is a sticky note
        // alert("function called");
        showBottomPopUp(e);
        });*/
        const bottomPilledNotes = document.querySelectorAll('.bottom-sticky-note-piled');

        // Ensure bottomStickyNotesContainer is not empty
        // if (bottomStickyNotesContainer1.length > 0) {
            bottomPilledNotes.forEach(div => {
                // Add click event listener to each div

                div.addEventListener('click', function() {
                    // debug
                    // console.log(`Clicked on div with data-id: ${dataId}`);
                    // const innderDivData = document.querySelector(`div[data-id="${dataId}"]`);
                    // console.log(innderDivData);
                    const dataId = div.getAttribute('data-id');
                    showNewBottomPopUp(dataId);
                });
            });


    }

// Function to translate note status into a human-readable format
function translateStatus(status) {
    if (status === 'tomorrow') return 'Lendemain';
    if (status === 'same_day') return 'Même Jour';
    if (status === 'urgent') return 'Urgent';

    return 'Invalide';
}


    function fetchAndGenerateNotes() {
        Promise.all([fetchNotes(), fetchDriverData(), fetchAdditionalData()])
            .then(([notes, drivers, additionalData]) => {
                if (notes || drivers || additionalData) {
                    // generateTable(drivers);
                    console.dir(notes);
                    generateTopStickyNotes(notes, additionalData);
                    // generateBottomStickyNotes(notes, additionalData);

                }
                else {
                    console.log("fetch error");
                }
            });
    }
    /*function generateTable(drivers) {
        tableHeaderRow.innerHTML = '';
        tableBody.innerHTML = '';

        drivers.forEach((driver, index) => {
            const th = document.createElement('th');
            // th.textContent = `${driver.full_name}\n (${driver.phone})`;
            th.textContent = `${driver.full_name}\n(${driver.phone})`;
            th.classList.add('table-header');
            th.style.verticalAlign = 'top'; // Align text to the top
            tableHeaderRow.appendChild(th);
        });

        const rows = 5; // 5 rows in the table
        const columns = drivers.length;

        for (let i = 0; i < rows; i++) {
            const tr = document.createElement('tr');
            for (let j = 0; j < columns; j++) {
                const td = document.createElement('td');
                td.id = `cell${i * columns + j + 1}`;
                td.className = 'note-container';
                tr.appendChild(td);
            }
            tableBody.appendChild(tr);
        }
    }*/

    /*function addDragAndDropToCells() {
        const tableCells = document.querySelectorAll('.note-container');

        tableCells.forEach(cell => {
            cell.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.target.classList.add('drag-over');
            });

            cell.addEventListener('dragleave', (e) => {
                e.target.classList.remove('drag-over');
            });

            cell.addEventListener('drop', (e) => {
                e.preventDefault();
                e.target.classList.remove('drag-over');

                const noteId = e.dataTransfer.getData('text/plain');
                const note = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

                if (note) {
                    note.style.position = 'relative';
                    note.style.left = '0';
                    note.style.top = '0';
                    // note.style.width = '100%';
                    note.style.height = '100%';

                    e.target.innerHTML = ''; // Clear existing note in cell if any
                    e.target.appendChild(note);

                    saveNotePosition(noteId, e.target.id);
                }
            });
        });

        stickyNotesContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.target.classList.add('drag-over');
        });

        stickyNotesContainer.addEventListener('dragleave', (e) => {
            e.target.classList.remove('drag-over');
        });

        stickyNotesContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            e.target.classList.remove('drag-over');

            const noteId = e.dataTransfer.getData('text/plain');
            const note = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

            if (note) {
                note.style.position = 'relative';
                note.style.left = '0';
                note.style.top = '0';
                // note.style.width = '200px';
                // note.style.height = '200px';

                stickyNotesContainer.appendChild(note);
                removeNotePosition(noteId);
            }
        });
    }*/

    //  old functions test
    /*function saveNotePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        const rect = document.querySelector(`#${cellId}`).getBoundingClientRect();
        positions[noteId] = {
            cellId: cellId,
            top: rect.top,
            left: rect.left
        };
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }

    function getSavedPosition(noteId) {
        const positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        return positions[noteId] ? positions[noteId] : null;
    }

    function removeNotePosition(noteId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        delete positions[noteId];
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }*/


    // new functions test
    /*function saveNotePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        positions[noteId] = { cellId };
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }

    function getSavedPosition(noteId) {
        const positions = JSON.parse(localStorage.getItem('notePositions'));
        return positions ? positions[noteId] : null;
    }

    function removeNotePosition(noteId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        delete positions[noteId];
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }*/


    function addDragAndDropToCells() {
        console.log("dragAnddrop function runs!");
        const tableCells = document.querySelectorAll('.note-container');
        const cornerspeicalNote = document.querySelectorAll(".cornerSpecialNote") ;
        let cellId = 0;
        console.log(cornerspeicalNote);

        tableCells.forEach(cell => {
            cell.id = `cell${cellId++}`;
            console.log(cell.id);
            // cell.addEventListener('contextmenu', (e) => updateNoteCount(e));
            cell.addEventListener('click', (e) => showPopUp(e));
            cell.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.target.classList.add('drag-over');
                // showNoteCount(cell.id);
            });

            cell.addEventListener('dragleave', (e) => {
                e.target.classList.remove('drag-over');
                // showNoteCount(cell.id);
            });

            cell.addEventListener('drop', (e) => {
                e.preventDefault();
                e.target.classList.remove('drag-over');

                const noteId = e.dataTransfer.getData('text/plain');
                let note = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

                if (note) {
                    console.log(e.currentTarget.id);
                    insertNoteInCell(note, e.currentTarget.id);

                }
                /*else if(cornerspeicalNote){
                    insertNoteInCell(cornerspeicalNote, e.currentTarget.id);
                    // note = e.dataTransfer.getData('text/html');
                    // console.log(note);
                    // note = document.querySelector(`#${note}`);
                    // insertNoteInCell(note, e.currentTarget.id, true);
                }*/
                else{
                    note = e.dataTransfer.getData('text/html');
                    console.log(note);
                    note = document.querySelector(`#${note}`);
                    insertNoteInCell(note, e.currentTarget.id, true);
                }
                // updateNoteCount(e.currentTarget);
                // showNoteCount(cell.id);
            });
            console.log(cell);
            // showNoteCount(cell.id,cell);
            // showNoteCount(cell.id); // was active
            if(flag == 1){
            showAllNotes();
            }
            // updateAllNoteCounts();
            // showNewNoteCount()
        });

        stickyNotesContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.target.classList.add('drag-over');
        });

        stickyNotesContainer.addEventListener('dragleave', (e) => {
            e.target.classList.remove('drag-over');
        });

        stickyNotesContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            e.target.classList.remove('drag-over');

            const noteId = e.dataTransfer.getData('text/plain');
            const note = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

            if (note && e.target.id === stickyNotesContainer.id) {

                // newly turned off for val update

                /*note.style.position = 'relative';
                note.style.left = '0';
                note.style.top = '0';
                // note.style.width = '200px';
                // note.style.height = '200px';
                */
                stickyNotesContainer.appendChild(note);
                removeNotePosition(noteId);
            }

        });
    }

    /*function updateNoteCount(cell) {
    const noteCount = cell.querySelectorAll('.bottom-sticky-note').length;
    console.log(`Notes: ${noteCount}`);
    /*let countDisplay = cell.querySelector('.note-count');

    if (!countDisplay) {
        countDisplay = document.createElement('span');
        countDisplay.classList.add('note-count');
        cell.appendChild(countDisplay);
    }
    countDisplay.textContent = `Notes: ${noteCount}`;
}*/

function showAllNotes() {
    // Now, cellId is directly passed to the function
    for(i=0;i<=62;i++)
    {
        // if(i==1){
        //     continue;
        // }
    // console.log(`i: ${i}`);
    cellId = `cell${i}`
    // debug 01
    // console.log("Cell ID:", cellId);
    const stickyNotes = document.querySelectorAll(`#${cellId} .bottom-sticky-note`);
    // stickyNotes.forEach(note => note.style.display = 'none');

    // Get the count of sticky notes
    const noteCount = stickyNotes.length;
    // if(noteCount==0)
    // {
    //     break;
    // }
    // console.log(`Notes: ${noteCount}`);
    const cell = document.getElementById(cellId);
    // console.log(`show count cell details: ${cell}`);

    /*if (cell) {
    // Log the details of the cell
    console.log('Cell ID:', cell.id); // Logs the ID of the cell
    console.log('Cell Content:', cell.innerHTML); // Logs the content inside the cell
    console.log('Cell Class List:', cell.classList); // Logs any classes assigned to the cell
    console.log('Cell Attributes:', cell.attributes); // Logs all attributes of the cell
    console.log('Cell Outer HTML:', cell.outerHTML); // Logs the HTML code of the cell including its tag
} else {
    console.log(`No cell found with ID: ${cellId}`);
}*/
    // if(cellId == "cell1"||)
    /*if (cellId === "cell0" ||
    cellId === "cell1" ||
    cellId === "cell11" ||
    cellId === "cell12" ||
    cellId === "cell22" ||
    cellId === "cell23" ||
    cellId === "cell24" ||
    cellId === "cell34" ||
    cellId === "cell35" ||
    cellId === "cell36" ||
    cellId === "cell46" ||
    cellId === "cell47" ||
    cellId === "cell48" ||
    cellId === "cell58" ||
    cellId === "cell59" ||
    cellId === "cell60") */


    if(cellId)
    {
        // stickyNotes.forEach(note => note.style.display = 'none');
        let countDisplay = cell.querySelector('.count-bubble-number');
        // debug 02
        // console.log(`countDisplay: ${countDisplay}`);
        let waybillText = cell.querySelector('.waybill-text');
        if (!countDisplay) {
            // console.log("created!");
            countDisplay = document.createElement('div');
            countDisplay.classList.add('count-bubble-number');
            cell.appendChild(countDisplay);
        }

        if (!waybillText) {
            waybillText = document.createElement('div');
            waybillText.classList.add('waybill-text');
            cell.appendChild(waybillText);
        }







        /*countDisplay.textContent = `Notes: ${noteCount}`;*/
        // countDisplay.textContent = `Notes: ${noteCount}`;
        const noteCountElement = cell.querySelector('.count-bubble-number');
            if(noteCount ==0 ){
            // {   alert("here1!");
            // noteCountElement.classList.add('hidden');
            noteCountElement.textContent = `Waybills: ${noteCount}`;
            noteCountElement.style.display = '';
            noteCountElement.removeAttribute('id');
            noteCountElement.id = 'hidden';

            waybillText.textContent = "Waybills:";
            waybillText.style.display = '';
            waybillText.removeAttribute('id');
            waybillText.id = 'hidden';


                // noteCountElement.style.display = 'none';
            }
            else if(noteCount ==1 )
            {
                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybill";
                waybillText.style.display = 'block';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';
                // debug 03
                // console.log("text updated!");
            }
            else {
            // else (noteCountElement) {

                // cell text

                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybills";
                waybillText.style.display = 'block';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';
                // debug
                // console.log("text updated!");
            }
    }
}

}

function showNoteCount(cellId) {
    // Now, cellId is directly passed to the function
    console.log("Cell ID:", cellId);
    const stickyNotes = document.querySelectorAll(`#${cellId} .bottom-sticky-note`);
    // stickyNotes.forEach(note => note.style.display = 'none');

    // Get the count of sticky notes
    const noteCount = stickyNotes.length;
    // console.log(`Notes: ${noteCount}`);
    console.log(`lettre de transport ${noteCount}`);
    const cell = document.getElementById(cellId);

    /*if (cell) {
    // Log the details of the cell
    console.log('Cell ID:', cell.id); // Logs the ID of the cell
    console.log('Cell Content:', cell.innerHTML); // Logs the content inside the cell
    console.log('Cell Class List:', cell.classList); // Logs any classes assigned to the cell
    console.log('Cell Attributes:', cell.attributes); // Logs all attributes of the cell
    console.log('Cell Outer HTML:', cell.outerHTML); // Logs the HTML code of the cell including its tag
} else {
    console.log(`No cell found with ID: ${cellId}`);
}*/
    // if(cellId == "cell1"||)
    /*if (cellId === "cell0" ||
    cellId === "cell1" ||
    cellId === "cell11" ||
    cellId === "cell12" ||
    cellId === "cell22" ||
    cellId === "cell23" ||
    cellId === "cell24" ||
    cellId === "cell34" ||
    cellId === "cell35" ||
    cellId === "cell36" ||
    cellId === "cell46" ||
    cellId === "cell47" ||
    cellId === "cell48" ||
    cellId === "cell58" ||
    cellId === "cell59" ||
    cellId === "cell60") */
    /*if(cellId)
    {
        stickyNotes.forEach(note => note.style.display = 'none');
        let countDisplay = cell.querySelector('.note-count');
        if (!countDisplay) {
            countDisplay = document.createElement('div');
            countDisplay.classList.add('note-count');
            cell.appendChild(countDisplay);
        }
        // countDisplay.textContent = `Notes: ${noteCount}`;
        // countDisplay.textContent = `Notes: ${noteCount}`;
        const noteCountElement = cell.querySelector('.note-count');
        if(noteCount == 0)
        {
            noteCountElement.id = 'hidden';
        }
            // if (noteCountElement) {
            else{
                // Update the note count dynamically
                noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                console.log("text updated!");
            }
    }*/

    if(cellId)
    {
        // stickyNotes.forEach(note => note.style.display = 'none');
        let countDisplay = cell.querySelector('.count-bubble-number');
        console.log(`countDisplay: ${countDisplay}`);
        let waybillText = cell.querySelector('.waybill-text');
        if (!countDisplay) {
            // console.log("created!");
            countDisplay = document.createElement('div');
            countDisplay.classList.add('count-bubble-number');
            cell.appendChild(countDisplay);
        }

        if (!waybillText) {
            waybillText = document.createElement('div');
            waybillText.classList.add('waybill-text');
            cell.appendChild(waybillText);
        }







        /*countDisplay.textContent = `Notes: ${noteCount}`;*/
        // countDisplay.textContent = `Notes: ${noteCount}`;
        const noteCountElement = cell.querySelector('.count-bubble-number');
            if(noteCount ==0 ){
            // {   alert("here1!");
            // noteCountElement.classList.add('hidden');
            noteCountElement.textContent = `Waybills: ${noteCount}`;
            noteCountElement.style.display = '';
            noteCountElement.removeAttribute('id');
            noteCountElement.id = 'hidden';

            waybillText.textContent = "Waybills:";
            waybillText.style.display = '';
            waybillText.removeAttribute('id');
            waybillText.id = 'hidden';


                // noteCountElement.style.display = 'none';
            }
            else if(noteCount ==1 )
            {
                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybill";
                waybillText.style.display = 'block';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';

                console.log("text updated!");
            }
            else {
            // else (noteCountElement) {

                // cell text

                waybillText.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                waybillText.textContent = "Waybills";
                waybillText.style.display = 'block';

                // Update the note count dynamically
                noteCountElement.removeAttribute('id');
                // noteCountElement.textContent = `Waybills: ${noteCount}`;
                noteCountElement.textContent = `${noteCount}`;
                noteCountElement.style.display = 'block';
                // noteCountElement.textContent = `lettre de transport: ${noteCount}`;
                // element.style.display = 'none';

                console.log("text updated!");
            }
    }

}


    // stop for val function edit

    /*function insertNoteInCell(note, cellId, copy) {
        //we use data-id to identify the note, but id property is used to identify the cell

        const cell = document.querySelector(`#${cellId}`);
        const table = document.querySelector('#table-body');
        const tableRows = table.querySelectorAll(':scope > tr');

        const existingNote = cell.querySelector('.bottom-sticky-note');
        if (existingNote) {
            const firstRow = tableRows[0];
            const fourthRow = tableRows[3];
            if (cell.parentElement !== firstRow && cell.parentElement !== fourthRow && !cell.classList.contains('side-note')) {
                //we return any existing note to the sticky notes container
                stickyNotesContainer.appendChild(existingNote);
                removePosition(existingNote.dataset.id);
            }
            else {
                cell.classList.add('multiple-notes');
            }
        }
        else{
            cell.classList.remove('multiple-notes');
        }
        if (copy) {
            cell.appendChild(note.cloneNode(true));
        }
        else{
            cell.appendChild(note);
        }
        savePosition(note.dataset.id, cellId);
        showNoteCount(cellId);
    }*/

        /*function insertNoteInCell(element, cellId, copy=false) {
            console.log("insertnotecell function runs!");
            //we use data-id to identify the note, but id property is used to identify the cell
            console.log(typeof(cellId));
            const cell = document.querySelector(`#${cellId}`);
            const table = document.querySelector('#table-body');
            const tableRows = table.querySelectorAll(':scope > tr');

            const existingNote = cell.querySelector('.bottom-sticky-note');
            if (existingNote) {
                const firstRow = tableRows[0];
                const fourthRow = tableRows[3];
                if (cell.parentElement !== firstRow && cell.parentElement !== fourthRow && !cell.classList.contains('side-note')) {
                    //we return any existing note to the sticky notes container
                    stickyNotesContainer.appendChild(existingNote);
                    // removePosition(existingNote.dataset.id);
                    removeNotePosition(existingNote.dataset.id); //new test old one remove
                }
                else {
                    cell.classList.add('multiple-notes');
                }
            }
            else {
                cell.classList.remove('multiple-notes');
            }
        //     if (copy) {
        //     cell.appendChild(note.cloneNode(true));
        // }
            console.log(copy);
            if (copy==true) {
                // alert("here copy starts!");
                const clonedNote = element.cloneNode(true);
                //add a remove button to the cloned note
                const removeButton = document.createElement('button');
                removeButton.textContent = 'X';
                removeButton.className = 'btn-close-popup';
                removeButton.style.marginLeft = 'auto';
                removeButton.addEventListener('click', (e) => {
                    console.log("click detected!");
                    e.stopPropagation();
                    clonedNote.remove();
                    // removePosition(clonedNote.id);
                    removeNotePosition(clonedNote.id);
                });
                clonedNote.appendChild(removeButton);
                cell.appendChild(clonedNote);
                // alert("ends here!");
                // return;
            }
            else {
                cell.appendChild(element);
            }
            console.log(element.dataset.id);
            savePosition(element.dataset.id, cellId);
            // showNoteCount(cellId); // was active
            // showAllNotes();
            if(flag == 0){
                showAllNotes();
            }
            // showNewNoteCount();
        }*/


        // new insert

        function insertNoteInCell(element, cellId, copy = false) {
    console.log("insertnotecell function runs!");
    const cell = document.querySelector(`#${cellId}`);
    const table = document.querySelector('#table-body');
    const tableRows = table.querySelectorAll(':scope > tr');

    if (!cell) {
        console.error('Cell not found with id:', cellId);
        return;
    }

    const existingNote = cell.querySelector('.bottom-sticky-note');
    if (existingNote) {
        const firstRow = tableRows[0];
        const fourthRow = tableRows[3];
        if (cell.parentElement !== firstRow && cell.parentElement !== fourthRow && !cell.classList.contains('side-note')) {
            stickyNotesContainer.appendChild(existingNote);
            removeNotePosition(existingNote.dataset.id);
        } else {
            cell.classList.add('multiple-notes');
        }
    } else {
        cell.classList.remove('multiple-notes');
    }

    console.log(copy);
    if (copy === true) {
        const clonedNote = element.cloneNode(true);
        if (clonedNote instanceof Node) {
            const removeButton = document.createElement('button');
            removeButton.textContent = 'X';
            removeButton.className = 'btn-close-popup';
            removeButton.style.marginLeft = 'auto';
            removeButton.addEventListener('click', (e) => {
                console.log("click detected!");
                e.stopPropagation();
                clonedNote.remove();
                removeNotePosition(clonedNote.id);
            });
            clonedNote.appendChild(removeButton);
            cell.appendChild(clonedNote);
        } else {
            console.error('Cloned note is not a valid DOM node:', clonedNote);
        }
    } else {
        if (element instanceof Node) {
            cell.appendChild(element);
        } else {
            console.error('Element is not a valid DOM node:', element);
        }
    }

    console.log(element.dataset.id);
    savePosition(element.dataset.id, cellId);
    if (flag === 0) {
        showAllNotes();
    }
}


    // mine old function
    /*function removePosition(id) {
        console.log("removing position", id);
        const savedPositions = JSON.parse(localStorage.getItem('notePositions') || '{}');
        delete savedPositions[id];
        showNoteCount(cellId);
        localStorage.setItem('notePositions', JSON.stringify(savedPositions));
    }*/

    // new update of val function

    function removePosition(id) {
        console.log("removing position", id);
        const savedPositions = JSON.parse(localStorage.getItem('notePositions') || '[]');
        console.log(`saved positions: ${savedPositions}`)
        const positionIndex = savedPositions.findIndex(position => position.noteId === id);
        if (positionIndex !== -1) {
            savedPositions.splice(positionIndex, 1);
        }
        localStorage.setItem('notePositions', JSON.stringify(savedPositions));
    }



    // stopped for val function
    /*function savePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        positions[noteId] = { cellId };
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }*/

    /*function savePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || [];
        // [ {noteId, cellId} ]
        const existingPosition = positions.find(position => position.noteId === noteId);
        if (existingPosition && existingPosition.noteId != "absent" && existingPosition.noteId != "cheque") {
            existingPosition.cellId = cellId;
        }
        else {
            positions.push({ noteId, cellId });
        }
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }*/

    function savePosition(noteId, cellId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        positions[noteId] = { cellId };
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }

    function getSavedPosition(noteId) {
        const positions = JSON.parse(localStorage.getItem('notePositions'));
        return positions ? positions[noteId] : null;
        // showAllNotes();
    }

    function removeNotePosition(noteId) {
        let positions = JSON.parse(localStorage.getItem('notePositions')) || {};
        delete positions[noteId];
        localStorage.setItem('notePositions', JSON.stringify(positions));
    }

    /*function showPopUp(eventInitiator) {
        //we take into consideration event bubbling. we need the cell that holds the sticky notes
        let cellElement = eventInitiator.target;
        let cellId = cellElement.id;
        while (cellElement && !cellElement.classList.contains('note-container')) {
            cellElement = cellElement.parentElement;
        }
        if (cellElement && cellElement.classList.contains('note-container')) {
            cellId = cellElement.id;
            // Continue with your logic using cellId
        } else {
            console.log("No <td> element found in the parent chain.");
        }

        //check if the cell has no notes
        if (!cellElement.querySelector(`.bottom-sticky-note`)) {
            return;
        }

        const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';



        //get all the notes in the cell
        const notes = document.querySelectorAll(`#${cellId} .bottom-sticky-note`);
        console.log(`#${cellId}`);
        console.log(notes.length);
        console.log(notes);
        const popupBody = document.querySelector('.popup .body');
        popupBody.innerHTML = '';
        notes.forEach(note => {
            const clonedNode = note.cloneNode(true);
            clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        });
    }*/

    // semi done

    /*function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }
    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }


    const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';

    // const overlay = document.querySelector('.overlay');
    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        const clonedNote = note.cloneNode(true);
        clonedNote.style.display = 'block';

        // Add a close button to the note
        const closeButton = document.createElement('button');
        closeButton.textContent = 'X';
        closeButton.classList.add('note-close-button');
        closeButton.style.position = 'absolute';
        closeButton.style.top = '5px';
        closeButton.style.right = '5px';

        // Handle the close button click
        closeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);

            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            clonedNote.remove();
            showAllNotes();
        });

        clonedNote.appendChild(closeButton);
        popupBody.appendChild(clonedNote);

        // Make the note content editable
        const tableCells = clonedNote.querySelectorAll('td');
        tableCells.forEach(cell => {
            cell.contentEditable = true;
        });
    });

    // Show the popup overlay
    overlay.style.display = 'flex';
    }*/
                // old working stopped 28.11.24 12:30 am
    /*function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }

    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }

    const closePopupButton = document.querySelector('#btn-close-popup');
    const overlay = document.querySelector('.overlay');

    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    overlay.style.display = 'flex';

    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        console.log(note);
        const noteWrapper = document.createElement('div');
        noteWrapper.classList.add('note-wrapper');
        noteWrapper.style.position = 'relative';
        // noteWrapper.appendChild(note);
        const clonedNote = note.cloneNode(true);

        // remove a class
        clonedNote.classList.remove('minimized-note');

        clonedNote.style.display = 'block';

        // Add a remove button to the top-right corner
        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.classList.add('note-remove-button');

        // Handle the remove button click
        removeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`noteID from popup remove postion: ${noteId}`);
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
            removeNotePosition(noteId);
            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            noteWrapper.remove();
            showAllNotes();
        });

        // Append the button and the note to the wrapper
        noteWrapper.appendChild(removeButton);
        noteWrapper.appendChild(clonedNote);
        popupBody.appendChild(noteWrapper);

        clonedNote.addEventListener("contextmenu", function (event) {
            console.log(note);
            console.dir(note);
            // selectedStickyNote = note;

            console.log("popup click detected!");
            event.preventDefault();
            selectedStickyNote = note;
            console.log(selectedStickyNote);
            // Show and position context menu
            contextMenu.style.display = "block";
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        });
        // if (window.opener && window.opener.document) {
        //     alert("window opener!");
        document.getElementById("moveToLundi").addEventListener("click", function () {
        if (selectedStickyNote) {
            console.log("Moving sticky note to Lundi...");

            // Check if window.opener is available (main window)
            if (window.opener) {
                // Access the main window's #cell0 element
                const destinationCell = window.opener.document.querySelector("#cell0");
                if (destinationCell) {
                    console.log(`Moving sticky note to ${destinationCell}`);
                    // Move the selected sticky note to the target cell
                    destinationCell.appendChild(selectedStickyNote);
                    showAllNotes();
                    selectedStickyNote = null; // Clear selection after move
                } else {
                    console.error('Destination cell not found in the parent window.');
                }
            } else {
                console.error('window.opener is null. Ensure the popup is opened correctly.');
            }

            // Hide the context menu after moving
            contextMenu.style.display = "none"; // Hide context menu after move
        } else {
            console.log('No sticky note selected.');
        }
    });
        // Make the note content editable
        /*const tableCells = clonedNote.querySelectorAll('td');
        // tableCells.forEach(cell => {
        //     cell.contentEditable = true;
        // });
// }
    });

    // Show the popup overlay
    overlay.style.display = 'flex';
}*/


/*function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }

    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }

    const closePopupButton = document.querySelector('#btn-close-popup');
    const overlay = document.querySelector('.overlay');

    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    overlay.style.display = 'flex';

    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        console.log(note);
        const noteWrapper = document.createElement('div');
        noteWrapper.classList.add('note-wrapper');
        noteWrapper.style.position = 'relative';
        // noteWrapper.appendChild(note);
        const clonedNote = note.cloneNode(true);

        // remove a class
        clonedNote.classList.remove('minimized-note');

        clonedNote.style.display = 'block';

        // Add a remove button to the top-right corner
        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.classList.add('note-remove-button');

        // Handle the remove button click
        removeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`noteID from popup remove postion: ${noteId}`);
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
            removeNotePosition(noteId);
            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            noteWrapper.remove();
            showAllNotes();
        });




    function showNewBottomPopUp(dataId){

        const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';



        //get all the notes in the cell
        // const notes = document.querySelectorAll(`.bottom-sticky-note-piled`);
        // get only specific note
        // const element2 = document.querySelector('.bottom-sticky-note-piled');

// Get the value of the data-id attribute
        const note = document.querySelector(`div[data-id="${dataId}"]`);
        // const notes = event.target.getAttribute('data-info');
        // document.querySelector(`div[data-id="${dataId}"]`);

        console.log(note);
        // console.log(`#${cellId}`);
        // console.log(notes.length);
        // console.log(notes);
        const popupBody = document.querySelector('.popup .body');
        popupBody.innerHTML = '';

        const clonedNode = note.cloneNode(true);
            clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            // remove a class
        clonedNode.classList.remove('minimized-note');
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        /*notes.forEach(note => {
            const clonedNode = note.cloneNode(true);
            // clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        });

    }*/


    function showPopUp(eventInitiator) {
    let cellElement = eventInitiator.target;

    // Find the note container in the parent chain
    while (cellElement && !cellElement.classList.contains('note-container')) {
        cellElement = cellElement.parentElement;
    }

    if (!cellElement) {
        console.log("No note container found.");
        return;
    }

    // Check if the cell has no notes
    if (!cellElement.querySelector(`.bottom-sticky-note`)) {
        return;
    }

    const closePopupButton = document.querySelector('#btn-close-popup');
    const overlay = document.querySelector('.overlay');

    closePopupButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    overlay.style.display = 'flex';

    const popupBody = document.querySelector('.popup .body');

    // Clear the popup body
    popupBody.innerHTML = '';

    // Get all the sticky notes in the cell
    const notes = cellElement.querySelectorAll('.bottom-sticky-note');

    notes.forEach(note => {
        console.log(note);
        const noteWrapper = document.createElement('div');
        noteWrapper.classList.add('note-wrapper');
        noteWrapper.style.position = 'relative';
        // noteWrapper.appendChild(note);
        const clonedNote = note.cloneNode(true);

        // remove a class
        clonedNote.classList.remove('minimized-note');

        clonedNote.style.display = 'block';

        // Add a remove button to the top-right corner
        const removeButton = document.createElement('button');
        removeButton.textContent = '-';
        removeButton.classList.add('note-remove-button');

        // Handle the remove button click
        removeButton.addEventListener('click', () => {
            // Move the note back to the sticky notes container
            const noteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`noteID from popup remove postion: ${noteId}`);
            const originalNote = document.querySelector(`.bottom-sticky-note[data-id="${noteId}"]`);
            removeNotePosition(noteId);
            if (originalNote) {
                stickyNotesContainer.appendChild(originalNote);
            }

            // Remove the cloned note from the popup
            noteWrapper.remove();
            showAllNotes();
        });

        // Append the button and the note to the wrapper
        noteWrapper.appendChild(removeButton);
        noteWrapper.appendChild(clonedNote);
        popupBody.appendChild(noteWrapper);

        clonedNote.addEventListener("contextmenu", function (event) {
            console.log(`log for context: ${note}`);
            console.dir(`dir for context: ${note}`);

            const stcikyNoteId = clonedNote.dataset.id; // Ensure notes have a unique data-id
            console.log(`selected sticky noteID from popup: ${stcikyNoteId}`);
            const actualNote = document.querySelector(`.bottom-sticky-note[data-id="${stcikyNoteId}"]`);

            // selectedStickyNote = note;

            console.log("popup click detected!");
            event.preventDefault();
            selectedStickyNote = actualNote;
            console.dir(selectedStickyNote);
            // Show and position context menu
            contextMenu.style.display = "block";
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        });
        // if (window.opener && window.opener.document) {
        //     alert("window opener!");
        /*document.getElementById("moveToLundi").addEventListener("click", function () {
        console.log(selectedStickyNote);
        const destinationCell = document.querySelector("#cell1");
        console.log(`selected cellID from popup: ${destinationCell}`);
        // if (selectedStickyNote && mainTable) {
            // const cell0 = mainTable.rows[0].cells[0]; // Target cell 0
            destinationCell.appendChild(selectedStickyNote);
            // cell0.appendChild(selectedStickyNote); // Move sticky note to cell 0
            showAllNotes();
            selectedStickyNote = null; // Clear selection
        // }
        contextMenu.style.display = "none"; // Hide context menu after move
    });*/
    // });
        // Make the note content editable
        /*const tableCells = clonedNote.querySelectorAll('td');
        tableCells.forEach(cell => {
            cell.contentEditable = true;
        });*/
// }
    });

    // Show the popup overlay
    overlay.style.display = 'flex';
}

    function showBottomPopUp(eventInitiator) {
        //we take into consideration event bubbling. we need the cell that holds the sticky notes
        let bottomPopElement = eventInitiator.target;
        let cellElement = eventInitiator.target;




        const closePopupButton = document.querySelector('#btn-close-popup');
        const overlay = document.querySelector('.overlay');
        closePopupButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        overlay.style.display = 'flex';



        //get all the notes in the cell
        const notes = document.querySelectorAll(`.bottom-sticky-note-piled`);
        // console.log(`#${cellId}`);
        console.log(notes.length);
        console.log(notes);
        const popupBody = document.querySelector('.popup .body');
        popupBody.innerHTML = '';
        notes.forEach(note => {
            const clonedNode = note.cloneNode(true);
            // clonedNode.style.display = 'block';
            popupBody.appendChild(clonedNode);
            //make all the table cells in the note editable
            const tableCells = clonedNode.querySelectorAll('td');
            tableCells.forEach(cell => {
                cell.contentEditable = true;
            });
        });
    }

    // Prevent dropping within another sticky note
    document.addEventListener('dragover', (e) => {
        if (e.target.classList.contains('bottom-sticky-note')) {
            e.preventDefault();
        }
    });

    document.addEventListener('drop', (e) => {
        if (e.target.classList.contains('bottom-sticky-note')) {
            e.preventDefault();
        }
    });

    // prevent on special note

    document.addEventListener('dragover', (e) => {
        if (e.target.classList.contains('bottom-note-section')) {
            e.preventDefault();
        }
    });

    document.addEventListener('drop', (e) => {
        if (e.target.classList.contains('bottom-note-section')) {
            e.preventDefault();
        }
    });

    fetchAndGenerateNotes();

    const specialNotes = [];
    specialNotes.push( document.querySelector('#cheque'));
    specialNotes.push( document.querySelector('#absent'));

    for(const specialNote of specialNotes){
        specialNote.draggable = true;
        // specialNote.addEventListener('dragstart', dragStart);
        specialNote.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/html', e.target.id);
            e.dataTransfer.effectAllowed = 'move';
        });
        // break;
    }




    // commented for val function update
    /*document.querySelector('#btn-save-waybill').addEventListener('click', (e) => {
        const waybills = e.target.parentElement.parentElement.querySelectorAll('.bottom-sticky-note');
        waybills.forEach(waybill => {
            const noteId = waybill.dataset.id;
            console.log('waybill id: ' + noteId);
        });
    });
    */



    // fetchAndGenerateNotes();

    // generate context menu

// });




/*document.querySelectorAll('.bottom-note-table td').forEach(cell => {
    // Ensure each cell is detected
    console.log("Table cell detected", cell);

    // Enable editing on double-click
    cell.addEventListener('dblclick', function () {
        // Make the cell content editable when double-clicked
        this.setAttribute('contenteditable', 'true');
        this.focus();  // Automatically focus on the cell to start editing
    });

    // Save the data when the user finishes editing (on blur event)
    cell.addEventListener('blur', function () {
        const noteId = this.closest('.bottom-sticky-note').dataset.id;
        const newValue = this.innerText.trim();  // Get the edited value

        // Ensure the value is changed before sending it to the backend
        if (newValue !== this.dataset.originalValue) {
            saveEditedData(noteId, this.cellIndex, newValue);  // Send data to the backend
        }

        // After editing, remove contenteditable
        this.setAttribute('contenteditable', 'false');
    });

    // Store the original value when the cell is focused (before editing)
    cell.addEventListener('focus', function () {
        this.dataset.originalValue = this.innerText.trim();
    });
});*/

// Function to save the data to the server (Laravel backend)
/*function saveEditedData(noteId, columnIndex, newValue) {
    fetch('/update-sticky-note', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  // CSRF token
        },
        body: JSON.stringify({
            noteId: noteId,
            columnIndex: columnIndex,  // Send the column index or field ID
            newValue: newValue
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Data saved successfully:', data);
    })
    .catch(error => {
        console.error('Error saving data:', error);
    });
}*/


// working dblclick detection

/*const editableElements = document.querySelectorAll('.editable');
alert("I am here!");
document.body.addEventListener('click', function(event) {
        // Check if the clicked element is an editable element
        if (event.target.classList.contains('editable')) {
            console.log(`Clicked on element with content: ${event.target.textContent}`);
            alert("Clicked detected!");
        }
    });*/



// editableFields.addEventListener('dblclick', function () {
//             // Enable editing for the specific cell being double-clicked
//             this.contentEditable = true;
//             this.focus();
//         });

//         editableFields.addEventListener('keydown', function (event) {
//             if (event.key === 'Enter') {
//                 event.preventDefault(); // Prevent newline creation
//                 this.contentEditable = false; // Disable editing
//                 this.blur(); // Remove focus
//             }
//         });

//         editableFields.addEventListener('blur', function () {
//             // Disable editing when focus is lost
//             this.contentEditable = false;
//         });


/*document.body.addEventListener('dblclick', function (event) {
        // Check if the clicked element has the 'editable' class
        if (event.target.classList.contains('editable')) {
            const cell = event.target;

            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                }
            });

            // Save the data when the user finishes editing
            cell.addEventListener('blur', function () {
                const noteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                const newValue = this.innerText.trim(); // Get the edited value

                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    saveEditedData(noteId, this.cellIndex, newValue); // Custom function to handle saving
                }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });
        }
    });


// Function to handle saving edited data
function saveEditedData(noteId, cellIndex, newValue) {
    console.log(`Saving data for Note ID: ${noteId}, Cell Index: ${cellIndex}, New Value: ${newValue}`);

    // Example AJAX call to send the updated data to the backend
    fetch('/save-edited-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ noteId, cellIndex, newValue }),
    })
        .then(response => response.json())
        .then(data => {
            console.log('Data saved successfully:', data);
        })
        .catch(error => {
            console.error('Error saving data:', error);
        });
}*/




    document.body.addEventListener('dblclick', function (event) {
        // Check if the clicked element has the 'editable' class
        if (event.target.classList.contains('editable')) {
            // alert("detected!");
            const cell = event.target;

            const tableName = cell.dataset.table;    // "waybills"
            const columnName = cell.dataset.column;  // "user_id"
            const compValue = columnName.toLowerCase();

            // const recordId = cell.dataset.id;        // "12345"
            const dashboardCellId = cell.id;

            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                }
            });

            // Handle keydown event for saving on Enter
            cell.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent adding a new line in the contenteditable element
                    this.blur(); // Trigger the blur event to save the data
                }
            });

            // Save the data when the user finishes editing (blur or Enter)
            cell.addEventListener('blur', function () {
                const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                const newValue = this.innerText.trim(); // Get the edited value
                if(compValue == 'status')
                {
                    const translatedNewValue = statusConvertion(newValue);
                    if (newValue !== this.dataset.originalValue) {
                    saveEditedData(selectedNoteId, columnName , tableName,translatedNewValue,dashboardCellId); // Custom function to handle saving
                }
                }
                else{
                // const datacolumn = this.getAttribute('data-column')
                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    saveEditedData(selectedNoteId, columnName , tableName,newValue,dashboardCellId); // Custom function to handle saving
                }
            }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });
        }
    });

    // client editable

    document.body.addEventListener('dblclick', function (event) {
        // Check if the clicked element has the 'editable' class
        if (event.target.classList.contains('client-editable')) {
            // alert("detected!");
            const cell = event.target;

            const tableName = cell.dataset.table;    // "waybills"
            const columnName = cell.dataset.column;  // "user_id"
            // const recordId = cell.dataset.id;        // "12345"
            const dashboardCellId = cell.id;
            const selectedClientId = cell.dataset.id

            // Make the cell content editable
            cell.setAttribute('contenteditable', 'true');
            cell.focus(); // Automatically focus on the cell to start editing

            // Store the original value when the cell is focused
            cell.addEventListener('focus', function () {
                // if (!this.dataset.originalValue) {
                    this.dataset.originalValue = this.innerText.trim();
                    const oldValue = this.dataset.originalValue;
                    console.log(`original value: ${this.dataset.originalValue}`);
                    console.log(`old value: ${oldValue}`);
                // }
            });

            // Handle keydown event for saving on Enter
            cell.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent adding a new line in the contenteditable element
                    this.blur(); // Trigger the blur event to save the data
                }
            });

            // Save the data when the user finishes editing (blur or Enter)
            cell.addEventListener('blur', function () {
                const selectedNoteId = this.closest('.bottom-sticky-note').dataset.id; // Get the sticky note ID
                const newValue = this.innerText.trim(); // Get the edited value
                const intNewValue = +newValue;
                // const datacolumn = this.getAttribute('data-column')
                // Ensure the value is changed before sending it to the backend
                if (newValue !== this.dataset.originalValue) {
                    // saveEditedData(selectedNoteId, columnName , tableName,intNewValue,dashboardCellId,selectedClientId); // Custom function to handle saving
                    saveEditedData(selectedNoteId, columnName , tableName,newValue,dashboardCellId,selectedClientId); // Custom function to handle saving
                }

                // Remove contenteditable attribute after editing
                this.setAttribute('contenteditable', 'false');
                this.removeAttribute('data-original-value'); // Clean up temporary data
            });
        }
    });


// Function to handle saving edited data
function saveEditedData(selectedNoteId, columnName , tableName, newValue,dashboardCellId,selectedClientId=false) {
    console.log(`Saving data for Note ID: ${selectedNoteId}, data-Table: ${tableName},data-column: ${columnName}, New Value: ${newValue},dashboard Cell ID: ${dashboardCellId}`) ;
    console.log(typeof newValue);
    // Example AJAX call to send the updated data to the backend
    fetch('admin/update-sticky-note', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ selectedNoteId, columnName,tableName, newValue }),
    })
        .then(response => response.json())
        // .then(data => {
        //     console.log('Data saved successfully:', data);
        // })
        // .catch(error => {
        //     console.error('Error saving data:', error);
        // });

        .then(data => {
        if (data.success) {
            // showAllNotes();
            updateNoteDiv(selectedNoteId, columnName, newValue);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data updated successfully!',
                showConfirmButton: false, // No button
                timer: 1500, // Notification will disappear in 3 seconds
                timerProgressBar: true, // Show progress bar

            });


        } else {
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
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating data.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
}


// Update the note div with the new value on the front-end
function updateNoteDiv(noteId, columnName, newValue) {
    // Find the note div by its ID
    const noteDiv = document.querySelector(`[data-id="${noteId}"]`);

    if (noteDiv) {
        // Depending on the columnName, update the corresponding part of the note
        /*if (columnName === 'status') {
            const statusElement = noteDiv.querySelector('[data-column="status"]');
            if (statusElement) {
                statusElement.innerText = newValue;  // Update status
            }
        }*/
        if (columnName === 'user_id') {
            const userIdElement = noteDiv.querySelector('[data-column="user_id"]');
            if (userIdElement) {
                userIdElement.innerText = newValue;  // Update client ID
                // alert("updated!");
            }
        }

        else if (columnName === 'status') {
            const statusElement = noteDiv.querySelector('[data-column="status"]');
            // alert(`given new value: ${newValue}`);
            if (statusElement) {

                newValue = statusUpdate(newValue,noteDiv);
                // alert(`translated new value: ${newValue}`);
                statusElement.innerText = newValue.toUpperCase();  // Update status
                // alert(newValue);
                // statusUpdate(newValue,noteDiv);
                // alert("status updated!");
            }
        }


        // Add more conditions if there are other editable columns
        // For example:
        // else if (columnName === 'phone') { ... }
    }
}
function statusUpdate(value,statusElement)
{
    var temp;
    statusElement.classList.remove(
        'status-tomorrow', 'status-today', 'status-urgent', 'status-tres_urgent',
        'status-code_red', 'status-special_night', 'status-default'
    );

    if(value.toLowerCase() == "tomorrow")
    {
        statusElement.classList.add('status-tomorrow');
        temp = "Lendemain";
    }
    // else if(value.toLowerCase() == "même jour" || value.toLowerCase() == "meme jour")
    else if(value.toLowerCase() == "same_day")
    {
        statusElement.classList.add('status-today');
        temp = "Même JOUR";

    }

    else if(value.toLowerCase() == "urgent")
    {
        statusElement.classList.add('status-urgent');
        temp = "urgent";
    }

    else if(value.toLowerCase() == "very_urgent")
    {
        statusElement.classList.add('status-tres_urgent');
        temp = "TRES urgent";
    }

    else if(value.toLowerCase() == "code_red")
    {
        statusElement.classList.add('status-code_red');
        temp = "red code";

    }

    else if(value.toLowerCase() == "night")
    {
        statusElement.classList.add('status-special_night');
        temp = "special night";
    }
    // else {
    //     statusElement.classList.add('status-default');
    //         }
    return temp;

}

// Function to save data into Laravel
function saveData(cell) {
    const newValue = cell.textContent.trim(); // Get the edited value
    const datacolumn = cell.getAttribute('data-column'); // The column name (e.g., 'jour', 'heure', etc.)
    const dataIdCell = cell.getAttribute('data-id'); // The ID of the note (e.g., 22860)
    alert("here!");

    // Check if the value has changed before sending the request
    /*if (newValue !== cell.getAttribute('data-original-value')) {
        cell.setAttribute('data-original-value', newValue); // Update the original value attribute to prevent unnecessary AJAX requests

        // Prepare the data to be sent to the backend
        const data = {
            id: id,
            column: column,
            value: newValue
        };

        // Send the data to Laravel using fetch API
        fetch('/update-sticky-note', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for security
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                console.log('Data saved successfully.');
            } else {
                console.error('Error saving data');
            }
        })
        .catch(error => {
            console.error('Error saving data:', error);
        });
    }*/

}

function statusConvertion(givenStr) {
    var convetedStr;

    // Convert the input string to lowercase for case-insensitive comparison
    givenStr = givenStr.toLowerCase();

    if (givenStr === 'lendemain') {
        convetedStr = 'tomorrow';
    }
    // Uncomment and modify for other cases if needed
    /*else if (givenStr === 'same_day') {
        convetedStr = 'aujourd’hui'
    }*/

    else if (givenStr === 'même jour' || givenStr === 'meme jour') {
        convetedStr = 'same_day';
    }

    else if (givenStr === 'tres urgent') {
        convetedStr = 'very_urgent';
    }

    else if (givenStr === 'red code') {
        convetedStr = 'code_red';
    }
    else if (givenStr === 'special night') {
        convetedStr = 'night';
    }

    else if (givenStr === 'urgent') {
        convetedStr = 'urgent';
    }

    /*else {
        convetedStr = givenStr;
    }*/

    return convetedStr;
}

// self try note update
/*function updateStickyNotes(notes, additionalData) {
        flag = 0;
        // addDragAndDropToCells();
        const stickyNotesContainer = document.querySelector('.sticky-notes-container');
        const contextMenu = document.getElementById("contextMenu");
        const mainTable = document.querySelector("#main-table"); // Replace with your table's actual ID
        let selectedStickyNote = null;

    // Clear the existing notes
    stickyNotesContainer.innerHTML = '';

    const topNotes = notes.slice(0, 10);
    // addDragAndDropToCells();
        // var flag = 0;
            stickyNotesContainer.innerHTML = '';
        topNotes.forEach(note => {
            flag = 1;
            // const waybillDiv = document.createElement('div');
            // waybillDiv.className = 'waybill-container';

            // var dispacherId = note.recipient_id;


        const waybillDiv = document.createElement('div');
        waybillDiv.className = 'waybill-container';

        const noteDiv = document.createElement('div');
        noteDiv.className = 'bottom-sticky-note';
        noteDiv.draggable = true;
        noteDiv.dataset.id = note.id;

            var dispacherId = note.shipper_id;
            var description = note.description;
            var sortDescription = description.substring(0, 10);
            // var clientID = note.
            // console.log("dispacher ID(soft_ID): ")
            // console.log(additionalData[0]);
            const additionalInfo = additionalData.find(data => data.id === dispacherId); // Replace `key` with the actual key name
            console.log('additional Info: ');
            console.log(additionalInfo);
            // if(additionalData.find(data => data.id == dispacherId))
            // {
            var dispacherIndexNumber = additionalData.findIndex(data => data.id == dispacherId)
            var prefix = additionalData[dispacherIndexNumber].prefix;
            // console.log('prefix: ' +prefix);

            // soft_id is the number of waybill
            var waybillSoftId = note.soft_id;

            // user_id is the client identity number
            var clientID = note.user_id;


            // console.log('waybill: ' + waybill);

            var dispacherName = additionalData[dispacherIndexNumber].name;
            var dispacherPhone = additionalData[dispacherIndexNumber].phone;
            var dispacherPostalCode = additionalData[dispacherIndexNumber].postal_code;
            var dispacherStreetAddress = additionalData[dispacherIndexNumber].address;
            var dispacherCityName = additionalData[dispacherIndexNumber].city_name;

            // receiver details:

            var receiverID = note.recipient_id


            var receiverIndexNumber = additionalData.findIndex(data => data.id == receiverID)

            // var prefix = additionalData[receiverIndexNumber].prefix;
            var waybill = waybillCreation(waybillSoftId, 6, 0, prefix);
            var receiverName = additionalData[receiverIndexNumber].name;
            var receiverPhone = additionalData[receiverIndexNumber].phone;
            var receiverPostalCode = additionalData[receiverIndexNumber].postal_code;
            var receiverStreetAddress = additionalData[receiverIndexNumber].address;
            var receiverCityName = additionalData[receiverIndexNumber].city_name;

            var statusTranslated =  updateNoteStatus(note,noteDiv)
            // <span class="right-text">${dispacherPhone}</span>

            noteDiv.innerHTML = `

                <table class="bottom-note-table bottom-table">
                            <tbody>
                            <tr>
                                <th>JOUR</th>
                                <td colspan="2" contenteditable="true">05-09-2024</td>
                            </tr>
                                <tr>
                                    <th>HEURE</th>
                                    <th>SERVICE</th>
                                    <th>CHAUFFEUR</th>
                                </tr>
                                <tr>
                                    <td contenteditable="true">8:00</td>
                                    <td class="editable" data-table="waybills" data-column="status" data-id=${note.id}>${statusTranslated.toUpperCase()}</td>
                                    <td contenteditable="true">08</td>
                                </tr>
                                <tr>

                                    <th>N° CLIENT</th>
                                    <th>DIVERS</th>
                                    <th>PRIX</th>
                                </tr>
                                <tr>
                                    <td class="editable" data-table="waybills" data-column="user_id" data-id=${note.id}>${clientID}</td>

                                    <td contenteditable="true">${waybill}</td>
                                    <td contenteditable="true">560,00 $</td>
                                </tr>
                                <tr>
                                    <td contenteditable="true">AUTRES</td>
                                    <td contenteditable="true">POIDS</td>
                                    <td contenteditable="true"></td>
                                </tr>

                                <tr>
                                    <td contenteditable="true"></td>
                                    <td contenteditable="true">TRUCK SIZE</td>
                                    <td contenteditable="true"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="bottom-note-body">
                            <div class="bottom-from-to-section">
                                <div class="bottom-from-section">
                                    <div class="bottom-section-title">DE:</div>
                                    <div class="two-line">
                                    <span class="name-center" >${dispacherName.toUpperCase()}</span>
                                    <span class="phone-center client-editable" data-table="clients" data-column="phone" data-id=${dispacherId}> ${dispacherPhone}</span>
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${dispacherId}>${dispacherStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note" contenteditable="true">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${dispacherId}>${dispacherCityName.toUpperCase()}</span>
                                        <span class="right-text client-editable" data-table="clients" data-column="postal_code" data-id=${dispacherId}>${dispacherPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                                <div class="bottom-to-section">
                                    <div class="bottom-section-title">À:</div>
                                    <div class="two-line">
                                    <span class="name-center" contenteditable="true">${receiverName.toUpperCase()} </span>
                                    <span class= "phone-center client-editable" data-table="clients" data-column="phone" data-id=${receiverID}> ${receiverPhone}</span>
                                    <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${receiverID}>${receiverStreetAddress.toUpperCase()}</span>
                                    </div>
                                    <div class="bottom-note-section">
                            <p id="bottom-special-Note" contenteditable="true">${note.note || 'NOTES'}</p>
                        </div>

                                    <div class="corner-container">
                                        <span class="left-text client-editable" data-table="clients" data-column="city_name" data-id=${receiverID}>${receiverCityName.toUpperCase()}</span>
                                        <span class="right-text client-editable" data-table="clients" data-column="postal_code" data-id=${receiverID}>${receiverPostalCode.substring(0, 3)}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    `;


        // Add note to container
        // stickyNotesContainer.appendChild(noteDiv);

        const savedPosition = getSavedPosition(note.id);
            console.log(savedPosition);
            if (savedPosition) {
                insertNoteInCell(noteDiv, savedPosition.cellId);
            } else {
                // Otherwise, place it in the sticky notes container
                stickyNotesContainer.appendChild(noteDiv);
            }
    }*/

    // generated try

    /*function generateSingleStickyNote(note, additionalData) {
    const stickyNotesContainer = document.querySelector('.sticky-notes-container');
    const savedPosition = getSavedPosition(note.id);

    // Remove any existing sticky note with the same ID (if re-rendering is required)
    const existingNote = document.querySelector(`.bottom-sticky-note[data-id="${note.id}"]`);
    if (existingNote) {
        existingNote.remove();
    }

    // Generate sticky note
    const waybillDiv = document.createElement('div');
    waybillDiv.className = 'waybill-container';

    const noteDiv = document.createElement('div');
    noteDiv.className = 'bottom-sticky-note';
    noteDiv.draggable = true;
    noteDiv.dataset.id = note.id;

    // Extract additional data based on dispatcher ID
    const dispacherId = note.shipper_id;
    const additionalInfo = additionalData.find(data => data.id === dispacherId);

    if (!additionalInfo) {
        console.error(`No additional data found for dispatcher ID: ${dispacherId}`);
        return;
    }

    const prefix = additionalInfo.prefix;
    const waybillSoftId = note.soft_id;
    const clientID = note.user_id;
    const waybill = waybillCreation(waybillSoftId, 6, 0, prefix);

    // Populate note content
    noteDiv.innerHTML = `
        <table class="bottom-note-table bottom-table">
            <tbody>
                <tr>
                    <th>JOUR</th>
                    <td colspan="2" contenteditable="true">05-09-2024</td>
                </tr>
                <tr>
                    <th>HEURE</th>
                    <th>SERVICE</th>
                    <th>CHAUFFEUR</th>
                </tr>
                <tr>
                    <td contenteditable="true">8:00</td>
                    <td class="editable" data-table="waybills" data-column="status" data-id=${note.id}>
                        ${updateNoteStatus(note, noteDiv).toUpperCase()}
                    </td>
                    <td contenteditable="true">08</td>
                </tr>
                <tr>
                    <th>N° CLIENT</th>
                    <th>DIVERS</th>
                    <th>PRIX</th>
                </tr>
                <tr>
                    <td class="editable" data-table="waybills" data-column="user_id" data-id=${note.id}>${clientID}</td>
                    <td contenteditable="true">${waybill}</td>
                    <td contenteditable="true">560,00 $</td>
                </tr>
                <tr>
                    <td contenteditable="true">AUTRES</td>
                    <td contenteditable="true">POIDS</td>
                    <td contenteditable="true"></td>
                </tr>
                <tr>
                    <td contenteditable="true"></td>
                    <td contenteditable="true">TRUCK SIZE</td>
                    <td contenteditable="true"></td>
                </tr>
            </tbody>
        </table>
        <div class="bottom-note-body">
            <div class="bottom-from-to-section">
                <div class="bottom-from-section">
                    <div class="bottom-section-title">DE:</div>
                    <div class="two-line">
                        <span class="name-center">${additionalInfo.name.toUpperCase()}</span>
                        <span class="phone-center client-editable" data-table="clients" data-column="phone" data-id=${dispacherId}>
                            ${additionalInfo.phone}
                        </span>
                        <span class="address-center client-editable" data-table="clients" data-column="address" data-id=${dispacherId}>
                            ${additionalInfo.address.toUpperCase()}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Place the note based on the saved position or in the container
    if (savedPosition) {
        insertNoteInCell(noteDiv, savedPosition.cellId);
    } else {
        stickyNotesContainer.appendChild(noteDiv);
    }
}*/


});

</script>

@endpush
