package com.example.gofuel.model;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

@Entity(tableName = "stations")
public class Station {
    //region Properties
    @PrimaryKey
    private int id;
    private String name;
    private String address;
    private String postal_code;
    //endregion

    public Station(int id, String name, String address, String postal_code) {
        this.id = id;
        this.name = name;
        this.address = address;
        this.postal_code = postal_code;
    }

    //region Getters and Setters
    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getPostal_code() {
        return postal_code;
    }

    public void setPostal_code(String postal_code) {
        this.postal_code = postal_code;
    }
    //endregion
}
