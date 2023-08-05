import axios from "axios";
import { showLoader, hideLoader } from "../../../partials/loader";
import { errorAlert, successAlert } from "../../../partials/alerts";

/**
 * Registra una nueva apertura y actualiza.
*/
export default () => ({
    motivo: "",

    /**
     * Registra una nueva apertura en la base de datos.
    */
    async saveApertura() {
        try {
            showLoader();
            const {data} = await axios.post(process.env.API + "/aperturas/create", {
                "carro_id": this.getCarroId(),
                "motivo": this.motivo,
                "before": {
                    "medicamentos": this.$store["MED_DATA"],
                    "dispositivos": this.$store["DIS_DATA"]
                }
            }).finally(hideLoader);
            successAlert("Carro Abierto.");

            /** Establecemos que el carro esta abierto **/
            this.carroStatus = true;
            this.motivo = "";

            /** Establecemos el id de la apertura global **/
            this.$store["APERTURA_ID"] = data.__id;
            window.closeDetail();
        } catch(e) {
            errorAlert("Ha ocurrido un error al realizar la apertura.");
            console.error("Apertura: ", e);
        }
    },

    /**
     * Determina si se puede dar click en abrir carro.
    */
    get canOpenCarro() {
        return this.motivo !== "";
    }
});
