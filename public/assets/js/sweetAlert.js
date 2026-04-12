/**
 *
 * Notification Alert
 *
 */
export function sweetAlert(title, text, onConfirm) {
    return Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimer",
        cancelButtonText: "Annuler",
        reverseButtons: true,
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Callback AJAX
            onConfirm();
        }
        return false;
    });
}
