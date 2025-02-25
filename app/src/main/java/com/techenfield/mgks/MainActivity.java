package com.techenfield.mgks;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.content.res.ResourcesCompat;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.techenfield.mgks.models.MainModel;
import com.techenfield.mgks.services.MainAPI;
import com.techenfield.mgks.services.RetrofitService;
import com.techenfield.mgks.services.TokenManager;

import java.lang.reflect.Type;
import java.util.Objects;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {
    TextView tvUserName, tvTotalSavings, tvTotalDebtCollected, tvPayableInterest, tvPayableSaving, tvFine, tvRemainingDebt, tvLastPaymentDate, tvLastDownPayment, tvAppName, tvNameText, tvTotalSavingsText, tvTotalDebtCollectedText, tvLastPaymentDateText, tvLastDownPaymentText, tvRemainingDebtText, tvPayableInterestText, tvPayableSavingText, tvFineText, tvUnpaidMonthsText, tvUnpaidMonths;
    String token, bearerToken, role, lang;
    View rlPay, rlProfile;
    Intent itProfile;
    Typeface typeface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Finding the ids
        findViews();

        typeface = ResourcesCompat.getFont(this, R.font.montserrat_semibold);

        itProfile = new Intent(this, ProfileActivity.class);

        token = TokenManager.getToken(getApplicationContext());
        bearerToken = "Bearer " + token;
        role = TokenManager.getRole(getApplicationContext());
        lang = TokenManager.getLang(getApplicationContext());
        tvAppName.setTypeface(tvAppName.getTypeface(), Typeface.BOLD);
        checkLang();

        if(Objects.equals(lang, "Nep")){
            callAPINep();
        }else {
            callAPI();
        }
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

    protected void callAPINep(){
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
                        tvTotalSavings.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getTotalSavings()));
                        tvTotalDebtCollected.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getTotalDebtCollected()));
                        tvPayableInterest.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getPayableInterest()));
                        tvPayableSaving.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getPayableSaving()));
                        tvFine.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getFine()));
                        tvUserName.setText(" " + mainModel.getBody().getUserName());
                        tvRemainingDebt.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getRemainingDebt()));
                        tvLastDownPayment.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getLastDownPayment().getDown_payment_amount()));
                        tvLastPaymentDate.setText(" " + NumberConverter.toNepaliNumbers(mainModel.getBody().getLastDownPayment().getYear()) + "-" + NumberConverter.toNepaliNumbers(mainModel.getBody().getLastDownPayment().getMonth()));
                        tvUnpaidMonths.setText(" "+NumberConverter.toNepaliNumbers(mainModel.getBody().getUnpaidMonths()));

                        tvUserName.setTypeface(typeface);
                        tvTotalSavings.setTypeface(typeface);
                        tvTotalDebtCollected.setTypeface(typeface);
                        tvPayableSaving.setTypeface(typeface);
                        tvPayableInterest.setTypeface(typeface);
                        tvFine.setTypeface(typeface);
                        tvRemainingDebt.setTypeface(typeface);
                        tvLastDownPayment.setTypeface(typeface);
                        tvLastPaymentDate.setTypeface(typeface);
                        tvUnpaidMonths.setTypeface(typeface);
                    }
                }
            }

            @Override
            public void onFailure(Call<MainModel> call, Throwable throwable) {

            }
        });
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
                        tvTotalSavings.setText(" " + mainModel.getBody().getTotalSavings());
                        tvTotalDebtCollected.setText(" " + mainModel.getBody().getTotalDebtCollected());
                        tvPayableInterest.setText(" " + mainModel.getBody().getPayableInterest());
                        tvPayableSaving.setText(" " + mainModel.getBody().getPayableSaving());
                        tvFine.setText(" " + mainModel.getBody().getFine());
                        tvUserName.setText(" " + mainModel.getBody().getUserName());
                        tvRemainingDebt.setText(" " + mainModel.getBody().getRemainingDebt());
                        tvLastDownPayment.setText(" " + mainModel.getBody().getLastDownPayment().getDown_payment_amount());
                        tvLastPaymentDate.setText(" " + mainModel.getBody().getLastDownPayment().getYear() + "-" + mainModel.getBody().getLastDownPayment().getMonth());
                        tvUnpaidMonths.setText(" "+mainModel.getBody().getUnpaidMonths());

                        tvUserName.setTypeface(typeface);
                        tvTotalSavings.setTypeface(typeface);
                        tvTotalDebtCollected.setTypeface(typeface);
                        tvPayableSaving.setTypeface(typeface);
                        tvPayableInterest.setTypeface(typeface);
                        tvFine.setTypeface(typeface);
                        tvRemainingDebt.setTypeface(typeface);
                        tvLastDownPayment.setTypeface(typeface);
                        tvLastPaymentDate.setTypeface(typeface);
                        tvUnpaidMonths.setTypeface(typeface);
                    }
                }
            }

            @Override
            public void onFailure(Call<MainModel> call, Throwable throwable) {

            }
        });
    }

    protected void findViews(){
        tvAppName = findViewById(R.id.tvAppName);
        tvUserName = findViewById(R.id.tvUserName);
        tvTotalSavings = findViewById(R.id.tvTotalSavings);
        tvTotalDebtCollected = findViewById(R.id.tvTotalDebtCollected);
        tvPayableInterest = findViewById(R.id.tvPayableInterest);
        tvPayableSaving = findViewById(R.id.tvPayableSaving);
        tvFine = findViewById(R.id.tvFine);
        tvRemainingDebt = findViewById(R.id.tvRemainingDebt);
        tvLastDownPayment = findViewById(R.id.tvLastDownPayment);
        tvLastPaymentDate = findViewById(R.id.tvLastPaymentDate);
        tvUnpaidMonths = findViewById(R.id.tvUnpaidMonths);

        tvNameText = findViewById(R.id.tvNameText);
        tvTotalSavingsText = findViewById(R.id.tvTotalSavingsText);
        tvTotalDebtCollectedText = findViewById(R.id.tvTotalDebtCollectedText);
        tvPayableInterestText = findViewById(R.id.tvPayableInterestText);
        tvPayableSavingText = findViewById(R.id.tvPayableSavingText);
        tvFineText = findViewById(R.id.tvFineText);
        tvRemainingDebtText = findViewById(R.id.tvRemainingDebtText);
        tvLastDownPaymentText = findViewById(R.id.tvLastDownPaymentText);
        tvLastPaymentDateText = findViewById(R.id.tvLastPaymentDateText);
        tvUnpaidMonthsText = findViewById(R.id.tvUnpaidMonthsText);

        rlPay = findViewById(R.id.rlPay);
        rlProfile = findViewById(R.id.rlProfile);
    }

    protected void checkLang(){
        if(Objects.equals(lang, "Nep")){
            tvAppName.setText(ContextCompat.getString(MainActivity.this, R.string.nep_app_name));
            tvNameText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_name_home));
            tvTotalSavingsText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_total_savings_home));
            tvTotalDebtCollectedText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_total_debt_collected_home));
            tvPayableInterestText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_payable_interest_home));
            tvPayableSavingText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_payable_saving_home));
            tvFineText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_fine_home));
            tvRemainingDebtText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_remaining_debt_home));
            tvLastDownPaymentText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_last_down_payment_home));
            tvLastPaymentDateText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_last_payment_date_home));
            tvUnpaidMonthsText.setText(ContextCompat.getString(MainActivity.this, R.string.nep_unpaid_months));
        }
    }

    protected static class NumberConverter{
        public static String toNepaliNumbers(String englishNumber) {
            char[] nepaliDigits = {'०', '१', '२', '३', '४', '५', '६', '७', '८', '९'};
            StringBuilder nepaliNumber = new StringBuilder();

            for (char digit : englishNumber.toCharArray()) {
                if (Character.isDigit(digit)) {
                    nepaliNumber.append(nepaliDigits[digit - '0']);
                } else {
                    nepaliNumber.append(digit);
                }
            }
            return nepaliNumber.toString();
        }

    }
}