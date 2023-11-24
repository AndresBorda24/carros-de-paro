export default () => ({
    CARRO: undefined,
    /**
     * Determina el estado del carro. False (cerrado) y true (aperto)
    */
    carroStatus: false,
    grillaShow: undefined,
    events: {
        ["@carro-selected.document"]: "setCarro",
        ["@carro-updated.document"]:  "setCarro",
        ["@carro-deleted.document"]:  "deleteCarro"
    },

    init() {
        // Informamos el cambio en el estadon de carro a los componentes
        // que no sean hijos
        this.$watch("carroStatus", (val) => {
            this.$dispatch("carro-status", val);
            Alpine.store("CARRO_STATUS", val);
        });
    },

    /**
     * Obtine y guarda la informacion del carro clicado
    */
    setCarro({ detail: carro }) {
        this.CARRO = carro;
        this.grillaShow = 1;
    },

    /**
     * Cuando se elimina un carro, restablece los valores por defecto
    */
    deleteCarro() {
        this.CARRO      = undefined;
        this.grillaShow = undefined;
    },

    /**
     * Aqui le indicamos al componente "print" cual es la ruta que debe
     * imprimir
    */
    __getPrintWeb() {
        return process.env.API.substring(0, process.env.API.length - 3)
            + "print/"
            + this.getCarroId()
            + "/current";
    },

    /**
     * -------------------------------------------------------------------------
     * Las funciones aqui abajo son para evitar errores a la hora de
     * obtener la informacion del carro
     *
     * Si `CARRO` no esta seteado siempre retornaran null
     * -------------------------------------------------------------------------
    */

    hasCarro() {
        return Boolean(this.CARRO);
    },
    getCarroFull() {
        return this.CARRO;
    },
    getCarroId() {
        if (! Boolean(this.CARRO)) {
            return null
        }

        return this.CARRO.id;
    },
    getCarroNombre() {
        if (! Boolean(this.CARRO)) {
            return null
        }

        return this.CARRO.nombre;
    },
    getCarroUbicacion() {
        if (! Boolean(this.CARRO)) {
            return null
        }

        return this.CARRO.ubicacion;
    }
});
