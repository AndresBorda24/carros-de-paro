import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    show: false,
    state: {},
    api: process.env.API,
    __rowIndex: undefined,
    events: {
        ['@create-dispositivo.document.stop']: "open",
        ['@edit-dispositivo.document.stop']: "openEdit",
        ['@dispositivo-deleted.document']: "close"
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    open({ detail: dispositivoId }) {
        this.show = true;
        this.state = {
            carro_id: dispositivoId,
            vida_util: "N/A"
        };
        this.__rowIndex = undefined;

        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.desc"]')
                .focus();
        });
    },


    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    openEdit({ detail: data }) {
        this.show = true;
        this.__rowIndex = data.rowIndex;
        this.state = JSON.parse(JSON.stringify(data.dispositivo));

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
        if (Boolean(this.__rowIndex)) {
            await this.update()
            return;
        }

        await this.save();
    },

    /** Realiza la consulta */
    async save() {
        try {
            this.checkFechaVencimiento();

            this.state.id = (Math.random() + 3).toString(36).substring(3);
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
            this.checkFechaVencimiento();

            this.$dispatch("dispositivo-updated", {
                dispositivo: this.state,
                rowIndex: this.__rowIndex
            });
            successAlert();
            this.close();
        } catch (e) {
            errorAlert();
        }
    },

    /**
     * Revisa si se selecciono una fecha de vencimiento o no. Esto se hace
     * para evitar que quede guardada una fecha '0000-00-00'
    */
    checkFechaVencimiento() {
        if (! Boolean(this.state.vencimiento)) {
            this.state.vencimiento = null;
        }
    },

    /**
     * Determina si la modificacion es en base a un nuevo registro o es
     * una modificacion
    */
    isEdit() {
        return Boolean( parseInt(this.state.id) );
    }
});
