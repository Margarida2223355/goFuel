package com.example.gofuel.model.invoice.finished;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class FinishedInvoiceConverter {

    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromFinishedInvoice(FinishedInvoice invoice) {
        return invoice == null ? null : gson.toJson(invoice);
    }

    @TypeConverter
    public static FinishedInvoice toFinishedInvoice(String invoiceJson) {
        return invoiceJson == null ? null : gson.fromJson(invoiceJson, FinishedInvoice.class);
    }
}
