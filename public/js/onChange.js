
var $sport = $("#estudiantes_programas");

$(document).ready(function(){

    $sport.change(function(){

        var $form = $(this).closest('form');

        // Simulate form data, but only include the selected sport value.
        var data = {};
        data[$sport.attr("name")] = $sport.val();
        // Submit data via AJAX to the form's action path.

        $('#estudiantes_programa').attr('readonly', true);

        if ($sport.val()=='Otro') {
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: data,
                success: function (html) {

                    $("#estudiantes_programa").replaceWith(
                        // ... with the returned one from the AJAX response.
                        $(html).find("#estudiantes_programa")

                        //$("select:first").replaceWith("Hello world!"
                    );

                    $('#estudiantes_programa').attr('readonly', false);

                    // Position field now displays the appropriate positions.
                }
            });
        }
    });
});