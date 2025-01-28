package com.example.gofuel.util;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;

import com.example.gofuel.MyApplication;
import com.example.gofuel.R;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Base64;
import java.util.Locale;

public class Util {
    public static String convertToData(String data) {
        SimpleDateFormat inputFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault());
        SimpleDateFormat outputFormat = new SimpleDateFormat("dd/MM/yyyy", Locale.getDefault());

        try {
            return outputFormat.format(inputFormat.parse(data));
        }
        catch (ParseException e) {
            return "Data Inválida: " + e.getMessage();
        }
    }

    public static Bitmap convertToImage(String image) {
        try {
            byte[] decodedBytes = Base64.getDecoder().decode(image);
            return BitmapFactory.decodeByteArray(decodedBytes, 0, decodedBytes.length);
        }
        catch (IllegalArgumentException e) {
            e.printStackTrace();
            return BitmapFactory.decodeResource(MyApplication.getAppContext().getResources(), R.drawable.item);
        }
    }
}
