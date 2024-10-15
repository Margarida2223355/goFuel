package com.example.gofuel.repository.invoice.remote;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.IInvoiceDataSource;

import java.util.List;

import retrofit2.Call;

public class InvoiceRemoteDataSource implements IInvoiceDataSource.Main {
    private final InvoiceAPI invoiceAPI;

    public InvoiceRemoteDataSource() {
        this.invoiceAPI = new HTTPClient<>(InvoiceAPI.class).get();
    }

    // Method for local DB
    @Override
    public ResultWrapper<Invoice> getCachedInvoice() {
        return null;
    }

    @Override
    public ResultWrapper<List<Invoice>> getInvoices() {
        Call<List<Invoice>> call = invoiceAPI.getInvoices();
        return ResultWrapper.safeApiCall(call);
    }
}
