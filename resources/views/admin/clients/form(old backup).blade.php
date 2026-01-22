<div class="row">
    <div class="col-lg-6 col-sm-12">
        {!! Form::text('prefix', 'Prefix')->readonly($readonly) !!}
        {!! Form::text('name', 'Nom')->readonly($readonly) !!}
        {!! Form::text('phone', 'Téléphone')->type('phone')->readonly($readonly) !!}
        {!! Form::text('extension', 'Extension')->type('phone')->readonly($readonly) !!}
        {!! Form::text('address', 'Adresse ligne 1')->readonly($readonly) !!}
        {!! Form::select('city_id', 'Ville')->options($cities)->readonly($readonly) !!}
        {!! Form::text('postal_code', 'Code Postale')->readonly($readonly) !!}
        {!! Form::text('contact', 'Contact')->readonly($readonly) !!}
        {!! Form::textarea('note_permanent', 'Note permanente')->readonly($readonly) !!}
    </div>
</div>
