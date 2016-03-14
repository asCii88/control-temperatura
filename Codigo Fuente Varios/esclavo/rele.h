byte RELEPIN = 5;

void inicializarRele() {
  pinMode(RELEPIN, OUTPUT);
  digitalWrite(RELEPIN, HIGH);
}

void encenderRele() {
  digitalWrite(RELEPIN, LOW);
}

void apagarRele() {
  digitalWrite(RELEPIN, HIGH);
}

