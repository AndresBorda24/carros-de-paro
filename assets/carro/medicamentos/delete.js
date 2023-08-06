import { deleteMedicamento } from "./handle"
import { successAlert } from "../../partials/alerts";

export default () => ({
    async delMed() {
        if (! confirm("Realmente desea eliminar el registro?") ) {
            return;
        }

        if (await deleteMedicamento(this.state)) {
            successAlert("Medicamento Eliminado!");
            this.$dispatch("medicamento-deleted", this.__rowIndex);
        }
    }
});
