<?php

namespace App\DataModels;

use Illuminate\Support\Facades\Date;


/**
 * Contains the weather information for a single day
 */
class WeatherDataModel
{
    /**
     * @var string
     */
    private string $date;

    /**
     * @var string
     */
    private string $dayofWeek;

    /**
     * Weather icon from OpenWeatherAPI
     * @var string
     */
    private string $icon;

    /**
     * @var string
     */
    private string $weatherText;

    /**
     * @var int
     */
    private int $min;

    /**
     * @var int
     */
    private int $max;


    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return WeatherDataModel
     */
    public function setDate(string $date): WeatherDataModel
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getDayofWeek(): string
    {
        return $this->dayofWeek;
    }

    /**
     * @param string $dayofWeek
     * @return WeatherDataModel
     */
    public function setDayofWeek(string $dayofWeek): WeatherDataModel
    {
        $this->dayofWeek = $dayofWeek;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getWeatherText(): string
    {
        return $this->weatherText;
    }

    /**
     * @param string $weatherText
     */
    public function setWeatherText(string $weatherText): void
    {
        $this->weatherText = $weatherText;
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @param int $min
     */
    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     */
    public function setMax(int $max): void
    {
        $this->max = $max;
    }

}
