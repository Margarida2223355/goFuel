package com.example.gofuel.model.invoice.common;

import androidx.room.TypeConverter;

import com.example.gofuel.model.invoice.Invoice;
import com.google.gson.Gson;

public class InvoiceConverter {

    private static final Gson gson = new Gson();

    @TypeConverter
    public static String fromInvoice(Invoice invoice) {
        return invoice == null ? null : gson.toJson(invoice);
    }

    @TypeConverter
    public static Invoice toInvoice(String invoiceJson) {
        return invoiceJson == null ? null : gson.fromJson(invoiceJson, Invoice.class);
    }
}
