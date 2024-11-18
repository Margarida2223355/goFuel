package com.example.gofuel.model.station;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class StationConverter {
    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromStation(Station station) {
        return station == null ? null : gson.toJson(station);
    }

    @TypeConverter
    public static Station toStation(String stationJson) {
        return stationJson == null ? null : gson.fromJson(stationJson, Station.class);
    }
}