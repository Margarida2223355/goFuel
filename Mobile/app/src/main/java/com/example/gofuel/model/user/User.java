package com.example.gofuel.model.user;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.station.Station;

@Entity(tableName = "users")
public class User {
    @PrimaryKey
    private final int id;
    private final int user_id;
    private final int nif;
    private String name;
    private String address;
    private String postal_code;
    private String phone;
    private Station station;

    public User(int id, int user_id, int nif, String name, String address, String postal_code, String phone, Station station) {
        this.id = id;
        this.user_id = user_id;
        this.nif = nif;
        this.name = name;
        this.address = address;
        this.postal_code = postal_code;
        this.phone = phone;
        this.station = station;
    }

    public int getId() {
        return id;
    }

    public int getUser_id() {
        return user_id;
    }

    public int getNif() {
        return nif;
    }

    public String getName() {
        return name;
    }

    public String getAddress() {
        return address;
    }

    public String getPostal_code() {
        return postal_code;
    }

    public String getPhone() {
        return phone;
    }

    public Station getStation() {
        return station;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public void setPostal_code(String postal_code) {
        this.postal_code = postal_code;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public void setStation(Station station) {
        this.station = station;
    }
}
