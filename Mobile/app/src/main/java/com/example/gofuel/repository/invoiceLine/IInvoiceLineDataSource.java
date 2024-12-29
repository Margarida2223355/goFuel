package com.example.gofuel.repository.invoiceLine;


import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.model.invoice.invoiceline.InvoicelinePost;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IInvoiceLineDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<InvoiceLine>> getInvoiceLines();
        ResultWrapper<List<InvoiceLine>> getInvoiceLines(Invoice invoice);
        ResultWrapper<List<InvoiceLine>> addInvoiceLines(PendingInvoice invoice, List<InvoicelinePost> lines);
        ResultWrapper<List<InvoiceLine>> addInvoiceLines(List<InvoicelinePost> lines);
        ResultWrapper<List<InvoiceLine>> removeInvoiceLines(PendingInvoice invoice, List<InvoicelinePost> lines);
        ResultWrapper<List<InvoiceLine>> removeInvoiceLines(List<InvoicelinePost> lines);
    }

    // Local data source
    interface Local {
        ResultWrapper<InvoiceLine> getCachedInvoiceLine();
    }

    interface Main extends Remote, Local {}
}
