package com.example.gofuel.repository.invoice.remote;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.HeaderID;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.IInvoiceDataSource;

import java.util.List;

import retrofit2.Call;

public class InvoiceRemoteDataSource implements IInvoiceDataSource.Main {
    private final InvoiceAPI invoiceAPI;

    public InvoiceRemoteDataSource() {
        this.invoiceAPI = new HTTPClient<>(InvoiceAPI.class, HeaderID.USER_ID, String.valueOf(MyApplication.getUser().getId())).get();
    }

    // Method for local DB
    @Override
    public ResultWrapper<Invoice> getCachedInvoice() {
        return null;
    }

    @Override
    public ResultWrapper<List<PendingInvoice>> getPendingInvoices() {
        Call<List<PendingInvoice>> call = invoiceAPI.getPendingInvoices();
        return ResultWrapper.safeApiCall(call);
    }

    @Override
    public ResultWrapper<List<FinishedInvoice>> getFinishedInvoices() {
        Call<List<FinishedInvoice>> call = invoiceAPI.getFinishedInvoices();
        return ResultWrapper.safeApiCall(call);
    }
}
