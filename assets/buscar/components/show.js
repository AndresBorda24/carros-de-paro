import axios from "axios";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

/**
 * Este componente esta pensado para que sea un 'hijo' del componenete
 * "show-results" en la vista ~buscar-historico~. Es de ese
 * componente (he dicho mucho COMPONENTE) de donde sacamos la variable
 * historicoId.
*/
export default () => ({
    data: undefined,

    init() {
        this.$watch("historicoId", () => this.getData());
    },

    /**
     * Trae los datos de la apertura seleccionada.
    */
    async getData() {
        try {
            showLoader();
            const {data} = await axios.get(
                process.env.API
                + "/historico/"
                + this.historicoId
                + "/get"
            ).finally(hideLoader);

            this.data = data;
        } catch(e) {
            errorAlert();
            console.log("Get Historico: ", e);
        }
    },

    /**
     * Devuelve el nombre del item. Dado que Medicamentos y Dispositivos tienen
     * el valor del nombre en campos con diferentes nombres, es importante esta
     * funcion.
    */
    getItemName( item ) {
        return item["desc"] // Para Dispositivos
        || item["p_activo_concentracion"] // Para Medicamentos xD;
    },

    /**
     * Determina si el registro iterado en la tabla de resultados corresponde
     * a los criterios de la busqueda. Con esto podemos resaltar el resultado
     * preciso.
    */
    isTheOne( item ) {
        return item[this._meta.field] == this._meta.query;
    }
});
