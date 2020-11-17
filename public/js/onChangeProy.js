var $sport2 = $("#proyectos_tipos");

$(document).ready(function(){

    $sport2.change(function(){

        var $form2 = $(this).closest('form');

        // Simulate form data, but only include the selected sport value.
        var data2 = {};
        data2[$sport2.attr("name")] = $sport2.val();
        // Submit data via AJAX to the form's action path.

        $('#proyectos_tipo').attr('readonly', true);

        if ($sport2.val()=='Otro') {
            $.ajax({
                url: $form2.attr('action'),
                type: $form2.attr('method'),
                data: data2,
                success: function (html) {

                    $("#proyectos_tipo").replaceWith(
                        // ... with the returned one from the AJAX response.
                        $(html).find("#proyectos_tipo")

                        //$("select:first").replaceWith("Hello world!"
                    );

                    $('#proyectos_tipo').attr('readonly', false);

                    // Position field now displays the appropriate positions.

                }
            });
        }

    });


});