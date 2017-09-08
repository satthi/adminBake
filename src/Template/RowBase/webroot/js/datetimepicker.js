$(function(){
    $('.datetimepicker').each(function(){
        var self = $(this);
        self.daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            singleDatePicker: true,
            autoUpdateInput: false,
            locale: {
                applyLabel: 'セット',
                cancelLabel: 'クリア',
                format: 'YYYY/MM/DD HH:mm'
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
