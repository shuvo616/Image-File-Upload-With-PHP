<?php 
	/**
	* Database Class.[Second time practice.$ () & # ! ]
	*/
	class Database{
		
		public $host   = DB_HOST;
		public $user   = DB_USER;
		public $pass   = DB_PASS;
		public $dbname = DB_NAME;

		public $link;
		public $error;

		function __construct(){
			$this->connectDB();
		}

		//This is database connection.
		private function connectDB(){
			$this->link = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
			if (!$this->link) {
				$this->error = "Connection Error".$this->link->connect_error;
			}
		}
		//This function will insert image to our database.
		public function insert_img($rcv_data){
			$insert_row = $this->link->query($rcv_data) or die($this->link->error.__LINE__);
			if ($insert_row) {
				return $insert_row;
			} else{
				return false;
			}
		}

		//This function will retirive image from our database for view image.
		public function view_img($rcv_data){
			$view_row = $this->link->query($rcv_data) or die($this->link->error.__LINE__);
			if ($view_row) {
				return $view_row;
			} else {
				return false;
			}	
		}

		//This function will delete image from our database.
		public function delete_img($rcv_data){
			$delete_row = $this->link->query($rcv_data) or die($this->link->error.__LINE__);
			if ($delete_row) {
				return $delete_row;
			} else {
				return false;
			}
			
		}
	}

 ?>