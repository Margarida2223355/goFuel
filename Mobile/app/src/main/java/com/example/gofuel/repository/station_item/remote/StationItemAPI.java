package com.example.gofuel.repository.station_item.remote;

import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.station.StationItem;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface StationItemAPI {
    @GET("station-item")
    Call<List<StationItem>> getStationItems();
}
