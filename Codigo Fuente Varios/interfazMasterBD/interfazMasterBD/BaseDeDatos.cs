using System;
using MySql.Data.MySqlClient;
using System.Collections.Generic;

namespace interfazMasterBD
{
	public class BaseDeDatos
	{
		private MySqlConnection con;
		private string server;
		private string database;
		private string uid;
		private string password;

		//Constructor
		public BaseDeDatos()
		{
			Initialize();
		}

		//Inicializar valroes
		private void Initialize()
		{
			server = "localhost";
			database = "sistema";
			uid = "root";
			password = "";
			string connectionString;
			connectionString = "SERVER=" + server + ";" + "DATABASE=" +
				database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";";

			con = new MySqlConnection(connectionString);
		}

		//Abrir la conexión con la base de datos
		private bool OpenConnection()
		{
			try
			{
				con.Open();
				return true;
			}
			catch (MySqlException ex)
			{
				switch (ex.Number)
				{
					case 0:
						Console.WriteLine("No se puede conectar al servidor");
						break;

					case 1045:
						Console.WriteLine("Usuario o contraseña inválidos");
						break;
				}
				return false;
			}
		}

		//Cerrar la conexión
		private bool CloseConnection()
		{
			try
			{
				con.Close();
				return true;
			}
			catch (MySqlException ex)
			{
				Console.WriteLine(ex.Message);
				return false;
			}
		}
		public void CargarSensores(int cantidadSensores)
		{
			for(int i=0;i<cantidadSensores;i++){
				const string fixedQuery = "INSERT INTO Estado (id) VALUES ({0})";
				var query = string.Format(fixedQuery,(i+1).ToString());
				//Abrir la conexión
				if (this.OpenConnection() == true)
				{
					
					MySqlCommand cmd = new MySqlCommand(query, con);

					//Ejecutar el comando
					cmd.ExecuteNonQuery();

					//Cerrar la conexión
					this.CloseConnection();
				}
			}
			
		}
		
		//Sentencia de actualización
		public void ActualizarEstado(Esclavo[] esclavos)
		{
			const string fixedQuery = "UPDATE Estado SET tempact={0}, estado={1}, potencia={2} WHERE id={3}";
			for(int i =0; i<esclavos.Length; i++){
				var query = string.Format(fixedQuery, esclavos[i].Temperatura.ToString(), esclavos[i].Estado.ToString(), esclavos[i].Potencia.ToString(),(i+1).ToString());
				//Abrir la conexión
				if (this.OpenConnection() == true)
				{
					//Crear el comando y asignar la solicitud y la conexión del constructor
					MySqlCommand cmd = new MySqlCommand(query, con);

					//Ejecutar el comando
					cmd.ExecuteNonQuery();

					//Cerrar la conexión
					this.CloseConnection();
				}
			}
		}

		//Sentencia de borrado
		public void Reiniciar()
		{
			const string query = "DELETE FROM Estado WHERE 1";
			
			if (this.OpenConnection() == true)
			{
				MySqlCommand cmd = new MySqlCommand(query, con);
				cmd.ExecuteNonQuery();
				this.CloseConnection();
			}
		}
		
		//Sentencia de selección
		public bool LeerComandos(ref Esclavo[] comandos)
		{
			const string query = "SELECT * FROM Control";
			const string query2 = "UPDATE Control SET modificado=0";

			//Abrir la conexión
			if (this.OpenConnection() == true)
			{
				//Create comando
				MySqlCommand cmd = new MySqlCommand(query, con);
				//Crear un lector de datos y ejecutar el comando
				MySqlDataReader dataReader = cmd.ExecuteReader();
				
				dataReader.Read();
				var modificado = dataReader.GetBoolean(3);
				//Si hay líneas modificadas se leen.
				if(modificado){
					int i = 0;
					do{
						comandos[i].Temperatura=dataReader.GetInt16(1);
						comandos[i].Estado=dataReader.GetBoolean(2);	
						i++;
					} while(dataReader.Read());
				}
				
				//Cerrar el lector de datos
				dataReader.Close();
				
				//Se borra el campo de modificado
				cmd.CommandText = query2;
				cmd.ExecuteNonQuery();
				
				//Cerrar la conexión
				this.CloseConnection();
	
				//Devolver la lista
				return modificado;
			}
			else
			{
				return false;
			}
		}
	}
}
