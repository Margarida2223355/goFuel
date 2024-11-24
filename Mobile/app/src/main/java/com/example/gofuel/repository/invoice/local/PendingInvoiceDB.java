package com.example.gofuel.repository.invoice.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.invoice.pending.PendingInvoice;

import java.util.List;

@Dao
public interface PendingInvoiceDB {
    @Insert
    void addAll(List<PendingInvoice> invoices);

    @Query("SELECT * FROM pending_invoices")
    List<PendingInvoice> getAllInvoices();

    @Query("DELETE FROM pending_invoices")
    void deleteAll();
}
