package com.example.gofuel.repository.invoice.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.invoice.Invoice;

import java.util.List;

@Dao
public interface PendingInvoiceDB {
    @Insert
    void addAll(List<Invoice> invoices);

    @Query("SELECT * FROM pending_invoices")
    List<Invoice> getAllInvoices();

    @Query("DELETE FROM pending_invoices")
    void deleteAll();
}
