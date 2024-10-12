package com.example.gofuel.repository.pump.local;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.gofuel.model.pump.Pump;

import java.util.List;

@Dao
public interface PumpDB {
    @Insert
    void addAll(List<Pump> pumps);

    @Query("SELECT * FROM pumps")
    List<Pump> getAllPumps();

    @Query("DELETE FROM pumps")
    void deleteAll();
}
