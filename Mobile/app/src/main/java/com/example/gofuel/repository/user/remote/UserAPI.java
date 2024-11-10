package com.example.gofuel.repository.user.remote;

import com.example.gofuel.model.user.User;

import retrofit2.Call;
import retrofit2.http.GET;

public interface UserAPI {
    @GET("user/login")
    Call<User> getUser();
}
