<?php
	/*Classe DB(DataBase)
		2015 (c) Hardcorder
		
		--------Leia-me!------------
		- Para usar a Classe (db) devera chamar o ficheiro usando require_once e criar uma um objecto:
			
			| Code |
				require_once("db.php"); // Caminho para o ficheiro atual
				$dbase = new db();  //$dbase ira carregar todos os metodos e atributos da class
			| End Code |
		 - Para Iniciar a conexao com o Servidor MySql use o Metodo |db_connect| fornecendo os argumentos necessarios
		 
			| Code |
				$dbase->db_connect("hostename","username", "password","nome_base_dados");
			| End Code |
			
		- Para usar algum Metodo da class devera meter como prefixo o nome do objeto criado em cima | $dbase |
		
			| Code |
				echo $dbase->isConnected();
			| End Code |
			
		- A Maior parte das Funcoes retornam alguma coisa e normalmente sao Arrays por isso devemos criar arrays para ficar com o valor retornado da funcaoe
			
			| Code |
				$dados = array(); // criacao de um array
				$dados = $dbase->getTable("nome_da_tabela");
				print_r($dados); // Esta Funcao imprime no ecra todos os valores do array | $dados |
				echo $dados[1]["nome_da_coluna"]; // Podem tambem ser imprimidos 1 a 1 usando arrays associaveis no 1 argumento é o numero da linha e no 2 argumento o nome da coluna
			| End Code |
			
		- Exemplo Testes 
		
			| Code |
				 <?php
				  require_once("db.php");
				  $dbase = new db();
				  
				   $connected = $dbase->db_connect("localhost","root", "","db_testes");
				   
				   
					  if($connected) {
					   echo '
							<div class="success">
							  <strong>Conectado</strong> a Base de Dados...
							</div>

							';
					  } else {
					   echo '<div class="error">
							  A Base de Dados deu tilt: <strong>'.$dbase->getError().'</strong>.
							</div>';
							
						die();
					  }
					  $dados = array();
					  $dados = $dbase->getColum("users","id",1, 2); //1 parametro | tabela | 2 parametro |Coluna| 3 parametro |linha| 4 parametro | Resultados maximo devolvidos para o array neste caso sao  2
					  echo "<br><br>";
					  print_r($dados); // Imprime no ecra
					  
					  $dados = $dbase->getTable("users");
					  echo "<br><br>";
					  print_r($dados); // Imprime no ecra
					?>
				   
			| End Code |
	
	*/
	
  class db {
	  
		//-------------------------------Atributos-------------------------------
		//----------------- Nao Alterar Nenhum Atributo e o seu Conteudo !!!!!! --------------------------
	   private $conn = "";	//Atributo Usado para a fazer Holder da Conexao 
	   private $hostename = "";	//Atributo Usado para fazer Holder do Hostename/IP do servidor MySQL
	   private $username = "";	//Atributo Usado para fazer Holder do username da base de dados
	   private $password = "";	//Atributo Usado para fazer Holder da password da base de dados
	   private $db_connect = "";	//Atributo Usado para fazer Holder do nome da base de dados
	   private $connected = false;	//Atributo Usado para fazer Holder se a Conexao esta ativa ou desativa
	   
	   //-------------------------------Metodos-------------------------------
	   
	   //Cria conexao com a base de dados fornecendo os dados necessarios para a sua conexao
	   public function db_connect($hostename, $username, $password, $db_connect){
		 $this->hostename = $hostename;
		 $this->username = $username;
		 $this->password = $password;
		 $this->db_connect = $db_connect;
		 // Create connection
		@$this->conn = new mysqli($hostename, $username, $password, $db_connect);
		// Check connection
		if ($this->conn->connect_error) {
			//die("Connection failed: " . $conn->connect_error);
			return false;
		}
		
		$this->connected = true;
		return true;

	   }
	
		//Metodo usado para verificar se ja existe alguma conexao com a base de dados
	   public function isConnected(){
		return $this->connected;
	   }
   
	   //Retorna o nome da Base de Dados
	   public function getDb(){
		return $this->db_connect;
	   }
    
		//Retorna a Tabela toda fornecendo a tabela como argumento, -------Retorna um array!---------
		public function getTable($table){
			
			$sql = "SELECT * FROM `".$table."`";
			//echo "<br><br><h2>".$sql."</h2><br><br>";
			$result = $this->conn->query($sql);
			$colum = array();
			$i = 0;
			if ($result->num_rows > 0) {
				// output data of each row
				
				while($line = $result->fetch_assoc()){
					$i++;
					$row[$i] = $line;
				
				}

			  } else {
				  return 0;
			  }
			  return $row;
			
		}
		
		  
		//Retorna a Coluna da Base de Dados Fornecendo a tabela, o que procurar e onde, e Limite de resultados, como argumentos -------Retorna um array!---------
	   public function getColum($table, $procura, $onde, $quantos) {
			$colum = array();
			$i = 0;
			if($quantos<=0) { 
				$sql = "SELECT * FROM `".$table."` WHERE `".$procura."`='".$onde."'";
                //echo $sql;
				//echo "<br><br><h2>".$sql."</h2><br><br>";
				$result = $this->conn->query($sql); 
				
				while($line = $result->fetch_assoc()){  
					$i++;
					$row[$i] = $line;
				}
				return $row;
			} else {
				if($this->getNumLinesSearch($table, $procura, $onde)<$quantos) {
					$quantos=$this->getNumLinesSearch($table, $procura, $onde);
				}
				$sql = "SELECT * FROM `".$table."` WHERE `".$procura."`='".$onde."' LIMIT ".$quantos;
				//echo "<br><br><h2>".$sql."</h2><br><br>";
				$result = $this->conn->query($sql);
				
				while($i<$quantos){
					$i++;
					if ($result->num_rows > 0) {
						// output data of each row
						$row[$i] = $result->fetch_assoc();
					} else {
					  break;
					}
				}
				//echo $this->getNumLines($table);
				return $row;
			}
		}
		
		public function insertQueryReturn($query)
		{
			$colum = array();
			$row = array();
			$sql = $query;

			$result = $this->conn->query($sql);

			while($line = $result->fetch_assoc()){  
				$i++;
				$row[$i] = $line;
			}
			return $row;
		}
		//Retorna quantas Linhas Existem na tabela
		public function getNumLines($table){
			$sql = "SELECT * FROM `".$table."`";
			//echo "<br><br><h2>".$sql."</h2><br><br>";
			$result = $this->conn->query($sql);
			$i = 0;
			if ($result->num_rows > 0) {
				while($line = $result->fetch_assoc()){
					$i++;	
				}
			  } else {
			  }
			  return $i;
		}
		
		//Retorna quantas Linhas Existem na tabela com determinada pesquisa
		public function getNumLinesSearch($table, $procura, $onde){
			$sql = "SELECT * FROM `".$table."` WHERE ".$procura."=".$onde."";
			//echo "<br><br><h2>".$sql."</h2><br><br>";
			$result = $this->conn->query($sql);
			$i = 0;
			if ($result->num_rows > 0) {
				while($line = $result->fetch_assoc()){
					$i++;	
				}
			  } else {
				return 0;
			  }
			  return $i;
		}

		//Retry na connection da Base de Dados Mysql com os dados fornecidos anteriormente
		public function retryConnection(){
		 $this->conn->close();
		 $this->db_connect($this->hostename, $this->username, $this->password, $this->db_connect);
		}
		
		
		//Metodo que muda a base de dados e faz retry da ligacao com a mesma
		public function changeDb($db_connect){
		 $this->db_connect = $db_connect;
		 retryConnection();
		}
		
		//Fecha a conexao com a base de dados retornamdo 'True' ->se for bem sucedido ou 'False' -> se nao for bem sucedido
		public function closeConnection(){
		  if($this->conn){
			$this->conn->close();
			return true;
		  } else {
			return false;
		  }
 
		}
		
		//Retorna o ultimo erro com a base de dados
		public function getError(){
		 return $this->conn->connect_error;
		}
		
		//Metodo usado para inserir Query na base de dados retornado 'True' -> se for bem sucedido ou 'False' -> se nao for bem sucedido
		public function insertQuery($query){
		  if (mysqli_query($this->conn, $query)) {
			 return true;
		  } else { 
			 return false;
		  }
        }
  }
?>