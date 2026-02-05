<div class="row">
    <div class="col-lg-6 col-sm-12">
        
        {{-- old working
        
        {!! Form::text('id', 'ID')->readonly(true) !!} --}}
        
        {!! Form::text('id', 'ID')
    ->readonly(!( auth()->check() && auth()->user()->hasRole('admin') && ($isCreate ?? false) )) !!}

        {{-- Editable fields for all users --}}
        {!! Form::text('name', 'Nom')->readonly($readonly) !!}
        {!! Form::text('email', 'Email')->type('email')->readonly($readonly) !!}

        {{-- Optional hidden section for driver fields --}}
        <div id="driver-fields" style="display: none;">
            {!! Form::text('phone', 'Phone')->type('phone')->readonly($readonly) !!}
            {!! Form::text('address', 'Address')->type('address')->readonly($readonly) !!}
        </div>

        {!! Form::text('password', 'Mot de passe')->type('password')->readonly($readonly) !!}
        @if(Auth::user()->hasRole('admin') === true)
            {!! Form::text('password_confirmation', 'Mot de passe confirmation')->type('password')->readonly($readonly) !!}
        @endif
        {{-- show only admin--}}
        @if(Auth::user()->hasRole('admin'))
            {!! Form::select('roles', 'Roles', $roles)->multiple()->readonly($readonly) !!}
            {!! Form::select('permissions', 'Permission', $permissions)->multiple()->readonly($readonly) !!}
            {!! Form::select('client_id', 'Client', $clients)->placeholder('Choisir un client')->readonly($readonly) !!}
        @endif
    </div>
</div>

@if(Auth::user()->hasRole('admin') === false)
    <button
        type="button"
        id="request-password-update"
        class="btn btn-warning mt-3"
        data-url="{{ route('admin.users.requestPasswordUpdate') }}"
    >
        Demander la mise a jour du mot de passe
    </button>
    
@endif

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let waybillLink = document.querySelector('#dynamic-waybill-link a');
        let waybillInprogress = document.querySelector('#dynamic-waybill-inprogress a');
        let waybillPickedup = document.querySelector('#dynamic-waybill-pickedup a');
        let waybillDelivered = document.querySelector('#dynamic-waybill-delivered a');
        @if(auth()->check() && auth()->user()->roles->contains('id', 3))
            if (waybillLink) waybillLink.href = "{{ url('admin/driver-summary-table/' . auth()->id()) }}";
            if (waybillInprogress) waybillInprogress.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}/in-progress";
            if (waybillPickedup) waybillPickedup.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}/pickedup";
            if (waybillDelivered) waybillDelivered.href = "{{ url('admin/driver-waybill/' . auth()->id()) }}/delivered";
        @endif
    });
</script>
@endpush





