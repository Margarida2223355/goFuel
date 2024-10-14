package com.example.gofuel.repository.invoice.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.item.Item;

import java.util.List;

@Dao
public interface InvoiceDB {
    @Insert
    void addAll(List<Invoice> invoices);

    @Query("SELECT * FROM invoices")
    List<Invoice> getAllInvoices();

    @Query("DELETE FROM invoices")
    void deleteAll();
}
