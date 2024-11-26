package com.example.gofuel.repository.client_station.remote;

import com.example.gofuel.model.client_station.ClientStation;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface ClientStationAPI {
    @GET("client-station")
    Call<List<ClientStation>> getFavoriteStation();
}
