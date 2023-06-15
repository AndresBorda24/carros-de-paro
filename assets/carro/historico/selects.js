import axios from "axios";

export default () => ({
    model: undefined,
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
                .get( process.env.API + `/historico/${this.getCarroId()}/list`);

            this.changesList = data;
        } catch(e) {
            console.log("Lista de Cambios: ", e);
        }
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
        this.$dispatch("fetch-changes", value);

        // Limpiamos los selects
        document
            .querySelectorAll('[x-data="historicoSelect"] select')
            .forEach(el => el.value = "");
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
     * Obtiene el nombre del modelo dependiendo de `model`
    */
    getModel() {
        if (! this.model) {
            return "";
        }

        return this.model;
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
})
