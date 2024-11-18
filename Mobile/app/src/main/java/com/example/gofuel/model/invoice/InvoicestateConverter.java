package com.example.gofuel.model.invoice;

import androidx.room.TypeConverter;

import com.google.gson.Gson;

public class InvoicestateConverter {

    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromInvoiceState(InvoiceState invoiceState) {
        return invoiceState == null ? null : gson.toJson(invoiceState);
    }

    @TypeConverter
    public static InvoiceState toInvoiceState(String invoiceStateJson) {
        return invoiceStateJson == null ? null : gson.fromJson(invoiceStateJson, InvoiceState.class);
    }
}
