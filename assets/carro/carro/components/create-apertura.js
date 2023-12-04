import axios from "axios";

import { createApertura } from "@/carro/requests";
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
        showLoader();
        const { data, error } = await createApertura({
            "carro_id": this.getCarroId(),
            "motivo": this.motivo,
            "before": {
                "medicamentos": this.$store["MED_DATA"],
                "dispositivos": this.$store["DIS_DATA"]
            }
        });
        hideLoader();

        if (error !== null) {
            errorAlert("Ha ocurrido un error al realizar la apertura.");
            return;
        }

        successAlert("Apertura creada.");

        /** Establecemos que el carro esta abierto **/
        this.carroStatus = true;
        this.motivo = "";

        /** Establecemos el id de la apertura global **/
        this.$store["APERTURA_ID"] = data.__id;
        window.closeDetail();
    },

    /**
     * Determina si se puede dar click en abrir carro.
    */
    get canOpenCarro() {
        return this.motivo !== "";
    }
});
