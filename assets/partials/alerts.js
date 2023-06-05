import Noty from "noty";

const N = new Noty({
    layout: 'topRight',
    theme: 'mint',
    timeout: 2000,
    closeWith: ['click']
});

export function showAlert({ type = "alert", message = "Hey" }) {
    N.setType(type, true);
    N.setText(message, true);
    N.setTimeout(4500);
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
