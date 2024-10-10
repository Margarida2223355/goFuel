package com.example.gofuel.repository.pump.remote;


import com.example.gofuel.model.Pump;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface PumpAPI {
    @GET("pump")
    Call<List<Pump>> getPumps();
}