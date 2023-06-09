import axios from "axios";
import { showLoader, hideLoader } from "../../partials/loader";
import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    show: false,
    state: {},
    api: process.env.API,
    __rowIndex: undefined,
    events: {
        ['@create-medicamento.document.stop']: "open",
        ['@edit-medicamento.document.stop']: "openEdit",
        ['@medicamento-deleted.document']: "close"
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    open({ detail: carroId }) {
        this.show = true;
        this.state = {
            carro_id: carroId
        };
        this.__rowIndex = undefined;

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.p_activo_concentracion"]')
                .focus();
        });
    },


    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    openEdit({ detail: data }) {
        this.show  = true;
        this.state = JSON.parse( JSON.stringify(data.medicamento) );
        this.__rowIndex = data.rowIndex;

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

    /**
     * Determina si es una actualizacion o una insercion y luego ejecuta
     * la consulta.
    */
    async guardar() {
        if (Boolean(this.__rowIndex)) {
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
                .post(this.api + "/medicamentos/create", this.state)
                .finally(hideLoader);

            this.state.id = data.id;
            this.$dispatch("new-medicamento-created", this.state);
            successAlert();
            this.close();
        } catch (e) {
            errorAlert();
        }
    },

    /**
     * Sip. Se parece mucho a `save` pero me pidieron que fuera rapido
     * asi que...
    */
    async update() {
        try {
            this.$dispatch("medicamento-updated", {
                medicamento: this.state,
                rowIndex: this.__rowIndex
            });
            successAlert();
            this.close();
        } catch (e) {
            errorAlert();
        }
    }
});
