struct _valores {
  byte temperaturaActual;
  byte potencia;
  bool estado;
};
_valores valores;


unsigned int segundos = 20;

#include "comandos.h"
#include "esclavos.h"
#include "mensajesRF.h"
#include "mensajes.h"


void setup() {

  //Generar la tabla para el cálculo del CRC de los mensajes serie
  generarTablaCRC();

  //Codificación fija de las direcciones de los esclavos
  esclavos[0].direccion = 0xF0F0F0F0D2LL;
  esclavos[1].direccion = 0xF0F0F0F0C3LL;

  //Inicialización del serie
  Serial.begin(57600);
  while (!Serial) {
    ; // esperar al puerto serie a que se conecte. Necesario para puertos USB nativos únicamente
  }
  establishContact();  // Enviar un byte para establecer el contacto hasta que la PC responda
  
  //Iniciar la radio
  iniciarRF();
}

void loop(void) {
  Mensaje mensajeEntrante;

  //Cada 20 segundos
  if (segundos >= 20) {//Solicitar estado de todos los esclavos
    segundos = 0;
    for (int i = 0; i < CANTIDAD_ESCLAVOS; i++) {
      enviarMensajeRF(&(esclavos[i]), CMD_NOP, 0);
    }
  }

  //Recibir y procesar mensajes del puerto serie
  while (recibirMensajeSerie(&mensajeEntrante)) {
    procesarMensajeSerie(&mensajeEntrante);
    delay(50);
  }

  //Esperar 1 segundo
  delay(1000);
  segundos++;
}


void establishContact() {
  while (Serial.available() <= 0) {
    Serial.print('A');   // enviar una A mayúscula
    delay(300);
  }
  Serial.read();
}
