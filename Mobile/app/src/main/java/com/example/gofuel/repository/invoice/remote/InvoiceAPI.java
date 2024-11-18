package com.example.gofuel.repository.invoice.remote;


import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.item.Item;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.GET;

public interface InvoiceAPI {
    @GET("invoice")
    Call<List<Invoice>> getInvoices();
}