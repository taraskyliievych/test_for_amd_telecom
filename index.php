<?php
header('Content-type: application/json');

require 'Weather.php';
require 'Routee.php';

$temp = Weather::getTemperature('Thessaloniki', 'b385aa7d4e568152288b3c9f5c2458a5');

if (empty($temp)) {
    return;
}

if ($temp > 20) {
    $messageText = 'Your name and Temperature more than 20C. ' . $temp . 'C';
} else {
    $messageText = 'Your name and Temperature less than 20C. ' . $temp . 'C';
}

$phoneNumber = '+30  6948872100';

//This script is executed every 10 minutes if we use cron job
$routeeResponse = Routee::sendSMS('57cd83a3e4b0464b9119ba46', 'OXr7WYcP9A', $phoneNumber, $messageText);

echo json_encode(['result_text' => $messageText, 'routee_response' => $routeeResponse]);
