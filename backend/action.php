<?php
	$result = "No function found";

	switch ($_GET['return']) {
    case 'get_user':
        $result = get_user();
        break;
    case 'count_users':
        $result = count_users();
        break;
    case 'get_whitelist':
        $result = get_whitelist();
        break;
    case 'get_user_info':
        $result = get_user_info($_GET['user'], $_GET['field']);
        break;
    case 'get_job':
        $result = get_job($_GET['job']);
        break;
   	case 'get_job_grade':
        $result = get_job_grade($_GET['job'], $_GET['grade']);
        break;
    case 'add_to_whitelist':
        add_to_whitelist(htmlspecialchars($_GET['firstname']), htmlspecialchars($_GET['lastname']), htmlspecialchars($_GET['identifier']));
        $result = NULL;
        break;
	}
    
    if ($result != NULL) {
        return $result;   
    }
	
?>