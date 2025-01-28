package com.example.gofuel.model.item;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.subcategory.Subcategory;
import com.example.gofuel.util.Util;

import java.util.Base64;

@Entity(tableName = "items")
public class Item {
    @PrimaryKey private final int id;
    private String description, image;
    private Subcategory subcategory;

    public Item(int id, String description, Subcategory subcategory, String image) {
        this.id = id;
        this.description = description;
        this.subcategory = subcategory;
        this.image = image;
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

    public String getImage() {
        return image;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setSubcategory(Subcategory subcategory) {
        this.subcategory = subcategory;
    }

    public void setImage(String image) {
        this.image = image;
    }
}
