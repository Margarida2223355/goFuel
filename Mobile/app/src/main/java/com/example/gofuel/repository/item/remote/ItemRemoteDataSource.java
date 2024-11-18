package com.example.gofuel.repository.item.remote;

import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.item.IItemDataSource;

import java.util.List;

import retrofit2.Call;

public class ItemRemoteDataSource implements IItemDataSource.Main {
    private final ItemAPI itemAPI;

    public ItemRemoteDataSource() {
        this.itemAPI = new HTTPClient<>(ItemAPI.class, null, null).get();
    }

    // Method for local DB
    @Override
    public ResultWrapper<Item> getCachedItem() {
        return null;
    }

    @Override
    public ResultWrapper<List<Item>> getItems() {
        Call<List<Item>> call = itemAPI.getItems();
        return ResultWrapper.safeApiCall(call);
    }
}
