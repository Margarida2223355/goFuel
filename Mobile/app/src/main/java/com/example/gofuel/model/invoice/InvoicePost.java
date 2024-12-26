package com.example.gofuel.model.invoice;

public class InvoicePost {
    private int client_id, station_id;
    private float total;

    public InvoicePost(int client_id, int station_id, float total) {
        this.client_id = client_id;
        this.station_id = station_id;
        this.total = total;
    }

    public int getClient_id() {
        return client_id;
    }

    public int getStation_id() {
        return station_id;
    }

    public float getTotal() {
        return total;
    }
}
