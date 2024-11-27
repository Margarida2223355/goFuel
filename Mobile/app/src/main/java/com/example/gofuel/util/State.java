package com.example.gofuel.util;

import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station.StationItem;

import java.util.HashMap;
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
    public static class StationItemList extends State {
        private final List<StationItem> stationItems;

        public StationItemList(List<StationItem> stationItems) {
            this.stationItems = stationItems;
        }

        public List<StationItem> getStationItems() {
            return stationItems;
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
    public static class FinishedInvoiceList extends State {
        private final List<FinishedInvoice> invoices;

        public FinishedInvoiceList(List<FinishedInvoice> invoices) {
            this.invoices = invoices;
        }

        public List<FinishedInvoice> getInvoices() {
            return invoices;
        }
    }
    public static class MainResults extends State {
        private final List<ClientStation> favoriteStation;
        private final HashMap<String, String> pendingInvoices;
        private final List<FinishedInvoice> finishedInvoices;

        public MainResults(List<ClientStation> favoriteStation, HashMap<String, String> pendingInvoices, List<FinishedInvoice> finishedInvoices) {
            this.favoriteStation = favoriteStation;
            this.pendingInvoices = pendingInvoices;
            this.finishedInvoices = finishedInvoices;
        }

        public List<ClientStation> getFavoriteStation() {
            return favoriteStation;
        }

        public List<FinishedInvoice> getFinishedInvoices() {
            return finishedInvoices;
        }

        public HashMap<String, String> getPendingInvoices() {
            return pendingInvoices;
        }
    }
}
