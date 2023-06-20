import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

// Guarda la modificacion de algun medicamento o dispositivo
export default ( model ) => ({
    api: process.env.API,
    model: model,
    motivo: "",

    init() {
        this.setWatchers();
    },

    /** Realiza la consulta */
    async save() {
        try {
            showLoader();
            await axios.put(
                this.api + `/dispositivos/${this.getCarroId()}/update-carro`,
                {
                    data: this.getTableData(),
                    motivo: this.motivo
                }
            ).finally(hideLoader);

            // notificamos que se ha creado un carro de manera exitosa.
            this.$dispatch("carro-dispositivos-updated");
            successAlert("Dispositivos actualizados correctamente");
        } catch(e) {
            console.error("Guardar Carro Disp: ", e);
            errorAlert();
        }
    },

    /**
     * Determina si se puede o no presionar el boton para guardar
    */
    cannotSave() {
        return this.motivo === "";
    },

    /**
     * Establece los watchers
    */
    setWatchers() {
        this.$watch("hasChanged", () => {
            this.motivo = "";
        });
    },

    /**
     * Listado de motivos dependiendo de si la grilla ha sido modificada o no
    */
    get motivos() {
        return this.hasChanged
            ? ["Cambio Realizado 1", "Cambio Realizado 2", "Cambio Realizado 3"]
            : ["Sin modificar"];
    }


});
