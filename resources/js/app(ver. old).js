/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$body = $('body');

$body.on('click', '.btn-delete', function (e) {
    e.preventDefault();
    if (confirm("Voulez-vous vraiment effectuée la suppression?")) {
        $.ajax({
            url: $(this).attr('href'),
            type: 'post',
            data: {_method: 'delete'},
            success: function (msg) {
                alert('Success');
                window.location = '';
            }
        });
    }
    return false;
});

function matchStart(params, data) {
    params.term = params.term || '';
    if(params.term.toLowerCase().indexOf("st-") === 0) {
        params.term = "Saint-" + params.term.substr(3);
    } else if(params.term.toLowerCase().indexOf("st") === 0) {
        params.term = "Saint" + params.term.substr(2);
    }

    if (data.text.toUpperCase().replace('SAINT-', '').indexOf(params.term.toUpperCase()) === 0
        || data.text.toUpperCase().indexOf(params.term.toUpperCase()) === 0) {
        return data;
    }
    return false;
}



if($body.hasClass('admin-clients-create') || $body.hasClass('admin-clients-edit')) {
    $("select").select2({
        theme: 'bootstrap4',
        matcher: matchStart
    });
}

if($body.hasClass('admin-waybills-create') || $body.hasClass('admin-waybills-edit')) {

    $("#add_waybills").on('click', function() {
        var next = parseInt($("#inp-counter").val())+1;
        $("#inp-counter").val(next);
        $.get(route("admin.waybills.form_helper", [next]), function(html) {
           $(html).insertAfter("#waybills-form hr:last");
            $("#remove_waybills").show();
            init_form(next, "shipper");
            init_form(next, "recipient");
        });
    });
    $("#remove_waybills").on('click', function() {
        if(!confirm("Attention toutes l'information contenu dans le dernier formulaire serait effacer"))
            return false;

        var next = parseInt($("#inp-counter").val())-1;
        if(next === 0) {
            $("#remove_waybills").hide();
        }
        $("#inp-counter").val(next);
        $("#waybills-form hr:last").prev().hide(1000, function() {
            $(this).remove();
        });
        $("#waybills-form hr:last").remove();
    });

    function fillClient(counter, who, item) {
        if($("#" + counter + "_" + who + " .is-invalid").length > 0) {
            $("#" + counter + "_" + who + " .is-invalid").removeClass('is-invalid');
            $("#" + counter + "_" + who + " .invalid-feedback").remove();
        }

        $("#inp-" + counter + "-" + who + "_id").val(item.id);
        $("#inp-" + counter + "-" + who + "-name").val(item.name).attr('readonly', true);
        $("#inp-" + counter + "-" + who + "-phone").val(item.phone).attr('readonly', true);
        $("#inp-" + counter + "-" + who + "-extension").val(item.extension).attr('readonly', true);
        $("#inp-" + counter + "-" + who + "-address").val(item.address).attr('readonly', true);
        $("select#inp-" + counter + "-" + who + "-city_id").val(item.city_id).attr('disabled', true).trigger('change');
        $("input#inp-" + counter + "-" + who + "-city_id").val(item.city_id);
        $("#inp-" + counter + "-" + who + "-postal_code").val(item.postal_code).attr('readonly', true);
        $("#inp-" + counter + "-" + who + "-contact").val(item.contact);
        $("#btn-" + counter + "-change-" + who + "").removeClass('d-none');
        
      if(who === 'recipient'){
        $("#inp-" + counter + "-note_permanent").val(item.note_permanent).attr('readonly', false);
       }
    }

    function init_form(counter, who) {
        $("#inp-" + counter + "-" + who + "-name" ).autocomplete({
            source: route("admin.clients.autocomplete"),
            minLength: 1,
            select: function( event, ui ) {
                fillClient(counter, who, ui.item);
            }
        }).attr('autocomplete', 'chrome-off');

        $("select#inp-" + counter + "-" + who + "-city_id").select2({
            theme: 'bootstrap4',
            matcher: matchStart
        });

        $("#btn-" + counter + "-change-" + who + "").on('click', function() {
            $("#inp-" + counter + "-" + who + "_id,#inp-" + counter + "-" + who + "-name,#inp-" + counter + "-" + who + "-phone,#inp-" + counter + "-" + who + "-extension,#inp-" + counter + "-" + who + "-address,#inp-" + counter + "-" + who + "-postal_code,#inp-" + counter + "-" + who + "-contact").val('').removeAttr('readonly');
            $("select#inp-" + counter + "-" + who + "-city_id").val('').removeAttr('disabled', false).trigger('change');
            $("input#inp-" + counter + "-" + who + "-city_id").val('');
            $("#btn-" + counter + "-change-" + who +",#badge-" + counter + "-new-" + who).addClass('d-none');
        });

        $("#inp-" + counter + "-" + who + "_id,#inp-" + counter + "-" + who + "-name,#inp-" + counter + "-" + who + "-phone,#inp-" + counter + "-" + who + "-address,#inp-" + counter + "-" + who + "-postal_code,#inp-" + counter + "-" + who + "-city_id").on('change', function () {
            if($("#inp-" + counter + "-" + who + "_id").val() === '' && $("#badge-" + counter + "-new-" + who + "").hasClass('d-none')) {
                $("#badge-" + counter + "-new-" + who + "").removeClass('d-none');
            }

            if($("#inp-" + counter + "-" + who + "_id").val() !== '' && !$("#badge-" + counter + "-new-" + who + "").hasClass('d-none')) {
                $("#badge-" + counter + "-new-" + who + "").addClass('d-none');
            }
        });

        $("#inp-" + counter + "-who_pay-shipper").on('click', function() {
            if($("#inp-" + counter + "-recipient_id").val() != '')
                $("#btn-" + counter + "-change-recipient").trigger('click');
            fillClient(counter, "shipper", window.laravel.default_client);
        });

        $("#inp-" + counter + "-who_pay-recipient").on('click', function() {
            if($("#inp-" + counter + "-shipper_id").val() != '')
                $("#btn-" + counter + "-change-shipper").trigger('click');
            fillClient(counter, "recipient", window.laravel.default_client);
        });

        $("#inp-" + counter + "-who_pay-other").on('click', function() {
            $("#btn-" + counter + "-change-shipper,#btn-" + counter + "-change-recipient").trigger('click');
        });

        $("#inp-" + counter + "-status-night,#inp-" + counter + "-status-code_red,#inp-" + counter + "-status-very_urgent,#inp-" + counter + "-status-urgent").on('click', function () {
            $("#alert-" + counter + "-status").show();
        })
        $("#inp-" + counter + "-status-same_day,#inp-" + counter + "-status-tomorrow").on('click', function() {
            $("#alert-" + counter + "-status").hide();
        })
    }

    for(i = 0; i <= parseInt($("#inp-counter").val()); i++) {
        init_form(i, "shipper");
        init_form(i, "recipient");
    }
}
