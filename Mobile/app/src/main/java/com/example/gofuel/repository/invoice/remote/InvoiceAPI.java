package com.example.gofuel.repository.invoice.remote;


import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoicePost;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.PATCH;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface InvoiceAPI {
    @GET("invoices/pendentinvoices")
    Call<List<PendingInvoice>> getPendingInvoices();

     @GET("invoices/paidinvoices")
    Call<List<FinishedInvoice>> getFinishedInvoices();

    @POST("invoices/createinvoice")
    Call<PendingInvoice> createInvoice(@Body InvoicePost invoicePost);

    @PUT("invoice/updateinvoice")
    Call<String> closeInvoice(@Query("id") int id);
}