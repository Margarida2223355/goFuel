package com.example.gofuel.repository.station_item.remote;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.HeaderID;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station_item.IStationItemDataSource;

import java.util.List;

import retrofit2.Call;

public class StationItemRemoteDataSource implements IStationItemDataSource.Main {
    private final StationItemAPI stationItemAPI;

    public StationItemRemoteDataSource(Station station) {
        this.stationItemAPI = new HTTPClient<>(StationItemAPI.class, HeaderID.STATION_ID ,String.valueOf(station.getId())).get();
    }

    @Override
    public ResultWrapper<StationItem> getCachedItem() {
        return null;
    }

    @Override
    public ResultWrapper<List<StationItem>> getStationItems() {
        Call<List<StationItem>> call = stationItemAPI.getStationItems();
        return ResultWrapper.safeApiCall(call);
    }

    @Override
    public ResultWrapper<List<StationItem>> getStationItems(Station station) {
        return null;
    }
}
