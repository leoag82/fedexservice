<?php 

	/**
	* Esta es una clase que maneja la lista de acciones del servicio
	*/
	class Service {
		
		private $data;
		private $conection;

		function __construct(){
			/* connect to the db */
			$this->conection = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
			mysqli_select_db($this->conection, 'asefedex') or die('Cannot select the DB');

			$this->data = null;
		}

		function getData() {
			return $this->data;
		}

		/**
		 * Esta funcion se encarga de validar el usario
		 */
		function validate_user(){

			$user = $this->data['u'];
			$password = $this->data['p'];
			/* grab the posts from the db */
			$query = "SELECT * FROM users WHERE Id_emp = '$user' AND password = '$password'";
			$result = mysqli_query($this->conection, $query) or die('Va Jalando');

			$info = mysqli_fetch_assoc($result);
			
			echo json_encode(array($info));
			
		}

		function create_session() {
			$user = $this->data["user"];

			session_start();
			$_SESSION["ID"] = $user->Id;
			$_SESSION["NOMBRE"] = $user->first_name." ".$user->last_name;
			$_SESSION["STATUS"] = $user->status;
			$_SESSION["PROFILE"] = $user->profile;

			if (isset($_SESSION["ID"])){
				echo json_encode(1);	
			} else {
				echo json_encode(0);
			}

			
		}

		function get_session(){
			session_start();
			echo json_encode($_SESSION);	
		}

		function get_all_users(){
						
			$query = "SELECT * FROM users";
			$result = mysqli_query($this->conection, $query) or die('Va Jalando');

			//$info = mysqli_fetch_assoc($result);

			while($row = mysqli_fetch_assoc($result)){
			     $info[] = $row;
			}			
			
			echo json_encode(array($info));
		}

		function get_user(){
						
			$idUser = $this->data['id'];
			$query = "SELECT * FROM users WHERE Id = $idUser";
			$result = mysqli_query($this->conection, $query) or die('el id es incorrecto');

			$info = mysqli_fetch_assoc($result);

			echo json_encode(array($info));
		} 
 
		function add_users(){
			//echo json_encode(array('comence agregar el usurario'));
			

			$firstName = $this->data['firstName'];
			$lastName = $this->data['lastName'];
			$idNumber = $this->data['idNumber'];
			$password = $this->data['password'];
			$inDate = $this->data['inDate'];
			$status = $this->data['status'];
			$profile = $this->data['profile'];
			$email = $this->data['email'];
			$phone = $this->data['phone'];
			$query = "INSERT INTO users(first_name, last_name, id_number, password, in_date, status, profile, email, phone ) 
			VALUES ('$firstName', '$lastName' , '$idNumber', '$password', '$inDate', '$status', '$profile','$email', '$phone')"; 
			$result = mysqli_query($this->conection, $query) or die('no se pudo agregar el usuario');


			//$info = mysqli_fetch_assoc($result);

			echo json_encode(array($result));

		}
		
		function delete_user(){
			$id = $this->data['id'];

			$query = "DELETE FROM users WHERE Id = $id"; 
			$result = mysqli_query($this->conection, $query) or die($query);

			echo json_encode(array($result));

		}
		
		function edit_user(){
			$idUser=$this->data['Id'];
			$Id_emp=$this->data['Id_emp'];
			$firstName = $this->data['firstName'];
			$lastName = $this->data['lastName'];
			$idNumber = $this->data['idNumber'];
			$password = $this->data['password'];
			$inDate = $this->data['inDate'];
			$status = $this->data['status'];
			$profile = $this->data['profile'];
			$email = $this->data['email'];
			$phone = $this->data['phone'];	
			$query = "UPDATE users SET Id_emp=$Id_emp, first_name='$firstName', last_name='$lastName', Id_number='$idNumber', password='$password', in_date='$inDate', status='$status', profile='$profile', email='$email', phone='$phone' WHERE Id = $idUser"; 
			$result = mysqli_query($this->conection, $query) or die('No se puedo modificar su usuario');

			echo json_encode(array($result));
		}
			
		function saving_christmas(){

			$userId=$this->data['Id'];
			$Qsaving=$this->data['Qsaving'];
			$date=$this->data['date'];
			$query = "INSERT INTO saving (Id_emp, amount, date) VALUES ($userId, $Qsaving, '$date')"; 
			$result = mysqli_query($this->conection, $query) or die('no se pudo programar su ahorro');
			
			echo json_encode(array($result));

		}

		function request_credit (){
			$userId=$this->data['Id'];
			$dateRq=$this->data['dateRq'];
			$creditAmount=$this->data['creditAmount'];
			$termMonths=$this->data['termMonths'];
			$query = "INSERT INTO requestcredit ( Id_emp, dateRq, creditAmount, termMonths ) VALUES ($userId, '$dateRq', $creditAmount , $termMonths)"; 
			$result = mysqli_query($this->conection, $query) or die('su credito no fue solicitado correctamente.');


			//$info = mysqli_fetch_assoc($result);

			echo json_encode(array($result));

		}

		function request_status (){
			$Id=$this->data['Id'];
			$mount=$this->data['mount'];
			$query = "INSERT INTO accountstatus (mount ) VALUES ('$mount')"; 
			$result = mysqli_query($this->conection, $query) or die('Su estado de cuenta no se puede consultar');


			//$info = mysqli_fetch_assoc($result);

			echo json_encode(array($result));

		}



		function close_session(){

			echo json_encode(array('response'=>$this->getData()));
			
		}

		/**
		 * Esta es una funcion qu devuelve la lista de parametros
		 */
		function setData($array){			
			foreach ($array as $key => $value) {
				if($key != "action") {
					$this->data[$key] = $value;	
				}
			}
			
		}		

	}

?>