int temperaturaDeseada;
int pb;
struct _valores {
  byte temperaturaActual;
  byte potencia;
  bool estado;
};
_valores valores;

#include "mensajeRF.h"
#include "sleep.h"
#include "DHT.h"
#include "rele.h"
#include "printf.h"
#define DHTPIN 4     // El pin digital al que se conecta el sensor DHT
#define DHTTYPE DHT11   // Modelo del DHT

//Inicializar el DHT
DHT dht(DHTPIN, DHTTYPE);

//Pines de leds
#define LED_ROJO 6
#define LED_VERDE 7


void setup() {
  //Valores iniciales
  valores.temperaturaActual = 0;
  valores.estado = true;
  valores.potencia = 0;
  temperaturaDeseada = 0;
  pb = 10;

  //Inicialización de entrada salida digital
  pinMode(2, INPUT_PULLUP);
  pinMode(LED_ROJO, OUTPUT);
  pinMode(LED_VERDE, OUTPUT);

  //Inicialización de puertos de relé
  inicializarRele();

  //Configuración del watchdog
  setup_watchdog(wdt_8s);
  
  //Iniciar módulo RF
  iniciarRF();
}

void loop(void) {
  int banda, salida;
  MensajeRF mensajeEntrante;
  delay(1000);

  //Leer valor de temperatura
  valores.temperaturaActual = (byte)dht.readTemperature();
  
  //Encender el led correspondiente
  if ( valores.estado) {
    digitalWrite(LED_VERDE, HIGH);
    digitalWrite(LED_ROJO, LOW);
  } else {
    digitalWrite(LED_ROJO, HIGH);
    digitalWrite(LED_VERDE, LOW);
  }

  //Encender o apagar relé, calcular potencia
  if (( valores.estado) & ( valores.temperaturaActual < temperaturaDeseada)) {
    //potencia --> CONTROL PROPORCIONAL
    banda = (pb * temperaturaDeseada) / 100; //pb es la constante para definir la banda
    salida = ((temperaturaDeseada - valores.temperaturaActual) * 100) / banda;
    if (salida > 100) {
      encenderRele();
      valores.potencia = 100;
    } else if (salida < 0) {
      apagarRele();
      valores.potencia = 0;
    } else {
      encenderRele();
      valores.potencia = salida;
    }
  } else {
    apagarRele();
    valores.potencia = 0;
  }

  //Entrar en modo de bajo consumo
  do_sleep();

  //Recibir y procesar mensaje de radiofrecuencia
  while (radio.available()) {
    radio.read(&mensajeEntrante, sizeof(MensajeRF));
    switch (mensajeEntrante.byteControl) {
      case CMD_NOP: {
          break;
        }
      case SET_TEMP: {
          temperaturaDeseada = mensajeEntrante.dato;
          break;
        }
      case SET_ESTADO: {
          valores.estado = (bool)mensajeEntrante.dato;
          break;
        }
    }
    //Escribir el payload del ACK
    radio.writeAckPayload(1, &valores, sizeof(_valores));
  }
}
