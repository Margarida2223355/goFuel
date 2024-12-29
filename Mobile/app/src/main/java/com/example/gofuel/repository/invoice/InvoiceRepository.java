package com.example.gofuel.repository.invoice;

import android.content.Context;

import com.example.gofuel.MyApplication;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoicePost;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoice.local.FinishedInvoiceDB;
import com.example.gofuel.repository.invoice.local.PendingInvoiceDB;
import com.example.gofuel.repository.invoice.remote.InvoiceRemoteDataSource;

import java.util.List;

public class InvoiceRepository implements IInvoiceDataSource.Main {
    private static InvoiceRepository instance;
    private final PendingInvoiceDB pendingInvoiceDB;
    private final FinishedInvoiceDB finishedInvoiceDB;

    private InvoiceRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        pendingInvoiceDB = db.pendingInvoiceDB();
        finishedInvoiceDB = db.finishedInvoiceDB();
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
    public ResultWrapper<List<PendingInvoice>> getPendingInvoices() {
        ResultWrapper<List<PendingInvoice>> result = new InvoiceRemoteDataSource(MyApplication.getUser()).getPendingInvoices();

        if (result.getResult() != null) {
            pendingInvoiceDB.deleteAll();
            pendingInvoiceDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if (!pendingInvoiceDB.getAllInvoices().isEmpty()) {
                result = new ResultWrapper<>(pendingInvoiceDB.getAllInvoices(), null);
            }

            // If there's no data on local DB, return an Error
            else {
                result = new ResultWrapper<>(null, "No data on local DB");
            }
        }

        return result;
    }

    @Override
    public ResultWrapper<List<FinishedInvoice>> getFinishedInvoices() {
        ResultWrapper<List<FinishedInvoice>> result = new InvoiceRemoteDataSource(MyApplication.getUser()).getFinishedInvoices();

        if (result.getResult() != null) {
            finishedInvoiceDB.deleteAll();
            finishedInvoiceDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if (!finishedInvoiceDB.getAllInvoices().isEmpty()) {
                result = new ResultWrapper<>(finishedInvoiceDB.getAllInvoices(), null);
            }

            // If there's no data on local DB, return an Error
            else {
                result = new ResultWrapper<>(null, "No data on local DB");
            }
        }

        return result;
    }

    @Override
    public ResultWrapper<PendingInvoice> addInvoice(InvoicePost invoicePost) {
        ResultWrapper<PendingInvoice> result = new InvoiceRemoteDataSource(MyApplication.getUser()).addInvoice(invoicePost);

        if (result.getResult() != null) {
            pendingInvoiceDB.addInvoice(result.getResult());
        }

        return result;
    }

    @Override
    public ResultWrapper<String> closeInvoice(Invoice invoice) {
        return new InvoiceRemoteDataSource().closeInvoice(invoice);
    }
}
