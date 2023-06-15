export default () => ({
    data: undefined,
    events: {
        '@new-results-found.document': "setData"
    },

    /**
     * Determina si mostrar el select con las fechas
    */
    show() {
        return (Boolean(this.data)) && this.data.length > 0;
    },

    /**
     * Setea data con la informacion que llega del evento.
    */
    setData({ detail }) {
        this.data = detail.data;
    },

    /**
     * Retorna el total de coincidencas de los filtros
    */
    resultCount() {
        return (Boolean(this.data)) ? this.data.length : '';
    },

    /**
     * Se ejecuta cuando se selecciona algun elemento del select de cambios
    */
    changed( id ) {
        this.$dispatch("fetch-changes", id);
    }
});
