package com.example.gofuel.modelView.User;

import com.example.gofuel.model.user.User;

public interface LoginCallback {
    void onSuccess(User user);
    void onError(String error);
}
