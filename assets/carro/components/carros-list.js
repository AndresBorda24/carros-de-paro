import axios from "axios";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

export default () => ({
    carros: {},
    loader: "#carro-list-loader",
    api: process.env.API + "/carros/get-all",
    events: {
        ['@new-carro-created.document']: "getList"
    },

    async init() {
        await this.getList();
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
    }
});
