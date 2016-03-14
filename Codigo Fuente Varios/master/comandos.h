#ifndef _COMANDOS_H
#define _COMANDOS_H

//Comandos posibles
enum Comando {
  SET_TEMP = 0x01,
  RES_TEMP = 0x03,
  
  SET_ESTADO = 0x11,
  RES_ESTADO = 0x13,

  RES_POT = 0x23,
  
  REQ_ENUM = 0x32,
  RES_ENUM = 0x33,

  REQ_ALL = 0xF2,
  
  CMD_NOP = 0xFF
};

#endif
