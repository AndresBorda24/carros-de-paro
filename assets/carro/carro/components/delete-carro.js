import { deleteCarro } from "@/carro/requests";
import { showLoader, hideLoader } from "@/partials/loader";
import { errorAlert, successAlert } from "@/partials/alerts";

export default () => ({
    api: process.env.API,

    /** Realiza la consulta */
    async delCarro() {
        if (! confirm("Realmente desea eliminar el Carro?") ) return;

        showLoader();
        const { error } = await deleteCarro(this.getCarroId());
        hideLoader();

        if  (error !== null) return errorAlert();

        successAlert("Carro Eliminado!");
        this.$dispatch("carro-deleted", this.getCarroId());
    },
});
