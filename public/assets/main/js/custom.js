/**
 * Created by etsb on 7/19/16.
 */
$('.datapicker').datepicker({autoclose: true, todayHighlight: true,format: 'yyyy-mm-dd'});
$('.timepicker1').timepicker({
    minuteStep: 1,
    //template: 'modal',
    //appendWidgetTo: 'body',
    showSeconds: false,
    showMeridian: false,
    defaultTime: false
});