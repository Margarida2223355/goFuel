package com.example.gofuel.repository.invoiceLine;

import android.content.Context;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.repository.common.AppDatabase;
import com.example.gofuel.repository.common.ResultWrapper;
import com.example.gofuel.repository.invoiceLine.local.InvoiceLineDB;
import com.example.gofuel.repository.invoiceLine.remote.InvoiceLineRemoteDataSource;

import java.util.List;

public class InvoiceLineRepository implements IInvoiceLineDataSource.Main {
    private static InvoiceLineRepository instance;
    private final InvoiceLineDB invoiceLineDB;

    private InvoiceLineRepository(Context context) {
        AppDatabase db = AppDatabase.getDatabase(context);
        invoiceLineDB = db.invoiceLineDB();
    }

    public static InvoiceLineRepository getInstance(Context context) {
        if (instance == null) {
            instance = new InvoiceLineRepository(context);
        }

        return instance;
    }

    @Override
    public ResultWrapper<InvoiceLine> getCachedInvoiceLine() {
        return null;
    }

    @Override
    public ResultWrapper<List<InvoiceLine>> getInvoiceLines() {
        return null;
    }

    @Override
    public ResultWrapper<List<InvoiceLine>> getInvoiceLines(Invoice invoice) {
        ResultWrapper<List<InvoiceLine>> result = new InvoiceLineRemoteDataSource(invoice).getInvoiceLines();

        if (result.getResult() != null) {
            invoiceLineDB.deleteAll();
            invoiceLineDB.addAll(result.getResult());
        }
        else {
            // If there's data on local DB, return it
            if(!invoiceLineDB.getAllInvoiceLines().isEmpty()) { result = new ResultWrapper <>(invoiceLineDB.getAllInvoiceLines(), null); }

            // If there's no data on local DB, return an Error
            else { result = new ResultWrapper<>(null, "No data on local DB"); }
        }

        return result;
    }
}
