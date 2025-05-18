#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>

#define SS_PIN  5  // D8
#define RST_PIN 2  // D3
#define BUZZER   2
const int ledPin = 13;

// Create MFRC522 instance
MFRC522 mfrc522(SS_PIN, RST_PIN);

// WiFi credentials
const char *ssid = "Wifi SSID";
const char *password = "Wifi Password";

// Array of device tokens
const char* device_tokens[] = {
    "feeb7b55697b5855"  // Add more tokens as needed
    //"",
    //"",
    //""
};
const int numTokens = sizeof(device_tokens) / sizeof(device_tokens[0]);

// Server URL
String URL = "http://Private_IP_address/rfidattendance/getdata.php";

// Array to store scanned Card IDs
String scannedCardIDs[25];  // Adjust the size depending on your needs
int scannedCount = 0;  // Counter for scanned cards
unsigned long previousMillis = 0;

void setup() {
    Serial.begin(115200);
    pinMode(ledPin, OUTPUT);
    pinMode(BUZZER, OUTPUT);
    SPI.begin();  // Init SPI bus
    mfrc522.PCD_Init(); // Init MFRC522 card
    connectToWiFi();
}

void loop() {
    // Check if there's a connection to Wi-Fi or not
    if (!WiFi.isConnected()) {
        connectToWiFi();    // Retry to connect to Wi-Fi
    }

    // Clear scanned IDs after a certain period
    if (millis() - previousMillis >= 15000) {
        previousMillis = millis();
        scannedCount = 0;  // Reset count
    }

    // Look for new card
    if (!mfrc522.PICC_IsNewCardPresent()) {
        return; // Go to start of loop if there is no card present
    }

    // Select one of the cards
    if (!mfrc522.PICC_ReadCardSerial()) {
        return; // If read card serial fails, exit
    }

    String CardID = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
        CardID += mfrc522.uid.uidByte[i];
    }

    // Check if the card has already been scanned
    for (int i = 0; i < scannedCount; i++) {
        if (scannedCardIDs[i] == CardID) {
            return; // Card has already been processed
        }
    }

    // Store the new Card ID
    if (scannedCount < 10) {  // Prevent overflow
        scannedCardIDs[scannedCount++] = CardID;  // Add card to the list
    } else {
        // Optionally handle overflow, e.g., reset or shift out the oldest ID
        scannedCount = 0; // Reset for simplicity; you can implement more complex logic if needed
    }

    // Send Card ID to the server with a device token
    for (int i = 0; i < numTokens; i++) {
        SendCardID(CardID, device_tokens[i]);  // Send each token with the Card ID
    }

    // Activate buzzer and LED
    digitalWrite(ledPin, HIGH);
    digitalWrite(BUZZER, HIGH);
    delay(3500);
    digitalWrite(ledPin, LOW);
    digitalWrite(BUZZER, LOW);
  
}

// Send the Card UID and device token to the website
void SendCardID(String Card_uid, const char* device_token) {
    Serial.println("Sending the Card ID");
    if (WiFi.isConnected()) {
        HTTPClient http;    // Declare object of class HTTPClient
        String getData = "?card_uid=" + Card_uid + "&device_token=" + String(device_token); // Prepare GET data
        String Link = URL + getData; // Complete URL

        http.begin(Link); // Initiate HTTP request

        int httpCode = http.GET();   // Send the request
        String payload = http.getString();    // Get the response payload

        Serial.println(httpCode);   // Print HTTP return code
        Serial.println(Card_uid);    // Print Card ID
        Serial.println("Server Response: Allowed"); // Improved logging

        if (httpCode == 200) {
            if (payload.substring(0, 5) == "login") {
                String user_name = payload.substring(5);
                Serial.println("Logged in user: " + user_name);
            } else if (payload.substring(0, 6) == "logout") {
                String user_name = payload.substring(6);
                Serial.println("Logged out user: " + user_name);
            } else if (payload == "successful") {
                Serial.println("Attendance recorded successfully.");
            } else if (payload == "available") {
                Serial.println("Card is available for use.");
            } else if (payload == "Not Allowed!") {
                Serial.println("Card ID is matched.");
            }
        } else {
            Serial.println("HTTP request failed.");
        }

        http.end();  
    }
}

// Connect to the WiFi
void connectToWiFi() {
    WiFi.mode(WIFI_OFF);  
    delay(1000);
    WiFi.mode(WIFI_STA);
    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
  
    Serial.println("\nConnected");
    delay(1000);
}
