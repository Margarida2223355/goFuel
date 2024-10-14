package com.example.gofuel.repository.item.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.item.Item;

import java.util.List;

@Dao
public interface ItemDB {
    @Insert
    void addAll(List<Item> items);

    @Query("SELECT * FROM items")
    List<Item> getAllItems();

    @Query("DELETE FROM items")
    void deleteAll();
}
