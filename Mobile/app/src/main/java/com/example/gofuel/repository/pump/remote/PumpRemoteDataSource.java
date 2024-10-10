package com.example.gofuel.repository.pump.remote;

import com.example.gofuel.model.Pump;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.pump.IPumpDataSource;

import java.util.List;

import retrofit2.Call;

public class PumpRemoteDataSource implements IPumpDataSource.Main {
    private final PumpAPI pumpAPI;

    public PumpRemoteDataSource() {
        this.pumpAPI = new HTTPClient<>(PumpAPI.class).get();
    }

    // Method for local DB
    @Override
    public ResultWrapper<Pump> getCachedPump() {
        return null;
    }

    @Override
    public ResultWrapper<List<Pump>> getPumps() {
        Call<List<Pump>> call = pumpAPI.getPumps();
        return ResultWrapper.safeApiCall(call);
    }
}
