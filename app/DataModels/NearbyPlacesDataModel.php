<?php

namespace App\DataModels;


/**
 * Information about restaurants near the input Zipcode
 */
class NearbyPlacesDataModel
{
    /**
     * Determine whether business is open or closed.
     * @var string
     */
    private string $business_status;

    /**
     * status open -> green , closed -> red
     * @var string
     */
    private string $icon_bg_colour;

    /**
     * Name of the business
     * @var string
     */
    private string $name;

    /**
     * Image of the business from google
     * @var string
     */
    private string $photo_url;

    /**
     * Average user ratings
     * @var string
     */
    private string $ratings;

    /**
     * Total number of user ratings
     * @var string
     */
    private string $user_ratings_total;

    /**
     * Simplified address from Google Maps
     * @var string
     */
    private string $vicinity;

    /**
     * Place id on Google Places API
     * @var string
     */
    private string $place_id;

    /**
     * @return string
     */
    public function getPlaceid(): string
    {
        return $this->place_id;
    }

    /**
     * @param string $place_id
     * @return NearbyPlacesDataModel
     */
    public function setPlaceid(string $place_id): NearbyPlacesDataModel
    {
        $this->place_id = $place_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getVicinity(): string
    {
        return $this->vicinity;
    }

    /**
     * @param string $vicinity
     * @return NearbyPlacesDataModel
     */
    public function setVicinity(string $vicinity): NearbyPlacesDataModel
    {
        $this->vicinity = $vicinity;
        return $this;
    }


    /**
     * @return string
     */
    public function getRatings(): string
    {
        return $this->ratings;
    }

    /**
     * @param string $ratings
     * @return NearbyPlacesDataModel
     */
    public function setRatings(string $ratings): NearbyPlacesDataModel
    {
        $this->ratings = $ratings;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserRatingsTotal(): string
    {
        return $this->user_ratings_total;
    }

    /**
     * @param string $user_ratings_total
     * @return NearbyPlacesDataModel
     */
    public function setUserRatingsTotal(string $user_ratings_total): NearbyPlacesDataModel
    {
        $this->user_ratings_total = $user_ratings_total;
        return $this;
    }

    /**
     * @return string
     */
    public function getBusinessStatus(): string
    {
        return $this->business_status;
    }

    /**
     * @param string $business_status
     * @return NearbyPlacesDataModel
     */
    public function setBusinessStatus(string $business_status): NearbyPlacesDataModel
    {

        $this->business_status = ($business_status == 'OPERATIONAL') ? 'Open' : 'Closed Temporarily';
        return $this;
    }

    /**
     * @return string
     */
    public function getIconBgColour(): string
    {
        return $this->icon_bg_colour;
    }

    /**
     * @param string $icon_bg_colour
     * @return NearbyPlacesDataModel
     */
    public function setIconBgColour(string $icon_bg_colour): NearbyPlacesDataModel
    {
        $this->icon_bg_colour = $icon_bg_colour;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return NearbyPlacesDataModel
     */
    public function setName(string $name): NearbyPlacesDataModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoUrl(): string
    {
        return $this->photo_url;
    }

    /**
     * @param string $photo_url
     * @return NearbyPlacesDataModel
     */
    public function setPhotoUrl(string $photo_url): NearbyPlacesDataModel
    {
        $this->photo_url = $photo_url;
        return $this;
    }


}
