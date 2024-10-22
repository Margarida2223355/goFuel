package com.example.gofuel.view.components;

import static java.lang.Math.PI;
import static java.lang.Math.sin;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.ImageButton;

import com.example.gofuel.databinding.BottombarBinding;

import java.util.ArrayList;

public class MenuButtons {
    private BottombarBinding bottombarBinding;
    private ArrayList<ImageButton> menuButtons;

    public MenuButtons(Context context) {
        LayoutInflater inflater = LayoutInflater.from(context);
        bottombarBinding = BottombarBinding.inflate(inflater);
        menuButtons = new ArrayList<>();
    }

    public ArrayList<ImageButton> getMenuButtons() {
        FrameLayout frame = bottombarBinding.appMenu.getRoot();

        for(int i=0; i<frame.getChildCount(); i++) {
            menuButtons.add((ImageButton) frame.getChildAt(i));
        }

        return menuButtons;
    }

    public void animateButtons(Context context) {
        
    }
}
