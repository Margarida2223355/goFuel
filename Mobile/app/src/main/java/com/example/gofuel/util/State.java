package com.example.gofuel.util;

import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;

import java.util.ArrayList;
import java.util.List;

public class State {
    public static class Loading extends State {}
    public static class EmptyState extends State {}
    public static class StationList extends State {
        private final List<Station> stations;

        public StationList(List<Station> stations) {
            this.stations = stations;
        }

        public List<Station> getStations() {
            return stations;
        }
    }
    public static class InvoiceList extends State {
        private final List<Invoice> invoices;

        public InvoiceList(List<Invoice> invoices) {
            this.invoices = invoices;
        }

        public List<Invoice> getInvoices() {
            return invoices;
        }
    }
}
