import { errorAlert, successAlert } from "../../partials/alerts";

export default () => ({
    delDisp() {
        try {
            if (! confirm("Realmente desea eliminar el registro?") ) {
                return;
            }

            successAlert("Dispositivo Eliminado!");
            this.$dispatch("dispositivo-deleted", this.__rowIndex);
        } catch(e) {
            console.error("Eliminar Dispositivo: ", e);
            errorAlert();
        }
    },

    /** Determina si se muestra el boton de eliminar o no */
    showButton() {
        return typeof this.__rowIndex !== 'undefined';
    }
});
