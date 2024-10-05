package com.example.gofuel.repository.station.remote;

import com.example.gofuel.model.Station;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface StationAPI {
    @GET("station")
    Call<List<Station>> getStations();
}
