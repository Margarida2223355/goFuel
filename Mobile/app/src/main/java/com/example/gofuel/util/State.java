package com.example.gofuel.util;

import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.station.Station;

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
    public static class PendingInvoiceList extends State {
        private final List<PendingInvoice> invoices;

        public PendingInvoiceList(List<PendingInvoice> invoices) {
            this.invoices = invoices;
        }

        public List<PendingInvoice> getInvoices() {
            return invoices;
        }
    }
}
