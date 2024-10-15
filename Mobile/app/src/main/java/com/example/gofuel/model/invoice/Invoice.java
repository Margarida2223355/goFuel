package com.example.gofuel.model.invoice;

import android.util.Log;

import androidx.room.Entity;
import androidx.room.PrimaryKey;
import androidx.room.TypeConverters;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

@Entity(tableName = "invoices")
@TypeConverters(DateConverter.class)
public class Invoice {
    @PrimaryKey
    private final int id;
    private User user;
    private Station station;
    private String invoice_date;
    private double total;
    private InvoiceState invoiceState;

    public Invoice(int id, User user, Station station, String invoice_date, double total, InvoiceState invoiceState) {
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
