package com.example.gofuel.model.station_item;

import androidx.annotation.NonNull;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.station.Station;

@Entity(tableName = "station_items")
public class StationItem {
    @PrimaryKey @NonNull
    private Station station;
    private Item item;

    public StationItem(@NonNull Station station, Item item) {
        this.station = station;
        this.item = item;
    }

    @NonNull
    public Station getStation() {
        return station;
    }

    public void setStation(@NonNull Station station) {
        this.station = station;
    }

    public Item getItem() {
        return item;
    }

    public void setItem(Item item) {
        this.item = item;
    }
}
