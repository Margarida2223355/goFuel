package com.example.gofuel.model.invoice.invoiceline;

import androidx.room.Entity;
import androidx.room.Ignore;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.category.Category;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.item.Item;

@Entity(tableName = "invoicelines")
public class InvoiceLine {
    @PrimaryKey
    private final int id;
    private Item item;
    private double qty;
    private double total;
    private PendingInvoice invoice;

    public InvoiceLine(int id, Item item, double qty, double total, PendingInvoice invoice) {
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

    public double getQty() {
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

    public void setQty(double qty) {
        this.qty = qty;
    }

    public void setTotal(double total) {
        this.total = total;
    }

    public void setInvoice(PendingInvoice invoice) {
        this.invoice = invoice;
    }

    public void addQty() {
        String category = item.getSubcategory().getCategory().getName();

        if ((category.equals("Gasoline")) || (category.equals("Diesel"))) {
            double finalTotal = total + 0.1;
            qty = finalTotal * (qty/total);
            total = finalTotal;
        }
        else {
            double unitPrice = total/qty;
            total += unitPrice;
            qty++;
        }
    }

    public void removeQty() {
        String category = item.getSubcategory().getCategory().getName();

        if ((category.equals("Gasoline")) || (category.equals("Diesel"))) {
            double finalTotal = total - 0.1;
            qty = finalTotal * (qty/total);
            total = finalTotal;
        }
        else {
            double unitPrice = total/qty;
            total -= unitPrice;
            qty--;
        }
    }
}
