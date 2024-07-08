<?php

class EasyBrokerClient {
    private $apiUrl = 'https://api.stagingeb.com/v1/properties';
    private $apiKey = 'tu_api_key'; // Reemplazar con la clave API correcta

    public function fetchProperties() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Authorization: ' . $this->apiKey,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            throw new Exception('Error al obtener propiedades: ' . $httpCode);
        }

        return json_decode($response, true)['content'];
    }

    public function printTitles() {
        $properties = $this->fetchProperties();
        foreach ($properties as $property) {
            echo $property['title'] . "\n";
        }
    }
}

// Ejemplo de uso
try {
    $client = new EasyBrokerClient();
    $client->printTitles();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
