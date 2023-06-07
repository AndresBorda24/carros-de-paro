export default () => ({
    CARRO: undefined,
    grillaShow: undefined,
    events: {
        ["@carro-selected.document"]: "setCarro",
        ["@carro-updated.document"]: "setCarro",
        ["@carro-deleted.document"]: "deleteCarro"
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
