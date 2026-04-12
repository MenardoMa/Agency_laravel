import { sweetAlert } from "./sweetAlert.js";
import { deleteCategorie } from "./scripts.js";

function formValidate() {
    $("#form_categorie").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
            },
            description: {
                required: false,
                minlength: 8,
            },
        },
        messages: {
            name: {
                required: "Le nom est obligatoire",
                minlength: "Le nom doit contenir au moins 3 caractères",
            },
            description: {
                minlength: "La description doit contenir au moins 8 caractères",
            },
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
            if (element.parent(".input-group").length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },

        // SUBMIT
        submitHandler: function (form) {
            let data = $("form").serialize();
            let btn_save = $("#btn_save");
            let originalText = btn_save.text();
            // AJAX
            $.ajax({
                url: $(form).attr("action"),
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                data: data,
                beforeSend: function () {
                    btn_save
                        .html(
                            '<span class="spinner-border spinner-border-sm"></span> Traitement ...',
                        )
                        .prop("disabled", true);
                },
                success: function (response) {
                    // fermer modal
                    $("#modal_categorie").modal("hide");
                    // reset form
                    form.reset();
                    $(".form-control").removeClass("is-valid");
                    btn_save.text(originalText).prop("disabled", false);
                    Swal.fire({
                        title: "Crée",
                        text: "La catégorie a été supprimée.",
                        icon: "success",
                    });
                },
                error: function (xhr) {
                    // fermer modal
                    $("#modal_categorie").modal("hide");
                    // reset form
                    form.reset();
                    $(".form-control").removeClass("is-valid");
                    btn_save.text(originalText).prop("disabled", false);
                    Swal.fire({
                        title: "Erreur",
                        text: "Impossible de créér une categorie.",
                        icon: "error",
                    });
                },
            });
            // Prevent submit classique
            return false;
        },
    });
}

// Ready dom
$(document).ready(function () {
    // BTN CREATE CATEGORI
    $("#btn_over_modal").click(function (e) {
        e.preventDefault();
        $("#modal_categorie").modal("show");
    });
    // FORM VALIDATE
    formValidate();

    // BTN DELETE
    $(".btn_delete").on("click", deleteCategorie);
});
