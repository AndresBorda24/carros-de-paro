import { deleteMedicamento } from "@/carro/requests"
import { successAlert, errorAlert } from "@/partials/alerts";

export default () => ({
    async delMed() {
        if (! confirm("Realmente desea eliminar el registro?") ) {
            return;
        }

        const { error } = await deleteMedicamento(this.state.id, {
            data: {
                "apertura_id": Alpine.store("APERTURA_ID")
            }
        });

        if (error !== null) return errorAlert();

        successAlert("Medicamento Eliminado!");
        this.$dispatch("medicamento-deleted", this.__rowIndex);
    }
});
