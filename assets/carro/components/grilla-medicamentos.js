import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';

export default () => ({
    selector: "#grilla-medicamentos",
    table: undefined,
    data: [],

    init() {
        this.table = this.getTable();
    },

    getTable() {
        return new DataTable(this.selector, {
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                className: 'dtr-control',
                orderable: false,
                targets: 0
            }]
        });
    }
});
