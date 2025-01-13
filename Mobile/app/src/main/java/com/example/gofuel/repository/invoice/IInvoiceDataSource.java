package com.example.gofuel.repository.invoice;


import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.InvoicePost;
import com.example.gofuel.model.invoice.InvoiceStationPost;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IInvoiceDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<PendingInvoice>> getPendingInvoices();
        ResultWrapper<List<PendingInvoice>> getPendingStationInvoices(InvoiceStationPost invoiceStationPost);
        ResultWrapper<List<FinishedInvoice>> getFinishedInvoices();
        ResultWrapper<List<PendingInvoice>> addInvoice(InvoicePost invoicePost);
        ResultWrapper<String> closeInvoice(Invoice invoice);
    }

    // Local data source
    interface Local {
        ResultWrapper<Invoice> getCachedInvoice();
    }

    interface Main extends Remote, Local {}
}
