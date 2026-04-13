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
                    if (response.status) {
                        let categorie = response.categorie;
                        let tr = `
                            <tr id="row_${categorie.id}">
                                <th>${categorie.id}</th>
                                <td>${categorie.name}</td>
                                <td>${categorie.description ?? ""}</td>
                                <td class="d-flex align-items-center ml-1">

                                    <a href="" class="btn btn-secondary btn-sm">Edit</a>

                                    <form action="/admin/categorie/delete/${categorie.id}"
                                        method="POST"
                                        class="form_delete">

                                        <button type="button"
                                                class="btn btn-danger btn-sm btn_delete"
                                                data-categorie="${categorie.id}">
                                            Supprimer
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        `;

                        $("#table_body").prepend(tr);

                        $("#modal_categorie").modal("hide");

                        form.reset();
                        $(".form-control").removeClass("is-valid");

                        btn_save.text(originalText).prop("disabled", false);

                        Swal.fire({
                            title: "Créé",
                            text: "La catégorie a été ajoutée avec succès.",
                            icon: "success",
                        });
                    }
                },

                error: function (xhr) {
                    let response = xhr.responseJSON;
                    let message = "Une erreur est survenue";

                    if (response?.message) {
                        message = response.message;
                    }

                    if (response?.errors?.slug) {
                        message = response.errors.slug[0];
                    }

                    Swal.fire({
                        title: "Erreur",
                        text: message,
                        icon: "error",
                    });

                    btn_save.text(originalText).prop("disabled", false);
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
    $(document).on("click", ".btn_delete", deleteCategorie);
});
