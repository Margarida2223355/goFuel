package com.example.gofuel.view;

import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.example.gofuel.MyApplication;
import com.example.gofuel.R;
import com.example.gofuel.databinding.ActivityHomeBinding;
import com.example.gofuel.view.Fragments.StationFragment;
import com.example.gofuel.view.components.MenuButtons;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {

    private ActivityHomeBinding binding;
    private MenuButtons menuButtonsInstance;
    private ArrayList<ImageButton> menuButtons;
    private FragmentManager fragmentManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        binding = ActivityHomeBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        //region Setup Fragment
        fragmentManager = getSupportFragmentManager();
        //changeFragment(binding.bottombar.appMenu.btnStation);
        //endregion

        //region Setup Menu buttons
        menuButtonsInstance = MyApplication.getMenuButtonsInstance(this);
        menuButtons = menuButtonsInstance.getMenuButtons(binding);
        setupFragment();
        //endregion

        //region Listener to menu button click
        binding.bottombar.menuBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                menuButtonsInstance.animateButtons(view);
            }
        });
        //endregion
    }

    private void changeFragment(View view) {
        Fragment fragment = null;

        if (view.getId() == R.id.btnStation) {
            fragment = new StationFragment();
        }

        if (fragment != null) { fragmentManager.beginTransaction().replace(R.id.fragment, fragment).commit(); }
    }

    private void setupFragment() {
        for(ImageButton button: menuButtons) {
            button.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Toast.makeText(MyApplication.getAppContext(), view.getContentDescription(), Toast.LENGTH_SHORT).show();
                    changeFragment(view);
                }
            });
        }
    }
}