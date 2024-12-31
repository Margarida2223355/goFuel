package com.example.gofuel.repository.invoiceLine.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;

import java.util.List;

@Dao
public interface InvoiceLineDB {
    @Insert
    void addAll(List<InvoiceLine> invoiceLines);

    @Query("SELECT * FROM invoicelines")
    List<InvoiceLine> getAllInvoiceLines();

    @Query("DELETE FROM invoicelines")
    void deleteAll();
}
