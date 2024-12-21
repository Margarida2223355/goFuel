package com.example.gofuel.model.invoice;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.pump.Pump;

@Entity(tableName = "invoicelines")
public class InvoiceLine {
    @PrimaryKey
    private final int id;
    private Item item;
    private int qty;
    private double total;
    private Invoice invoice;

    public InvoiceLine(int id, Item item, int qty, double total, Invoice invoice) {
        this.id = id;
        this.item = item;
        this.qty = qty;
        this.total = total;
        this.invoice = invoice;
    }

    public int getId() {
        return id;
    }

    public Item getItem() {
        return item;
    }

    public int getQty() {
        return qty;
    }

    public double getTotal() {
        return total;
    }

    public Invoice getInvoice() {
        return invoice;
    }

    public void setItem(Item item) {
        this.item = item;
    }

    public void setQty(int qty) {
        this.qty = qty;
    }

    public void setTotal(double total) {
        this.total = total;
    }

    public void setInvoice(Invoice invoice) {
        this.invoice = invoice;
    }
}
