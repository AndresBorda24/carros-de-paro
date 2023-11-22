import { deleteDispositivo } from "@/carro/requests";
import { successAlert, errorAlert } from "@/partials/alerts";

export default () => ({
    async delDisp() {
        if (! confirm("Realmente desea eliminar el registro?") ) {
            return;
        }

        const { error } = await deleteDispositivo(this.state.id, {
            data: {
                "apertura_id": Alpine.store("APERTURA_ID")
            }
        });

        if (error) return errorAlert();

        successAlert("Dispositivo Eliminado!");
        this.$dispatch("dispositivo-deleted", this.__rowIndex);
    },
});
