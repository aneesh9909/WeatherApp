<?php

namespace App\Http\Controllers;

use App\DataModels\NearbyPlacesDataModel;
use App\DataModels\WeatherDataModel;
use App\DataModels\ZipcodeDataModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string|mixed
     */
    private string $googleApiKey;
    /**
     * @var string|mixed
     */
    private string $openWeatherApiKey;

    /**
     *
     */
    public function __construct()
    {
        $this->googleApiKey = env('GOOGLE_APIKEY');
        $this->openWeatherApiKey = env('OPENWEATHER_APIKEY');
    }

    /**
     * Main function for "/" URL.
     * @throws Exception
     */
    public function home(Request $request)
    {
       if(!empty($request->zipcode)){
           //remove - from zipcode since it is common character. For all other non numberic character return error.
           $zipcode = str_replace('-','',$request->zipcode);

           $validator = Validator::make($request->all(),[
               'zipcode' => 'digits:7|numeric'
           ]);
           if($validator->fails())
               return redirect('/')->withErrors($validator->errors());

           try{
               $zipCodeModel = $this->geocodeCoordinates($zipcode);

               $nearbyPlaces = $this->getNearbyByPlaces($zipCodeModel);
               $zipCodeModel->setNearbyPlaces($nearbyPlaces);

               $nextThreeDaysWeather = $this->getNextThreeDaysWeather($zipCodeModel);

               foreach ($nextThreeDaysWeather as $day){
                   $weatherDataModel = new WeatherDataModel();
                   $weatherInfo = $day->weather[0];

                   $weatherDataModel->setDate(date('Y-m-d',$day->dt));
                   $weatherDataModel->setDayofWeek(Carbon::parse($day->dt)->format('l'));
                   $weatherDataModel->setWeatherText($weatherInfo->main);
                   $weatherDataModel->setIcon($weatherInfo->icon);
                   $weatherDataModel->setMin($day->temp->min);
                   $weatherDataModel->setMax($day->temp->max);

                   $zipCodeModel->setWeatherData($weatherDataModel); //this setter is array push
               }
           }catch (Exception $exception){
               abort(500);
           }
       }

        return view('home')->with('data',!empty($zipCodeModel) ? $zipCodeModel : '');
    }

    /**
     * Retrieve latitude and longitude from Google Geolocation API
     * @param string $zipcode
     * @return ZipcodeDataModel
     * @throws Exception
     */
    private function geocodeCoordinates(string $zipcode): ZipcodeDataModel
    {
        $zipCodeModel = new ZipcodeDataModel();
        $zipCodeModel->setZip($zipcode);

        $mapRequest = Http::get('https://maps.googleapis.com/maps/api/geocode/json',[
            'address' => $zipCodeModel->getZip().',jp', //append ,jp to search only Japan zipcodes
            'key' => $this->googleApiKey
        ]);

        if($mapRequest->status() != 200)
            throw new Exception('Failed to fetch geolocation');

        $location = json_decode($mapRequest->body())->results[0];
        $text = $location->address_components[3]->long_name.','.$location->address_components[2]->long_name.','.$location->address_components[1]->long_name; //parse address
        $zipCodeModel->setAddress($text);

        $coordinates = $location->geometry->location;
        $zipCodeModel->setLat($coordinates->lat);
        $zipCodeModel->setLng($coordinates->lng);

        return $zipCodeModel;
    }

    /**
     * Get weather of next 3 days using coordinates from OpenWeatherMap API
     * @param ZipcodeDataModel $zipCodeModel
     * @return Collection
     * @throws Exception
     */
    private function getNextThreeDaysWeather(ZipcodeDataModel $zipCodeModel): Collection
    {
        //onecall API requires a single call for all information but returns large volume of data. Take next 3 days.
        $request = Http::get('https://api.openweathermap.org/data/2.5/onecall',[
            'appid' => $this->openWeatherApiKey,
            'lat' => $zipCodeModel->getLat(),
            'lon' => $zipCodeModel->getLng(),
            'units' => 'metric',
            'exclude' => 'minutely,hourly' //do not fetch minutely and hourly data
        ]);

        if($request->status() != 200)
            throw new Exception('Failed to fetch weather data');
        $weatherData = json_decode($request->body())->daily;
        return collect($weatherData)->take(3);
    }

    /**
     * Use latitude and longitude to find nearby restaurants
     * @param ZipCodeDataModel $zipCodeModel
     * @return array|null
     * @throws Exception
     */
    private function getNearbyByPlaces(ZipcodeDataModel $zipCodeModel): ?array
    {
        $placeRequest = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json',[
            'location' => $zipCodeModel->getLat().','.$zipCodeModel->getLng(),
            'key' => $this->googleApiKey,
            'type' => 'restaurant',
            'radius' => 2000 //in meters
        ]);

        if($placeRequest->status() != 200)
            throw new Exception('Failed to fetch map');

        $nearbyPlaces = json_decode($placeRequest)->results;
        if(!empty($nearbyPlaces)){
            $places = [];
            $count = 0;
            foreach ($nearbyPlaces as $nearbyPlace){
                if($count > 4)
                    break;
                $nearbyPlaceModel =  new NearbyPlacesDataModel();
                $nearbyPlaceModel->setBusinessStatus($nearbyPlace->business_status);
                $nearbyPlaceModel->setName($nearbyPlace->name);
                $nearbyPlaceModel->setIconBgColour($nearbyPlace->business_status == 'OPERATIONAL' ? 'green' : 'red');
                $nearbyPlaceModel->setPhotoUrl($nearbyPlace->photos[0]->photo_reference);
                $nearbyPlaceModel->setPlaceid($nearbyPlace->place_id);
                $nearbyPlaceModel->setRatings(!empty($nearbyPlace->rating) ?  $nearbyPlace->rating : '- ');
                $nearbyPlaceModel->setVicinity(!empty($nearbyPlace->vicinity) ? $nearbyPlace->vicinity : '-');
                $nearbyPlaceModel->setUserRatingsTotal(!empty($nearbyPlace->user_ratings_total) ? $nearbyPlace->user_ratings_total : '-');
                array_push($places,$nearbyPlaceModel);
                $count++;
            }
            return $places;
        }
        return null;
    }
}
