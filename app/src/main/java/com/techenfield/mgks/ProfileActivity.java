package com.techenfield.mgks;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.techenfield.mgks.services.TokenManager;

public class ProfileActivity extends AppCompatActivity {

    TextView tvLogout;
    Intent itLogin, itHome;
    View rlPay, rlProfile, rlHome;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        tvLogout = findViewById(R.id.tvLogout);
        rlHome = findViewById(R.id.rlHome);

        itLogin = new Intent(this, LoginActivity.class);
        itHome = new Intent(this, MainActivity.class);
        tvLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                TokenManager.clearToken(getApplicationContext());
                TokenManager.clearRole(getApplicationContext());
                startActivity(itLogin);
            }
        });

        rlHome.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(itHome);
            }
        });
    }
}