export default (date) => ({
    date: date,
    diff: undefined,
    ctrl: new Date(),
    binds: {
        [":class"]: "getClass"
    },

    init() {
        this.convertDate();
        this.getDiff();
    },

    /**
     * Dado que la fecha esta en formato de texto, se debe convertir
     * a una instancia de Date
    */
    convertDate() {
        console.log( this.date );
        if (Boolean( this.date )) {
            const data = this.date.split('-');

            this.date = new Date(
                parseInt( data[0] ),
                parseInt( data[1] ) - 1,
                parseInt( data[2] )
            );
        }
    },

    /**
     * Obtiene la diferencia en dias con respecto a `date` y la fecha
     * actal `ctrl`
    */
    getDiff() {
        const segs = this.date.getTime() - this.ctrl.getTime();

        this.diff = Math.ceil(segs / (1000 * 3600 * 24));
    },

    /**
     * Obtine la clase para resaltar la fecha dependiendo de diff
    */
    getClass() {
        if (! Boolean(this.date)) return "";

        // Rojo < 6 meses (180)
        if (this.diff < 180) {
            return "text-bg-danger bg-opacity-75";
        }

        // Amarillo > 6 y < 12 (entre 181 y 360)
        if (this.diff > 180 && this.diff < 360) {
            return "text-bg-warning bg-opacity-75";
        }

        // Verde > 12 meses (361)
        if (this.diff > 360) {
            return "text-bg-success bg-opacity-75";
        }
    }
})
