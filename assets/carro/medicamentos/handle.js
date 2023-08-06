import axios from "axios";
import Alpine from "alpinejs";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

/**
 * Se encarga de realizar la peticion al backend para crear un nuebo
 * medicamento.
*/
export async function createMedicamento(state) {
    try {
        showLoader();

        const {data} = await axios.post(
            process.env.API + "/medicamentos/create", {
            "apertura_id": Alpine.store("APERTURA_ID"),
            "data": getState( state )
        }).finally(hideLoader);

        state.id = data.__id;
        return state;
    } catch(e) {
        errorAlert("Ha ocurrido un error...");
        console.error("Med create: ", e);
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
