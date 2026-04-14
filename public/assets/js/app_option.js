import { sweetAlert } from "./sweetAlert.js";

export function optionHandler() {
    $(document).on("click", "#btn-create-option", function (e) {
        e.preventDefault();
        $("#modal-option").modal("show");
    });
    // FORM VALIDATE
    initValidation();

    // BTN DELETE
    $(document).on("click", ".btn-delete", deleteOption);

    // CLOSE MODAL
    $("#modal-option").on("hidden.bs.modal", function () {
        $("#form-option")[0].reset();
        $(".form-control").removeClass("is-valid is-invalid");
    });
}

function initValidation() {
    $("#form-option").validate({
        rules: {
            name: {
                required: true,
            },
        },

        messages: {
            name: "Le nom est obligatoire",
        },

        errorElement: "div",
        errorClass: "invalid-feedback",

        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },

        unhighlight: function (element) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        // SUBMIT
        submitHandler: function (form) {
            const form_element = $(form);
            const data = form_element.serialize();
            const btn_save = $("#btn_save");
            const original_text = btn_save.text();

            // AJAX
            $.ajax({
                url: form_element.attr("action"),
                method: "POST",
                // headers: {
                //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                //         "content",
                //     ),
                // },
                beforeSend: function () {
                    btn_save
                        .html(
                            '<span class="spinner-border spinner-border-sm"></span> Traitement ...',
                        )
                        .prop("disabled", true);
                },
                data: data,
                success: function (response) {
                    if (response.status) {
                        $("#modal-option").modal("hide");

                        form_element[0].reset();
                        $(".form-control").removeClass("is-valid is-invalid");
                        btn_save.text(original_text).prop("disabled", false);

                        Swal.fire({
                            title: "Succès",
                            text: "Catégorie créée",
                            icon: "success",
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
            });
        },
    });
}

// OPTION DELETE

function deleteOption(e) {
    e.preventDefault();
    let option_id = $(this).attr("data-option");
    let form_delete = $("#form-delete");
    let data = null;

    if (!option_id) {
        console.log("Erreur id");
        return false;
    }

    data = option_id;

    sweetAlert(
        "Êtes-vous sûr ?",
        "Cette action est irréversible.",
        function () {
            // AJAX
            $.ajax({
                url: form_delete.attr("action"),
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                data: data,
                success: function (response) {
                    if (response.status) {
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                },
            });
        },
    );
}
