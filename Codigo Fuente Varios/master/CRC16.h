unsigned int computarChecksum(byte *, int);
void generarTablaCRC();

const int polynomial = 0x8810;
unsigned int table[256];

//Genera la tabla para el cálculo del CRC
void generarTablaCRC() {
  unsigned int value;
  unsigned int temp;
  for (unsigned int i = 0; i < 256; ++i)
  {
    value = 0;
    temp = i;
    for (byte j = 0; j < 8; ++j)
    {
      if (((value ^ temp) & 0x0001) != 0)
      {
        value = (unsigned int)((value >> 1) ^ polynomial);
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

//Calcula el CRC de la cadena de bytes recibida como parámetro
unsigned int computarChecksum(byte * bytes, int cantBytes) {
  unsigned int crc = 0;
  for (int i = 0; i < cantBytes; ++i)
  {
    byte index = (byte)(bytes[i] ^ crc);
    crc = (unsigned int)((crc >> 8) ^ table[index]);
  }
  return crc;
}
