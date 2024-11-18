package com.example.gofuel;

import android.app.Application;
import android.content.Context;

import com.example.gofuel.model.user.User;
import com.example.gofuel.view.components.MenuButtons;

public class MyApplication extends Application {
    private static MyApplication instance;
    private static MenuButtons menuButtons;
    private static User userlogged;

    public static Context getAppContext() {
        return instance.getApplicationContext();
    }

    public static MenuButtons getMenuButtonsInstance(Context context) {
        if (menuButtons == null) {
            menuButtons = new MenuButtons(context);
        }
        return menuButtons;
    }

    public static void setUser(User user) {
        userlogged = user;
    }

    public static User getUser() {
        return userlogged;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        instance = this;
    }
}
