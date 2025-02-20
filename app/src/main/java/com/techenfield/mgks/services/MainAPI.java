package com.techenfield.mgks.services;

import com.techenfield.mgks.models.MainModel;

import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Header;

public interface MainAPI {
    @GET("/api/main")
    Call<MainModel> getMainData(@Header("Authorization") String token);
}
