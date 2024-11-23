package com.example.gofuel.model.invoice;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;

public interface Invoice {
    int getId();
    User getUser();
    Station getStation();
    String getInvoice_date();
    double getTotal();
    InvoiceState getInvoiceState();
}
