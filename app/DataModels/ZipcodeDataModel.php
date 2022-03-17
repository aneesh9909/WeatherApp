<?php

namespace App\DataModels;


/**
 * Super Model containing all the information required to be displayed.
 */
class ZipcodeDataModel
{
    /**
     * User input zipcode
     * @var int
     */
    private int $zip;

    /**
     * Location address as parsed from Google Geolocation API
     * @var string
     */
    private string $address;

    /**
     * Collection of @WeatherDataModel objects
     * @var array
     */
    private array $weatherData = [];

    /**
     * Latitude from Geolocation API
     * @var float
     */
    private float $lat;

    /**
     * Longitude from Geolocation API
     * @var float
     */
    private float $lng;

    /**
     * Collection of @NearbyPlacesDataModel
     * @var array
     */
    private array $nearbyPlaces = [];

    /**
     * @return array
     */
    public function getNearbyPlaces(): array
    {
        return $this->nearbyPlaces;
    }

    /**
     * @param array $nearbyPlaces
     * @return ZipcodeDataModel
     */
    public function setNearbyPlaces(array $nearbyPlaces): ZipcodeDataModel
    {
        $this->nearbyPlaces = $nearbyPlaces;
        return $this;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return ZipcodeDataModel
     */
    public function setLat(float $lat): ZipcodeDataModel
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     * @return ZipcodeDataModel
     */
    public function setLng(float $lng): ZipcodeDataModel
    {
        $this->lng = $lng;
        return $this;
    }


    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return ZipcodeDataModel
     */
    public function setAddress(string $address): ZipcodeDataModel
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int
     */
    public function getZip(): int
    {
        return $this->zip;
    }

    /**
     * @param int $zip
     * @return ZipcodeDataModel
     */
    public function setZip(int $zip): ZipcodeDataModel
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return array
     */
    public function getWeatherData(): array
    {
        return $this->weatherData;
    }

    /**
     * @param WeatherDataModel $weatherData
     * @return ZipcodeDataModel
     * @note This is not an assignment setter. Performs array push.
     */
    public function setWeatherData(WeatherDataModel $weatherData): ZipcodeDataModel
    {
        $this->weatherData[] = $weatherData;
        return $this;
    }
}
