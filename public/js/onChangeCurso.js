
var $sport3 = $("#cursos_lugares");

$(document).ready(function(){

    $sport3.change(function(){

        var $form3 = $(this).closest('form');

        // Simulate form data, but only include the selected sport value.
        var data3 = {};
        data3[$sport3.attr("name")] = $sport3.val();
        // Submit data via AJAX to the form's action path.

        $('#cursos_lugar').attr('readonly', true);

        if ($sport3.val()=='Otro') {
            $.ajax({
                url: $form3.attr('action'),
                type: $form3.attr('method'),
                data: data3,
                success: function (html) {

                    $("#cursos_lugar").replaceWith(
                        // ... with the returned one from the AJAX response.
                        $(html).find("#cursos_lugar")

                        //$("select:first").replaceWith("Hello world!"
                    );

                    $('#cursos_lugar').attr('readonly', false);

                    // Position field now displays the appropriate positions.

                }
            });
        }

    });

});