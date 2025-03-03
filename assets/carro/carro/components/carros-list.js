import { getList, getEstantesList, getKitsList } from "@/carro/requests";
import { errorAlert } from "@/partials/alerts";
import { showLoader, hideLoader } from "@/partials/loader";

export default (isEstante = 0) => ({
    carros: [],
    selected: undefined,
    carroStatus: false, // true open & false closed
    loader: "#carro-list-loader",
    events: {
        ['@new-carro-created.document']: "getList",
        ["@carro-updated.document"]: "updateCarro",
        ["@carro-deleted.document"]: "deleteCarro",
        ["@carro-status.document"]: "setCarroStatus",
        ["@beforeunload.window"]: "preventCloseWithoutSaving"
    },

    async init() {
        await this.getList();

        if (this.carros.length > 0) {
            this.carroClicked(
                this.carros[0].id
            )
        }
    },

    /** Realiza la consulta */
    async getList() {
        showLoader(this.loader);

        let response;
        if (isEstante === 1) {
            response = await getEstantesList();
        } else if (isEstante === 2) {
            response = await getKitsList();
        } else {
            response = await getList();
        }

        const { data, error } = response;

        hideLoader(this.loader);
        this.carros = data;

        if (error !== null) errorAlert();
    },

    /**
     * Actualiza la info del carro
    */
    updateCarro({ detail: carro }) {
        const index = this.carros.findIndex(c => c.id == carro.id);

        if (index !== -1) {
            this.carros[ index ] = carro;
        }
    },

    /**
     * Cuando Se selecciona un carro, despacha un evento
     * para informar a otros componentes
    */
    carroClicked( id ) {
        this.selected = id;
        const index = this.carros.findIndex(c => c.id == id);

        if (index !== -1) {
            this.$dispatch("carro-selected", this.carros[ index ]);
        }
    },

    /**
     * Establede el estado actual del carro (abierto o cerrado)
    */
    setCarroStatus({ detail: status }) {
        this.carroStatus = status;
    },

    /**
     * Evita que cerremos la pagina sin guardar cambios en el carro.
    */
    preventCloseWithoutSaving( $event ) {
        if (this.carroStatus) {
            $event.preventDefault();
        }
    },

    /**
     * Elimina un carro de la lista
    */
    deleteCarro({detail: id}) {
        const index = this.carros.findIndex(c => c.id == id);

        if (index !== -1) {
            this.carros.splice(index, 1);
        }
    },

    /**
     * Determina si hay carros xD
    */
    get areThereCars() {
        return this.carros?.length > 0;
    }
});
