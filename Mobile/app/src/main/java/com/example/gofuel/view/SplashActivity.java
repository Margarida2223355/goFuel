package com.example.gofuel.view;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.animation.AccelerateDecelerateInterpolator;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.lifecycle.ViewModelProvider;

import com.example.gofuel.MyApplication;
import com.example.gofuel.databinding.ActivitySplashBinding;
import com.example.gofuel.model.user.User;
import com.example.gofuel.modelView.User.LoginCallback;
import com.example.gofuel.modelView.User.UserViewModel;
import com.example.gofuel.repository.user.UserRepository;

import java.util.Objects;

@SuppressLint("CustomSplashScreen")
public class SplashActivity extends AppCompatActivity {

    private ActivitySplashBinding binding;
    private UserViewModel viewModel;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        binding = ActivitySplashBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        viewModel = new UserViewModel();

        //region Login Button to show login card
        binding.loginBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showLoginCard();

                binding.username.setText("admin");
                binding.password.setText("password");
            }
        });
        //endregion

        //region Hide login card when background click
        binding.main.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                hideLoginCard();
            }
        });
        //endregion

        binding.loginCardBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (binding.username.getText().toString().isEmpty() || binding.password.getText().toString().isEmpty()) {
                    new AlertDialog.Builder(SplashActivity.this)
                            .setTitle("Login")
                            .setMessage("Faltam dados para login")
                            .setPositiveButton("OK", null)
                            .show();
                }

                else {
                    viewModel.login(
                        binding.username.getText().toString(),
                        binding.password.getText().toString(),
                        new LoginCallback() {
                            @Override
                            public void onSuccess(User user) {
                                MyApplication.setUser(user);
                                startActivity(new Intent(getApplicationContext(), MainActivity.class));
                                finish();
                            }

                            @Override
                            public void onError(String error) {
                                runOnUiThread(() -> {
                                    new AlertDialog.Builder(SplashActivity.this)
                                            .setTitle("Erro login")
                                            .setMessage(error)
                                            .setPositiveButton("OK", null)
                                            .show();
                                });
                            }
                        }
                );
                }
            }
        });
    }

    // Use this method to get Y position of iplLogo. This method make sure the layout is all set
    @Override
    public void onWindowFocusChanged(boolean hasFocus) {
        binding.iplLogo.animate()
                .translationY(-binding.iplLogo.getY())
                .setStartDelay(500)
                .setDuration(1000)
                .setListener(new AnimatorListenerAdapter() {
                    @Override
                    public void onAnimationEnd(Animator animation) {
                        Log.i("-->", "Animation finished!");
                        binding.loginFrame.setVisibility(View.VISIBLE); // Show login button after animation
                    }
                })
                .start();
    }

    //region Private Funcs
    private void showLoginCard() {
        // Initialize login card with scale zero
        binding.loginCard.setVisibility(View.VISIBLE);
        binding.loginCard.setScaleX(0f);
        binding.loginCard.setScaleY(0f);
        binding.loginCard.setPivotX(binding.loginBtn.getWidth() / 2f);
        binding.loginCard.setPivotY(0f);

        // Animate to expand login card
        binding.loginCard.animate()
                .scaleX(1f)
                .scaleY(1f)
                .setInterpolator(new AccelerateDecelerateInterpolator())
                .setDuration(400)
                .start();

        binding.loginBtn.animate()
                .alpha(0f)
                .setDuration(300)
                .start();
    }

    private void hideLoginCard() {
        //Animation to hide login card
        binding.loginCard.animate()
                .scaleX(0f)
                .scaleY(0f)
                .setInterpolator(new AccelerateDecelerateInterpolator())
                .setDuration(400)
                .withEndAction(new Runnable() {
                    @Override
                    public void run() {
                        binding.loginCard.setVisibility(View.GONE);
                        binding.loginBtn.setVisibility(View.VISIBLE);
                        binding.loginBtn.animate()
                                .alpha(1f)
                                .setDuration(300)
                                .start();
                    }
                })
                .start();
    }
    //endregion
}