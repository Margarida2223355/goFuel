package com.example.gofuel.model.item;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.subcategory.Subcategory;

@Entity(tableName = "items")
public class Item {
    @PrimaryKey private final int id;
    private String description;
    private Subcategory subcategory;

    public Item(int id, String description, Subcategory subcategory) {
        this.id = id;
        this.description = description;
        this.subcategory = subcategory;
    }

    public int getId() {
        return id;
    }

    public String getDescription() {
        return description;
    }

    public Subcategory getSubcategory() {
        return subcategory;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setSubcategory(Subcategory subcategory) {
        this.subcategory = subcategory;
    }
}
