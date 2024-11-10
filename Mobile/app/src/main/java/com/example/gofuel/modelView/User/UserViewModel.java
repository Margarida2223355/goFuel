package com.example.gofuel.modelView.User;

import android.util.Log;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.user.UserRepository;
import com.example.gofuel.util.State;

import java.util.List;

public class UserViewModel {
    private final UserRepository userRepository;

    public UserViewModel() {
        this.userRepository = UserRepository.getInstance(MyApplication.getAppContext());
    }

    public void login(String username, String password, LoginCallback callback) {
        new Thread(() -> {
            ResultWrapper<User> result = userRepository.loginUser(username, password);

            if (result.getResult() != null) {
                callback.onSuccess(result.getResult());
            } else {
                callback.onError(result.getError());
            }
        }).start();
    }
}
