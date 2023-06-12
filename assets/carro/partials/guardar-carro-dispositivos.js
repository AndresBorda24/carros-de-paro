import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    api: process.env.API,

    /** Realiza la consulta */
    async save() {
        try {
            showLoader();
            await axios.put(
                    this.api + `/dispositivos/${this.getCarroId()}/update-carro`,
                    this.getTableData()
                ).finally(hideLoader);

            // notificamos que se ha creado un carro de manera exitosa.
            this.$dispatch("carro-dispositivos-updated");
            successAlert("Dispositivos actualizados correctamente");
        } catch(e) {
            console.error("Guardar Carro Disp: ", e);
            errorAlert();
        }
    }
});
