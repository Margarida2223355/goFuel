package com.example.gofuel.repository.common;

import android.content.Context;

import com.example.gofuel.util.Constants;

import java.nio.charset.StandardCharsets;
import java.util.Base64;
import java.util.Locale;
import java.util.concurrent.TimeUnit;

import okhttp3.Interceptor;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class HTTPClient<T> {
    //region Properties
    public static String credentials = null;
    private T client;
    //endregion

    public HTTPClient(Class<T> serviceClass, String username, String password) {
        setBasicAuthCredentials(username, password);

        // Configure OkHttpClient
        OkHttpClient.Builder httpClientBuider = new OkHttpClient.Builder();

        // Interceptor to add headers to all requests
        Interceptor defaultInterceptor = chain -> {
            Request original = chain.request();
            Request.Builder requestBuilder = original.newBuilder()
                    .header(Constants.HEADER_PARAMETER_ACCEPT, "application/json")
                    .header(Constants.HEADER_PARAMETER_LANG, Locale.getDefault().toString())
                    .header(Constants.HEADER_PARAMETER_CLIENT,"Mobile");

            if (credentials != null) { requestBuilder.header(Constants.HEADER_PARAMETER_AUTHORIZATION, "Basic " + credentials); }

            Request request = requestBuilder.build();

            return chain.proceed(request);
        };

        httpClientBuider.addInterceptor(defaultInterceptor);

        // Configure timeout for conection and reading
        httpClientBuider.connectTimeout(Constants.CALL_TIME_OUT, TimeUnit.SECONDS);
        httpClientBuider.readTimeout(Constants.CALL_TIME_OUT, TimeUnit.SECONDS);

        // Build OkHttpClient
        OkHttpClient httpClient = httpClientBuider.build();

        // Configure Retrofit with Gson and HttpClient configured
        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl(Constants.BASE_URL)
                .client(httpClient)
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        // Create an instance of API
        client = retrofit.create(serviceClass);
    }

    public T get() {
        return client;
    }

    public static void setBasicAuthCredentials(String username, String password) {
        credentials = Base64.getEncoder().encodeToString((username + ":" + password).getBytes(StandardCharsets.UTF_8));
    }
}
