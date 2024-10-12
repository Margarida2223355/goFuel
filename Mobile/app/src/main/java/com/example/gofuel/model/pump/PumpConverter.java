package com.example.gofuel.model.pump;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class PumpConverter {
    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromPump(Pump pump) {
        return pump == null ? null : gson.toJson(pump);
    }

    @TypeConverter
    public static Pump toPump(String pumpJson) {
        return pumpJson == null ? null : gson.fromJson(pumpJson, Pump.class);
    }
}