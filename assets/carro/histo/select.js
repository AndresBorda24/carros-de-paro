import { errorAlert } from "@/partials/alerts";
import { getAperturas } from "@/carro/requests";

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
        const { data, error } = await getAperturas( this.getCarroId() );
        if (error !== null) return errorAlert();
        this.aperturas = data;
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
