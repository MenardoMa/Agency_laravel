import { sweetAlert, sweetAlertReturn } from "./sweetAlert.js";

// INIT VALIDATION AND CREATE OPTION
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

            const mode = form_element.attr("data-mode");
            const url = form_element.attr("action");
            let method = null;

            if (mode === "edit") {
                method = "PUT";
            } else {
                method = "POST";
            }

            const data = form_element.serialize();
            const btn_save = $("#btn_save");
            const original_text = btn_save.text();

            // AJAX CREATE OPTION
            $.ajax({
                url: url,
                method: method,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
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
                        let option = response.option;
                        let action = `/admin/option/${option.id}`;
                        const messages =
                            mode === "edit"
                                ? "Option modifiée avec succès"
                                : "Option créée avec succès";

                        if (mode === "edit") {
                            // EDIT OPTION
                            $("#row_" + option.id).replaceWith(`
                            <tr id="row_${option.id}">
                                <th scope="row">${option.id}</th>
                                <td>${option.name}</td>
                                <td>${option.icon ?? "Pas d'icon"}</td>
                                <td class="text-end d-flex align-items-center">
                                    <button class="btn btn-secondary btn-sm btn-edit" data-option="${option.id}">Edit</button>
                                    <form action="${action}" method="POST" class="ml-2"
                                        id="form-delete">
                                        <button class="btn btn-danger btn-sm btn-delete" data-option="${option.id}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            `);
                        } else {
                            // CREATE OPTION
                            $("#table_body").prepend(`
                            <tr id="row_${option.id}">
                                <th scope="row">${option.id}</th>
                                <td>${option.name}</td>
                                <td>${option.icon ?? "Pas d'icon"}</td>
                                <td class="text-end d-flex align-items-center">
                                    <button class="btn btn-secondary btn-sm btn-edit" data-option="${option.id}">Edit</button>
                                    <form action="${action}" method="POST" class="ml-2"
                                        id="form-delete">
                                        <button class="btn btn-danger btn-sm btn-delete" data-option="${option.id}">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            `);
                        }

                        $("#modal-option").modal("hide");

                        form_element[0].reset();
                        form_element.removeAttr("data-mode");
                        $(".form-control").removeClass("is-valid is-invalid");
                        btn_save.text(original_text).prop("disabled", false);

                        sweetAlertReturn("Succès", messages);
                    }
                },
                error: function (xhr) {
                    sweetAlertReturn(
                        "Erreur",
                        "Impossible de créér une option.",
                        "error",
                    );
                },
            });
        },
    });
}

// EDIT OPTION
function editOption(e) {
    e.preventDefault();
    let option_id = $(this).attr("data-option");

    if (!option_id) {
        sweetAlertReturn(
            "Erreur",
            "Impossible de modifier cette option.",
            "error",
        );
        return false;
    }

    // AJAX
    $.ajax({
        url: `option/${option_id}`,
        method: "GET",
        success: function (response) {
            if (response.status) {
                let option = response.option;

                $("#name").val(option.name);
                // définir mode UPDATE
                $("#form-option").attr("action", `/admin/option/${option.id}`);
                $("#form-option").attr("data-mode", "edit");
                // modal
                $("#modal-option").modal("show");
            }
        },
        error: function (xhr) {
            sweetAlertReturn(
                "Erreur",
                "Impossible de recuperer cette option.",
                "error",
            );
        },
    });
}

// DELETE OPTION
function deleteOption(e) {
    e.preventDefault();
    let option_id = $(this).attr("data-option");
    let form_delete = $("#form-delete");
    let data = null;

    if (!option_id) {
        sweetAlertReturn("Erreur", "Impossible de supprimer.", "error");
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
                        $("#row_" + option_id).remove();
                        sweetAlertReturn(
                            "Succès",
                            "L'élément a bien été supprimé.",
                        );
                    }
                },
                error: function (xhr) {
                    sweetAlertReturn(
                        "Erreur",
                        "Impossible de supprimer.",
                        "error",
                    );
                },
            });
        },
    );
}

// HANDLER
export function optionHandler() {
    $(document).on("click", "#btn-create-option", function (e) {
        e.preventDefault();
        $("#modal-option").modal("show");
    });
    // FORM VALIDATE
    initValidation();

    // BTN EDIT
    $(document).on("click", ".btn-edit", editOption);

    // BTN DELETE
    $(document).on("click", ".btn-delete", deleteOption);

    // CLOSE MODAL
    $("#modal-option").on("hidden.bs.modal", function () {
        $("#form-option")[0].reset();
        $("#form-option")
            .attr("action", `/admin/option`)
            .removeAttr("data-mode");
        $(".form-control").removeClass("is-valid is-invalid");
    });
}
