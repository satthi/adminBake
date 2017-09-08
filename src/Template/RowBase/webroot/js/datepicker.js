$(function(){
    $('.datepicker').each(function(){
        var self = $(this);
        self.daterangepicker({
            timePicker: false,
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
                applyLabel: 'セット',
                cancelLabel: 'クリア',
                format: 'YYYY/MM/DD'
            }
        });
        self.on('apply.daterangepicker', function (ev, picker) {
            self.val(picker.startDate.format(picker.locale.format));
        });
        self.on('cancel.daterangepicker', function (ev, picker) {
            self.val('');
        });
    });
});
