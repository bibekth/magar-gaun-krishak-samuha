package com.techenfield.mgks;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.techenfield.mgks.services.TokenManager;

import java.util.Objects;

public class ProfileActivity extends AppCompatActivity {
    String lang;
    TextView tvLogout;
    Intent itLogin, itHome;
    View rlPay, rlProfile, rlHome;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        lang = TokenManager.getLang(getApplicationContext());

        tvLogout = findViewById(R.id.tvLogout);
        rlHome = findViewById(R.id.rlHome);
        if(Objects.equals(lang, "Nep")){
            tvLogout.setText(ContextCompat.getString(this, R.string.nep_logout));
        }
        itLogin = new Intent(this, PickLangActivity.class);
        itHome = new Intent(this, MainActivity.class);
        tvLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                TokenManager.clearToken(getApplicationContext());
                TokenManager.clearRole(getApplicationContext());
                TokenManager.clearLang(getApplicationContext());
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

    @Override
    protected void onStart() {
        super.onStart();
    }

    @Override
    protected void onStop() {
        super.onStop();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }

    @Override
    protected void onPause() {
        super.onPause();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    @Override
    protected void onRestart() {
        super.onRestart();
    }
}