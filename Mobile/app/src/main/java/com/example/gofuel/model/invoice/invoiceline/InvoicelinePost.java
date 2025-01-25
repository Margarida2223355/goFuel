package com.example.gofuel.model.invoice.invoiceline;

public class InvoicelinePost {
    private int item_id, invoice_id;
    private double qty;
    private float total;

    public InvoicelinePost(int item_id, double qty, float total, int invoice_id) {
        this.item_id = item_id;
        this.qty = qty;
        this.total = total;
        this.invoice_id = invoice_id;
    }

    public int getItem_id() {
        return item_id;
    }

    public double getQty() {
        return qty;
    }

    public float getTotal() {
        return total;
    }

    public int getInvoice_id() {
        return invoice_id;
    }
}
