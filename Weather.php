<?php

/**
 * Class Weather
 */
class Weather {

    /**
     * Return the temperature in the city in metric system(celsius)
     *
     * @param $temp
     * @return mixed
     */
    public static function getTemperature($temp) {
        $output = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' . $temp . '&appid=b385aa7d4e568152288b3c9f5c2458a5&units=metric');
        $temp = json_decode($output, TRUE)['main']['temp'];

        return $temp;
    }

}
