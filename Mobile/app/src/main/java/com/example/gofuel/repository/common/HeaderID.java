package com.example.gofuel.repository.common;

public enum HeaderID {
    USER_ID("X-USER-ID"),
    STATION_ID("X-STATION-ID"),
    INVOICE_ID("X-INVOICE-ID");

    private final String headerName;

    HeaderID(String headerName) {
        this.headerName = headerName;
    }

    public String getHeaderName() {
        return headerName;
    }
}
