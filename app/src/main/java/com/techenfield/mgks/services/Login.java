package com.techenfield.mgks.services;

import com.techenfield.mgks.models.UserModel;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;
import retrofit2.http.Query;

public interface Login {

    @POST("/api/login")
    Call<UserModel> postLogin(@Query("credential") String credential, @Query("password") String password, @Query("device_id") String device_id, @Query("fcm_id") String fcm_id);

}
