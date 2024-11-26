package com.example.gofuel.repository.client_station.remote;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.client_station.IClientStationDataSource;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.item.IItemDataSource;
import com.example.gofuel.repository.item.remote.ItemAPI;

import java.util.List;

import retrofit2.Call;

public class ClientStationRemoteDataSource implements IClientStationDataSource.Main {
    private final ClientStationAPI clientStationAPI;

    public ClientStationRemoteDataSource() {
        this.clientStationAPI = new HTTPClient<>(ClientStationAPI.class, MyApplication.getUser().getId()).get();
    }

    @Override
    public ResultWrapper<ClientStation> getCachedFavorite() {
        return null;
    }

    @Override
    public ResultWrapper<List<ClientStation>> getFavoriteStation() {
        Call<List<ClientStation>> call = clientStationAPI.getFavoriteStation();
        return ResultWrapper.safeApiCall(call);
    }
}
