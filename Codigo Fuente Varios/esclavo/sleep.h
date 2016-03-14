#include <avr/sleep.h>
#include <avr/power.h>

void wakeUp() {
  detachInterrupt(0);
}

// Declaraciones de sleep
typedef enum { wdt_16ms = 0, wdt_32ms, wdt_64ms, wdt_128ms, wdt_250ms, wdt_500ms, wdt_1s, wdt_2s, wdt_4s, wdt_8s } wdt_prescalar_e;

void setup_watchdog(uint8_t prescalar);
void do_sleep(void);

void setup_watchdog(uint8_t prescalar){

  uint8_t wdtcsr = prescalar & 7;
  if ( prescalar & 8 )
    wdtcsr |= _BV(WDP3);
  MCUSR &= ~_BV(WDRF);                      // Borrar la bandera de Reset de sistema del WD
  WDTCSR = _BV(WDCE) | _BV(WDE);            // Escribir el bit de habitlitación de cambio del WD
  WDTCSR = _BV(WDCE) | wdtcsr | _BV(WDIE);  // Escribir los bits del prescalador
}

ISR(WDT_vect)
{
}

void do_sleep(void)
{
  set_sleep_mode(SLEEP_MODE_IDLE); // Establecer el modo de bajo consumo
  sleep_enable();
  attachInterrupt(0, wakeUp, LOW);

  power_adc_disable();
  power_timer0_disable();
  power_timer1_disable();
  power_timer2_disable();
  power_twi_disable();
  WDTCSR |= _BV(WDIE);
  sleep_mode();                        // Entrar en modo de bajo consumo

  //El sistema continua la ejecución desde acá
  sleep_disable();

  power_all_enable();
  WDTCSR &= ~_BV(WDIE); 
}
