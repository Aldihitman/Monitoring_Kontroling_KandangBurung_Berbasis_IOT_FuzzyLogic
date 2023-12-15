#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <DHT.h>
#include <Servo.h>


#define LAMPU_PIN  5 //D1
#define DHTPIN 4// D2
#define DHTTYPE DHT22
#define TRIG1 0 //D3
#define ECHO1 2 //D4
#define TRIG2 14 //D5
#define ECHO2 12 //D6
#define SERVO_PIN 13 //D7
#define POMPA_PIN 15 //D8
#define KIPAS_PIN 3 //RX

DHT dht(DHTPIN, DHTTYPE);
Servo servo;

const char* ssid = "KB16/17";
const char* pass = "mayonice123";
const char* host = "http://192.168.1.14";

long zero = 0;
long jeda = 5000;

void setup() {
  Serial.begin(9600);
  dht.begin();
  // Koneksi ke WiFi
  WiFi.begin(ssid, pass);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("TERHUBUNG");

  pinMode(TRIG1, OUTPUT);
  pinMode(ECHO1, INPUT);
  pinMode(TRIG2, OUTPUT);
  pinMode(ECHO2, INPUT);
  pinMode(POMPA_PIN, OUTPUT);
  pinMode(LAMPU_PIN, OUTPUT);
  pinMode(KIPAS_PIN, OUTPUT);
  
  // Inisialisasi servo
  servo.attach(SERVO_PIN);
}

int bacaJarak(int trigPin, int echoPin) {
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  int durasi = pulseIn(echoPin, HIGH);
  int jarak = durasi * 0.034 / 2;
  return jarak;
}

void loop() {
  float suhu = dht.readTemperature();
  int kelembapan = dht.readHumidity();
  int pakan = bacaJarak(TRIG1, ECHO1);
  int minum = bacaJarak(TRIG2, ECHO2);
  int posisiServo = servo.read();


  if (millis() - zero > jeda) {
    String URL = String("") + host + "/tugas_akhir/monitor/input.php?suhu=" + String(suhu) + "&kelembapan=" + String(kelembapan) + "&pakan=" + String(pakan) + "&minum=" + String(minum);
    Serial.println(URL);

    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(URL);
      int httpcode = http.GET();
      if (httpcode > 0) {
        String payload = http.getString();
        Serial.println(payload);
        delay(5000);
      }
      http.end();
    }
    zero = millis();
  }
  
  // Kontrol servo
  if (pakan > 15) {
    servo.write(180);  // Servo membuka
  } else {
    servo.write(0);  // Servo menutup
  }
  
  // Kontrol relay pompa
  if (minum > 10) {
    digitalWrite(POMPA_PIN, HIGH);  // Nyalakan pompa jika ketinggian rendah
  } else {
    digitalWrite(POMPA_PIN, LOW);  // Matikan pompa jika ketinggian cukup
  }
  
  // Kontrol relay lampu dan kipas
  if (suhu < 30) {
    digitalWrite(LAMPU_PIN, HIGH);  // Nyalakan lampu jika suhu rendah
    digitalWrite(KIPAS_PIN, LOW);   // Matikan kipas jika suhu rendah
  } else if(suhu > 32) {
    digitalWrite(LAMPU_PIN, LOW);   // Matikan lampu jika suhu tinggi
    digitalWrite(KIPAS_PIN, HIGH);  // Nyalakan kipas jika suhu tinggi
  }
  
  delay(15);  // Delay untuk stabilisasi servo, pompa, lampu, dan kipas

  //membaca sensor pada pakan
  Serial.print("Sisa Pakan : ");
  Serial.println(pakan);

  Serial.print("Sisa minum : ");
  Serial.println(minum);

  Serial.print("Suhu : ");
  Serial.println(suhu);
  delay(300);
}
