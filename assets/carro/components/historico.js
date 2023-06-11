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

        if (this.model == 1) {
            return "Medicamento";
        }

        if (this.model == 2) {
            return "Dispositivo";
        }

        return "";
    },


    /**
     * Devuelve el nombre del medicamento o del dispositivo dependiendo
     * del `model`
    */
    getItemNombre( item ) {
        const key = (this.model == 1)
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
