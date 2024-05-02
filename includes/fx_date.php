<?php
$today = date('Y-m-d');
$end_date = '2024-04-24';
$days_before_end = 30;
$alert_date =  get_date_alert_before_due ($end_date, $days_before_end);

if ($today == $alert_date) {
    echo $alert_date;
    echo "ALERT";
}

function get_date_alert_before_due ($end_date, $days_before_end) {
   return date("Y-m-d", strtotime("-".$days_before_end." days", strtotime($end_date)));  
}

function date_reformat($date, $type) {
    $new_date = '';
    if ($type = 'day_to_year_dash') {
        $in_date = explode('-', $date);
        $new_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
    }
    return $new_date;
}       
?>
