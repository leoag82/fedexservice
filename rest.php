<?php 

	include ('actions.php');

	$data = file_get_contents("php://input", true);
	$request = json_decode($data);
		
	if (isset($request->action) && in_array($request->action, $acciones)) {

		include ('service.php');
		$function_name = str_replace("-", "_", $request->action);

		$func = new Service();		
		$func->setData($request);
		
		$func->$function_name();

	} else {		
		echo json_encode("El servicio no puede procesar su solicitud");
	}

?>