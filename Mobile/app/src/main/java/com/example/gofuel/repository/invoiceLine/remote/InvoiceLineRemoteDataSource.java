package com.example.gofuel.repository.invoiceLine.remote;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoiceLine;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoiceLine.IInvoiceLineDataSource;

import java.util.List;

import retrofit2.Call;

public class InvoiceLineRemoteDataSource implements IInvoiceLineDataSource.Main {
    private final InvoiceLineAPI invoiceLineAPI;

    public InvoiceLineRemoteDataSource() {
        this.invoiceLineAPI = new HTTPClient<>(InvoiceLineAPI.class).get();
    }

    // Method for local DB
    @Override
    public ResultWrapper<InvoiceLine> getCachedInvoiceLine() {
        return null;
    }

    @Override
    public ResultWrapper<List<InvoiceLine>> getInvoiceLines() {
        Call<List<InvoiceLine>> call = invoiceLineAPI.getInvoiceLines();
        return ResultWrapper.safeApiCall(call);
    }
}
