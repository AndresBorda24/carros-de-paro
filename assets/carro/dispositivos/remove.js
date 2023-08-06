import { successAlert } from "../../partials/alerts";
import { deleteDispositivo } from "./handle"

export default () => ({
    async delDisp() {
        if (! confirm("Realmente desea eliminar el registro?") ) {
            return;
        }

        if(await deleteDispositivo(this.state)) {
            successAlert("Dispositivo Eliminado!");
            this.$dispatch("dispositivo-deleted", this.__rowIndex);
        }
    },
});
