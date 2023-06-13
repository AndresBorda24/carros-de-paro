import axios from "axios";
import {hideLoader, showLoader} from "../../partials/loader";
import { errorAlert } from "../../partials/alerts";

export default () => ({
    api: process.env.API,
    model: undefined,
    changes: undefined,
    changesList: {
        "medicamentos": [],
        "dispositivos": []
    },
    events: {
        ["@carro-dispositivos-updated.document"]: "getListOfChanges",
        ['@carro-medicamentos-updated.document']: "getListOfChanges"
    },

    init() {
        this.setWatchers();
    },

    /**
     * Obtiene la lista de cambios para un carro en especifico
    */
    async getListOfChanges() {
        try {
            const { data } = await axios
                .get(`${this.api}/historico/${this.getCarroId()}/list`);

            this.changesList = data;
        } catch(e) {
            console.log("Lista de Cambios: ", e);
        }
    },

    /**
     * Una vez seleccionados el historico a cargar se realiza la peticion al
     * backend
    */
    async getChanges( id ) {
        try {
            showLoader();

            // Limpiamos los selects
            document
                .querySelectorAll('[x-data="historico"] select')
                .forEach(el => el.value = "");

            const { data } = await axios.get(
                `${this.api}/historico/${id}/get`
            ).finally(hideLoader);

            this.changes = data;
        } catch(e) {
            console.log("Lista de Cambios: ", e);
            errorAlert("Error al obtener el historico.");
        }
    },

    /**
     * Obtiene el nombre del modelo dependiendo de `model`
    */
    getModel() {
        if (! this.model) {
            return "";
        }

        return this.model;
    },


    /**
     * Devuelve el nombre del medicamento o del dispositivo dependiendo
     * del `model`
    */
    getItemNombre( item ) {
        const key = (this.model == 'Medicamento')
            ? "p_activo_concentracion"
            : "desc";

        return item[ key ];
    },

    /**
     * Manejador para seleccion de cambio, guarda el modelo (medicamento o
     * dispositivo) y el ID del registro.
     *
     * @param model Tipo. 1 Medicamento 2 dispositivo
     * @param value Id del registro a buscar
    */
    async changeSelected(model, value) {
        this.model = model;
        await this.getChanges( value );
    },

    /**
     * Determina si el modelo es un medicamento
    */
    isMed() {
        return this.model === 'Medicamento';
    },

    /**
     * Determina si el modelo es un dispositivo
    */
    isDisp() {
        return this.model === 'Dispositivo';
    },

    /**
     * El componente debe rastrear ciertos cambios en el estado. Para eso
     * son los watchers
    */
    setWatchers() {
        /**
         * CARRO Almacena la info del carro. Esta en el componente Carro
        */
        this.$watch("CARRO", async () => {
            if (this.getCarroId() === null) {
                return;
            }

            await this.getListOfChanges();
        });
    }
});
