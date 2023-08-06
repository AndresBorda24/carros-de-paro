import axios from "axios";
import Alpine from "alpinejs";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

/**
 * Se encarga de realizar la peticion al backend para crear un nuevo
 * medicamento.
*/
export async function createDispositivo(state) {
    try {
        showLoader();

        const {data} = await axios.post(
            process.env.API + "/dispositivos/create", {
            "apertura_id": Alpine.store("APERTURA_ID"),
            "data": getState( state )
        }).finally(hideLoader);

        state.id = data.__id;
        return state;
    } catch(e) {
        errorAlert("Ha ocurrido un error...");
        console.error("Dis create: ", e);
        return false;
    }
}

/**
 * Actualiza un dispositivo.
*/
export async function updateDispositivo(state) {
    try {
        showLoader();

        await axios.put(
            process.env.API + `/dispositivos/${state.id}/update`, {
            "apertura_id": Alpine.store("APERTURA_ID"),
            "data": state
        }).finally(hideLoader);

        return true;
    } catch(e) {
        errorAlert("Ha ocurrido un error...");
        console.error("Dis update: ", e);
        return false;
    }
}

/**
 * Elimina un dispositivo
*/
export async function deleteDispositivo(state) {
    try {
        showLoader();

        await axios.delete(
            process.env.API + `/dispositivos/${state.id}/delete`, {
                data: {
                    "apertura_id": Alpine.store("APERTURA_ID")
                }
            }).finally(hideLoader);

        return true;
    } catch(e) {
        errorAlert("Ha ocurrido un error...");
        console.error("Dis delete: ", e);
        return false;
    }
}

/**
* Establece la propiedad new para identificar en el historico que es un
* item nuevo
*/
function getState( state ) {
    state.new = 1;
    return state;
}
