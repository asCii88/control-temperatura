using System;
using System.Collections;
using System.Collections.Generic;
using System.IO.Ports;
using System.Threading;

namespace interfazMasterBD
{
	public class Comunicacion : SerialPort
	{
		Queue<Mensaje> mensajesRecibidos = new Queue<Mensaje>();
		Queue<Mensaje> mensajesAEnviar = new Queue<Mensaje>();
		byte errorCount = 0;
		
		public Mensaje MensajesRecibidos() {
			Mensaje result;
			result = mensajesRecibidos.Dequeue();
			return result;
		}

		public Comunicacion(String puerto) : base(puerto){
			//Establece la velocidad de transmisión 
			this.BaudRate = 57600;
			//Establecer los timeouts de lectura y escritura
			this.ReadTimeout = 500;
			this.WriteTimeout = 500;
		}
		
		//Lee todos los elementos del buffer, escribe un elemento y borra el buffer.
		new public void Open(){
			base.Open();
			this.ReadExisting();
			this.Write("A");
			this.DiscardInBuffer();
		}
		
		new public void Close(){
			base.Close();
		}
		
		//Agrega el timestamp a un mensaje, computa el checksum y lo envía por el puerto serie
		public void enviarComando(Mensaje mensaje){
			mensaje.timestamp = (uint)(Environment.TickCount & Int32.MaxValue);
			mensaje.ComputarChecksum();
			this.Write(mensaje.ToByteArray(),0,Mensaje.TAM_MENSAJE);
		}
		
		//Procesa los mensajes recibidos		
		public void procesarRecibidos(Esclavo[] esclavos){
			while(mensajesRecibidos.Count > 0){
				Mensaje mensaje;
				mensaje = mensajesRecibidos.Dequeue();
				switch(mensaje.byteControl){
						case Mensaje.Comando.RES_TEMP:{
							esclavos[mensaje.numeroSensor].Temperatura = mensaje.dato;
							break;
						}
						case Mensaje.Comando.RES_ESTADO:{
							esclavos[mensaje.numeroSensor].Estado = Convert.ToBoolean(mensaje.dato);
							break;
						}
						case Mensaje.Comando.RES_POT:{
							esclavos[mensaje.numeroSensor].Potencia = mensaje.dato;
							break;
						}
				}
			}
		}
		
		
		public void Comunicarse()
		{
				try
				{
					recibir();
				}
				catch (InvalidOperationException) { }
		
		}
		
		//Recibe a traves del puerto serie, calcula el CRC. Si es correcto agrega el mensaje a una cola de mensajes recibidos para luego ser procesado.
		public bool recibir(){
			bool ret = false;
			while(this.BytesToRead >= Mensaje.TAM_MENSAJE){
				byte[] buffer = new byte[Mensaje.TAM_MENSAJE];
				this.Read(buffer,0,Mensaje.TAM_MENSAJE);
				try {
					Mensaje mensaje = Mensaje.FromByteArray(buffer);
					mensajesRecibidos.Enqueue(mensaje);
					errorCount = 0;
					Console.Write("[");
					foreach (byte b in buffer){
						Console.Write(b+", ");
					}Console.WriteLine("]");
					ret = true;
				} catch (CrcErrorException){
					errorCount++;
					if(errorCount == 25){
						throw new Exception("25 mensajes erróneos seguidos. Revisar línea de conexión.");
					}
				}
			}
			return ret;
		}
		
	}
	
	
}
