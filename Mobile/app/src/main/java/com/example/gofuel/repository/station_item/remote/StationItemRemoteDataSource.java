package com.example.gofuel.repository.station_item.remote;

import com.example.gofuel.model.station.StationItem;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station_item.IStationItemDataSource;

import java.util.List;

import retrofit2.Call;

public class StationItemRemoteDataSource implements IStationItemDataSource.Main {
    private final StationItemAPI stationItemAPI;

    public StationItemRemoteDataSource() {
        this.stationItemAPI = new HTTPClient<>(StationItemAPI.class).get();
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
}
