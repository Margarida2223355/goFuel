package com.example.gofuel.repository.invoiceLine.remote;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.model.invoice.invoiceline.InvoicelinePost;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.HTTPClient;
import com.example.gofuel.util.enums.HeaderID;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoiceLine.IInvoiceLineDataSource;

import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

import retrofit2.Call;

public class InvoiceLineRemoteDataSource implements IInvoiceLineDataSource.Main {
    private final InvoiceLineAPI invoiceLineAPI;

    public InvoiceLineRemoteDataSource(Invoice invoice) {
        this.invoiceLineAPI = new HTTPClient<>(InvoiceLineAPI.class, HeaderID.INVOICE_ID, String.valueOf(invoice.getId())).get();
    }

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

    @Override
    public ResultWrapper<List<InvoiceLine>> getInvoiceLines(Invoice invoice) {
        return null;
    }

    @Override
    public ResultWrapper<List<InvoiceLine>> addInvoiceLines(PendingInvoice invoice, List<InvoicelinePost> lines) {
        return null;
    }

    @Override
    public ResultWrapper<List<InvoiceLine>> addInvoiceLines(List<InvoicelinePost> lines) {
        Call<List<InvoiceLine>> call = invoiceLineAPI.addInvoiceLines(lines);
        return ResultWrapper.safeApiCall(call);
    }

    @Override
    public ResultWrapper<List<InvoiceLine>> removeInvoiceLines(List<InvoiceLine> lines) {
        Map<String, List<Integer>> requestBody = new HashMap<>();
        requestBody.put("ids", lines.stream().map(InvoiceLine::getId).collect(Collectors.toList()));
        Call<List<InvoiceLine>> call = invoiceLineAPI.removeInvoiceLines(requestBody);
        return ResultWrapper.safeApiCall(call);
    }
}
