import { successAlert } from "../../partials/alerts";

export default () => ({
    delMed() {
        if (! confirm("Realmente desea eliminar el registro?") ) {
            return;
        }

        successAlert("Medicamento Eliminado!");
        this.$dispatch("medicamento-deleted", this.__rowIndex);
    }
});
