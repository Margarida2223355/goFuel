package com.example.gofuel.repository.invoice.remote;


import com.example.gofuel.model.invoice.InvoicePost;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.POST;

public interface InvoiceAPI {
    @GET("invoices/pendentinvoices")
    Call<List<PendingInvoice>> getPendingInvoices();

     @GET("invoices/paidinvoices")
    Call<List<FinishedInvoice>> getFinishedInvoices();

    @POST("invoices/createinvoice")
    Call<PendingInvoice> createInvoice(@Body InvoicePost invoicePost);
}