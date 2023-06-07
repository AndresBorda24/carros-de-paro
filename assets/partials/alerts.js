import Noty from "noty";

export function showAlert({ type = "alert", message = "Hey" }) {
    const N = new Noty({
        type: type,
        text: message,
        layout: 'topRight',
        theme: 'mint',
        timeout: 2000,
        closeWith: ['click']
    });

    N.show();
}

export function errorAlert(message = "Ha ocurrido un error!") {
    showAlert({
        type: "error",
        message: message
    });
}

export function successAlert(message = "Hecho!") {
    showAlert({
        type: "success",
        message: message
    });
}
