package com.example.gofuel.model.subcategory;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import com.example.gofuel.model.category.Category;

@Entity(tableName = "subcategories")
public class Subcategory {
    @PrimaryKey
    private final int id;
    private String description;
    private Category category;

    public Subcategory(int id, String description, Category category) {
        this.id = id;
        this.description = description;
        this.category = category;
    }

    public int getId() {
        return id;
    }

    public String getDescription() {
        return description;
    }

    public Category getCategory() {
        return category;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setCategory(Category category) {
        this.category = category;
    }
}
