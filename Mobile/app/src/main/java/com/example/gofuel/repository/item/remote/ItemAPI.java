package com.example.gofuel.repository.item.remote;


import com.example.gofuel.model.item.Item;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface ItemAPI {
    @GET("item")
    Call<List<Item>> getItems();
}