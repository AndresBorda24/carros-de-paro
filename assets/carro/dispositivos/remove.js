import { successAlert } from "../../partials/alerts";

export default () => ({
    delDisp() {
        if (! confirm("Realmente desea eliminar el registro?") ) {
            return;
        }

        successAlert("Dispositivo Eliminado!");
        this.$dispatch("dispositivo-deleted", this.__rowIndex);
    },
});
