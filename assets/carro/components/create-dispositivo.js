import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    show: false,
    state: {},
    api: process.env.API,
    events: {
        ['@create-dispositivo.document.stop']: "open",
        ['@edit-dispositivo.document.stop']: "openEdit",
        ['@dispositivo-deleted.document']: "close"
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    open({ detail: dispositivoId }) {
        this.show = true;
        this.state = {
            carro_id: dispositivoId
        };

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.desc"]')
                .focus();
        });
    },


    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    openEdit({ detail: dispositivo }) {
        this.show = true;
        this.state = JSON.parse(JSON.stringify(dispositivo));

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.desc"]')
                .focus();
        });
    },

    /** Cerramos el Modal. No se reinicia `state` ya que se hace en open */
    close() {
        this.show = false;
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

    /** Realiza la consulta */
    async save() {
        try {
            showLoader()
            const { data } = await axios
                .post(this.api + "/dispositivos/create", this.state)
                .finally(hideLoader);

            this.state.id = data.id;
            this.$dispatch("new-dispositivo-created", this.state);
            successAlert();
            this.close();
        } catch (e) {
            errorAlert();
        }
    },

    /**
     * Sip. Se parece mucho a `save` pero me pidieron que fuera rapido
     * asi que... Copy and Paste ...
    */
    async update() {
        try {
            showLoader()
            await axios.put(
                `${this.api}/dispositivos/${this.state.id}/update`,
                this.state
            ).finally(hideLoader);

            this.$dispatch("dispositivo-updated", this.state);
            successAlert();
            this.close();
        } catch (e) {
            errorAlert();
        }
    }
});
