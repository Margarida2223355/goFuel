package com.example.gofuel.model.item;

import androidx.room.TypeConverter;

import com.example.gofuel.model.station.Station;
import com.google.gson.Gson;

public class ItemConverter {
    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromItem(Item item) {
        return item == null ? null : gson.toJson(item);
    }

    @TypeConverter
    public static Item toItem(String itemJson) {
        return itemJson == null ? null : gson.fromJson(itemJson, Item.class);
    }
}