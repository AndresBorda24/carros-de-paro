import { showLoader, hideLoader } from "../../../partials/loader";


export default () => ({
    motivo: "",
    el: undefined,

    init() {
        this.el = this.$el;
    },

    /**
     * Cambia el estado del carro a abierto. Antes de esto, el usuario es
     * obligado a seleccionar un motivo de apertura que se guarda en motivo.
    */
    open() {
        if (this.motivo === "") {
            alert("Debes seleccionar un motivo de apertura valido!");
            return;
        }

        showLoader();
        setTimeout(() => {
            hideLoader();
            this.carroStatus = true;
            closeDetail();
        }, 400);
    },

    /**
     * "Cierra" el carro SIN guardar cambios. Despacha un evento para revertir
     * los cambios en las grillas.
    */
    cancel() {
        if (! confirm("Realmente desea cancelar la apertura?")) {
            return;
        }

        showLoader();
        setTimeout(() => {
            hideLoader();
            closeDetail();
            this.motivo = "";
            this.carroStatus = false;
            this.$dispatch("carro-apertura-cancelada");
        }, 400);
    },

    /**
     * Determina si se puede abrir el carro o no
    */
    canOpenCarro() {
        return this.motivo === "";
    },

    /**
     * Una vez que los cambios a los medicamentos y a los dispositivos se han
     * realzado, se guardan los cambios.
    */
    async save() {
        // por implementar
    }
});
