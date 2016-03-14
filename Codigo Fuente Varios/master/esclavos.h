#define CANTIDAD_ESCLAVOS 2

struct Esclavo{
  int temperaturaActual;
  bool estado;
  int potencia;
  uint64_t direccion;
};

Esclavo esclavos[CANTIDAD_ESCLAVOS];
