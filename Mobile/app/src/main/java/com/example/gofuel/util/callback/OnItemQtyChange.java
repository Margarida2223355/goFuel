package com.example.gofuel.util.callback;

import com.example.gofuel.model.station_item.StationItem;

public interface OnItemQtyChange {
    void onQtyChanged(Boolean show);
    void changeQty(StationItem item, int qty);
}
