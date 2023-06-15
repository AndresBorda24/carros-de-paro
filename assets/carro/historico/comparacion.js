import axios from "axios";
import {hideLoader, showLoader} from "../../partials/loader";
import { errorAlert } from "../../partials/alerts";

export default () => ({
    changes: undefined,
    afterIds: [],
    events: {
        ['@fetch-changes.document']: "getChanges($event.detail)"
    },

    /**
     * Una vez seleccionados el historico a cargar se realiza la peticion al
     * backend
    */
    async getChanges( id ) {
        try {
            showLoader();

            const { data } = await axios.get(
                process.env.API + `/historico/${id}/get`
            ).finally(hideLoader);

            this.changes = data;
            if (data) {
                // Id de after
                this.afterIds = this.changes.after.map(el => el.id);
            }

        } catch(e) {
            console.log("Lista de Cambios: ", e);
            errorAlert("Error al obtener el historico.");
        }
    },

    /**
     * Devuelve el nombre del medicamento o del dispositivo dependiendo
     * del `model`
    */
    getItemNombre( item ) {
        return item[ "p_activo_concentracion" ] || item["desc"] || '';
    },

    /**
     * Determina si un elemento se elimino. Esto se usa para pintar de rojo
     * el elemento eliminado en `before`
    */
    isDeleted( id ) {
        return ! this.afterIds.includes( id );
    },
});
