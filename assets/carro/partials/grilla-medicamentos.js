import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';

export default () => ({
    selector: "#grilla-medicamentos",
    table: undefined,
    data: [],
    events: {
        ['@new-medicamento-created.document']: "newMedicamento"
    },

    init() {
        this.$watch("CARRO", () => {
            console.log("Cambio el ID: ", this.getCarroId());
        });

        this.$watch("grillaShow", (val) => {
            if (val == 1) {
                this.$nextTick(() => {
                    this.table
                        .columns.adjust()
                        .responsive.recalc();
                });
            }
        });

        this.getTable();
    },

    newMedicamento({ detail: medicamento }) {
        this.data.push( medicamento );

        this.table.row.add(
            medicamento
        ).draw();
    },

    getTable() {
        this.table = new DataTable(this.selector, {
            responsive: true,
            paging: false,
            columnDefs: [
                // { data: false, targets: 0 },
                { data: 'p_activo', targets: 1 - 1  },
                { data: 'concentracion', targets: 2 - 1  },
                { data: 'forma_farma', targets: 3 - 1  },
                { data: 'medida', targets: 4 - 1  },
                { data: 'presentacion', targets: 5 - 1  },
                { data: 'invima', targets: 6 - 1  },
                { data: 'lote', targets: 7 - 1  },
                { data: 'vencimiento', targets: 8 - 1  },
                { data: 'cantidad', targets: 9 - 1  },
            ]
        });
    }
});
