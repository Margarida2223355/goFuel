package com.example.gofuel.model.client_station;

import androidx.annotation.NonNull;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.user.User;

@Entity(tableName = "client_station")
public class ClientStation {
    @PrimaryKey @NonNull
    private User client;
    private Station station;

    public ClientStation(User client, Station station) {
        this.client = client;
        this.station = station;
    }

    public User getClient() {
        return client;
    }

    public void setClient(User client) {
        this.client = client;
    }

    public Station getStation() {
        return station;
    }

    public void setStation(Station station) {
        this.station = station;
    }
}
