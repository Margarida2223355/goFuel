package com.example.gofuel.repository.station.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.Station;
import java.util.List;

@Dao
public interface StationDB {
    @Insert
    void addAll(List<Station> stations);

    @Query("SELECT * FROM stations")
    List<Station> getAllStations();

    @Query("DELETE FROM stations")
    void deleteAll();
}
