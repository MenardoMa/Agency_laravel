import { sweetAlert } from "./sweetAlert.js";

export function deleteCategorie(e) {
    e.preventDefault();
    e.stopPropagation();

    let btn = $(this);
    let form = btn.closest("form");
    let id_categorie = btn.data("categorie");

    if (!id_categorie) {
        console.log("Une erreur est survenue");
        return false;
    }

    sweetAlert("Êtes-vous sûr ?", "Cette action est irréversible", function () {
        // AJAX;
        $.ajax({
            url: form.attr("action"),
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function (response) {
                if (response.status) {
                    // Remove tr
                    $("#row_" + id_categorie).remove();
                    Swal.fire({
                        title: "Supprimé !",
                        text: "La catégorie a été supprimée.",
                        icon: "success",
                    });
                }
            },

            error: function (xhr) {
                Swal.fire({
                    title: "Erreur",
                    text: "Impossible de supprimer.",
                    icon: "error",
                });
            },
        });
    });
}
