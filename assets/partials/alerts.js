import Noty from "noty";

export function showAlert({ type = "alert", message = "Hey", time = 2000 }) {
    const N = new Noty({
        type: type,
        text: message,
        layout: 'topRight',
        theme: 'mint',
        timeout: time,
        closeWith: ['click']
    });

    N.show();
}

export function errorAlert(message = "Ha ocurrido un error!", time = 2000) {
    showAlert({
        type: "error",
        message: message,
        time: time
    });
}

export function successAlert(message = "Hecho!", time = 2000) {
    showAlert({
        type: "success",
        message: message,
        time: time
    });
}
