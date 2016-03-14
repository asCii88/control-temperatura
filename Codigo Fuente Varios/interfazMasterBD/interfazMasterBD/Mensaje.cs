using System;
using System.Runtime.InteropServices;

namespace interfazMasterBD
{
	
	[StructLayout(LayoutKind.Explicit, Size = TAM_MENSAJE, Pack = 1)]
	public class Mensaje
	{
		//Tamaño en bytes del mensaje
		public const byte TAM_MENSAJE = 10;
		
		//Comandos posibles
		public enum Comando : byte {
			SET_TEMP = 0x01,
			RES_TEMP = 0x03,

			SET_ESTADO = 0x11,
			RES_ESTADO = 0x13,

			RES_POT = 0x23,
			
			REQ_ENUM = 0x32,
			RES_ENUM = 0x33,
			
			REQ_ALL = 0xF2
		}

		[MarshalAs(UnmanagedType.U4)] //Tipo unsigned int de 4 bytes
		[FieldOffset(0)] //Comienza alineado con el byte 0
		public uint timestamp;
		
		[MarshalAs(UnmanagedType.U1)] //Tipo unsigned char de 1 byte
		[FieldOffset(4)] //Comienza alineado con el byte 4
		public Comando byteControl;
		
		[MarshalAs(UnmanagedType.U1)] //Tipo unsigned char de 1 byte
		[FieldOffset(5)] //Comienza alineado con el byte 5
		public byte numeroSensor;
		
		[MarshalAs(UnmanagedType.I2)] //Tipo short de 2 bytes
		[FieldOffset(6)] //Comienza alineado con el byte 6
		public short dato;
		
		[MarshalAs(UnmanagedType.U2)] //Tipo unsigned short de 2 bytes
		[FieldOffset(8)] //Comienza alineado con el byte 8
		ushort CRC16;
		
		//Distintos constructores para distintas situaciones
		public Mensaje(Comando byteControl, byte numeroSensor, short dato)
		{
			this.timestamp = 0;
			this.byteControl = byteControl;
			this.numeroSensor = numeroSensor;
			this.dato = dato;
			this.CRC16 = 0;
		}
		
		public Mensaje(Comando byteControl, byte numeroSensor)
		{
			this.timestamp = 0;
			this.byteControl = byteControl;
			this.numeroSensor = numeroSensor;
			this.dato = 0;
			this.CRC16 = 0;
		}
		
		public Mensaje(Comando byteControl)
		{
			this.timestamp = 0;
			this.byteControl = byteControl;
			this.numeroSensor = 0;
			this.dato = 0;
			this.CRC16 = 0;
		}
		
		public Mensaje(){ }
		
		//Convierte el mensaje en un arreglo de bytes
		public byte[] ToByteArray() {
			int size = Marshal.SizeOf(this);
			byte[] arr = new byte[size];

			IntPtr ptr = Marshal.AllocHGlobal(size);
			Marshal.StructureToPtr(this, ptr, true);
			Marshal.Copy(ptr, arr, 0, size);
			Marshal.FreeHGlobal(ptr);
			return arr;
		}
		
		//Genera un objeto mensaje a partir de un arreglo de bytes si el CRC es correcto
		public static Mensaje FromByteArray(byte[] bytes){
			if (Crc16.ComputeChecksum(bytes,TAM_MENSAJE) == 0){
				GCHandle handle = GCHandle.Alloc(bytes, GCHandleType.Pinned);
				Mensaje mensaje = (Mensaje)Marshal.PtrToStructure(handle.AddrOfPinnedObject(), typeof(Mensaje));
				handle.Free();
				return mensaje;
			} else {
				throw new CrcErrorException();
			}
		}
		
		//Computa el CRC del mensaje y lo agrega al campo de CRC
		public void ComputarChecksum(){
			this.CRC16 = Crc16.ComputeChecksum(this.ToByteArray(),Mensaje.TAM_MENSAJE-sizeof(ushort)); //El cheksum del mensaje sin el campo de checksum
		}

	}
}
