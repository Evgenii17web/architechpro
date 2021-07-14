@extends('layout')

@section('title')
    Weather in {{$title}}
@endsection

@section('main_content')
    <h1>Weather in {{$title}}</h1>
    <div class="weather-block">
        <div class="weather-block__geo">
            <p class="weather-block__degrees">{{$temperature}}&deg;</p>
            <p class="weather-block__city">{{$title}}</p>
        </div>
        <div class="weather-block__feeling">
            <img src="{{asset("images/$icon")}}" alt="icon">
            <div class="weather-block__precipitation">
                <div class="weather-block__mercury-column">
                    <img src="{{asset('images/drops.svg')}}" alt="#">
                    <div class="info">
                        <p class="value">{{$humidity}}</p>
                        <p class="quantity">mm</p>
                    </div>
                </div>
                <div class="weather-block__wind">
                    <img src="{{asset('images/wind.svg')}}" alt="#">
                    <div class="info">
                        <p class="value">{{$windSpeed}}</p>
                        <p class="quantity">mph</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

