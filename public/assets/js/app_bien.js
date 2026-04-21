import { sweetAlert, sweetAlertReturn, notify } from "./sweetAlert.js";

function formValidate() {
    $("#form_bien").validate({
        rules: {
            title: {
                required: true,
            },
            surface: {
                required: true,
                number: true,
            },
            prix: {
                required: true,
                number: true,
            },
            description: {
                required: true,
                minlength: 8,
            },
            nombre_pieces: {
                required: true,
                number: true,
                min: 1,
            },
            nombre_chambres: {
                required: true,
                number: true,
            },
            nombre_salles_bain: {
                required: true,
                number: true,
            },
            etage: {
                required: true,
                number: true,
            },
            adresse: {
                required: true,
                minlength: 4,
            },
            ville: {
                required: true,
                minlength: 2,
            },
            code_postal: {
                required: true,
                minlength: 4,
                maxlength: 8,
            },
            category_id: {
                required: true,
            },
            statut: {
                required: true,
            },
            type: {
                required: true,
            },
        },

        messages: {
            title: {
                required: "Le titre est obligatoire.",
            },
            surface: {
                required: "La surface est obligatoire.",
                number: "La surface doit être un nombre valide.",
            },
            prix: {
                required: "Le prix est obligatoire.",
                number: "Le prix doit être un nombre valide.",
            },
            description: {
                required: "La description est obligatoire.",
                minlength:
                    "La description doit contenir au moins 8 caractères.",
            },
            nombre_pieces: {
                required: "Le nombre de pièces est obligatoire.",
                number: "Le nombre de pièces doit être un nombre valide.",
                min: "Le nombre de pièces doit être au moins 1.",
            },
            nombre_chambres: {
                required: "Le nombre de chambres est obligatoire.",
                number: "Le nombre de chambres doit être un nombre valide.",
            },
            nombre_salles_bain: {
                required: "Le nombre de salles de bain est obligatoire.",
                number: "Le nombre de salles de bain doit être un nombre valide.",
            },
            etage: {
                required: "L’étage est obligatoire.",
                number: "L’étage doit être un nombre valide.",
            },
            adresse: {
                required: "L’adresse est obligatoire.",
                minlength: "L’adresse doit contenir au moins 4 caractères.",
            },
            ville: {
                required: "La ville est obligatoire.",
                minlength: "La ville doit contenir au moins 2 caractères.",
            },
            code_postal: {
                required: "Le code postal est obligatoire.",
                minlength:
                    "Le code postal doit contenir au moins 4 caractères.",
                maxlength: "Le code postal ne doit pas dépasser 8 caractères.",
            },
            category_id: {
                required: "Veuillez sélectionner une catégorie.",
            },
            status: {
                required: "Veuillez sélectionner un statut.",
            },
            type: {
                required: "Veuillez sélectionner un type.",
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
            error.insertAfter(element);
        },

        // submitHandler
        submitHandler: function (form) {
            let form_element = $(form);
            let data = new FormData(form);
            //AJAX STORE BIEN
            storeBien(form_element, data);
        },
    });
}

//AJAX STORE BIEN
function storeBien(form_element, data) {
    let method = "POST";
    let hiddenMethod = form_element.find('input[name="_method"]').val();

    if (hiddenMethod) {
        data.append("_method", hiddenMethod);
    }

    // AJAX
    $.ajax({
        url: form_element.attr("action"),
        method: method,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: data,
        contentType: false, // IMPORTANT
        processData: false, // IMPORTANT

        beforeSend: function () {
            $("#btn_save")
                .html(
                    '<span class="spinner-border spinner-border-sm"></span> Traitement ...',
                )
                .prop("disabled", true);
        },

        success: function (response) {
            if (response.status) {
                notify("success", response.message);
                setTimeout(() => {
                    window.location.href = "/admin/bien";
                }, 1000);
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                let message = "";

                Object.values(errors).forEach((err) => {
                    message += err + "\n";
                });

                $.each(errors, function (key, value) {
                    $("#" + key).addClass("is-invalid");
                });

                $("#btn_save")
                    .html("Sauvegarder les modifications")
                    .prop("disabled", false);

                sweetAlertReturn("Erreur de validation", message, "error");
            } else {
                sweetAlertReturn(
                    "Erreur",
                    "Une erreur serveur est survenue",
                    "error",
                );
            }
        },
    });
}

// AJAX DELETE BIEN
function deleteBien(e) {
    e.preventDefault();
    let bien_id = $(this).attr("data-option");

    if (!bien_id) {
        console.log("Une Erreur est survenue ...");
        return false;
    }

    // AJAX LOGIQUE
    sweetAlert(
        "Êtes-vous sûr ?",
        "Cette action est irréversible.",
        function () {
            // AJAX
            $.ajax({
                url: "bien/" + bien_id,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                success: function (response) {
                    if (response.status) {
                        notify("success", response.message);
                        $("#row_" + bien_id).remove();
                    }
                },
                error: function (xhr) {
                    notify("error", "Erreur lors de la suppression");
                },
            });
        },
    );
}

// AJAX DELETE IMAGE

function deleteImage(e) {
    e.preventDefault();

    let button = $(e.currentTarget);
    let id_image = button.data("id");

    if (!id_image) {
        Notyf("error", "Impossible de retirer cette image");
        return;
    }

    let imageItem = button.closest(".image-item");
    button.prop("disabled", true);

    $.ajax({
        url: "/admin/image/" + id_image,
        method: "POST",
        data: {
            _method: "DELETE",
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (response) {
            if (response.status) {
                notify("success", response.message);
                imageItem.fadeOut(200, function () {
                    $(this).remove();
                });
            } else {
                button.prop("disabled", false);
            }
        },

        error: function () {
            notify("error", "Impossible de retirer cette image");
            button.prop("disabled", false);
        },
    });
}

export function bienHandler() {
    // Form validation
    formValidate();
    // DELETE BIEN
    $(document).on("click", ".btn_delete_option", deleteBien);
    // DELETE IMAGE BIEN
    $(document).on("click", ".btn-delete-image", deleteImage);
}
