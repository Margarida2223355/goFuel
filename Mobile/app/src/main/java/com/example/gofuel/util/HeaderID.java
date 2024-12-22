package com.example.gofuel.util;

public enum HeaderID {
    USER_ID("X-USER-ID"),
    STATION_ID("X-STATION-ID"),
    INVOICE_ID("X-INVOICE-ID"),
    LINE_ID("X-LINE-ID");

    private final String headerName;

    HeaderID(String headerName) {
        this.headerName = headerName;
    }

    public String getHeaderName() {
        return headerName;
    }
}
