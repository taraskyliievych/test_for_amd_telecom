<?php

/**
 * Class Routee
 */
class Routee {

    /**
     * Get Authenticated
     *
     * @param $applicationID
     * @param $applicationSecret
     * @return mixed|string
     */
    private static function getAuthenticated($applicationID, $applicationSecret) {
        $authorizationData = base64_encode($applicationID . ':' . $applicationSecret);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://auth.routee.net/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => [
                'authorization: Basic ' . $authorizationData,
                'content-type: application/x-www-form-urlencoded'
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            return json_decode($response, TRUE);
        }
    }

    /**
     * Send sms message
     *
     * @param $applicationID
     * @param $applicationSecret
     * @param $phoneNumber
     * @param $messageText
     * @return bool|string
     */
    public static function sendSMS($applicationID, $applicationSecret, $phoneNumber, $messageText) {
        $authorizationOutput= self::getAuthenticated($applicationID, $applicationSecret);

        if (empty($authorizationOutput['access_token'])) {
            return 'Something wrong with Routee credential.';
        }

        $accessTokenWithType = 'Bearer ' . $authorizationOutput['access_token'];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://connect.routee.net/sms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => '{"body": "' . $messageText .'","to" : "' . $phoneNumber . '","from": "amdTelecom"}',
            CURLOPT_HTTPHEADER => [
                'authorization:' . $accessTokenWithType,
                'content-type: application/json'
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return 'cURL Error #:' . $err;
        } else {
            return $response;
        }
    }

}
