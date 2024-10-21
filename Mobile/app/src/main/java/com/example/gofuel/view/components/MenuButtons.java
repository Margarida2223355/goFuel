package com.example.gofuel.view.components;

import android.content.Context;
import android.view.LayoutInflater;
import android.widget.FrameLayout;
import android.widget.ImageButton;

import com.example.gofuel.databinding.BottombarBinding;

import java.util.ArrayList;

public class MenuButtons {
    private BottombarBinding bottombarBinding;
    private FrameLayout menuButtons;

    public MenuButtons(Context context) {
        LayoutInflater inflater = LayoutInflater.from(context);
        bottombarBinding = BottombarBinding.inflate(inflater);

        menuButtons = bottombarBinding.appMenu.getRoot();
    }

    public ArrayList<ImageButton> getMenuButtons() {
        ArrayList<ImageButton> buttons = new ArrayList<>();

        for(int i=0; i<menuButtons.getChildCount(); i++) {
            buttons.add((ImageButton) menuButtons.getChildAt(i));
        }

        return buttons;
    }
}
