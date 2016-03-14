using System;

namespace interfazMasterBD
{
	public static class Crc16
	{
		const ushort polynomial = 0x8810;
		static readonly ushort[] table = new ushort[256];

		//Calcula el CRC de la cadena de bytes recibida como parámetro
		public static ushort ComputeChecksum(byte[] bytes, int cantBytes)
		{
			ushort crc = 0;
			for (int i = 0; i < cantBytes; ++i)
			{
				byte index = unchecked((byte)(bytes[i] ^ crc));
				crc = (ushort)((crc >> 8) ^ table[index]);
			}
			return crc;
		}

		//Genera la tabla para el cálculo del CRC
		static Crc16()
		{
			ushort value;
			ushort temp;
			for (ushort i = 0; i < table.Length; ++i)
			{
				value = 0;
				temp = i;
				for (byte j = 0; j < 8; ++j)
				{
					if (((value ^ temp) & 0x0001) != 0)
					{
						value = (ushort)((value >> 1) ^ polynomial);
					}
					else
					{
						value >>= 1;
					}
					temp >>= 1;
				}
				table[i] = value;
			}
		}
	}
}
