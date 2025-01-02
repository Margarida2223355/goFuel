package com.example.gofuel.repository.invoiceLine.remote;

import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.model.invoice.invoiceline.InvoicelinePost;

import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.HTTP;
import retrofit2.http.POST;

public interface InvoiceLineAPI {
    @GET("invoiceline")
    Call<List<InvoiceLine>> getInvoiceLines();

    @POST("invoiceline/create")
    Call<List<InvoiceLine>> addInvoiceLines(@Body List<InvoicelinePost> lines);

    @HTTP(method = "DELETE", path = "invoiceline/delete", hasBody = true)
    Call<List<InvoiceLine>> removeInvoiceLines(@Body Map<String, List<Integer>> linesIds);
}