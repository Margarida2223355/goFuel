package com.example.gofuel.model.invoice.pending;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class PendingInvoiceConverter {

    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromPendingInvoice(PendingInvoice invoice) {
        return invoice == null ? null : gson.toJson(invoice);
    }

    @TypeConverter
    public static PendingInvoice toPendingInvoice(String invoiceJson) {
        return invoiceJson == null ? null : gson.fromJson(invoiceJson, PendingInvoice.class);
    }
}
