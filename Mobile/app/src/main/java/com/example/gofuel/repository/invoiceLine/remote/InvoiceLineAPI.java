package com.example.gofuel.repository.invoiceLine.remote;

import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface InvoiceLineAPI {
    @GET("invoiceline")
    Call<List<InvoiceLine>> getInvoiceLines();
}