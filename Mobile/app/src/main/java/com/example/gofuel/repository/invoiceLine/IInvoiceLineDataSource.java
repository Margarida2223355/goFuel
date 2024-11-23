package com.example.gofuel.repository.invoiceLine;


import com.example.gofuel.model.invoice.InvoiceLine;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IInvoiceLineDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<InvoiceLine>> getInvoiceLines();
    }

    // Local data source
    interface Local {
        ResultWrapper<InvoiceLine> getCachedInvoiceLine();
    }

    interface Main extends Remote, Local {}
}
