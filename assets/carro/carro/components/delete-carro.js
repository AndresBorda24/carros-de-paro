import axios from "axios";
import { showLoader, hideLoader } from "../../../partials/loader";
import { errorAlert, successAlert } from "../../../partials/alerts";

export default () => ({
    api: process.env.API,

    /** Realiza la consulta */
    async delCarro() {
        try {
            if (! confirm("Realmente desea eliminar el Carro?") ) {
                return;
            }

            showLoader();
            await axios.delete(
                `${this.api}/carros/${this.getCarroId()}/delete`
            ).finally(hideLoader);

            successAlert("Carro Eliminado!");
            this.$dispatch("carro-deleted", this.getCarroId());
        } catch(e) {
            console.error("Eliminar Carro: ", e);
            errorAlert();
        }
    },
});
