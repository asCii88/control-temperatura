#include "CRC16.h"

#define LENGTH 10 //Cantidad de bytes del mensaje serie


//Estructura del mensaje serie
struct Mensaje { 
  unsigned long timestamp;
  byte byteControl;
  byte numeroEsclavo;
  int dato;
};

unsigned long obtenerTimestamp();
void _enviar(Mensaje *);

//Recibir mensaje serie, calcular el checksum y devolverlo si da correcto
bool recibirMensajeSerie(Mensaje * mensaje) {
  byte buffer[LENGTH];
  // Recibir mensaje de serie
  if (Serial.available() >= LENGTH) {
    Serial.readBytes(buffer, LENGTH);
    if (computarChecksum(buffer, LENGTH) == 0) {
      memcpy(mensaje, buffer, sizeof(Mensaje));
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

//Procesar el mensaje
void procesarMensajeSerie(Mensaje * mensajeEntrante) {
  Mensaje mensaje;
  mensaje.timestamp = obtenerTimestamp();
  switch (mensajeEntrante->byteControl) {
    case REQ_ALL: { //Devolver todos los parámetros del esclavo solcitado
        if (mensajeEntrante->numeroEsclavo < CANTIDAD_ESCLAVOS) {
          mensaje.byteControl = RES_TEMP;
          mensaje.numeroEsclavo = mensajeEntrante->numeroEsclavo;
          mensaje.dato = esclavos[mensajeEntrante->numeroEsclavo].temperaturaActual;
          _enviar(&mensaje);
          mensaje.byteControl = RES_ESTADO;
          mensaje.dato = (byte)esclavos[mensajeEntrante->numeroEsclavo].estado;
          _enviar(&mensaje);
          mensaje.byteControl = RES_POT;
          mensaje.dato = esclavos[mensajeEntrante->numeroEsclavo].potencia;
          _enviar(&mensaje);
        }
        break;
      }
    case REQ_ENUM: { //Devolver la vantidad de esclavos
        mensaje.byteControl = RES_ENUM;
        mensaje.numeroEsclavo = 0;
        mensaje.dato = CANTIDAD_ESCLAVOS;
        _enviar(&mensaje);
        break;
      }
    default: { //Reenviar el comando al esclavo especificado
        if (mensajeEntrante->numeroEsclavo < CANTIDAD_ESCLAVOS) {
          enviarMensajeRF(&(esclavos[mensajeEntrante->numeroEsclavo]), mensajeEntrante->byteControl, mensajeEntrante->dato);
          segundos = 18;
        }
        break;
      }
  }
}

//Calcular checksum de mensaje y enviarlo por serie
void _enviar(Mensaje * mensaje) {
  byte buffer[LENGTH] = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
  unsigned int CRC16;
  memcpy(buffer, mensaje, sizeof(Mensaje));
  CRC16 = computarChecksum(buffer, sizeof(Mensaje));
  memcpy(buffer + sizeof(Mensaje), &CRC16, LENGTH - sizeof(Mensaje));
  Serial.write(buffer, LENGTH);
}


unsigned long obtenerTimestamp() {
  return millis();
}



