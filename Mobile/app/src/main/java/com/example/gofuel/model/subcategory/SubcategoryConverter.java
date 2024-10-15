package com.example.gofuel.model.subcategory;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class SubcategoryConverter {
    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromSubcategory(Subcategory subcategory) {
        return subcategory == null ? null : gson.toJson(subcategory);
    }

    @TypeConverter
    public static Subcategory toSubcategory(String subcategoryJson) {
        return subcategoryJson == null ? null : gson.fromJson(subcategoryJson, Subcategory.class);
    }
}
