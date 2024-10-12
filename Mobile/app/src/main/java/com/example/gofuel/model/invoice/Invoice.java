package com.example.gofuel.model.invoice;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;

import java.util.Date;

@Entity(tableName = "invoices")
public class Invoice {
    @PrimaryKey
    private final int id;
    private User user;
    private Station station;
    private Date invoice_date;
    private double total;
    private InvoiceState invoiceState;

    public Invoice(int id, User user, Station station, Date invoice_date, double total, InvoiceState invoiceState) {
        this.id = id;
        this.user = user;
        this.station = station;
        this.invoice_date = invoice_date;
        this.total = total;
        this.invoiceState = invoiceState;
    }

    public int getId() {
        return id;
    }

    public User getUser() {
        return user;
    }

    public Station getStation() {
        return station;
    }

    public Date getInvoice_date() {
        return invoice_date;
    }

    public double getTotal() {
        return total;
    }

    public InvoiceState getInvoiceState() {
        return invoiceState;
    }
}
