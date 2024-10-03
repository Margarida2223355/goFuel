package com.example.gofuel.repository.common;

import java.io.IOException;
import java.net.SocketTimeoutException;

import retrofit2.Call;
import retrofit2.HttpException;
import retrofit2.Response;

public class ResultWrapper<T> {
    //region Properties
    private T result;
    private String error;
    //endregion
    
    //region Getters and Setters
    public T getResult() {
        return result;
    }

    public void setResult(T result) {
        this.result = result;
    }

    public String getError() {
        return error;
    }

    public void setError(String error) {
        this.error = error;
    }
    //endregion

    //region API call
    public static <T> ResultWrapper<T> safeApiCall(Call<T> call) {
        ResultWrapper<T> resultWrapper = new ResultWrapper<>();

        try {
            Response<T> response = call.execute();

            if (response.isSuccessful()) { resultWrapper.setResult(response.body()); }
            else { resultWrapper.setError("HTTP Error: " + response.code()); }
        }

        catch (HttpException e) { resultWrapper.setError("HTTP Exception: " + e.code()); }
        catch (SocketTimeoutException e) { resultWrapper.setError("Network Timeout"); }
        catch (IOException e) { resultWrapper.setError("Network Error: " + e.getMessage()); }
        catch (Exception e) { resultWrapper.setError("Unknown Error: " + e.getMessage()); }

        return resultWrapper;
    }
    //endregion
}
