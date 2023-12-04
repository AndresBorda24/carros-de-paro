import { showLoader, hideLoader } from "@/partials/loader";
import { successAlert, errorAlert } from "@/partials/alerts";
import { createMedicamento, updateMedicamento } from "@/carro/requests";

/**
 * Este componente se encarga de crear (anexar) y modificar medicamentos.
 * NO reliza la peticion para guardarlo en la base de datos, solo se trabaja
 * con los datos de la grilla.
*/
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
        this.state = {
            carro_id: carroId
        };
        this.show = true;
        this.__rowIndex = undefined;
        this.focus();
    },

    /**
     * Se realiza una "Copia" del medicamento con JSON.parse y se establece
     * el index de la fila.
    */
    openEdit({ detail: data }) {
        this.show  = true;
        this.state = JSON.parse( JSON.stringify(data.medicamento) );
        this.__rowIndex = data.rowIndex;
        this.focus();
    },

    /** Cerramos el Modal. No se reinicia `state` ya que se hace en open */
    close() {
        this.show = false;
    },

    /**
     * Reliza el Focus al input del formulario
    */
    focus() {
        setTimeout(() => {
            document
                .querySelector('[x-model="state.p_activo_concentracion"]')
                .focus();
        }, 100);
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
    async save() {
        this.state.new = 1;
        showLoader()
        const { data, error } = await createMedicamento({
            "apertura_id": Alpine.store("APERTURA_ID"),
            "data": this.state
        });
        hideLoader();

        if (error !== null) return errorAlert();

        this.state.id = data.__id;
        this.$dispatch("new-medicamento-created", {... this.state });
        successAlert();
        this.close();
    },

    /**
     * Sip. Se parece mucho a `save` pero me pidieron que fuera rapido
     * asi que...
    */
    async update() {
        showLoader();
        const { error } = await updateMedicamento(this.state.id, {
            "apertura_id": Alpine.store("APERTURA_ID"),
            "data": this.state
        });
        hideLoader();

        if (error !== null) return errorAlert();

        this.$dispatch("medicamento-updated", {
            medicamento: this.state,
            rowIndex: this.__rowIndex
        });
        successAlert();
        this.close();
    },

    /**
     * Determina si la modificacion es en base a un nuevo registro o es
     * una modificacion
    */
    isEdit() {
        return typeof this.__rowIndex !== 'undefined';
    },

    /**
     * Determina si el registro ya ha sido creado y guardado en la base de
     * datos.
    */
    isCreated() {
        return Boolean( parseInt(this.state.id) );
    }
});
