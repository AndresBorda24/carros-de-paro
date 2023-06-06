export default () => ({
    CARRO: undefined,
    grillaShow: undefined,
    events: {
        ["@carro-selected.document"]: "setCarroId"
    },

    setCarroId({ detail: carro }) {
        this.CARRO = carro;
    },

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
