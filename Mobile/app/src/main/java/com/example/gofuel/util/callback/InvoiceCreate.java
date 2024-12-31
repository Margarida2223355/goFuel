package com.example.gofuel.util.callback;

import com.example.gofuel.model.invoice.pending.PendingInvoice;

public interface InvoiceCreate {
    public void onSuccess(PendingInvoice pendingInvoice);
    public void onError(String error);
}
