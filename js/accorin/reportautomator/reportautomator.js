/**
 * Created by Marco Segura on 8/7/15.
 */

function scheduleThis(url, report_id) {

    url = url + "?report_id=" + report_id;

    if (jQuery('#store_switcher').length == 1)
        url = url + "&website="+jQuery('#store_switcher').val();
    else
        url = url + "&website=0";

    if (jQuery("#filter_form").length == 1) {
        var values = {};
        jQuery("#filter_form input").each(function () {
            name = jQuery(this).attr('name');
            values[name.replace("[]", "")] = jQuery(this).val();
        });
        jQuery("#filter_form select").each(function () {
            name = jQuery(this).attr('name');
            values[name.replace("[]", "")] = jQuery(this).val();
        });
        url = url + "&template=" + encodeURIComponent(JSON.stringify(values));
    } else if (jQuery("td.filter").length == 1) {
        var values = {};
        jQuery("td.filter input").each(function () {
            name = jQuery(this).attr('name');
            values[name.replace("[]", "")] = jQuery(this).val();
        });
        jQuery("td.filter select").each(function () {
            name = jQuery(this).attr('name');
            values[name.replace("[]", "")] = jQuery(this).val();
        });
        url = url + "&template=" + encodeURIComponent(JSON.stringify(values));
    }

    window.location = url;
}

jQuery(document).ready(function(){
    jQuery('#schedule_frequency').change(function(){
        setLabelFor(jQuery(this).val());
    });
    setLabelFor(jQuery('#schedule_frequency').val());
});

function setLabelFor(id){
    switch(id){
        case '0':
            jQuery('small.schedule_date_flag').html('Set start and end date to the date the report is being run');
            break;
        case '1':
            jQuery('small.schedule_date_flag').html('Set start and end date to the seven days prior to the schedule day');
            break;
        case '2':
            jQuery('small.schedule_date_flag').html('Set start and end date to the first and last day  of the prior month');
            break;
    }
}