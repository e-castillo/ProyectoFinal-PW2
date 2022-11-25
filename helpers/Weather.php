<?php

class Weather
{
    private $configuration;
    private $temperature;

    public function __construct()
    {
        $cache_file = 'data.json';
        if (file_exists($cache_file)) {
            $dat = json_decode(file_get_contents($cache_file));
        } else {
            $api_url = 'https://content.api.nytimes.com/svc/weather/v2/current-and-seven-day-forecast.json';
            $dat = file_get_contents($api_url);
            file_put_contents($cache_file, $dat);
            $dat = json_decode($dat);
        }
        $this->configuration = $dat;

        //tempratura maxima y minima
        $apiKey = "200089269b0c6fe7b4c432e107949272";
        $cityId = "3433955";
        $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        $this->temperature = json_decode($response);
    }

    public function getDayWeather()
    {
        return $this->configuration->results->current[0];
    }

    public function getWeekWeather()
    {

        return $this->configuration->results->seven_day_forecast;
    }

    public function getTemperatura()
    {
        return $this->temperature->main->temp;
    }

    public function detailsTemperature()
    {
        return $this->temperature;
    }

    public function getCelciusTempDay()
    {

        $celciusTemp = number_format((float)(($this->configuration->results->current[0]->temp - 32) / 1.75), 1, '.', '');
        return $celciusTemp;
    }
}