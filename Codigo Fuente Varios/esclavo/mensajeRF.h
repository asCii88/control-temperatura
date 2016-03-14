#include <SPI.h>
#include "nRF24L01.h"
#include "RF24.h"
#include "printf.h"

//Comandos posibles
enum Comando {
  SET_TEMP = 0x01,

  SET_ESTADO = 0x11,
  
  CMD_NOP = 0xFF
};

struct MensajeRF {
  byte byteControl;
  int dato;
};

const uint64_t direccion = 0xF0F0F0F0D2LL;
const uint64_t direccionMaster = 0xF0F0F0F0E1LL;

//Utiliza los puertos 9 y 10 de gpio para spi
RF24 radio(9, 10);

//Idem master
void iniciarRF() {
  radio.begin();
  radio.setAutoAck(1);                    
  radio.enableAckPayload();               
  radio.setRetries(0, 15);               
  radio.enableDynamicPayloads();                
  radio.openWritingPipe(direccionMaster);        
  radio.openReadingPipe(1, direccion);
  radio.startListening();                 
}


