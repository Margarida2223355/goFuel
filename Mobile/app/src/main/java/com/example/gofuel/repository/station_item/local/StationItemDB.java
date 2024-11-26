package com.example.gofuel.repository.station_item.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.station.StationItem;

import java.util.List;

@Dao
public interface StationItemDB {
    @Insert
    void addAll(List<StationItem> stationItems);

    @Query("SELECT * FROM station_items")
    List<StationItem> getStationItems();

    @Query("DELETE FROM station_items")
    void deleteAll();
}
