<?php
	session_start();
    
    //if the mode value is pay and the checklist is not empty, proceed to billing page
	if($_POST['mode'] == "pay"){
	    if(isset($_POST['check_list'])){
	        $_SESSION['check_list'] = $_POST['check_list'];
            header('Location: payment/');
	    }
	    else{ 
	        //if the checklist is empty, return to the preceding page and pass a checklist var with a value of -1
	        header('Location: index.php?checklist=-1');
	    }
		exit();
	}
	else{ //if value of 'mode' is an id and not "pay", meaning the user has clicked the edit button named mode with a value of ID of the selected sample
		$id = $_POST['mode'];
		$_SESSION['id'] = $id;
		header('Location: edit/?id='.$id);
		exit();
	}
	
?>
