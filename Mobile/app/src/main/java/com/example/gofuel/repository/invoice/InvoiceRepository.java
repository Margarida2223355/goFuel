package com.example.gofuel.repository.invoice;

import android.content.Context;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.local.InvoiceDB;
import com.example.gofuel.repository.invoice.remote.InvoiceRemoteDataSource;

import java.util.List;

public class InvoiceRepository implements IInvoiceDataSource.Main {
    private static InvoiceRepository instance;
    private final InvoiceDB invoiceDB;

    private InvoiceRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        invoiceDB = db.invoiceDB();
    }

    public static InvoiceRepository getInstance(Context context) {
        if (instance == null) {
            instance = new InvoiceRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<Invoice> getCachedInvoice() {
        return null;
    }

    @Override
    public ResultWrapper<List<Invoice>> getInvoices() {
        ResultWrapper<List<Invoice>> result = new InvoiceRemoteDataSource().getInvoices();

        if (result.getResult() != null) {
            invoiceDB.deleteAll();
            invoiceDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!invoiceDB.getAllInvoices().isEmpty()) { result = new ResultWrapper <>(invoiceDB.getAllInvoices(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
