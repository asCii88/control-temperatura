#include <SPI.h>
#include "nRF24L01.h"
#include "RF24.h"

//Utiliza los puertos 9 y 10 de gpio para spi
RF24 radio(9, 10);

const uint64_t direccion = 0xF0F0F0F0E1LL;

//Estructura del mensaje que se envía por radiofrecuencia
struct MensajeRF {
  byte byteControl;
  int dato;
};


void iniciarRF() {
  radio.begin();
  radio.setAutoAck(1);                    // Asegurarse de que autoACK está habilitado
  radio.enableAckPayload();               // Habilitar los payloads de ACK opcionales
  radio.setRetries(0, 15);                // El menor tiempo entre reintentos y la mayor cantidad de reintentos
  radio.enableDynamicPayloads();                // Habilitar tamaño de payload dinámico
  radio.openReadingPipe(1, direccion); //Abrir la lectura para la dirección correspondiente al maestro
  radio.stopListening(); //Dejar de escuchar para poder escribir
}

//Enviar mensaje, esperar respuesta con el estado y almacenarla en el esclavo correspondiente
void enviarMensajeRF(Esclavo * esclavo, byte byteControl, int dato) {

  MensajeRF mensajeRF;
  mensajeRF.byteControl = byteControl;
  mensajeRF.dato = dato;
  radio.openWritingPipe(esclavo->direccion);
  if (!radio.write( &mensajeRF, sizeof(MensajeRF) )) {
    //fallo
  } else {
    if (!radio.available()) {
      //payload vacio de respuesta
    } else {
      while (radio.available() ) {
        radio.read( &valores, sizeof(_valores) );
        esclavo->temperaturaActual = valores.temperaturaActual;
        esclavo->potencia = valores.potencia;
        esclavos->estado = valores.estado;
      }
    }
  }
}
