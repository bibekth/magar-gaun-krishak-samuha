package com.techenfield.mgks;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.techenfield.mgks.services.TokenManager;

public class PickLangActivity extends AppCompatActivity {
    TextView tvHamroSamuha;
    View llNepaliLang, llEngLang;
    Button btnConfirm;
    String lang;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pick_lang);

        String token = TokenManager.getToken(getApplicationContext());
        if(token != null){
            Intent tokenIntent = new Intent(this, MainActivity.class);
            startActivity(tokenIntent);
        }

        findView();
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

        pickLang();
        confirmed();
    }

    @Override
    protected void onRestart() {
        super.onRestart();
    }

    protected void findView(){
        tvHamroSamuha = findViewById(R.id.tvHamroSamuha);
        llNepaliLang = findViewById(R.id.llNepaliLang);
        llEngLang = findViewById(R.id.llEngLang);
        btnConfirm = findViewById(R.id.btnConfirm);
    }

    protected void pickLang() {
        llNepaliLang.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lang = "Nep";
                tvHamroSamuha.setText(ContextCompat.getString(PickLangActivity.this, R.string.nep_hamro_samuha));
                btnConfirm.setText(ContextCompat.getString(PickLangActivity.this, R.string.nep_confirm));
                llEngLang.setBackground(ContextCompat.getDrawable(PickLangActivity.this, R.drawable.input_field_shape));
                llNepaliLang.setBackground(ContextCompat.getDrawable(PickLangActivity.this, R.drawable.selected_input_field));
            }
        });

        llEngLang.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                lang = "Eng";
                tvHamroSamuha.setText(ContextCompat.getString(PickLangActivity.this, R.string.hamro_samuha));
                btnConfirm.setText(ContextCompat.getString(PickLangActivity.this, R.string.confirm));
                llNepaliLang.setBackground(ContextCompat.getDrawable(PickLangActivity.this, R.drawable.input_field_shape));
                llEngLang.setBackground(ContextCompat.getDrawable(PickLangActivity.this, R.drawable.selected_input_field));
            }
        });
    }

    protected void confirmed(){
        btnConfirm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(PickLangActivity.this, LoginActivity.class);
                TokenManager.saveLang(getApplicationContext(),lang);
                startActivity(intent);
            }
        });
    }

}