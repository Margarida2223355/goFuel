package com.example.gofuel.model.station_item;

import androidx.annotation.NonNull;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.station.Station;

@Entity(tableName = "station_items")
public class StationItem {
    @PrimaryKey @NonNull
    private Double price;
    private Station station;
    private Item item;

    public StationItem(@NonNull Double price, Station station, Item item) {
        this.price = price;
        this.station = station;
        this.item = item;
    }

    @NonNull
    public Double getPrice() {
        return price;
    }

    public void setPrice(@NonNull Double price) {
        this.price = price;
    }

    public Station getStation() {
        return station;
    }

    public void setStation(Station station) {
        this.station = station;
    }

    public Item getItem() {
        return item;
    }

    public void setItem(Item item) {
        this.item = item;
    }
}
