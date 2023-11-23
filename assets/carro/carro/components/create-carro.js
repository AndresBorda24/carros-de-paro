import { showLoader, hideLoader } from "@/partials/loader";
import { createCarro, updateCarro } from "@/carro/requests";
import { errorAlert, successAlert } from "@/partials/alerts";

export default () => ({
    show: false,
    state: {},
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
        showLoader();
        const { error } = (Boolean(this.state.id))
            ? await updateCarro(this.state.id, this.state)
            : await createCarro(this.state);
        hideLoader();

        if (error) return errorAlert();

        (Boolean(this.state.id))
            ? this.$dispatch("carro-updated", this.state)
            : this.$dispatch("new-carro-created");

        successAlert();
        this.close();
    },

    /** Cerramos el Modal. No se reinicia `state` ya que se hace en open */
    close() {
        this.show = false;
    },
});
