import axios from "axios";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

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
        try {
            showLoader();
            const {data} = await axios.get(
                process.env.API + "/carros/aperturas/" + this.aperturaId + "/get"
            ).finally(hideLoader);

            this.data = data;
        } catch(e) {
            errorAlert("Ha ocurrido un error al recuperar la info.");
            console.error("Get Apertura", e);
        }
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
     * Este metodo DEBE devolver la url de la pagina que se desea imprima
    */
    __getPrintWeb() {
        return process.env.API.substring(0, process.env.API.length - 3)
            + "print/"
            + this.aperturaId
            + "/apertura";
    }
});
