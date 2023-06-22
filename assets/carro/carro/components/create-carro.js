import axios from "axios";
import { showLoader, hideLoader } from "../../../partials/loader";
import { errorAlert, successAlert } from "../../../partials/alerts";

export default () => ({
    show: false,
    state: {},
    api: process.env.API,
    events: {
        ['@create-carro.document.stop']: "open",
        ['@update-carro.document.stop']: "open"
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    open({ detail: carro }) {
        this.show  = true;
        this.state = Boolean(carro)
            ? JSON.parse(JSON.stringify(carro))
            : {};

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.nombre"]')
                .focus();
        });
    },

    /**
     * Determina si es una actualizacion o una insercion y luego ejecuta
     * la consulta.
    */
    async guardar() {
        if (Boolean(this.state.id)) {
            await this.update()
            return;
        }

        await this.save();
    },

    /** Cerramos el Modal. No se reinicia `state` ya que se hace en open */
    close() {
        this.show = false;
    },

    /** Realiza la consulta */
    async save() {
        try {
            showLoader();
            await axios
                .post(this.api + "/carros/create", this.state)
                .finally(hideLoader);

            // notificamos que se ha creado un carro de manera exitosa.
            this.$dispatch("new-carro-created");
            successAlert();
            this.close();
        } catch(e) {
            errorAlert();
        }
    },

    /** Realiza la consulta */
    async update() {
        try {
            showLoader();
            await axios.put(
                `${this.api}/carros/${this.state.id}/update`,
                this.state
            ).finally(hideLoader);

            this.$dispatch("carro-updated", this.state);
            successAlert();
            this.close();
        } catch(e) {
            errorAlert();
        }
    }
});
