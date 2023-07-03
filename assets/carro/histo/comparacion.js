export default (watch) => ({
    after: [],
    before: [],
    /** Esta propiedad nos ayuda a indentiicar cuales se han eliminado. */
    afterIds: [],

    async init(){
        this.$watch(watch, (val) => this.setData(val));

        /**
         * Un poco rebuscado pero bueno ... Es la unica manera que encontre
         * para que cargara con el init
        */
        this.setData(watch.split('.').reduce((a, val) => {
            if (typeof a == 'undefined') {
                a = this[val];
            } else {
                a = a[val];
            }

            return a;
        }, undefined));
    },

    /**
     * Devuelve el nombre del medicamento o del dispositivo dependiendo
     * del `model`
    */
    getItemNombre( item ) {
        return item[ "p_activo_concentracion" ] || item["desc"] || '';
    },

    /**
     * Determina si un elemento se elimin.o Esto se usa para pintar de rojo
     * el elemento eliminado en `before`
    */
    isDeleted( id ) {
        return ! this.afterIds.includes( id );
    },

    /**
     * Establece los datos para after y before
    */
    setData( val ) {
        if (! Boolean(val)) {
            this.after    = [];
            this.before   = [];
            this.afterIds = [];
        }

        this.after = val.after;
        this.before = val.before;
        this.afterIds = this.after.map(el => el.id);
    }
});
