<?php 

	/**
	 * Esta funcion se encarga de validar el usario
	 */
	function validate_user($data=null){

		echo json_encode(array('response'=>$data));
		
	}

	function close_session($data=null){

		echo json_encode(array('response'=>$data));
		
	}

?>