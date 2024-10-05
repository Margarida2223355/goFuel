package com.example.gofuel.repository.station.remote;

import com.example.gofuel.model.Station;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.station.IStationDataSource;

import java.util.List;

import retrofit2.Call;

public class StationRemoteDataSource implements IStationDataSource.Main {
    private final StationAPI stationAPI;

    public StationRemoteDataSource() {
        this.stationAPI = new HTTPClient<>(StationAPI.class).get();
    }

    // Method for local DB
    @Override
    public ResultWrapper<Station> getCachedStation() {
        return null;
    }

    @Override
    public ResultWrapper<List<Station>> getStations() {
        Call<List<Station>> call = stationAPI.getStations();
        return ResultWrapper.safeApiCall(call);
    }
}
