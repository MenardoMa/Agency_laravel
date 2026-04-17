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

export function sweetAlertReturn(title, text, icon = "success") {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
    });
}

const notyf = new Notyf({
    duration: 2000,
    position: {
        x: "right",
        y: "top",
    },
});

const ALLOWED_TYPES = ["success", "error", "warning", "info"];

export function notify(type, message) {
    if (ALLOWED_TYPES.includes(type)) {
        notyf[type](message);
    } else {
        notyf.success(message);
    }
}
