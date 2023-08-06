import axios from "axios";
import { showLoader, hideLoader } from "../../../partials/loader";
import { errorAlert, successAlert } from "../../../partials/alerts";

/**
 * Actualiza una nueva apertura y cierra el carro.
*/
export default () => ({
    message: "",

    /**
     * Registra una nueva apertura en la base de datos.
    */
    async update() {
        try {
            showLoader();
            await axios.put(
                process.env.API +
                `/aperturas/${this.$store["APERTURA_ID"]}/update`, {
                "mensaje": this.message,
            }).finally(hideLoader);
            successAlert("Apertura guardada.");

            /** Establecemos que el carro esta abierto **/
            this.carroStatus = false;
            this.message = "";

            this.$dispatch("carro-apertura-update");
        } catch(e) {
            errorAlert("Ha ocurrido un error al guardar la apertura.");
            console.error("Apertura: ", e);
        }
    },

    get messageLength() {
        return this.message.length;
    }
});