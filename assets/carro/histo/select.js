import axios from "axios";

export default () => ({
    aperturas: [],
    events: {
        ["@carro-apertura-update.document"]: "getAperturas"
    },

    init() {
        this.setWatchers();
    },

    /**
     * Obtiene todas las aperturas registradas para el carro seleccionado
     * actualmente.
    */
    async getAperturas() {
        try {
            const {data} = await axios.get(
                process.env.API
                + "/carros/"
                + this.getCarroId()
                + "/get-aperturas"
            );

            this.aperturas = data;
        } catch(e) {
            console.error("Histo: ", e);
        }
    },

    /**
     * Cuando se selecciona una apertura, se despacha un evento para que
     * otros componentes sepan cual ha sido. De esta forma se pueden realizar
     * cambios basados en eso.
    */
    aperturaSelected( aperturaId ) {
        if (aperturaId == "") return;
        this.$dispatch("apertura-selected", aperturaId);
    },

    /**
     * watchers
    */
    setWatchers() {
        this.$watch("CARRO", async () => {
            if (this.getCarroId() === null) return;

            this.getAperturas();
        });
    }
});
