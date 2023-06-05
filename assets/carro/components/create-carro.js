import axios from "axios";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    show: false,
    state: {},
    api: process.env.API + "/carros/create",
    events: {
        ['@create-carro.document.stop']: "open"
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    open() {
        this.show  = true;
        this.state = {};

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.nombre"]')
                .focus();
        });
    },

    /** Cerramos el Modal. No se reinicia `state` ya que se hace en open */
    close() {
        this.show = false;
    },

    /** Realiza la consulta */
    async save() {
        try {
            await axios.post(this.api, this.state);

            // notificamos que se ha creado un carro de manera exitosa.
            this.$dispatch("new-carro-created");
            successAlert();
            this.close();
        } catch(e) {
            errorAlert();
        }
    }
});
