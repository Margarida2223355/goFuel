package com.example.gofuel.model.station_item;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.station.Station;

@Entity(tableName = "station_items")
public class StationItem {
    @PrimaryKey(autoGenerate = true)
    private int id;
    private Station station;
    private Double price;
    private Item item;

    public StationItem(int id, Station station, Item item, Double price) {
        this.id = id;
        this.station = station;
        this.item = item;
        this.price = price;
    }

    public Item getItem() {
        return item;
    }

    public void setItem(Item item) {
        this.item = item;
    }

    public Double getPrice() {
        return price;
    }

    public void setPrice(Double price) {
        this.price = price;
    }

    public Station getStation() {
        return station;
    }

    public void setStation(Station station) {
        this.station = station;
    }

    public int getId() {
        return id;
    }
}
