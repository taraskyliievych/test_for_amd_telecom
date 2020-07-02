<?php

/**
 * Class Weather
 */
class Weather {

    /**
     * Return the temperature in the city in metric system(celsius)
     *
     * @param $city
     * @param $appId
     * @return mixed
     */
    public static function getTemperature($city, $appId) {
        $output = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $appId);
        $temp = json_decode($output, TRUE)['main']['temp'];

        return $temp;
    }

}
