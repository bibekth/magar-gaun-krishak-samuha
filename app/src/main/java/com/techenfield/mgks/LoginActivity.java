package com.techenfield.mgks;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.firebase.FirebaseApp;
import com.techenfield.mgks.models.UserModel;
import com.techenfield.mgks.services.DeviceFCMID;
import com.techenfield.mgks.services.Login;
import com.techenfield.mgks.services.RetrofitService;
import com.techenfield.mgks.services.TokenManager;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {
    Button btnLogin;
    EditText etEmailPhoneNumber, etPassword;
    String fcm_id, device_id;
    Intent loginIntent;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        FirebaseApp.initializeApp(this);

        String token = TokenManager.getToken(getApplicationContext());
        if(token != null){
            Intent tokenIntent = new Intent(this, MainActivity.class);
            startActivity(tokenIntent);
        }
        etPassword = findViewById(R.id.etPassword);
        etEmailPhoneNumber = findViewById(R.id.etEmailPhoneNumber);
        btnLogin = findViewById(R.id.btnLogin);
        loginIntent = new Intent(this, MainActivity.class);

    }

    @Override
    protected void onStart() {
        super.onStart();
        device_id = DeviceFCMID.getDeviceId(getApplicationContext());
        fcm_id = DeviceFCMID.getFCMToken();
        if(fcm_id == null){
            fcm_id = "12345678";
        }
        if(device_id == null){
            device_id = "12345678";
        }
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

        btnLogin.setOnClickListener(v -> {
            Login loginService = RetrofitService.getService(LoginActivity.this).create(Login.class);
//            UserModel.Body.User userModel = new UserModel.Body.User(etEmailPhoneNumber.getText().toString(), etEmailPhoneNumber.getText().toString(), device_id, fcm_id, etPassword.getText().toString());

            Call<UserModel> call = loginService.postLogin(etEmailPhoneNumber.getText().toString(),  etPassword.getText().toString(), device_id, fcm_id);

            call.enqueue(new Callback<UserModel>() {
                @Override
                public void onResponse(@NonNull Call<UserModel> call, @NonNull Response<UserModel> response) {
                    if (response.isSuccessful()) {
                        UserModel userModelResponse = response.body();
                        if (userModelResponse != null) {
//                            UserModel.Body.User user = userModelResponse.getBody().getUser();
                            try {
                                String token = userModelResponse.getBody().getToken();
                                String role = userModelResponse.getBody().getRole();
                                TokenManager.saveToken(getApplicationContext(), token);
                                TokenManager.saveRole(getApplicationContext(),role);

                                startActivity(loginIntent);
                            }catch (Exception e){
                                Toast.makeText(LoginActivity.this, "Something went wrong.", Toast.LENGTH_SHORT).show();
                            }
                        } else {
                        }
                    } else {
                    }
                }

                @Override
                public void onFailure(@NonNull Call<UserModel> call, @NonNull Throwable t) {
                }
            });
        });
    }

    @Override
    protected void onRestart() {
        super.onRestart();
    }
}