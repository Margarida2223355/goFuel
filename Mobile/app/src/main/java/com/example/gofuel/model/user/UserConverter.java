package com.example.gofuel.model.user;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class UserConverter {
    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromUser(User user) {
        return user == null ? null : gson.toJson(user);
    }

    @TypeConverter
    public static User toUser(String userJson) {
        return userJson == null ? null : gson.fromJson(userJson, User.class);
    }
}