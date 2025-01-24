package com.example.gofuel.model.invoice.invoiceline;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.item.Item;

@Entity(tableName = "invoicelines")
public class InvoiceLine {
    @PrimaryKey
    private final int id;
    private Item item;
    private int qty;
    private double total;
    private PendingInvoice invoice;

    public InvoiceLine(int id, Item item, int qty, double total, PendingInvoice invoice) {
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

    public PendingInvoice getInvoice() {
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

    public void setInvoice(PendingInvoice invoice) {
        this.invoice = invoice;
    }

    public int addQty() {
        qty++;
        total += qty * (total/qty);

        return qty;
    }

    public int removeQty() {
        qty--;
        total -= qty * (total/qty);

        return qty;
    }

    public float getUnitPrice() {
        return (float) (total/qty);
    }
}
