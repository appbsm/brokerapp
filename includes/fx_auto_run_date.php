<?php
include_once('connect_sql.php');
include_once('fx_crud_db.php');
include_once('fx_alert_date.php');

// $near_to_due_list = near_to_due_list ($conn);
// $overdue_list = overdue_list ($conn);
// new_to_follow_up ($near_to_due_list, $conn);
// follow_up_to_wait ($overdue_list, $conn);

$due_list = check_due_policy($conn);
update_follow($due_list, $conn);

$overdue_list = check_overdue_policy($conn);
update_wait($overdue_list, $conn);

?>
