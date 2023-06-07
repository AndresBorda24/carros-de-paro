import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    show: false,
    state: {},
    api: process.env.API + "/medicamentos/create",
    events: {
        ['@create-medicamento.document.stop']: "open",
        ['@edit-medicamento.document.stop']: "openEdit",
        ['@medicamento-deleted.document']: "close"
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    open({ detail: carroId }) {
        this.show  = true;
        this.state = {
            carro_id: carroId
        };

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.p_activo_concentracion"]')
                .focus();
        });
    },


    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    openEdit({ detail: carro }) {
        this.show  = true;
        this.state = JSON.parse(JSON.stringify(carro));

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.p_activo_concentracion"]')
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
            showLoader()
            const { data } = await axios
                .post(this.api, this.state)
                .finally(() => hideLoader());

            this.state.id = data.id;
            this.$dispatch("new-medicamento-created", this.state);
            successAlert();
            this.close();
        } catch(e) {
            errorAlert();
        }
    }
});
