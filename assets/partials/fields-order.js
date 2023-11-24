import Sortable from "sortablejs";

export default ( selector ) => ({
    text: "", // Aqui se copia el contenido del excel
    keys: [], // Aqui se almacena el array con las llaves de `state` <- Viene del padre
    sorted: {}, // Objeto con los datos del texto
    showItemList: false,

    init() {
        this.createSortableInstance(selector);
        this.setKeys( document.querySelector( selector )?.children );

        this.$watch("text", () => this.sort());
        this.$watch("keys", () => this.sort());
    },

    /**
     * Este metodo se encarga de establecer las llaves (ordenadas) con el
     * contenido del texto
    */
    sort() {
        const list = this.text.split("\t");
        this.keys.map(( key, i ) => {
            this.sorted[key] = list[ i ] ?
                list[ i ].trim()
                : "";
        })
        this.setState( this.sorted );
    },

    /**
     * @param htmlCollection { HTMLCollection } Se supone que este es el listado
     *      despues que se ha organizado.
    */
    setKeys( htmlCollection ){
        if (htmlCollection) {
            this.keys = Array.from(htmlCollection)
                .map(it => it.getAttribute("item-key"));
        }
    },

    /**
     * @param sel {string} Identificador (id o clase o... ) del listado
    */
    createSortableInstance( sel ) {
        const list = document.querySelector( sel );

        if (list) {
            new Sortable(list, {
                animation: 150,
                ghostClass: 'list-group-item-primary',
                dragoverBubble: false,
                onEnd: ({ to }) => {
                    this.setKeys( to.children )
                }
            })
        }
    },


    /**
     * Establece los valores copiados desde el excel.
    */
    setState( items ) {
        Object.keys(items).forEach( key => {
            if (key == "vencimiento") {
                const date = new Date(items[key]);

                this.state[key] = isNaN(date)
                    ? null
                    : date.toISOString().substring(0, 10);
            } else {
                this.state[key] = items[key]
            }
        });
    },
});
