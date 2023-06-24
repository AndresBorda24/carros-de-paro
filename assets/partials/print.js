export default () => ({
    __print() {
        const printWindow = window.open(
            this.getUrl(),
            'Print',
            'left=200',
            'top=200',
            'width=950',
            'height=500',
            'toolbar=0',
            'resizable=0'
        );

        printWindow.setTimeout(function(){
          printWindow.focus();
          printWindow.print();
          printWindow.close();
        }, 1000);
    },


    getUrl() {
        return this.__getPrintWeb() || "/";
    }
});
