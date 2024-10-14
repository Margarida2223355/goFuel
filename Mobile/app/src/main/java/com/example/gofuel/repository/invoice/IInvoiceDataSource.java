package com.example.gofuel.repository.invoice;


import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.repository.common.ResultWrapper;

import java.util.List;

public interface IInvoiceDataSource {
    interface Common {}

    // Remote data source
    interface Remote {
        ResultWrapper<List<Invoice>> getInvoices();
    }

    // Local data source
    interface Local {
        ResultWrapper<Invoice> getCachedInvoice();
    }

    interface Main extends Remote, Local {}
}
