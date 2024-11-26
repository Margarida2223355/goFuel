package com.example.gofuel.view;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.example.gofuel.MyApplication;
import com.example.gofuel.R;
import com.example.gofuel.databinding.ActivityHomeBinding;
import com.example.gofuel.model.user.User;
import com.example.gofuel.view.components.MenuButtons;
import com.example.gofuel.view.fragments.InvoiceFragment;
import com.example.gofuel.view.fragments.MainFragment;
import com.example.gofuel.view.fragments.StationFragment;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationBarView;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {

    private ActivityHomeBinding binding;
    private MenuButtons menuButtonsInstance;
    private BottomNavigationView navbarMenu;
    private ArrayList<ImageButton> menuButtons;
    private FragmentManager fragmentManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        binding = ActivityHomeBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        User user = MyApplication.getUser();
        Toast.makeText(this, "user: " + user.getName(), Toast.LENGTH_SHORT).show();

        navbarMenu = binding.bottombar.bottomNavBar;

        //region Setup Fragment
        fragmentManager = getSupportFragmentManager();
        changeFragment(findViewById(R.id.homeButton));
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
        else if (view.getId() == R.id.btnInvoice) {
            fragment = new InvoiceFragment();
        }
        else if (view.getId() == R.id.homeButton) {
            fragment = new MainFragment();
        }

        if (fragment != null) { fragmentManager.beginTransaction().replace(R.id.fragment, fragment).commit(); }
    }

    private void setupFragment() {
        for (ImageButton button: menuButtons) {
            button.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    //Toast.makeText(MyApplication.getAppContext(), view.getContentDescription(), Toast.LENGTH_SHORT).show();
                    menuButtonsInstance.animateButtons(view);
                    changeFragment(view);
                }
            });
        }

        navbarMenu.setOnItemSelectedListener(item -> {
            View view = findViewById(item.getItemId());
            if (view != null) {
                if (view == findViewById(R.id.logoutButton)) {
                    startActivity(new Intent(getApplicationContext(), SplashActivity.class));
                    finish();
                }
                else {
                    changeFragment(view);
                }
            }
            return true;
        });
    }
}