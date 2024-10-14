package com.example.gofuel.model.station;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.item.Item;

@Entity(tableName = "station_items")
public class StationItem {
    @PrimaryKey
    private final int id;
    private Station station;
    private Item item;
    private double price;

    public StationItem(int id, Station station, Item item, double price) {
        this.id = id;
        this.station = station;
        this.item = item;
        this.price = price;
    }

    public int getId() {
        return id;
    }

    public Station getStation() {
        return station;
    }

    public Item getItem() {
        return item;
    }

    public double getPrice() {
        return price;
    }
}
