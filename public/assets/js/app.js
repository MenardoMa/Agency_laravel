import { sweetAlert } from "./sweetAlert.js";
import { deleteCategorie, editCategorie } from "./scripts.js";

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
            let formEl = $(form);
            let mode = formEl.attr("data-mode");

            let url = formEl.attr("action");
            let method = mode === "edit" ? "PUT" : "POST";

            let data = formEl.serialize();

            let btn_save = $("#btn_save");
            let originalText = btn_save.text();

            $.ajax({
                url: url,
                method: method,

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

                        if (mode === "edit") {
                            // UPDATE ligne existante
                            $("#row_" + categorie.id).replaceWith(`
                            <tr id="row_${categorie.id}">
                                <th>${categorie.id}</th>
                                <td>${categorie.name}</td>
                                <td>${categorie.description ?? ""}</td>
                                <td class="d-flex align-items-center ml-1">
                                    <a href="" class="btn btn-secondary btn-sm btn_edit" data-categorie="${categorie.id}">Edit</a>
                                    <form action="/admin/categorie/delete/${categorie.id}" method="POST" class="form_delete">
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn_delete"
                                                data-categorie="${categorie.id}">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                        } else {
                            //  CREATE
                            $("#table_body").prepend(`
                            <tr id="row_${categorie.id}">
                                <th>${categorie.id}</th>
                                <td>${categorie.name}</td>
                                <td>${categorie.description ?? ""}</td>
                                <td class="d-flex align-items-center ml-1">
                                    <a href="" class="btn btn-secondary btn-sm btn_edit" data-categorie="${categorie.id}">Edit</a>
                                    <form action="/admin/categorie/delete/${categorie.id}" method="POST" class="form_delete">
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn_delete"
                                                data-categorie="${categorie.id}">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                        }

                        $("#modal_categorie").modal("hide");

                        form.reset();
                        formEl.removeAttr("data-mode"); // reset mode

                        btn_save.text(originalText).prop("disabled", false);

                        Swal.fire({
                            title: "Succès",
                            text:
                                mode === "edit"
                                    ? "Catégorie mise à jour"
                                    : "Catégorie créée",
                            icon: "success",
                        });
                    }
                },

                error: function (xhr) {
                    let response = xhr.responseJSON;

                    let message = response?.errors
                        ? Object.values(response.errors)
                              .map((e) => e[0])
                              .join("<br>")
                        : response?.message || "Erreur";

                    Swal.fire({
                        title: "Erreur",
                        html: message,
                        icon: "error",
                    });

                    btn_save.text(originalText).prop("disabled", false);
                },
            });

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

    // BTN EDIT
    $(document).on("click", ".btn_edit", editCategorie);

    // BTN DELETE
    $(document).on("click", ".btn_delete", deleteCategorie);

    // BTN CLOSE
    $("#modal_categorie").on("hidden.bs.modal", function () {
        $("#form_categorie")[0].reset();
        $("#form_categorie").removeAttr("data-id");
    });
});
