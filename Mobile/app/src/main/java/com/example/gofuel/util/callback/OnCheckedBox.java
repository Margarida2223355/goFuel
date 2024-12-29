package com.example.gofuel.util.callback;

import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;

public interface OnCheckedBox {
    void onChecked(InvoiceLine line);
    void onUnchecked(InvoiceLine line);
}
