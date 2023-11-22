import { errorAlert } from "@/partials/alerts";
import { getSingleApertura } from "@/carro/requests";
import { showLoader, hideLoader } from "@/partials/loader";

export default () => ({
    data: undefined,
    aperturaId: undefined,
    events: {
        ["@apertura-selected.document"]: "setAperturaId"
    },

    init() {
        this.$watch("aperturaId", async () => {
            if (this.aperturaId) await this.getData();
        });

        /* Cuando se selecciona otro carro, reiniciamos los valores */
        this.$watch("CARRO", () => {
            this.data = undefined;
            this.aperturaId = undefined;
        });
    },

    /**
     * Recupera la informacion relacionada con `id`
    */
    async getData() {
        showLoader();
        const { data, error } = await getSingleApertura(this.aperturaId);
        hideLoader();

        if (error !== null) return errorAlert();
        this.data = data;
    },

    /**
     * Establece el id de la apertura.
    */
    setAperturaId({ detail: id }) {
        this.aperturaId = id;
    },

    /**
     * Determina si hay informacion cargada en el componente
    */
    get hasData() {
        return typeof this.data !== "undefined";
    },

    /**
     * Importante!!
     *
     * Este metodo DEBE devolver la url de la pagina que se desea imprima.
     * Este metodo lo utiliza otro componente -> [print (/assets/partials)]
    */
    __getPrintWeb() {
        return process.env.API.substring(0, process.env.API.length - 3)
            + "print/"
            + this.aperturaId
            + "/apertura";
    }
});
