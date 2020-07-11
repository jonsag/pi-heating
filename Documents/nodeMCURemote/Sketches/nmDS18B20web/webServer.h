#include <ESPAsyncTCP.h> // library found at https://github.com/me-no-dev/ESPAsyncTCP
#include <ESPAsyncWebServer.h> // library found at https://github.com/me-no-dev/ESPAsyncWebServer

// Create AsyncWebServer object on port 8081
AsyncWebServer server(serverPort);

const char* PARAM_MESSAGE = "id";

void notFound(AsyncWebServerRequest *request) {
  request->send(404, "text/plain", "404: Not found");
}

const char index_html[] PROGMEM = R"rawliteral(
<!DOCTYPE HTML><html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <style>
    html {
     font-family: Arial;
     display: inline-block;
     margin: 0px auto;
     text-align: center;
    }
    h2 { font-size: 3.0rem; }
    p { font-size: 3.0rem; }
    .units { font-size: 1.2rem; }
    .dht-labels{
      font-size: 1.5rem;
      vertical-align:middle;
      padding-bottom: 15px;
    }
  </style>
</head>
<body>
  <h2>ESP8266 DHT Server</h2>
  <p>
    <i class="fas fa-thermometer-half" style="color:#059e8a;"></i> 
    <span class="dht-labels">Temperature</span> 
    <span id="temperature">%TEMPERATURE%</span>
    <sup class="units">&deg;C</sup>
  </p>
  <p>
    <i class="fas fa-tint" style="color:#00add6;"></i> 
    <span class="dht-labels">Humidity</span>
    <span id="humidity">%HUMIDITY%</span>
    <sup class="units">%</sup>
  </p>
</body>
<script>
setInterval(function ( ) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("temperature").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "/temperature", true);
  xhttp.send();
}, 10000 );

setInterval(function ( ) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("humidity").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "/humidity", true);
  xhttp.send();
}, 10000 ) ;
</script>
</html>)rawliteral";

String processor(const String& var) { // replaces placeholder with sensor values
  //Serial.println(var);
  if (var == "TEMPERATURE") {
    //return String(t);
  }
  else if (var == "HUMIDITY") {
    //return String(h);
  }
  return String();
}

void initiateServer() {
  // Route for root / web page
  server.on("/", HTTP_GET, [](AsyncWebServerRequest * request) {
    request->send_P(200, "text/html", index_html);
  });

  server.on("/count.php", HTTP_GET, [](AsyncWebServerRequest * request) {
    request->send_P(200, "text/plain", String(sizeof(deviceAddresses) / sizeof(deviceAddresses[0])).c_str());
  });

  // Send a GET request to <IP>/get?message=<message>
  server.on("/name.php", HTTP_GET, [] (AsyncWebServerRequest * request) {
    String message;
    if (request->hasParam(PARAM_MESSAGE)) {
      message = request->getParam(PARAM_MESSAGE)->value();
    } else {
      message = "No message sent";
    }
    //request->send(200, "text/plain", "Hello, GET: " + message);
    if (message.toInt() > sizeof(deviceAddresses) / sizeof(deviceAddresses[0]) || (message.toInt() <= 0)) {
      request->send(404, "text/plain", "404: Not found");
    } else {
      request->send(200, "text/plain", String(deviceNames[message.toInt() - 1]).c_str());
    }
  });
  
    server.on("/value.php", HTTP_GET, [] (AsyncWebServerRequest * request) {
      String message;
      if (request->hasParam(PARAM_MESSAGE)) {
        message = request->getParam(PARAM_MESSAGE)->value();
      } else {
        message = "No message sent";
      }
      if (message.toInt() > sizeof(deviceAddresses) / sizeof(deviceAddresses[0]) || (message.toInt() <= 0)) {
      request->send(404, "text/plain", "404: Not found");
    } else {
      request->send(200, "text/plain", String(readTemp(message.toInt() - 1)));
    }
    });
  
  server.onNotFound(notFound);

  // Start server
  server.begin();

  Serial.print("Web server started at port: ");
  Serial.println(serverPort);
  Serial.println();

}
