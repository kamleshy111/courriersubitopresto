<div class="row">
    <div class="col-lg-6 col-sm-12">
        {!! Form::text('id', 'ID')->readonly($readonly) !!}
        {!! Form::text('name', 'Nom')->readonly($readonly) !!}
        {!! Form::text('email', 'Email')->type('email')->readonly($readonly) !!}
        {{-- {!! Form::text('phone', 'Phone')->type('phone')->readonly($readonly) !!} --}}
        {{-- {!! Form::text('address', 'Address')->type('address')->readonly($readonly) !!} --}}
         <!-- Phone and Address Fields (Initially Hidden) -->
         <div id="driver-fields" style="display: none;">
            {!! Form::text('phone', 'Phone')->type('phone')->readonly($readonly) !!}
            {!! Form::text('address', 'Address')->type('address')->readonly($readonly) !!}
        </div>
        {!! Form::text('password', 'Mot de passe')->type('password')->readonly($readonly) !!}
        {!! Form::text('password_confirmation', 'Mot de passe confirmation')->type('password')->readonly($readonly) !!}
        <!--{!! Form::select('roles', 'Rôles', $roles)->multiple()->readonly($readonly) !!}-->
        {!! Form::select('roles', __('translations.Roles'), $roles)->multiple()->readonly($readonly) !!}
        {!! Form::select('permissions', 'Permission', $permissions)->multiple()->readonly($readonly) !!}
        {!! Form::select('client_id', 'Client', $clients)->placeholder('Choisir un client')->readonly($readonly) !!}
    </div>
</div>
@push('js')

    <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script>
    $(document).ready(function() {
        // Handle changes to the permissions select box
        $('#inp-permissions').change(function() {
            // Get the selected permission(s)
            var selectedPermissions = $('#inp-permissions').val();

            // If permission with value '3' (Driver) is selected, show the phone and address fields
            if (selectedPermissions.includes('3')) {
                $('#driver-fields').show();
            } else {
                $('#driver-fields').hide();
            }
        });
    });
</script> --}}
{{--<script>
$(document).ready(function() {
    // Listen for changes on the roles select box
    $('#inp-roles').change(function() {
        // Check if 'Driver' (option value 3) is selected
        var selectedRoles = $('#inp-roles').val();

        // If 'Driver' is selected, show phone and address fields
        if (selectedRoles.includes('3')) {
            $('#driver-fields').show();
            console.log("driver selected!");
        } else {
            $('#driver-fields').hide();
        }
    });
});
</script>--}}

<script>
    $(document).ready(function() {
        // Listen for changes on the roles select box
        $('#inp-roles').change(function() {
            var selectedRoles = $('#inp-roles').val();

            // If 'Driver' (option value 3) is selected, show the phone and address fields
            if (selectedRoles.includes('3')) {
                $('#driver-fields').show();
                alert("Driver selected!");
            } else {
                $('#driver-fields').hide();
            }
        });

        // Check if the 'Driver' role is already selected when the page loads
        var selectedRoles = $('#inp-roles').val();
        if (selectedRoles.includes('3')) {
            $('#driver-fields').show();
        } else {
            $('#driver-fields').hide();
        }
    });
    </script>
@endpush
