import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    api: process.env.API,

    /** Realiza la consulta */
    async delMed() {
        try {
            if (! confirm("Realmente desea eliminar el registro?") ) {
                return;
            }

            showLoader()
            await axios.delete(
                `${this.api}/medicamentos/${this.state.id}/delete`
            ).finally(hideLoader);

            successAlert("Medicamento Eliminado!");
            this.$dispatch("medicamento-deleted", this.state.id);
        } catch(e) {
            console.error("Eliminar Medicamento: ", e);
            errorAlert();
        }
    },

    /** Determina si se muestra el boton de eliminar o no */
    showButton() {
        return Boolean( this.state.id );
    }
});
