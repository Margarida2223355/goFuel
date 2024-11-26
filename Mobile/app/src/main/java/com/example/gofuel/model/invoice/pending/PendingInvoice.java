package com.example.gofuel.model.invoice.pending;

import androidx.room.Entity;
import androidx.room.PrimaryKey;
import androidx.room.TypeConverters;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.invoice.common.DateConverter;
import com.example.gofuel.model.invoice.InvoiceState;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;

@Entity(tableName = "pending_invoices")
@TypeConverters(DateConverter.class)
public class PendingInvoice implements Invoice {
    @PrimaryKey
    private final int id;
    private User user;
    private Station station;
    private String invoice_date;
    private String code;
    private double total;
    private InvoiceState invoiceState;

    public PendingInvoice(int id, String code, String invoice_date, InvoiceState invoiceState, Station station, double total, User user) {
        this.id = id;
        this.code = code;
        this.invoice_date = invoice_date;
        this.invoiceState = invoiceState;
        this.station = station;
        this.total = total;
        this.user = user;
    }

    public int getId() {
        return id;
    }

    public User getUser() {
        return user;
    }

    @Override
    public String getCode() {
        return code;
    }

    public Station getStation() {
        return station;
    }

    public String getInvoice_date() {
        return invoice_date;
    }

    public double getTotal() {
        return total;
    }

    public InvoiceState getInvoiceState() {
        return invoiceState;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public void setStation(Station station) {
        this.station = station;
    }

    public void setInvoice_date(String invoice_date) {
        this.invoice_date = invoice_date;
    }

    public void setTotal(double total) {
        this.total = total;
    }

    public void setInvoiceState(InvoiceState invoiceState) {
        this.invoiceState = invoiceState;
    }
}
