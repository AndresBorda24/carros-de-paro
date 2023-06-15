import axios from "axios"
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

export default () => ({
    changes: undefined,
    afterIds: [],
    events: {
        '@fetch-changes.document': 'getChanges($event.detail)'
    },

    async getChanges( id ) {
        try {
            showLoader();

            const { data } = await axios.get(
                process.env.API + `/historico/${id}/get`
            ).finally(hideLoader);

            this.changes = data;
            this.afterIds = this.changes.after.map(el => el.id);
        } catch(e) {
            errorAlert();
            console.error("Fetch changes: ", e);
        }
    },


    /**
     * Devuelve el nombre del medicamento o del dispositivo dependiendo
     * del `model`
    */
    getItemNombre( item ) {
        const key = (this.model == 'Medicamento')
            ? "p_activo_concentracion"
            : "desc";

        return item[ key ];
    },

    /**
     * Determina si un elemento se elimino. Esto se usa para pintar de rojo
     * el elemento eliminado en `before`
    */
    isDeleted( id ) {
        return ! this.afterIds.includes( id );
    },
});
