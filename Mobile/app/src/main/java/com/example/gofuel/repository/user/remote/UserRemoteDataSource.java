package com.example.gofuel.repository.user.remote;

import com.example.gofuel.model.user.User;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.user.IUserDataSource;

import retrofit2.Call;

public class UserRemoteDataSource implements IUserDataSource.Main {
    private final UserAPI userAPI;

    public UserRemoteDataSource(String username, String password) {
        this.userAPI = new HTTPClient<>(UserAPI.class, username, password).get();
    }

    @Override
    public ResultWrapper<User> getCachedUser() {
        return null;
    }

    @Override
    public ResultWrapper<User> loginUser(String username, String password) {
        return null;
    }

    @Override
    public ResultWrapper<User> getUser() {
        Call<User> call = userAPI.getUser();
        return  ResultWrapper.safeApiCall(call);
    }
}
