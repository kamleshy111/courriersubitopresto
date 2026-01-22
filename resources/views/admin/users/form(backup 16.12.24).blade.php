<div class="row">
    <div class="col-lg-6 col-sm-12">
        {!! Form::text('id', 'ID')->readonly($readonly) !!}
        {!! Form::text('name', 'Nom')->readonly($readonly) !!}
        {!! Form::text('email', 'Email')->type('email')->readonly($readonly) !!}
        {!! Form::text('password', 'Mot de passe')->type('password')->readonly($readonly) !!}
        {!! Form::text('password_confirmation', 'Mot de passe confirmation')->type('password')->readonly($readonly) !!}
        {!! Form::select('roles', 'Roles', $roles)->multiple()->readonly($readonly) !!}
        {!! Form::select('permissions', 'Permission', $permissions)->multiple()->readonly($readonly) !!}
        {!! Form::select('client_id', 'Client', $clients)->placeholder('Choisir un client')->readonly($readonly) !!}
    </div>
</div>
