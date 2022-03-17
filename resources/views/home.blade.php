<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weather App</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #04AA6D;
        }

        button {
            background-color: white;
            color: black;
            border: 1px solid #4CAF50;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        button:hover {
            background-color: #2868f9;
            color: white;
        }

        input[type=text], select {
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Float 3 columns side by side */
        .column {
            float: left;
            width: 33%;
            padding: 0 10px;
        }

        /* Remove extra left and right margins, due to padding */
        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive columns */
        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }

        /* Style the counter cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;
        }

        /* Responsive columns */
        @media screen and (max-width: 600px) {
            .column2 {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }

        /* Float 2 columns side by side */
        .column2 {
            float: left;
            width: 40%;
            padding: 0 10px;
            margin: 20px;
        }

        /* Style the counter cards */
        .card2 {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;
            height: 450px;
        }
    </style>
</head>
<body>
<div id="main" style="text-align: center;margin-top: 5%">
    <div>
        <form action="{{ route('home') }}" method="get">
            <label>
                Post Code :
                <input id="zipcode" name="zipcode" type="text" value="{{ !empty($data) ? $data->getZip() : '' }}">
                <button type="submit">Submit</button>
            </label>
        </form>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red">{{ $error }}</p>
            @endforeach
        @endif
        <br>
        @if(!empty($data))
            <div>
                <label>{{ $data->getAddress() }}</label>
            </div>
            <div>
                <div>
                    <br>
                    <label>3 day forecast</label>
                    <div class="row" style="margin-top: 25px">
                        @foreach($data->getWeatherData() as $day)
                            <div class="column">
                                <div class="card">
                                    <img id="weatherIcon"
                                         src="http://openweathermap.org/img/w/{{ $day->getIcon() }}.png"
                                         alt="Weather icon" style="width: 100px">
                                    <p>{{ $day->getDate() }} &nbsp; {{ $day->getDayofWeek() }}</p>
                                    <p>{{ $day->getWeatherText() }}</p>
                                    <p>Max : {{ $day->getMax() }}°C &nbsp; Min : {{ $day->getMin() }}°C</p>
                                </div>
                            </div>
                        @endforeach
                        <div style="text-align: center; padding: 10%">
                            <div class="column2">
                                <p>Map</p>
                                <div class="card2">
                                    <iframe id="map_canvas" name="map_canvas" width="100%" height="425px"
                                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAPiSqz8ZW2bOwV31gjsZSzblwJGUJAmpc&q={{$data->getZip()}},jp">
                                    </iframe>
                                </div>
                            </div>
                            <div class="column2" style="width: 50%">
                                <p>Nearby Restaurants</p>
                                <div class="card2" style="overflow-y:auto;">
                                    @foreach($data->getNearbyPlaces() as $place)
                                        <div style="margin-bottom: 50px">
                                            <p style="margin: 10px;font-size: 18px;font-weight: bold">{{ $place->getName() }}</p>
                                            <div style="display: flex">
                                                <img alt="alt"
                                                     src="{{"https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=".$place->getPhotoUrl()."&key=AIzaSyAPiSqz8ZW2bOwV31gjsZSzblwJGUJAmpc"}}">
                                                <div style="text-align: left;margin: 10px;">
                                                    <p style="color: {{$place->getIconBgColour()}};font-size: 16px">{{ $place->getBusinessStatus() }}</p>
                                                    <p>Average user rating : {{ $place->getRatings() }}/5</p>
                                                    <p>Total number of user ratings
                                                        : {{ $place->getUserRatingsTotal() }}</p>
                                                    <p>Address : {{ $place->getVicinity() }}</p>
                                                    <p>
                                                        <a href="https://www.google.com/maps/search/?api=1&query=Google&query_place_id={{ $place->getPlaceid() }}"
                                                           target="_blank">View details on Google Maps</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endif
</body>
</html>
