package com.example.gofuel.view;

import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import com.example.gofuel.MyApplication;
import com.example.gofuel.databinding.ActivityHomeBinding;
import com.example.gofuel.view.components.MenuButtons;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {

    private ActivityHomeBinding binding;
    private MenuButtons menuButtonsInstance;
    private ArrayList<ImageButton> menuButtons;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        binding = ActivityHomeBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        //region Setup Menu buttons
        menuButtonsInstance = MyApplication.getMenuButtonsInstance(this);
        menuButtons = menuButtonsInstance.getMenuButtons();
        //endregion

        //region Listener to menu button click
        binding.bottombar.menuBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(getBaseContext(), "Menu button", Toast.LENGTH_SHORT).show();
            }
        });
        //endregion
    }
}