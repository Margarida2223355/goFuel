package com.example.gofuel.view.components;

import static java.lang.Math.PI;
import static java.lang.Math.cos;
import static java.lang.Math.sin;

import android.content.Context;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.ImageButton;

import com.example.gofuel.databinding.ActivityHomeBinding;

import java.util.ArrayList;

public class MenuButtons {
    private ArrayList<ImageButton> menuButtons;
    private boolean menuOpen;

    public MenuButtons(Context context) {
        menuButtons = new ArrayList<>();
        menuOpen = false;
    }

    public ArrayList<ImageButton> getMenuButtons(ActivityHomeBinding binding) {
        FrameLayout frame = binding.bottombar.appMenu.getRoot();

        for(int i=0; i<frame.getChildCount(); i++) {
            menuButtons.add((ImageButton) frame.getChildAt(i));
        }

        return menuButtons;
    }

    public void animateButtons(View view) {
        // Get menu button position Y
        float y = view.getY();

        // Circle radius for buttons
        float r = 1.5F * view.getWidth();

        int i=0;

        if (menuOpen) {
            for(ImageButton button: menuButtons) {
                float angle = (float) ((PI / (menuButtons.size() * 2)) + (i * (PI / menuButtons.size())));

                button.animate()
                        .xBy((float) (r * cos(angle)))
                        .yBy((float) (r * sin(angle)))
                        .setDuration(1000)
                        .withEndAction(new Runnable() {
                            @Override
                            public void run() {
                                button.setVisibility(View.INVISIBLE);
                            }
                        })
                        .start();

                i++;
            }
        }

        else {
            for(ImageButton button: menuButtons) {
                float angle = (float) ((PI / (menuButtons.size() * 2)) + (i * (PI / menuButtons.size())));

                button.setY(y);
                button.setVisibility(View.VISIBLE);

                button.animate()
                        .xBy((float) -(r * cos(angle)))
                        .yBy((float) -(r * sin(angle)))
                        .setDuration(1000)
                        .start();

                i++;
            }
        }

        menuOpen = !menuOpen;
    }

    
}
