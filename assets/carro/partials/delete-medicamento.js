import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    delMed() {
        try {
            if (! confirm("Realmente desea eliminar el registro?") ) {
                return;
            }

            successAlert("Medicamento Eliminado!");
            this.$dispatch("medicamento-deleted", this.__rowIndex);
        } catch(e) {
            console.error("Eliminar Medicamento: ", e);
            errorAlert();
        }
    },

    /** Determina si se muestra el boton de eliminar o no */
    showButton() {
        return typeof this.__rowIndex !== 'undefined';
    }
});
