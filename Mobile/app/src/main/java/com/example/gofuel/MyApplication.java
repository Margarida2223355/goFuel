package com.example.gofuel;

import android.app.Application;
import android.content.Context;

import com.example.gofuel.view.components.MenuButtons;

public class MyApplication extends Application {
    private static MyApplication instance;
    private static MenuButtons menuButtons;

    public static Context getAppContext() {
        return instance.getApplicationContext();
    }

    public static MenuButtons getMenuButtonsInstance(Context context) {
        if (menuButtons == null) {
            menuButtons = new MenuButtons(context);
        }
        return menuButtons;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        instance = this;
    }
}
