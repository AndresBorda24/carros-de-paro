import axios from "axios";
import { showLoader, hideLoader } from "../../../partials/loader";
import { errorAlert, successAlert } from "../../../partials/alerts";

// Guarda la modificacion de algun medicamento o dispositivo
export default ( model ) => ({
    api: process.env.API,
    model: model,
    motivo: "",
    el: undefined,

    init() {
        this.el = this.$el;
        this.setWatchers();
    },

    /** Realiza la consulta */
    async save() {
        try {
            if (! confirm("Realmente desea registrar esta revision?")) {
                return;
            }

            showLoader();
            await axios.put(this.getUrl(), {
                data: this.getTableData(),
                motivo: this.motivo
            }).finally(hideLoader);

            // notificamos que se ha creado un carro de manera exitosa.
            this.dispatchEvent();
            this.el.open = false; // Cerramos el details
            successAlert("Datos actualizados correctamente");
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

    getUrl() {
        const urls = {
            "Medicamento": `/medicamentos/${this.getCarroId()}/update-carro`,
            "Dispositivo": `/dispositivos/${this.getCarroId()}/update-carro`
        }

        return this.api + (urls[ this.model ] || '');
    },

    /**
     * Notifica cuando una actualizacion se realizo correctamente
    */
    dispatchEvent() {
        const events = {
            ["Medicamento"]: "carro-medicamentos-updated",
            ["Dispositivo"]: "carro-dispositivos-updated"
        }

        if (events[ this.model ]) {
            this.$dispatch( events[ this.model ] );
        }
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
