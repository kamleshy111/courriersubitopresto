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
        {!! Form::text('password_confirmation', 'Mot de passe confirmation')->type('password')->readonly($readonly) !!}

        {{-- show only admin--}}
        @if(Auth::user()->hasRole('admin'))
            {!! Form::select('roles', 'Roles', $roles)->multiple()->readonly($readonly) !!}
            {!! Form::select('permissions', 'Permission', $permissions)->multiple()->readonly($readonly) !!}
            {!! Form::select('client_id', 'Client', $clients)->placeholder('Choisir un client')->readonly($readonly) !!}
        @endif
    </div>
</div>

@if(Auth::user()->hasRole('admin') === false)
    <button type="button" id="request-password-update" class="btn btn-warning mt-3">
        Demander la mise à jour du mot de passe
    </button>
@endif

<script>
document.getElementById('request-password-update')?.addEventListener('click', function () {

    if (!confirm('Envoyer une demande à l