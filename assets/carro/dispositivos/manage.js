import { successAlert } from "../../partials/alerts";

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
    open({ detail: carroId }) {
        this.show = true;
        this.state = {
            carro_id: carroId,
            vida_util: "N/A"
        };
        this.__rowIndex = undefined;
        this.focus();
    },

    /** Abrimos el Modal Prinicpal y se 'reinicia' `state` */
    openEdit({ detail: data }) {
        this.show  = true;
        this.state = JSON.parse(JSON.stringify(data.dispositivo));
        this.__rowIndex = data.rowIndex;
        this.focus();
    },

    /** Cerramos el Modal. No se reinicia `state` ya que se hace en open */
    close() {
        this.show = false;
    },

    /**
     * Focus para el formulario
    */
    focus() {
        this.$nextTick(() => {
            document
                .querySelector('[x-model="state.desc"]')
                .focus();
        });
    },

    /**
     * Determina si es una actualizacion o una insercion y luego ejecuta
     * la consulta.
    */
    guardar() {
        (this.isEdit())
            ? this.update()
            : this.save();
    },

    /** Realiza la consulta */
    save() {
        this.checkFechaVencimiento();

        // Id temporal
        this.state.id = (Math.random() + 3).toString(36).substring(3);
        this.$dispatch("new-dispositivo-created", this.state);
        successAlert();
        this.close();
    },

    /**
     * Sip. Se parece mucho a `save` pero me pidieron que fuera rapido
     * asi que... Copy and Paste ...
    */
    update() {
        this.checkFechaVencimiento();

        this.$dispatch("dispositivo-updated", {
            dispositivo: this.state,
            rowIndex: this.__rowIndex
        });

        successAlert();
        this.close();
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
        return Boolean( parseInt(this.state.id) )
            || typeof this.__rowIndex !== 'undefined';
    }
});
