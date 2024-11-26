package com.example.gofuel.util;

import java.text.ParseException;
import java.text.SimpleDateFormat;
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
}
