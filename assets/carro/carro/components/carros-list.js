import axios from "axios";
import { errorAlert } from "../../../partials/alerts";
import { showLoader, hideLoader } from "../../../partials/loader";

export default () => ({
    carros: [],
    selected: undefined,
    loader: "#carro-list-loader",
    api: process.env.API + "/carros/get-all",
    events: {
        ['@new-carro-created.document']: "getList",
        ["@carro-updated.document"]: "updateCarro",
        ["@carro-deleted.document"]: "deleteCarro"
    },

    async init() {
        await this.getList();

        if (this.carros.length > 0) {
            this.carroClicked(
                this.carros[0].id
            )
        }
    },

    /** Realiza la consulta */
    async getList() {
        try {
            showLoader(this.loader);
            const { data } = await axios
                .get(this.api, this.state)
                .finally(() => hideLoader(this.loader));

            this.carros = data;
        } catch(e) {
            errorAlert();
        }
    },

    /**
     * Actualiza la info del carro
    */
    updateCarro({ detail: carro }) {
        const index = this.carros.findIndex(c => c.id == carro.id);

        if (index !== -1) {
            this.carros[ index ] = carro;
        }
    },

    /**
     * Cuando Se selecciona un carro, despacha un evento
     * para informar a otros componentes
    */
    carroClicked( id ) {
        this.selected = id;
        const index = this.carros.findIndex(c => c.id == id);

        if (index !== -1) {
            this.$dispatch("carro-selected", this.carros[ index ]);
        }
    },

    /**
     * Elimina un carro de la lista
    */
    deleteCarro({detail: id}) {
        const index = this.carros.findIndex(c => c.id == id);

        if (index !== -1) {
            this.carros.splice(index, 1);
        }
    }
});