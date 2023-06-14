export default () => ({
    data: [],
    events: {
        '@new-results-found.document': "setData"
    },

    /**
     * Determina si mostrar el select con las fechas
    */
    show() {
        return this.data.length > 0;
    },

    /**
     * Setea data con la informacion que llega del evento.
    */
    setData({ details }) {
        this.data = details.data;
    }
});
