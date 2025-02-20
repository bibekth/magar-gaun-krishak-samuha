package com.techenfield.mgks;

import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.techenfield.mgks.models.MainModel;
import com.techenfield.mgks.services.MainAPI;
import com.techenfield.mgks.services.RetrofitService;
import com.techenfield.mgks.services.TokenManager;

import java.util.Objects;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {
    TextView tvUserName, tvTotalSavings, tvTotalDebtCollected, tvPayableInterest, tvPayableSaving, tvFine, tvRemainingDebt, tvLastPaymentDate, tvLastDownPayment;
    String token, bearerToken, role;
    View rlPay, rlProfile;
    Intent itProfile;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Finding the ids
        tvUserName = findViewById(R.id.tvUserName);
        tvTotalSavings = findViewById(R.id.tvTotalSavings);
        tvTotalDebtCollected = findViewById(R.id.tvTotalDebtCollected);
        tvPayableInterest = findViewById(R.id.tvPayableInterest);
        tvPayableSaving = findViewById(R.id.tvPayableSaving);
        tvFine = findViewById(R.id.tvFine);
        tvRemainingDebt = findViewById(R.id.tvRemainingDebt);
        tvLastDownPayment = findViewById(R.id.tvLastDownPayment);
        tvLastPaymentDate = findViewById(R.id.tvLastPaymentDate);

        rlPay = findViewById(R.id.rlPay);
        rlProfile = findViewById(R.id.rlProfile);


        itProfile = new Intent(this, ProfileActivity.class);

        token = TokenManager.getToken(getApplicationContext());
        bearerToken = "Bearer " + token;
        role = TokenManager.getRole(getApplicationContext());

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

        callAPI();

        rlProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(itProfile);
            }
        });
    }

    @Override
    protected void onRestart() {
        super.onRestart();
    }

    protected void callAPI(){
        MainAPI mainAPI = RetrofitService.getService(MainActivity.this).create(MainAPI.class);
        Call<MainModel> call = mainAPI.getMainData(bearerToken);

        call.enqueue(new Callback<MainModel>() {
            @SuppressLint("SetTextI18n")
            @Override
            public void onResponse(Call<MainModel> call, Response<MainModel> response) {
                if(response.isSuccessful()){
                    MainModel mainModel = response.body();
                    assert mainModel != null;
                    if(Objects.equals(mainModel.getStatus(), "success")){
                        tvTotalSavings.setText(mainModel.getBody().getTotalSavings());
                        tvTotalDebtCollected.setText(mainModel.getBody().getTotalDebtCollected());
                        tvPayableInterest.setText(mainModel.getBody().getPayableInterest());
                        tvPayableSaving.setText(mainModel.getBody().getPayableSaving());
                        tvFine.setText(mainModel.getBody().getFine());
                        tvUserName.setText(mainModel.getBody().getUserName());
                        tvRemainingDebt.setText(mainModel.getBody().getRemainingDebt());
                        tvLastDownPayment.setText(mainModel.getBody().getLastDownPayment().getDown_payment_amount());
                        tvLastPaymentDate.setText(mainModel.getBody().getLastDownPayment().getYear() + "-" + mainModel.getBody().getLastDownPayment().getMonth());
                    }
                }
            }

            @Override
            public void onFailure(Call<MainModel> call, Throwable throwable) {

            }
        });
    }
}