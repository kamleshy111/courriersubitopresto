<div class="row">
    <div class="col-lg-6 col-sm-12">
        {!! Form::text('name', 'Nom')->readonly($readonly) !!}
        {!! Form::select('permissions', 'Permission', $permissions)->multiple()->readonly($readonly) !!}
    </div>
</div>

