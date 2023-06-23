import axios from "axios";
import { showLoader, hideLoader } from "../../../partials/loader";
import { errorAlert, successAlert } from "../../../partials/alerts";


export default () => ({
    motivo: "",
    el: undefined,
    grillasData: {
        med: undefined,
        disp: undefined
    },
    events: {
        ["@save-dispositivos-data.document"]: "saveData(false, $event.detail)",
        ["@save-medicamentos-data.document"]: "saveData(true, $event.detail)"
    },

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
     * Esta funcion resive la informacion de las grillas y la guarda en
     * `grillasData`
    */
    saveData(isMed, data) {
        if (isMed) {
            this.grillasData.med = data;
            return;
        }
        this.grillasData.disp = data;
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
        try {
            showLoader();
            await this.getGrillasData();
            const endpoint = process.env.API
                + "/carro/"
                + this.getCarroId()
                + "/save-apertura";

            const {data} = await axios.post(endpoint, {
                medicamentos: this.grillasData.med,
                dispositivos: this.grillasData.disp,
                motivo: this.motivo
            }).finally(hideLoader);

            this.motivo = "";
            this.carroStatus = false;
            this.$dispatch("carro-apertura-update");
            successAlert("Carro actualizado con exito!");
        } catch(e) {
            console.error(e);
            errorAlert();
        }
    },

    /**
     * Obtiene la informacion de las grillas.
    */
    async getGrillasData() {
        this.$dispatch("carro-apertura-save");

        return new Promise(res => {
            setTimeout(res, 100);
        });
    }
});
