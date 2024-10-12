package com.example.gofuel.model.pump;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.station.Station;

@Entity(tableName = "pumps")
public class Pump {
    @PrimaryKey
    private final int id;
    private Station station;

    public Pump(int id, Station station) {
        this.id = id;
        this.station = station;
    }

    public int getId() {
        return id;
    }

    public Station getStation() {
        return station;
    }

    public void setStation(Station station) {
        this.station = station;
    }
}