package com.example.gofuel.model.category;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class CategoryConverter {
    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromCategory(Category category) {
        return category == null ? null : gson.toJson(category);
    }

    @TypeConverter
    public static Category toCategory(String categoryJson) {
        return categoryJson == null ? null : gson.fromJson(categoryJson, Category.class);
    }
}
