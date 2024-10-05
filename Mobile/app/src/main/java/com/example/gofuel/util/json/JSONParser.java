package com.example.gofuel.util.json;

import android.os.Build;

import androidx.annotation.RequiresApi;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.time.LocalDateTime;

@RequiresApi(api = Build.VERSION_CODES.O)
public class JSONParser<T> {

    public static Gson getGson() {
        GsonBuilder gsonBuilder = new GsonBuilder();
        gsonBuilder.registerTypeAdapter(LocalDateTime.class, new LocalDateTimeDeserializer());
        return gsonBuilder.create();
    }

    public T deserialize(String json, Class<T> target) {
        Gson gson = getGson();
        return gson.fromJson(json, target);
    }
}
