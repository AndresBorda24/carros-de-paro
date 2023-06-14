import axios from "axios";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

export default () => ({
    state: {},

    /**
     * Realiza la peticion al backend, retorna un listado con las fechas y
     * horas en las que se encuentren las coincidencias.
    */
    async fetchList() {
        try {
            showLoader();

            const { data } = await axios
                .get(process.env.API + "historico/buscar", {
                    params: this.state
                }).finally(hideLoader);

            this.dispatchResult( data );
        } catch(e) {
            errorAlert();
            console.error("Get Historico List: ", e);
        }
    },

    /**
     * Informa que se ha realizado la peticion y envia la info
    */
    dispatchResult( data ) {
        this.$dispatch("new-results-found", {
            data: data,
            _meta: this.state
        });
    }
})
