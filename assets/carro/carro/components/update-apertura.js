import axios from "axios";
import { updateApertura } from "@/carro/requests";
import { showLoader, hideLoader } from "@/partials/loader";
import { errorAlert, successAlert } from "@/partials/alerts";

/**
 * Actualiza una nueva apertura y cierra el carro.
*/
export default () => ({
    message: "",

    /**
     * Registra una nueva apertura en la base de datos.
    */
    async update() {
        showLoader();
        const { data, error } = await updateApertura(
            this.$store["APERTURA_ID"], { "mensaje": this.message }
        );
        hideLoader();

        if (error !== null) {
            errorAlert("Ha ocurrido un error al guardar la apertura.");
            return;
        }
        successAlert("Apertura guardada.");

        /** Establecemos que el carro esta abierto **/
        this.carroStatus = false;
        this.message = "";

        this.$dispatch("carro-apertura-update");
    },

    get messageLength() {
        return this.message.length;
    }
});
