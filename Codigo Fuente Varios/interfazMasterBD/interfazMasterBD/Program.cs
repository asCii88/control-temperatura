using System;
using System.Threading;
using System.Collections.Generic;
using MySql.Data.MySqlClient;

namespace interfazMasterBD
{

	public class PortChat
	{
		
		static Comunicacion _comunicacion;
		
		// disable once FunctionNeverReturns
		public static void Main(string[] args)
		{
			
			bool hayComandos;
			
			//Lee el argumento de la línea de comandos y crea la comunicación serie a través del puerto ingresado
			if((args.Length == 1) && (args[0].ToLower()).StartsWith("com")){
				_comunicacion = new Comunicacion(args[0]);
			} else {
				Console.WriteLine("Especificar el puerto com del arduino en la linea de comandos. Ejemplo com3");
				Console.ReadKey();
				Environment.Exit(1);
			}

			BaseDeDatos based = new BaseDeDatos();
			//Borra el contenido de las tablas
			based.Reiniciar();

			//Sincroniza con el maestro
			_comunicacion.Open();
			
			//Enumerar cantidad de esclavos
			_comunicacion.enviarComando(new Mensaje(Mensaje.Comando.REQ_ENUM));
			while(!_comunicacion.recibir()){}
			Mensaje mensaje = _comunicacion.MensajesRecibidos();
			
			//Crea arreglos donde se guardará el estado de los esclavos y los comandos ingresados
			Esclavo[] esclavos = new Esclavo[mensaje.dato];
			Esclavo[] comandos = new Esclavo[mensaje.dato];
			for(byte i = 0; i < esclavos.Length;i++){
				esclavos[i] =  new Esclavo();
				comandos[i] =  new Esclavo();
			}
			//Carga el estado de los esclavos en la base de datos
			based.CargarSensores(esclavos.Length);
			
			//Tarea cíclica
			while (true)
			{
				//Recibe mensajes del maestro
				_comunicacion.Comunicarse();
				//Solicita el estado de todos los sensores enumerados
				for(byte i = 0; i < esclavos.Length;i++){
					_comunicacion.enviarComando(new Mensaje(Mensaje.Comando.REQ_ALL,i));
				}
				//Procesa los mensajes recibidos anteriormente
				_comunicacion.procesarRecibidos(esclavos);
				
				//Comprueba la base de datos para ver si hay comandos
				hayComandos = based.LeerComandos(ref comandos);
				
				//Actualizar el estado de los esclavos en la base de datos
				based.ActualizarEstado(esclavos);
				
				//Enviar comandos
				if(hayComandos){
					for(byte i = 0; i < comandos.Length;i++){
						_comunicacion.enviarComando(new Mensaje(Mensaje.Comando.SET_ESTADO,i,Convert.ToInt16(comandos[i].Estado)));
						_comunicacion.enviarComando(new Mensaje(Mensaje.Comando.SET_TEMP,i,comandos[i].Temperatura));
					}
				}
				
				//Esperar 2,5 segundos
				Thread.Sleep(2500);
			}
		}
		

	}

}