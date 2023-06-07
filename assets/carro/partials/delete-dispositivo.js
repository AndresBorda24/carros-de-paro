import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    api: process.env.API,

    /** Realiza la consulta */
    async delDisp() {
        try {
            if (! confirm("Realmente desea eliminar el registro?") ) {
                return;
            }

            showLoader()
            await axios.delete(
                `${this.api}/dispositivos/${this.state.id}/delete`
            ).finally(hideLoader);

            successAlert("Dispositivo Eliminado!");
            this.$dispatch("dispositivo-deleted", this.state.id);
        } catch(e) {
            console.error("Eliminar Dispositivo: ", e);
            errorAlert();
        }
    },

    /** Determina si se muestra el boton de eliminar o no */
    showButton() {
        return Boolean( this.state.id );
    }
});
